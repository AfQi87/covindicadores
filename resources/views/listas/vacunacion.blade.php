@extends('layouts.master')
@section('contenido')
<div class="content mt-4 container-sm">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header ">
            <h4 class="card-title text-center">Listado de Vacunaciones</h4>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <th class="text-center">Identificación</th>
                  <th class="text-center">Numero Dosis</th>
                  <th class="text-center">Persona</th>
                  <th class="text-center">Más</th>
                </thead>
                <tbody>
                  @foreach($vacunaciones as $vacuna)
                  <tr>
                    <td class="text-center">{{ $vacuna->identificacion }}</td>
                    <td class="text-center">{{ $vacuna->numero }}</td>
                    @foreach($estudiantes as $estudiante)
                      @if($vacuna->persona == $estudiante->persona_id)
                        <td class="text-center">Estudiante</td>
                      @else
                        @foreach($empleados as $empleado)
                          @if($vacuna->persona == $empleado->persona_id)
                            @foreach($cargos as $cargo)
                              @if($empleado->cargo_id == $cargo->id)
                                <td class="text-center">{{$cargo->nombre}}</td>
                              @endif
                            @endforeach
                          @endif
                        @endforeach
                      @endif
                    @endforeach
                    <td style=" display: flex;justify-content: center;">
                      <button type="button" class="btn btn-warning text-white" style="margin-right: 5px; text-decoration:none;font-size: 15px"><i class="bi bi-pencil-square"></i></button>
                      <button type="button" class="btn btn-danger text-white" style="margin-left: 5px; text-decoration:none;font-size: 15px"><i class="bi bi-trash"></i></button>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop