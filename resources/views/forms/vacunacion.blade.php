@extends('layouts.master')
@section('contenido')
<div class="container">

  <div id="logo">
    <h1 class="logo">Udenar</h1>
  </div>
  <div class="leftbox">
    <nav>
      <a id="profile" class="active"><i class="fa-solid fa-syringe"></i></a><br><br><br><br>
      <a id="payment"><i class="bi bi-heart-pulse h3"></i></a><br><br><br><br>
      <a id="subscription"><i class="fa fa-tv"></i></a>
    </nav>
  </div>
  <div class="rightbox">
    <div class="profile">
      <div class="row">
        <div class="col-sm-6 mt-5">
          <h1>Formulario Vacunación</h1>
        </div>
        <div class="col-sm-6 mt-12">
          <h1 style="float: right; font-size:13.5px">CovIndcadores</h1>
        </div>
      </div>
      <form action="{{ url('/forms/vacunacion') }}" method="post">
        @csrf
        <div>
          <div class="mb-3">
            <label for="identificacion" class="form-label laber-form ">Identificación</label>
            <input type="number" class="input-form form-control" name="identificacion" id="identificacion" required>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label laber-form ">Fecha Aplicación</label>
            <input type="date" class="input-form form-control" name="fecha" id="fecha" max="<?= date('Y-m-d'); ?>" required>
          </div>
          <div class="mb-3">
            <label for="dosis" class="form-label laber-form ">Tipo de vacuna</label>
            <select class="input-form" name="vacuna" id="vacuna" required>
              <option value="">Seleccione una opción</option>
              @foreach($vacunas as $vacuna)
              <option value="{{ $vacuna->id }}">{{ $vacuna->vacuna }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="dosis" class="form-label laber-form ">Dosis de vacuna</label>
            <select class="input-form" name="dosis" id="dosis" required>
              <option value="">Seleccione una opción</option>
              @foreach($dosis as $d)
              <option value="{{ $d->id }}">{{ $d->dosis }}</option>
              @endforeach
            </select>
          </div>
          <div class="mb-3">
            <label for="archivo" class="form-label laber-form ">subir Archivo (Opcional)</label>
            <input type="file" disabled class="input-form form-control" name="archivo" id="archivo">
          </div>
          <div class="centrar">
            <button type="submit" class="btn btn-success btn-color">Enviar</button>
          </div>
        </div>
      </form>

    </div>

    <div class="payment noshow" style="margin-top: -88%;">
      <div class="row">
        <div class="col-sm-6">
          <h1>Formulario de Síntomas</h1>
        </div>
        <div class="col-sm-6">
          <h1 style="float: right; font-size:13.5px;margin-top:-2px">CovIndcadores</h1>
        </div>
      </div><br>
      <form action="{{ url('/forms/sintomas') }}" method="post">
        @csrf
        <div>
          <div class="mb-3">
            <label for="identificacion" class="form-label laber-form ">Identificación</label>
            <input type="number" class="input-form form-control" name="identificacion" id="identificacion" required>
          </div>
          <div class="mb-3 table-responsive mt-5">
            <div class="col-sm-10" style="font-size: 14px;max-height: 250px;">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col" style="width: 100px;">Seleción</th>
                    <th scope="col">Síntoma</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($sintomas as $sintoma)
                  <tr>
                    <th><input type="checkbox" value="{{$sintoma->id}}" name="sintoma[]" id="sintoma"></th>
                    <td>{{$sintoma->nombre}}</td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>

          <div>
            <button type="submit" class="btn btn-success btn-color" style="margin-left: 90%; margin-top: -5.5%">Enviar</button>
          </div>
        </div>
      </form>
    </div>

    <div class="subscription noshow" style="margin-top: -84%;">
      <div class="row">
        <div class="col-sm-6">
          <h1>Formulario de Contagio</h1>
        </div>
        <div class="col-sm-6">
          <h1 style="float: right; font-size:13.5px;margin-top:-2px">CovIndcadores</h1>
        </div>
      </div><br>
    </div>
  </div>
</div>
@stop