<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan_komentars', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['comment_id']);
            // Ubah jadi nullable
            $table->foreignId('comment_id')->nullable()->change();
            // Tambahkan foreign key baru dengan set null
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_komentars', function (Blueprint $table) {
            // Balik lagi ke kondisi awal
            $table->dropForeign(['comment_id']);
            $table->foreignId('comment_id')->nullable(false)->change();
            $table->foreign('comment_id')
                ->references('id')->on('comments')
                ->onDelete('cascade');
        });
    }
};
