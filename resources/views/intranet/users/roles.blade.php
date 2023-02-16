@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/usuarios/rol.js')}}"></script>
    <title>Roles</title>
    {{-- <script src="{{asset('asset/auth/users.js')}}"></script> --}}
@endsection
@section('body')
    <section class="p-2">
       <div class="row">
            <div class="bg-white p-2 col-12 col-md-4">
                <form action="">
                    <div class="form-group">
                        <label for="txtRol">Rol</label>
                        <input type="text" maxlength="255" class="form-control" placeholder="Ej: Administrador" id="txtRol">
                    </div>
                    <div class="form-group">
                        <label for="txtIcono">Icono</label>
                        <input type="text" maxlength="255" class="form-control" placeholder="Ej: fas fa-eraset" id="txtIcono">
                    </div>
                    <div class="form-group">
                        <span>
                            Para conseguir los íconos ingrese al siguiente enlace de
                            <a href="https://fontawesome.com/v5/search?o=r&m=free">FontAwesome</a>
                        </span>
                    </div>
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-outline-primary">
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
            <div class="bg-white p-2 col-12 col-md-8">
                <table id="tablaRol"></table>
            </div>
       </div>
    </section>
    
@endsection