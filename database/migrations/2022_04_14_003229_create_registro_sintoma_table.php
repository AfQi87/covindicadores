<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistroSintomaTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('registroSintoma', function (Blueprint $table) {
      $table->increments('id');
      $table->unsignedInteger('persona_id');
      $table->date('fecha');

      $table->foreign('persona_id')->references('id')->on('persona');
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
    Schema::dropIfExists('registroSintoma');
  }
}
