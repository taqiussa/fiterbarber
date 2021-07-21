<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTanggalsimpanToPemasukanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->date('tanggalsimpan')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pemasukan', function (Blueprint $table) {
            $table->dropColumn('tanggalsimpan');
        });
    }
}
