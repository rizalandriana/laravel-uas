<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member', function (Blueprint $table) {
            $table->increments('id');
            $table->string('kode');
            $table->integer('kategori_id')->unsigned();
            $table->string('nama');
            $table->string('foto');
            $table->text('alamat');
            $table->string('hp');
            $table->string('email');
            $table->enum('status', ['Y', 'N']);
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategori')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('member');
    }
}
