<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connects', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');

            $table->timestamps();
            $table->integer('type_id')->unsigned();
            $table->integer('line_id')->unsigned();
            $table->integer('form_id')->unsigned();
            $table->string('ralation');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
            $table->foreign('line_id')->references('id')->on('lines')->onDelete('cascade');
            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('connects');
    }
}
