<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id('id_barang');

            $table->unsignedBigInteger('id_penjual');

            $table->foreign('id_penjual')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->string('nama_barang');
            $table->text('deskripsi');
            $table->integer('harga');
            $table->string('kategori');
            $table->enum('status', ['tersedia', 'terjual']);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};