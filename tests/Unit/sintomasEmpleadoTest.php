<?php

namespace Tests\Unit;

use App\Models\Cargo;
use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\Estado;
use App\Models\Nivel;
use App\Models\Persona;
use App\Models\RegistroSintoma;
use App\Models\Sintoma;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class sintomasEmpleadoTest extends TestCase
{
  use RefreshDatabase;

  //Estudiante no pertenece a la universidad(2)
  public function testRegistrarSintomaEmpleado1()
  {
    $test_post = ([
      'identificacion' => 1085946632,
      'sintoma' => 1,
    ]);

    $response = $this->post('/forms/vacunacion', $test_post);

    $sintoma = RegistroSintoma::all();
    $conteo = $sintoma->count();

    $this->assertEquals($conteo, 0, 'Se le registro sintomas a un empleado que no pertenece a la Universidad');
  }

  //Registro de dosis a estudiante registrado(1)
  public function testRegistrarSintomaEmpleado2()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-01', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

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
    $this->assertEquals($conteo, 1, 'No se agrego sintomas a empleado registrado');
  }

  //Registro de dosis a empleado inactivo(4)
  public function testRegistrarSintomaEmpleado3()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  123, 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 2]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2022-04-18', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

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
  public function testRegistrarSintomaEmpleado4()
  {
    $persona1 = Persona::create(['identificacion' => 1085946632, 'nombres' =>  'persona1', 'apellidos' =>  'apellido1', 'fecNac' => '2022-04-16']);
    $persona2 = Persona::create(['identificacion' => 1085946633, 'nombres' =>  'persona2', 'apellidos' =>  'apellido2', 'fecNac' => '2022-04-16']);
    $persona3 = Persona::create(['identificacion' => 1085946634, 'nombres' =>  'persona3', 'apellidos' =>  'apellido3', 'fecNac' => '2022-04-16']);
    $persona4 = Persona::create(['identificacion' => 'qweertyuio', 'nombres' =>  'persona4', 'apellidos' =>  'apellido4', 'fecNac' => '2022-04-16']);

    $estado = Estado::create(['estado' => 'Activo']);
    $estado = Estado::create(['estado' => 'Inactivo']);

    $cargo = Cargo::create(['nombre' =>  'cargo1']);
    $nivel = Nivel::create(['nombre' =>  'nivel1']);

    $empleado = Empleado::create(['titulo' => 'titulo', 'cargo_id' =>  1, 'persona_id' => 1, 'nivelEd_id' =>  1, 'estado_id' => 1]);
    $contrato = Contrato::create(['fecha_ini' => '2022-04-01', 'fecha_fin' =>  '2023-04-18', 'descripcion' =>  'descripcion', 'empleado_id' => 1]);

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
