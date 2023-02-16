@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    @include('headDatatable')
    <script src="{{asset('asset/auth/users.js')}}"></script>
    <title>Usuarios</title>
@endsection
@section('body')
<section class="p-3">
    <div class="mb-4">
        <div class="m-auto" style="max-width: 400px;">
            <img src="{{asset('asset/img/modulo/usuario.png')}}" alt="Imagen de una persona con roles" width="120px" class="img-fluid d-block m-auto">
            <h4 class="text-center text-primary my-2">Administración de usuarios</h4>
        </div>
    </div>
    <div class="form-group text-right">
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#usurioModal">
            <i class="fas fa-plus"></i>
            <span>Agregar</span>
        </button>
    </div>
    <div class="bg-white p-3 mb-3">
        <form action="" class="row">
            <div class="form-group col-12 col-md-6 col-xl-3">
                <label for="cbArea">Área:</label>
                <select name="area" id="cbArea" class="form-control">
                    <option value="todos">Todos</option>
                    @foreach ($areas as $area)
                        <option value="{{$area->id}}">{{$area->nombreArea}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-12 col-md-6 col-xl-3">
                <label for="cbRol">Rol:</label>
                <select name="rol" id="cbRol" class="form-control">
                    <option value="todos">Todos</option>
                    @foreach ($roles as $rol)
                        <option value="{{$rol->id}}">{{$rol->nombreRol}}</option>
                    @endforeach
                </select>
            </div>
            
            
        </form>
    </div>
    <div class="bg-white p-3">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre y Apellido</th>
                        <th>Celular</th>
                        <th>Correo</th>
                        <th>Área</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jean Pier Carrasco Tamariz</td>
                        <td>924777699</td>
                        <td>jeanpi.jpct@gmail.com</td>
                        <td>Sistemas</td>
                        <td class="text-success">Activo</td>
                        <td>
                            <button class="btn btn-danger btn-sm"><span class="material-icons">delete</span></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
@include('intranet.users.modales.usuario')
@endsection