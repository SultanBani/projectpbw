<?php

namespace Tests\Feature;

use App\Models\Publikasi;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class BpsApplicationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('user', function (Blueprint $table) {
            $table->string('username', 50)->primary();
            $table->string('password', 255);
        });

        User::create([
            'username' => 'adminpapua',
            'password' => Hash::make('kata-sandi-uji'),
        ]);

        Publikasi::create([
            'no' => 1,
            'judul' => 'Provinsi Papua Tengah Dalam Angka 2026',
            'tanggal_rilis' => '2026-02-27',
            'sampul' => 'cover1.webp',
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/publikasi')->assertRedirect('/login');
    }

    public function test_authenticated_session_can_open_home(): void
    {
        $this->withBpsSession()->get('/')
            ->assertOk()
            ->assertSee('Selamat Datang');
    }

    public function test_user_can_log_in_with_valid_credentials(): void
    {
        $this->post('/login', [
            'username' => 'adminpapua',
            'password' => 'kata-sandi-uji',
        ])->assertRedirect('/');

        $this->assertTrue(session()->has('bps_username'));
    }

    public function test_user_with_a_legacy_plain_text_password_can_log_in_and_is_upgraded(): void
    {
        DB::table('user')->insert([
            'username' => 'adminlama',
            'password' => 'kata-sandi-lama',
        ]);

        $this->post('/login', [
            'username' => 'adminlama',
            'password' => 'kata-sandi-lama',
        ])->assertRedirect('/');

        $password = User::findOrFail('adminlama')->password;
        $this->assertNotSame('kata-sandi-lama', $password);
        $this->assertTrue(Hash::check('kata-sandi-lama', $password));
    }

    public function test_authenticated_session_can_open_publication_form(): void
    {
        $this->withBpsSession()->get('/publikasi/tambah')
            ->assertOk()
            ->assertSee('Form Tambah Publikasi Baru');
    }

    public function test_authenticated_session_can_open_gallery(): void
    {
        $this->withBpsSession()->get('/galeri')
            ->assertOk()
            ->assertSee('Galeri Kegiatan');
    }

    public function test_authenticated_session_can_read_and_search_publications(): void
    {
        $this->withBpsSession()->get('/publikasi')
            ->assertOk()
            ->assertSee('Daftar Publikasi');

        $this->withBpsSession()->getJson('/publikasi/data?q=Papua%20Tengah')
            ->assertOk()
            ->assertJsonPath('data.0.no', 1);
    }

    public function test_publication_forms_validate_required_fields(): void
    {
        $this->withBpsSession()->post('/publikasi', [])
            ->assertSessionHasErrors(['no', 'judul', 'tanggal_rilis', 'sampul']);

        $this->withBpsSession()->put('/publikasi/1', [])
            ->assertSessionHasErrors(['judul', 'tanggal_rilis']);
    }

    public function test_authenticated_session_can_manage_a_publication_with_a_cover(): void
    {
        $sampulAwalUji = UploadedFile::fake()->createWithContent(
            'sampul-awal.webp',
            File::get(public_path('assets/cover1.webp')),
        );

        $this->withBpsSession()->post('/publikasi', [
            'no' => 2,
            'judul' => 'Publikasi Uji',
            'tanggal_rilis' => '2026-03-01',
            'sampul' => $sampulAwalUji,
        ])->assertRedirect('/publikasi');

        $publikasi = Publikasi::findOrFail(2);
        $sampulAwal = public_path("assets/{$publikasi->sampul}");
        $this->assertFileExists($sampulAwal);

        $sampulBaruUji = UploadedFile::fake()->createWithContent(
            'sampul-baru.webp',
            File::get(public_path('assets/cover2.webp')),
        );

        $this->withBpsSession()->put('/publikasi/2', [
            'judul' => 'Publikasi Uji Diperbarui',
            'tanggal_rilis' => '2026-03-02',
            'sampul_baru' => $sampulBaruUji,
        ])->assertRedirect('/publikasi');

        $publikasi->refresh();
        $sampulBaru = public_path("assets/{$publikasi->sampul}");
        $this->assertFileDoesNotExist($sampulAwal);
        $this->assertFileExists($sampulBaru);

        $this->withBpsSession()->delete('/publikasi/2')
            ->assertRedirect('/publikasi');

        $this->assertDatabaseMissing('publikasi', ['no' => 2]);
        $this->assertFileDoesNotExist($sampulBaru);
        File::delete($sampulAwal, $sampulBaru);
    }

    public function test_authenticated_session_can_log_out(): void
    {
        $this->withBpsSession()->post('/logout')
            ->assertRedirect('/login');
    }

    private function withBpsSession(): static
    {
        return $this->withSession([
            'bps_username' => 'adminpapua',
            'bps_last_activity' => now(),
        ]);
    }
}
