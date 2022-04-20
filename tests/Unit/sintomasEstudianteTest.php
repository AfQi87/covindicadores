<?php

namespace Tests\Unit;

use App\Models\Estado;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Persona;
use App\Models\Programa;
use App\Models\RegistroSintoma;
use App\Models\Sintoma;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class sintomasEstudianteTest extends TestCase
{
  use RefreshDatabase;

  //Estudiante no pertenece a la universidad(2)
  public function testRegistrarSintoma1()
  {
    $test_post = ([
      'identificacion' => 1085946632,
      'sintoma' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $sintoma = RegistroSintoma::all();
    $conteo = $sintoma->count();

    $this->assertEquals($conteo, 0, 'Se le registro sintomas a un estudiate que no pertenece a la Universidad');
  }

  //Registro de dosis a estudiante registrado(1)
  public function testRegistrarSintoma2()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $facultad = Facultad::create(['codigo' => 1, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 2, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $sintoma = Sintoma::create(['nombre' => 'sintoma1']);
    $sintoma = Sintoma::create(['nombre' => 'sintoma2']);

    $test_post = ([
      'identificacion' => 1085946632,
      'sintoma' => 1,
      'sintoma' => 2,
    ]);

    $response = $this->post('/forms/sintomas', $test_post);

    $vacunacion = RegistroSintoma::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 1, 'No se agrego sintomas a estudiante registrado');
  }

  //Registro de dosis a estudiante inactivo(4)
  public function testRegistrarSintoma3()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 2]);

    $sintoma = Sintoma::create(['nombre' => 'sintoma1']);
    $sintoma = Sintoma::create(['nombre' => 'sintoma2']);

    $test_post = ([
      'identificacion' => 1085946632,
      'sintoma' => 1,
      'sintoma' => 2,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = RegistroSintoma::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se le registro una dosis a un estudiate que esta inactivo');
  }

  //Registro dosis a estudiante con identificacion no numerica
  public function testRegistrarSintoma4()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);
    $persona4 = Persona::create(['identificacion' => 'qweertyuio', 'nombres' =>  'persona4', 'apellidos' =>  'apellido4', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $sintoma = Sintoma::create(['nombre' => 'sintoma1']);
    $sintoma = Sintoma::create(['nombre' => 'sintoma2']);

    $test_post = ([
      'identificacion' => 'qweertyuio',
      'sintoma' => 1,
      'sintoma' => 2,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = RegistroSintoma::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se registro dosis a identificacion no numerica');
  }
}
