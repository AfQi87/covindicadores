<?php

namespace App\Http\Controllers\forms;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use App\Models\Contrato;
use App\Models\Dosis;
use App\Models\Empleado;
use App\Models\Estudiante;
use App\Models\Persona;
use App\Models\Sintoma;
use App\Models\Vacuna;
use App\Models\Vacunacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;


class VacunacionController extends Controller
{
  public function index()
  {
    // $vacunacion = Vacunacion::all();
    // $conteo = $vacunacion->count();
    // return $conteo;

    $vacunaciones = Vacunacion::selectRaw('persona.id as persona, identificacion, count(persona_id) as "numero"')
      ->join('persona', 'vacunacion.persona_id', 'persona.id')
      ->groupBy('persona_id')->get();

    $estudiantes = Estudiante::all();
    $empleados = Empleado::all();
    $cargos = Cargo::all();
    return view('listas/vacunacion', compact('vacunaciones', 'estudiantes', 'empleados', 'cargos'));
  }

  public function create()
  {
    $vacunas = Vacuna::all();
    $dosis = Dosis::all();
    $sintomas = Sintoma::all();

    return view('forms/vacunacion', compact('vacunas', 'dosis', 'sintomas'));
  }

  public function store(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'identificacion' => 'required|max:10',
      'fecha' => 'required',
      'vacuna' => 'required',
      'dosis' => 'required',
    ]);
    if ($validator->fails()) {
      return ($validator->errors());
    } else {
      $persona = Persona::where('identificacion', $request->identificacion)->first();
      if ($persona != null) {
        $estudiante = Estudiante::where('persona_id', $persona->id)->first();
        if ($estudiante != null) {
          if ($estudiante->estado_id == 1) {
            $fecha = Carbon::now('America/lima');
            $fecha = $fecha->format('Y-m-d');
            if ($request->fecha <= $fecha) {
              $dosis = Vacunacion::where('persona_id', $persona->id)->get();
              $conteo = $dosis->count();
              if ($conteo <= 3) {
                $vacunacion = new Vacunacion();
                $vacunacion->fecha = $request->fecha;
                $vacunacion->vacuna_id = $request->vacuna;
                $vacunacion->dosis_id = $request->dosis;
                $vacunacion->persona_id = $persona->id;
                $vacunacion->save();
                notify()->success('Se a guardado el registro de su vacuna');
                return back();
              } else {
                notify()->error('Ya se han registro el maximo de dosis para el usuario ingresado por favor ponganse en contacto con la universidad');
                return back();
              }
            } else {
              notify()->error('La fecha debe ser menor a la fecha actual');
              return back();
            }
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
              if ($request->fecha <= $fecha) {
                $dosis = Vacunacion::where('persona_id', $persona->id)->get();
                $conteo = $dosis->count();
                if ($conteo <= 3) {
                  $vacunacion = new Vacunacion();
                  $vacunacion->fecha = $request->fecha;
                  $vacunacion->vacuna_id = $request->vacuna;
                  $vacunacion->dosis_id = $request->dosis;
                  $vacunacion->persona_id = $persona->id;
                  $vacunacion->save();
                  notify()->success('Se a guardado el registro de su vacuna');
                  return back();
                } else {
                  notify()->error('Ya se han registro el maximo de dosis para el usuario ingresado por favor ponganse en contacto con la universidad');
                  return back();
                }
              } else {
                notify()->error('La fecha debe ser menor a la fecha actual');
                return back();
              }
            } else {
              notify()->error('El empleado no se encuentra activo');
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
    //
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
