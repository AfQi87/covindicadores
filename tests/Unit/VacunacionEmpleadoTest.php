<?php

namespace Tests\Unit;

use App\Models\Cargo;
use App\Models\Contrato;
use App\Models\Dosis;
use App\Models\Empleado;
use App\Models\Estado;
use App\Models\Estudiante;
use App\Models\Facultad;
use App\Models\Nivel;
use App\Models\Persona;
use App\Models\Programa;
use App\Models\Vacuna;
use App\Models\Vacunacion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Faker\Factory;
use Illuminate\Support\Facades\DB;

class VacunacionEmpleadoTest extends TestCase
{
  use RefreshDatabase;

  //Empleado no pertenece a la universidad(2)
  public function testRegistrarDosisEmpleado1()
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

  //Registro de dosis a empleado registrado(1)
  public function testRegistrarDosisEmpleado2()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna' => 1,
      'dosis' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 1, 'No se agrego dosis a empleado registrado');
  }

  //Regsitro dosis a empleado con mas de 3 dosis(6)
  public function testRegistrarDosisEmpleado3()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

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

  //Registro de dosis a empleado con fecha mayor a la actual(3)
  public function testRegistrarDosisEmpleado4()
  {

    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-05-18',
      'vacuna_id' => 1,
      'dosis_id' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 0, 'Se le registro una dosis con fecha superior a la actual');
  }

  //Registro de dosis a empleado inactivo(4)
  public function testRegistrarDosisEmpleado5()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

    $test_post = ([
      'identificacion' => 1085946632,
      'fecha' => '2022-04-01',
      'vacuna' => 1,
      'dosis' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $vacunacion = Vacunacion::all();
    $conteo = $vacunacion->count();
    $this->assertEquals($conteo, 1, 'Se agrego dosis a empleado Inactivo');
  }

  //Registro dosis a estudiante con identificacion no numerica
  public function testRegistrarDosisEmpleado6()
  {

    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);
    $persona4 = Persona::create(['identificacion' => 'qweertyuio', 'nombres' =>  'persona4', 'apellidos' =>  'apellido4', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $vacuna = Vacuna::create(['vacuna' => 'vacuna1']);
    $dosis = Dosis::create(['dosis' => 'dosis1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 2]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

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
