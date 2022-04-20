<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacunacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacunacion', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha');
            $table->unsignedInteger('vacuna_id');
            $table->unsignedInteger('dosis_id');
            $table->unsignedInteger('persona_id');

            $table->foreign('persona_id')->references('id')->on('persona');
            $table->foreign('vacuna_id')->references('id')->on('vacuna');
            $table->foreign('dosis_id')->references('id')->on('dosis');

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
        Schema::dropIfExists('vacunacion');
    }
}
