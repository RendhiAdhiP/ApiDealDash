<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('laporan_penjualans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('produk_id');
            $table->foreign('produk_id')->references('produk_id')->on('produks')->onDelete('cascade');
            $table->unsignedBigInteger('sales_id');
            $table->foreign('sales_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('jumlah_produk_terjual');
            $table->integer('nominal_penjualan');
            $table->timestamp('tanggal_penjualan')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_penjualans');
    }
};
