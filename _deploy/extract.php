<?php
/**
 * Ekstrak deploy.zip langsung di server InfinityFree.
 * Cara pakai: upload deploy.zip + extract.php ke htdocs, lalu buka
 * http://projectpbw.page.gd/extract.php di browser. File ini menghapus dirinya sendiri.
 */
set_time_limit(300);

$zipPath = __DIR__ . '/deploy.zip';

if (!class_exists('ZipArchive')) {
    exit('ZipArchive tidak tersedia di server ini.');
}

$zip = new ZipArchive();
if ($zip->open($zipPath) !== true) {
    exit('Gagal membuka deploy.zip. Pastikan file sudah ter-upload ke htdocs.');
}

$zip->extractTo(__DIR__);
$total = $zip->numFiles;
$zip->close();

if (file_exists(__DIR__ . '/.env.production')) {
    rename(__DIR__ . '/.env.production', __DIR__ . '/.env');
}

@unlink($zipPath);
@unlink(__FILE__);

echo "Selesai! {$total} file diekstrak. Silakan buka halaman utama web Anda.";
