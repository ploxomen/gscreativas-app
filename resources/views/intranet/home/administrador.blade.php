@extends('general.index')
@section('head')
    <script src="{{asset('asset/general.js')}}"></script>
    <link rel="stylesheet" href="{{asset('asset/home/administrador.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{asset('asset/home/administrador.js')}}"></script>
    <title>Página de inicio</title>
@endsection
@section('body')
    <h5>Panel de inicio</h5>
    <div class="p-3">
        <section class="row mb-4">
            <div class="form-group col-12 col-sm-6 col-lg-3">
                <div class="carta color1">
                    <div class="principal">
                        <span class="tipo">Ventas del día</span>
                        <span class="valor">S/ {{number_format($ventasDia,2)}}</span>
                    </div>
                    <div class="icono">
                        <span class="material-icons">paid</span>
                    </div>
                    <span class="indicador"></span>
                </div>
            </div>
            <div class="form-group col-12 col-sm-6 col-lg-3">
                <div class="carta color2">
                    <div class="principal">
                        <span class="tipo">Ventas del mes</span>
                        <span class="valor">S/ {{number_format($ventasMes,2)}}</span>
                    </div>
                    <div class="icono">
                        <span class="material-icons">paid</span>
                    </div>
                    <span class="indicador"></span>
                </div>
            </div>
            <div class="form-group col-12 col-sm-6 col-lg-3">
                <div class="carta color3">
                    <div class="principal">
                        <span class="tipo">Compras del mes</span>
                        <span class="valor">S/ {{number_format($comprasMes,2)}}</span>
                    </div>
                    <div class="icono">
                        <span class="material-icons">shopping_cart_checkout</span>
                    </div>
                    <span class="indicador"></span>
                </div>
            </div>
            <div class="form-group col-12 col-sm-6 col-lg-3">
                <div class="carta color4">
                    <div class="principal">
                        <span class="tipo">Clientes</span>
                        <span class="valor">{{$totalClientes}}</span>
                    </div>
                    <div class="icono">
                        <span class="material-icons">people</span>
                    </div>
                    <span class="indicador"></span>
                </div>
            </div>
        </section>
        <section class="bg-white p-3 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="title">
                    <h6 class="mb-0">Ventas del año</h6>
                </div>
                <div class="control d-flex align-items-center">
                    <select class="form-control form-control-sm" id="cbAnioVentas" style="max-width: 100px;">
                        @for ($i = 2023; $i <= date('Y'); $i++)
                            <option value="{{$i}}">{{$i}}</option> 
                        @endfor
                    </select>
                </div>
            </div>
            <div class="ventas-mes-grafico">
                <div class="">
                    <div style="max-width: 1000px;" class="m-auto">
                        <canvas class="graficos" id="grafico-1"></canvas>
                    </div>
                </div>
            </div>
        </section>
        <section class="p-3 mb-4">
            <div class="row">
                <div class="col-12 form-group col-lg-6">
                    <div class="bg-white p-3 ventas-semanales">
                        <div>
                            <h6>Top 5 productos más vendidos en el {{date('Y')}}</h6>
                        </div>
                        <div class="">
                            <div style="max-width: 300px;" class="m-auto">
                                <canvas id="grafico-2" width="100%"></canvas>
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="col-12 form-group col-lg-6">
                    <div class="bg-white p-3 ultima-notificacion">
                        <div class="mb-3">
                            <h6>Productos por caducar</h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered" style="font-size: 0.9rem;" id="tablaPerecedero">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Fecha vencimiento</th>
                                        <th>Días restante</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection