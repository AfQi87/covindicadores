<?php

namespace Tests\Unit;

use App\Models\Dosis;
use App\Models\Estado;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Persona;
use App\Models\Programa;
use App\Models\Vacunacion;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Vacuna;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Faker\Factory;

class VacunacionTest extends TestCase
{
  use RefreshDatabase;

  //Estudiante no pertenece a la universidad(2)
  public function testRegistrarDosis1()
  {
    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();

    $this->assertEquals($conteo, 0, 'Se le registro una dosis a un estudiate que no pertenece a la Universidad');
  }

  //Registro de dosis a estudiante registrado(1)
  public function testRegistrarDosis2()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $facultad = Facultad::create(['codigo' => 1, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 2, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna' => 1,
      'dosis' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 1, 'No se agrego dosis a estudiante registrado');
  }

  //Regsitro dosis a Estudiante con mas de 3 dosis(6)
  public function testRegistrarDosis3()
  {

    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $vacunacion = Vacunacion::create(['fecha' => '2022-04-01', 'vacuna_id' =>  1, 'dosis_id' =>  1, 'persona_id' => 1]);
    $vacunacion = Vacunacion::create(['fecha' => '2022-04-01', 'vacuna_id' =>  1, 'dosis_id' =>  1, 'persona_id' => 1]);
    $vacunacion = Vacunacion::create(['fecha' => '2022-04-01', 'vacuna_id' =>  1, 'dosis_id' =>  1, 'persona_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 3, 'Se le registro una dosis a un estudiate con esquema de vacunación completo');
  }

  //Registro de dosis a estudiante con fecha mayor a la actual(3)
  public function testRegistrarDosis4()
  {

    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-18',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se le registro una dosis con fecha superior a la actual');
  }

  //Registro de dosis a estudiante inactivo(4)
  public function testRegistrarDosis5()
  {

    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 2]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se le registro una dosis a un estudiate que esta inactivo');
  }

  //Registro dosis a estudiante con identificacion no numerica
  public function testRegistrarDosis6()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);
    $persona4 = Persona::create(['identificacion' => 'qweertyuio', 'nombres' =>  'persona4', 'apellidos' =>  'apellido4', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $facultad = Facultad::create(['codigo' => 216036112, 'nombre' =>  'facultad1']);
    $programa = Programa::create(['codigo' => 216036112, 'nombre' =>  'programa1', 'facultad_id' =>  1]);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $estudiante1 = Estudiante::create(['codigo' => 216036112, 'programa_id' =>  1, 'persona_id' =>  1, 'estado_id' => 1]);

    $test_post = ([
      'identificacion' => 'qweertyuio',
      'fecha' => '2022-04-01',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se registro dosis a identificacion no numerica');
  }
}
