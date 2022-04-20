@extends('layouts.master')
@section('contenido')
<div class="content mt-4 container-sm">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header ">
            <h4 class="card-title text-center">Listado de Sintomas</h4>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <th class="text-center">Identificación</th>
                  <th class="text-center">Fecha</th>
                  <th class="text-center">Persona</th>
                  <th class="text-center">Más</th>
                </thead>
                <tbody>
                  @foreach($registros as $registro)
                  <!-- Modal Visualizar-->
                  <div class="modal fade" id="mostrarSintomas{{$registro->sintoma}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog  modal-lg">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Sintomas Usuario</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body sintomas">
                          <div class="row">
                            <div class="col-sm-6">
                              <div class="mb-3">
                                <h2>Registro de Sintoma</h2>
                                <h6>{{$registro->sintoma}}</h6>
                              </div>
                              <div class="mb-3">
                                <h2>Identificación</h2>
                                <h6>{{ $registro->identificacion }}</h6>
                              </div>
                            </div>
                            <div class="col-sm-6">
                              <div class="mb-3">
                                <h2>Fecha</h2>
                                <h6>{{ $registro->fecha }}</h6>
                              </div>
                              <div class="mb-3">
                                <h2>Nombres</h2>
                                <h6>{{ $registro->nombres }} {{ $registro->apellidos }}</h6>
                              </div>
                            </div>
                          </div><br>
                          <div class="col-sm-12">
                            <h2>Sintomas</h2>
                            <div>
                              <div class="col-sm-10 mb-3"><br>
                                @foreach($sintomas as $sintoma)
                                @if($sintoma->registroSintoma_id == $registro->sintoma)
                                  <h6><i class="bi bi-check2-circle"> </i>{{ $sintoma->sintomas->nombre }}</h6>
                                @endif
                                @endforeach
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" style="text-decoration: none;color:white" class="btn btn-success" data-bs-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <tr>
                    <td class="text-center">{{ $registro->identificacion }}</td>
                    <td class="text-center">{{ $registro->fecha }}</td>
                    @foreach($estudiantes as $estudiante)
                    @if($registro->persona == $estudiante->persona_id)
                    <td class="text-center">Estudiante</td>
                    @else
                    @foreach($empleados as $empleado)
                    @if($registro->persona == $empleado->persona_id)
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
                      <button type="button" class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#mostrarSintomas{{$registro->sintoma}}" style="margin-right: 5px; text-decoration:none;font-size: 15px" onclick="mostrar('{{$registro->sintoma}}');"><i class="bi bi-three-dots"></i></button>
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