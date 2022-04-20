<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Vacunacion;

class VacunacionTest extends TestCase
{
  /**
   * A basic feature test example.
   *
   * @return void
   */
  // use RefreshDatabase;
  public function test_ruta_create()
  {
    $response = $this->get('/forms/vacunacion/create');

    $response->assertStatus(200);
  }

  // public function testRegistrarDosis1()
  // {
  //   // $response = $this->post('/forms/vacunacion', [
  //   //   'identificacion' => 1085946632,
  //   //   'fecha' => '2022-04-01',
  //   //   'vacuna_id' => 1,
  //   //   'dosis_id' => 1,
  //   // ]);
  //   // $response->assertOk();
  //   // $response->assertSessionHasErrors([
  //   //   'msg' => 'Usuario no registrado',
  //   // ]);

  //   // $this->assertEquals($conteo, 0, 'Se le registro una dosis a un estudiate que no pertenece a la Universidad');

  //   // if ($conteo > 0) {
  //   //   // $response->$this->fail();
  //   //   $response->assertSessionHasErrors([
  //   //     'msg' => 'Se le registro una dosis a un estudiate que no pertenece a la Universidad',
  //   //   ]);
  //   // }

  //   // $response->$this->assertTrue(true);
  //   // $response = Vacunacion::all();

  //   // $this->assertEquals(array(1, '2022-04-16', 1, 1, 1), $response);

  //   // Null, now the box is empty
  //   // $this->assertNull($response->all());
  // }
}
