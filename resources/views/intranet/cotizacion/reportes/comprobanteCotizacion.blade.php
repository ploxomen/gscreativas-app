<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Comprobante Cotizacion</title>
</head>
<body>
    <style>
        @page{
            font-family: Arial, Helvetica, sans-serif;
        }
        table{
            width: 700px;
            border-collapse: collapse;
        }
        p{
            margin: 5px 0;
        }
        .text-logo{
            font-size: 25px;
        }
    </style>
    <table style="margin-bottom: 30px;">
        <tr>
            <td>
                <b class="text-logo">{{$configuracion[0]->valor}}</b>
            </td>
            <td rowspan="6" style="text-align: center;">
                <p><b class="text-logo">COTIZACIÓN</b></p>
                <p>N° {{str_pad($cotizacion->id,5,"0",STR_PAD_LEFT)}}</p>
                <p><b>Fecha:</b><span> {{date("d/m/Y",strtotime($cotizacion->fechaCotizacion))}}</span></p>
                <p><b>Cotizado por:</b><span>{{$cotizacion->cotizador->nombres .' ' . $cotizacion->cotizador->apellidos}}</span></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>RUC:</b>
                    <span>{{$configuracion[1]->valor}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>Dirección:</b>
                    <span>{{$configuracion[6]->valor}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>Correo:</b>
                    <span>{{$configuracion[4]->valor}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>Teléfono:</b>
                    <span>{{$configuracion[3]->valor}}</span>
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <b>Celular:</b>
                    <span>{{$configuracion[2]->valor}}</span>
                </p>
            </td>
        </tr>
    </table>
    <div style="margin-bottom: 30px;">
        <p>
            <b>Cliente:</b>
            <span>{{empty($cotizacion->cliente) ? 'Cliente no establecido' : $cotizacion->cliente}}</span>
        </p>
    </div>
    <table style="font-size: 13px; border: 1px solid black; margin-bottom: 50px;">
        <thead style="background: rgb(212, 212, 212);">
            <tr>
                <th>CANTIDAD</th>
                <th>DESCRIPCIÓN</th>
                <th>PRECIO UNITARIO</th>
                <th>DESCUENTO</th>
                <th>MONTO</th>
            </tr>
        </thead>
        <tbody style="text-align: center;">
            @foreach ($cotizacion->productos as $cotizacionDeta)
                <tr>
                    <td>{{$cotizacionDeta->pivot->cantidad}}</td>
                    <td>{{$cotizacionDeta->nombreProducto}}</td>
                    <td>S/{{$cotizacionDeta->pivot->costo}}</td>
                    <td>- S/{{$cotizacionDeta->pivot->descuento}}</td>
                    <td>S/{{$cotizacionDeta->pivot->total}}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot style="text-align: right;">
            <tr >
                <td colspan="4" style="padding-top: 20px;">SUBTOTAL</td>
                <td style="text-align: center; padding-top: 20px;">S/ {{$cotizacion->importe}}</td>
            </tr>
            <tr>
                <td colspan="4">IGV</td>
                <td style="text-align: center;">S/ {{$cotizacion->igv}}</td>
            </tr>
            <tr>
                <td colspan="4">DESCUENTO TOTAL</td>
                <td style="text-align: center;">- S/ {{$cotizacion->descuento}}</td>
            </tr>
            @if (!empty(floatval($cotizacion->envio)))
                <tr>
                    <td colspan="4">ENVÍO</td>
                    <td style="text-align: center;">S/ {{$cotizacion->envio}}</td>
                </tr>
            @endif
            <tr>
                <td colspan="4">TOTAL</td>
                <td style="text-align: center;">S/ {{$cotizacion->total}}</td>
            </tr>
        </tfoot>
    </table>
    <h5 style="text-align: center; margin: 20px 0;">Si deseas realizar alguna consulta con respecto a la cotización, no dudes en comunicarte con nosotros</h5>
    <h3 style="text-align: center;">!GRACIAS POR SU PREFERENCIA!</h3>
</body>
</html>