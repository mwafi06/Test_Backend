<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransaksiDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('transaksi_id');
            $table->unsignedInteger('layanan_id');
            $table->string('unit');
            $table->string('harga');
            $table->string('qty');
            $table->string('tagihan');
            $table->timestamps();

            $table->foreign('transaksi_id')->references('id')->on('transaksi');
            $table->foreign('layanan_id')->references('id')->on('layanan');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_details');
    }
}
