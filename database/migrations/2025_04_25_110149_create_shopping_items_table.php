<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi database untuk membuat tabel shopping_items.
     *
     * @return void
     */
    public function up()
{
    Schema::create('shopping_items', function (Blueprint $table) {
        $table->id();
        $table->string('nama_barang');
        $table->integer('jumlah');
        $table->integer('harga');
        $table->string('kategori'); // makanan, minuman, aktivitas, dll
        $table->timestamps();
    });
}


    /**
     * Reverse migrasi (hapus tabel jika rollback).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopping_items');
    }
};
