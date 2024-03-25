<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Comprobante de cita - ÉH</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 15px;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .logo{
            width: 100px;
            height: 59px;
            padding-right: 50px;
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
            justify-content: center;
            border-radius: 12px;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
            background: #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        .row{
            display: -ms-flexbox;
            display: flex;
            -ms-flex-wrap: wrap;
            flex-wrap: wrap;
            margin-right: -15px;
            margin-left: -15px;
        }
    </style>
</head>
<body>
    <div class="izquierda row">
        <img class="logo" src="img/logoeh.png" class="img-avatar" alt="Foto">
    </div>
    <br>
    <div class="row">
        <h3>Comprobante de cita<span class="derecha">Impreso el: {{now()}}</span></h3>
    </div>
    <div class="row">
        @foreach ($numerocliente as $nc)
        <p><strong>No. cliente: </strong>{{$nc->numerocliente}}</p>
        @endforeach     
    </div>
       <br>
    <div>
                @foreach ($citas as $c)
                <div class="row">
                    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('png')->size(100)->generate($c->id)) }} "></p>
                </div>
                <div class="row">
                        <p><b>Sucursal: </b>{{$c->nombreComercial}}</p>
                </div> 
                <div class="row">
                        <p><b>Dirección de la sucursal: </b>{{$c->direccion}}</p>
                    </div>
                    <div class="row">
                        <p><b>Fecha: </b>{{$c->fecha}}</p>
                    </div>
                    <div class="row">
                        <p><b>Horario de cita: </b>{{$c->horaInicio .' - '. $c->horaFin}}</p>
                    </div>
                    <div class="row">
                        <p><b>Automóvil: </b>{{$c->marca .'/'. $c->modelo}}</p>
                    </div>
                    <div class="row">
                        <p><b>Placas: </b>{{$c->placa}}</p>
                    </div>
                    <div class="row">
                        @if($c->estatus == 1)
                        <p><b>Estatus: </b>Cita confirmada</p>
                        @endif
                </div>   
                @endforeach      
                                    
    </div>
    {{-- <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div>     --}}
</body>
</html>

{{-- $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria',
                     'categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras',
                     'productos.descripcion','productos.precioVenta','productos.presentacion',
                     'productos.unidad','productos.ventaXpartes','productos.estatus')
            ->orderBy('productos.id', 'desc')->get(); --}}


{{-- $inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 

            ->select(','productos.id', 'productos.FkidCategoria',
                      ,, 
                      ''
                     
                    
                    ,)
            ->orderBy('productos.id', 'desc')->get();
            productos.codigoBarras',
            'productos.nombre'
            'productos.marca',
            productos.modelo',
            ''productos.presentacion', 'productos.unidad',
            'categorias.nombre as nombre_categoria'
            'productos.descripcion',
            productos.precioVenta',
            'productos.ventaXpartes'
            'productos.estatus'
            inventarios.cantidad' --}}