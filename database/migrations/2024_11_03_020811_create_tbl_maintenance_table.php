<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblMaintenanceTable extends Migration
{
    public function up()
    {
        Schema::create('tbl_maintenance', function (Blueprint $table) {
            $table->id('id_maintenance');
            $table->string('kode_barang');
            $table->string('nama_barang');
            $table->string('kondisi');
            $table->integer('jumlah');
            $table->date('tanggal_maintenance');
            $table->date('tanggal_maintenance_selanjutnya');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_maintenance');
    }
}