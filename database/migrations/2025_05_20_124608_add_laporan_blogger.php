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
        Schema::create('laporan_bloggers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('blogger_id')->nullable()->constrained('bloggers')->onDelete('set null');
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // pelapor
            $table->foreignId('to_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('alasan');
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_bloggers');
    }
};
