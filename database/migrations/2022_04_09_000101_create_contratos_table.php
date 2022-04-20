<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratosTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('contrato', function (Blueprint $table) {
      $table->increments('id');
      $table->date('fecha_ini');
      $table->date('fecha_fin');
      $table->string('descripcion', 250);
      $table->unsignedInteger('empleado_id');

      $table->foreign('empleado_id')->references('id')->on('empleado');
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
    Schema::dropIfExists('contrato');
  }
}
