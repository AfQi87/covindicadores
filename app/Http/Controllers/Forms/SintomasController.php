<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Contrato;
use App\Models\Empleado;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\RegistroSintoma;
use App\Models\SintomaPersona;
use App\Models\Vacunacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SintomasController extends Controller
{
  public function index()
  {
    $registros = RegistroSintoma::selectRaw('persona.id as persona, nombres, apellidos, registroSintoma.id as sintoma, identificacion, fecha')
      ->join('persona', 'registroSintoma.persona_id', 'persona.id')->get();

    $estudiantes = Estudiante::all();
    $empleados = Empleado::all();
    $cargos = Cargo::all();
    $sintomas = SintomaPersona::all();
    return view('listas/sintomas', compact('registros', 'estudiantes', 'empleados', 'cargos', 'sintomas'));
  }

  public function create()
  {
    //
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'identificacion' => 'required|max:10',
      'sintoma' => 'required',
    ]);
    if ($validator->fails()) {
      $validator = $validator->errors();
      $errores = json_decode($validator);
      echo '<script>validate(' . $validator . ')</script>';
    } else {
      $persona = Persona::where('identificacion', $request->identificacion)->first();
      if ($persona != null) {
        $estudiante = Estudiante::where('persona_id', $persona->id)->first();
        if ($estudiante != null) {
          if ($estudiante->estado_id == 1) {
            $fecha = Carbon::now('America/lima');
            $fecha = $fecha->format('Y-m-d');
            $sintoma = new RegistroSintoma();
            $sintoma->persona_id = $persona->id;
            $sintoma->fecha = $fecha;
            $sintoma->save();
            $cont = count($request->sintoma);
            $sintoma = RegistroSintoma::latest()->first();
            for ($i = 0; $i < $cont; $i++) {
              $sintomaP = new SintomaPersona();
              $sintomaP->registroSintoma_id = $sintoma->id;
              $sintomaP->sintoma_id = $request->sintoma[$i];
              $sintomaP->save();
            }
            notify()->success('Se a guardado el registro de sus sintomas');
            return back();
          } else {
            notify()->error('No se encuentra activo');
            return back();
          }
        } else {
          $empleado = Empleado::where('persona_id', $persona->id)->first();
          if ($empleado != null) {
            $contrato = Contrato::where('empleado_id', $empleado->id)->first();
            $fecha_fin = Carbon::create($contrato->fecha_fin);
            $fecha_fin = $fecha_fin->format('Y-m-d');
            $fecha = Carbon::now('America/lima');
            $fecha = $fecha->format('Y-m-d');
            if ($fecha_fin > $fecha) {
              $sintoma = new RegistroSintoma();
              $sintoma->persona_id = $persona->id;
              $sintoma->fecha = $fecha;
              $sintoma->save();
              $cont = count($request->sintoma);
              $sintoma = RegistroSintoma::latest()->first();
              for ($i = 0; $i < $cont; $i++) {

                $sintomaP = new SintomaPersona();
                $sintomaP->registroSintoma_id = $sintoma->id;
                $sintomaP->sintoma_id = $request->sintoma[$i];
                $sintomaP->save();
              }
              notify()->error('Se a guardado el registro de sus sintomas');
              return back();
            } else {
              notify()->error('No se encuentra activo');
              return back();
            }
          } else {
            notify()->error('No se encuentra registrado como Empleado/Estudiante');
            return back();
          }
        }
      } else {
        notify()->error('Identificacion no registrada');
        return back();
      }
    }
  }

  public function show($id)
  {
    $regSintoma = RegistroSintoma::findOrFail($id);
    $persona = Persona::findOrFail($regSintoma->persona_id);
    $estudiantes = Estudiante::all();
    $empleados = Empleado::all();
    $cargos = Cargo::all();
    $sintomas = SintomaPersona::where('registroSintoma_id', $id)->get();
    return response()->json(['registro' => $regSintoma,'persona' => $persona,'sintomas' => $sintomas]);
  }

  public function edit($id)
  {
    //
  }

  public function update(Request $request, $id)
  {
    //
  }

  public function destroy($id)
  {
    //
  }
}
