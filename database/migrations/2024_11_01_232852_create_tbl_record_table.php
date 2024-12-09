<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    if (!Schema::hasTable('tbl_record')) {
        Schema::create('tbl_record', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('name');
            $table->string('condition');
            $table->integer('quantity');
            $table->date('date_of_entry');
            $table->timestamps();
        });
    }
}

protected $table = 'tbl_record';

};
