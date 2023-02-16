@extends('general.index')
@section('head')
    <title>Agregar producto</title>
    <link rel="stylesheet" href="{{asset('asset/productos/pestilos.css')}}">
    <script src="{{asset('asset/general.js')}}"></script>
    <script src="{{asset('asset/productos/misProductos.js')}}"></script>
@endsection
@section('body')
    <section class="bg-white p-2">
        <form id="send-form" enctype="multipart/form-data">
            <fieldset class="px-3 border mb-4 form-row">
                <legend class="d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Nuevo producto</legend>
                <div class="form-group col-12 col-md-4 col-lg-3">
                    <label for="idsku">SKU:</label>
                    <input type="text" name="sku" id="idsku" class="form-control">
                </div>
                <div class="form-group col-12 col-md-4 col-lg-6">
                    <label for="idname">Producto: <small class="text-danger">*</small></label>
                    <input type="text" name="producto" id="idname" class="form-control">
                </div>
                <div class="form-group col-12 col-md-4 col-lg-3">
                    <label for="idmarca">Marca:</label>
                    <select name="marca" id="idmarca" class="form-control select2">
                        @foreach ($marcas as $marca)
                            <option value="{{$marca->id}}">{{$marca->marca}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12">
                    <label for="iddescription">Descripción:</label>
                    <textarea name="description" class="form-control" id="iddescription" cols="30" rows="5"></textarea>
                </div>
                <div class="form-group col-12 col-md-4 col-lg-3">
                    <label for="idprice">Precio de compra:</label> 
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">S/</div>
                        </div>
                        <input type="number" class="form-control" id="idprice_purchase" step="0.01" name="price_purchase">
                    </div>
                </div>
                <div class="form-group col-12 col-md-4 col-lg-3">
                    <label for="idprice">Precio de venta: <small class="text-danger">*</small></label> 
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">S/</div>
                        </div>
                        <input type="number" class="form-control" id="idprice_sale" step="0.01" name="price_sale">
                    </div>
                </div>
                <div class="form-group col-12 col-md-4 col-lg-3">
                    <label for="idunidad">Tipo de unidad: <small class="text-danger">*</small></label>
                    <select name="unidad" id="idunidad" class="form-control">
                        @foreach ($unidades as $unidad)
                            <option value="{{$unidad->id}}">{{$unidad->unidades}} ({{$unidad->abreviado}})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-12 col-lg-3">
                    <label for="idstock">Stock: <small class="text-danger">*</small></label>
                    <input type="number" class="form-control" name="stock" id="idstock" step="0.01">
                </div>
                <div class="form-group col-12 col-md-6 col-lg-4">
                    <label for="">Categorías: <small class="text-danger">*</small></label>
                    <select class="form-control select2" name="categorias[]" id="categorias" multiple>
                        <option></option>
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->name}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group col-12">
                    <input type="file" class="form-control" accept="image/*" multiple="" id="imagenes" name="productos-img[]" hidden>
                    <input type="file" multiple="" id="upload-img" hidden accept="image/*">
                    <button type="button" id="btn-load-img" class="btn btn-danger btn-sm"><span class="material-icons">image</span></button>
                </div>
                <div class="gorm-group">
                    <ul id="prev-img" class="lista-imagen"></ul>
                </div>
            </fieldset>
            <fieldset class="px-3 border mb-2">
                <legend class="d-inline-block w-auto px-2 border shadow-sm text-left legend-add">Conversión de unidades</legend>
                <section class="row">
                    <div class="col-12 text-right">
                        <button class="btn btn-primary btn-sm"><span class="material-icons">add</span></button>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="form-row">
                            <div class="col-5 col-lg-4 form-group">
                                <label for=""><small>UI:</small></label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <span>=></span>
                            </div>
                            <div class="col-5 col-lg-3 form-group">
                                <label for=""><small>Conversión:</small></label>
                                <input type="text" class="form-control form-control-sm">
                            </div>
                            <div class="col-6 col-lg-4 form-group">
                                <label for=""><small>Unidad:</small></label>
                                <select name="" id="" class="form-control form-control-sm">
                                    @foreach ($unidades as $unidad)
                                        <option value="{{$unidad->id}}">{{$unidad->unidades}} ({{$unidad->abreviado}})</option>
                                    @endforeach
                                </select> 
                            </div>
                        </div>
                        
                    </div>
                </section>
            </fieldset>
            <div class="form-group">
                <button class="btn btn-primary">
                    <div class="d-flex">
                        <span class="material-icons">add</span>
                        <span>Agregar</span>
                    </div>
                </button>
                <button class="btn btn-secondary" type="reset">
                    <div class="d-flex">
                        <span class="material-icons">clear_all</span>
                        <span>Limpiar</span>
                    </div>
                </button>
                <a href="{{route('listarProductos')}}" class="btn btn-danger">
                    <div class="d-flex">
                        <span>Mis productos</span>
                    </div>
                </a>
            </div>
        </form>
    </section>
@endsection