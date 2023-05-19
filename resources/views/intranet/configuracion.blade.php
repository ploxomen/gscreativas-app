@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <script src="{{asset('asset/configuracion/miNegocio.js')}}"></script>
    <title>Configurar negocio</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 400px;">
                <img src="{{asset('asset/img/modulo/proceso.png')}}" alt="Imagen de configuración" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Configurar Negocio</h4>
            </div>
        </div>
        <form id="configuracionMiNegocio" class="form-row">
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del Negocio</legend>
                        <div class="col-12 form-group">
                            <label for="razon_social_id" class="col-form-label col-form-label-sm">Razón social</label>
                            <input type="text" value="{{$configuracion[0]->valor}}" class="form-control form-control-sm" id="razon_social_id" name="razon_social" maxlength="255" required>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="id_ruc" class="col-form-label col-form-label-sm">RUC</label>
                            <input type="text" maxlength="11" value="{{$configuracion[1]->valor}}" name="ruc" id="id_ruc" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="id_telefono" class="col-form-label col-form-label-sm">Teléfono</label>
                            <input type="tel" maxlength="15" value="{{$configuracion[3]->valor}}" name="telefono" id="id_telefono" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-md-6 col-lg-4 form-group">
                            <label for="id_celular" class="col-form-label col-form-label-sm">Celular</label>
                            <input type="tel" maxlength="15" value="{{$configuracion[2]->valor}}" name="celular" id="id_celular" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="id_correo" class="col-form-label col-form-label-sm">Correo</label>
                            <input type="email" maxlength="255" value="{{$configuracion[4]->valor}}" name="correo" id="id_correo" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="id_pagina_web" class="col-form-label col-form-label-sm">Página Web</label>
                            <input type="url" maxlength="255" value="{{$configuracion[5]->valor}}" name="pagina_web" id="id_pagina_web" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group">
                            <label for="id_direccion" class="col-form-label col-form-label-sm">Dirección</label>
                            <input type="text" maxlength="255" value="{{$configuracion[6]->valor}}" name="direccion" id="id_direccion" class="form-control form-control-sm">
                        </div>               
                </fieldset>
            </div>
            <div class="form-group col-12 col-md-6">
                <fieldset class="bg-white col-12 px-3 border form-row mb-3">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Datos del Propietario</legend>
                        <div class="col-6 form-group">
                            <label for="id_propietario_tipo_documento" class="col-form-label col-form-label-sm">Tipo Documento</label>
                            <select id="id_propietario_tipo_documento" name="propietario_tipo_documento" class="form-control form-control-sm select2-simple">
                                <option value=""></option>
                                @foreach ($tiposDocumentos as $tipoDocumento)
                                    <option value="{{$tipoDocumento->id}}" {{$tipoDocumento->id == $configuracion[7]->valor ? 'selected' : ''}}>{{$tipoDocumento->documento}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 form-group">
                            <label for="id_propietario_nro_documento" class="col-form-label col-form-label-sm">N° Documento</label>
                            <input type="tel" value="{{$configuracion[8]->valor}}" id="id_propietario_nro_documento" name="propietario_nro_documento" maxlength="20" class="form-control form-control-sm">
                        </div>
                        <div class="col-12 form-group">
                            <label for="id_propietario_apellidos_nombre" class="col-form-label col-form-label-sm">Apellidos y nombres</label>
                            <input type="text" value="{{$configuracion[9]->valor}}" name="propietario_apellidos_nombre" id="id_propietario_apellidos_nombre" maxlength="255" class="form-control form-control-sm">
                        </div>
                </fieldset>
                <fieldset class="bg-white col-12 px-3 border form-row">
                    <legend class="bg-white d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Caja</legend>
                        <div class="col-12 col-md-6 form-group">
                            <label for="id_abrir_caja" class="col-form-label col-form-label-sm">Abrir caja</label>
                            <input type="time" value="{{$configuracion[10]->valor}}" name="abrir_caja" id="id_abrir_caja" class="form-control form-control-sm" required>
                        </div>
                        <div class="col-12 col-md-6 form-group">
                            <label for="id_cerrar_caja" class="col-form-label col-form-label-sm">Cerra caja</label>
                            <input type="time" value="{{$configuracion[11]->valor}}" id="id_cerrar_caja" name="cerrar_caja" required class="form-control form-control-sm">
                        </div>
                </fieldset>
            </div>
            <div class="col-12 form-group text-center">
                <button type="submit" class="btn btn-success btn-sm" id="btnSubmitNegocio">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Actualizar Datos</span>
                </button>
            </div>
        </form>
    </section>
@endsection