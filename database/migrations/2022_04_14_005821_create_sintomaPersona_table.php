<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSintomaPersonaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('sintomaPersona', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('registroSintoma_id');
      $table->unsignedInteger('sintoma_id');

      $table->foreign('registroSintoma_id')->references('id')->on('registroSintoma');
      $table->foreign('sintoma_id')->references('id')->on('sintoma');

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
    Schema::dropIfExists('sintomaPersona');
  }
}
