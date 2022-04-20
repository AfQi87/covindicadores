<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstudianteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiante', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codigo');
            $table->unsignedInteger('programa_id');
            $table->unsignedInteger('persona_id');
            $table->unsignedInteger('estado_id');

            $table->foreign('persona_id')->references('id')->on('persona');
            $table->foreign('programa_id')->references('id')->on('programa');
            $table->foreign('estado_id')->references('id')->on('estado');

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
        Schema::dropIfExists('estudiante');
    }
}
