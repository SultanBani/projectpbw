<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('publikasi')) {
            Schema::create('publikasi', function (Blueprint $table) {
                $table->increments('no');
                $table->string('judul', 100);
                $table->date('tanggal_rilis');
                $table->string('sampul', 50);
            });
        }
    }

    public function down(): void {}
};
