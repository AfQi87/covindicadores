<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('empleado', function (Blueprint $table) {
      $table->increments('id');
      $table->string('titulo');
      $table->unsignedInteger('cargo_id');
      $table->unsignedInteger('persona_id');
      $table->unsignedInteger('nivelEd_id');
      $table->unsignedInteger('estado_id');

      $table->foreign('cargo_id')->references('id')->on('cargo');
      $table->foreign('persona_id')->references('id')->on('persona');
      $table->foreign('nivelEd_id')->references('id')->on('nivelEd');
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
    Schema::dropIfExists('empleado');
  }
}
