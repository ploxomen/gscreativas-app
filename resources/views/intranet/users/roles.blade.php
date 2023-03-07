@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/usuarios/rol.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/usuarios/rol.css')}}">
    <title>Roles</title>
@endsection
@section('body')
    <section class="p-3">
        <div class="mb-4">
            <div class="m-auto" style="max-width: 300px;">
                <img src="{{asset('asset/img/modulo/roles.png')}}" alt="Imagen de 4 roles" width="120px" class="img-fluid d-block m-auto">
                <h4 class="text-center text-primary my-2">Administración de roles</h4>
            </div>
        </div>
        
       <div class="row">
            <div class="form-group col-12 col-md-4">
                <form class="bg-white p-3 border" id="formRol">
                    <div class="form-group">
                        <label for="txtRol">Rol</label>
                        <input type="text" name="rol" maxlength="255" class="form-control" placeholder="Ej: Administrador" id="txtRol" required>
                    </div>
                    {{-- <div class="form-group">
                        <label for="txtIcono">Icono</label>
                        <input type="text" name="icono" maxlength="255" class="form-control" placeholder="Ej: fas fa-eraset" id="txtIcono">
                    </div>
                    <div class="form-group">
                        <small>
                            Para conseguir los íconos ingrese al siguiente enlace de
                            <a href="https://fontawesome.com/v5/search?o=r&m=free">FontAwesome</a>
                        </small>
                    </div> --}}
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
                    <table id="tablaRol" class="table table-sm table-bordered">
                        <thead class="text-center">
                            <tr>
                                <th>N°</th>
                                <th>Rol</th>
                                {{-- <th>Icono</th> --}}
                                {{-- <th>Fecha Creada</th>
                                <th>Fecha Actualizada</th> --}}
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
       </div>
    </section>
    
@endsection