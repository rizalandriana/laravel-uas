<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->string('judul_buku');
            $table->double('harga_sewa');
            $table->integer('stok');
            $table->string('gambar');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->integer('tahun');
            $table->string('tempat');
            $table->enum('status', ['Y', 'N']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku');
    }
}
