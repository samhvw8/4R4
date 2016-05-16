<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->bigInteger('price');
            $table->double('area');
            $table->string('decripstion')->nullable(true);
            $table->string('image_album_url')->nullable(true);
            $table->double('latitude')->nullable(true);
            $table->double('longitude')->nullable(true);
            $table->string('street');
            $table->string('district');
            $table->string('ward');
            $table->string('city');

            $table->unique(array('street', 'district', 'ward', 'city'));
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rooms');
    }
}
