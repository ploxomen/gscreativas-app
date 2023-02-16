@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/usuarios/area.js')}}"></script>
    <title>Area</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 300px;">
                <img src="{{asset('asset/img/modulo/area.png')}}" alt="Imagen de área" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Administración de áreas</h4>
            </div>
        </div>
        
       <div class="row">
            <div class="form-group col-12 col-md-4">
                <form class="bg-white p-3 border" id="formArea">
                    <div class="form-group">
                        <label for="txtArea">Area</label>
                        <input type="text" name="area" maxlength="255" class="form-control" placeholder="Ej: Ventas" id="txtArea" required>
                        <small class="form-text text-muted">Escriba las áreas que se le asignaran a los usuarios</small>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-primary" id="btnGuardarForm">
                            <i class="fas fa-save"></i>
                            <span>Guardar</span>
                        </button>
                        <button type="reset" class="btn btn-outline-danger">
                            <i class="fas fa-eraser"></i>
                            <span>Cancelar</span>
                        </button>
                    </div>
                </form>
            </div>
            <div class="form-group col-12 col-md-8">
                <div class="bg-white p-3 border">
                    <table id="tablaArea" class="table table-sm table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>N°</th>
                                <th>Area</th>
                                <th>Fecha Creada</th>
                                <th>Fecha Actualizada</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
       </div>
    </section>
    
@endsection