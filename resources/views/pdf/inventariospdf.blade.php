<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de inventario - ÉH</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 9px;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .logo{
            width: 100px;
            height: 59px;
            padding-right: 10px;
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
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
    </style>
</head>
<body>
    <div class="izquierda">
        <img class="logo" src="img/logoeh.png" class="img-avatar" alt="Foto">
    </div>
    <br>
    <div>
        <h3>Listado de insumos/refacciones<span class="derecha">{{now()}}</span></h3>
    </div>
    <br>
    <div>
        <table class="table table-bordered table-striped table-sm">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Presentación</th>
                    <th>Categoría</th>
                    {{-- <th>Descripción</th> --}}
                    <th>Precio Venta</th>
                    <th>VentaXPartes</th>
                    {{-- <th>Estatus</th> --}}
                    <th>Stock</th> 
                </tr>
            </thead>
            <tbody>
                @foreach ($inventarios as $i)
                <tr>
                    <td>{{$i->codigoBarras}}</td>
                    <td>{{$i->nombre}}</td>
                    <td>{{$i->marca}}</td>
                    <td>{{$i->modelo}}</td>
                    <td>{{$i->presentacion . $i->unidad}}</td>
                    <td>{{$i->nombre_categoria}}</td>
                    {{-- <td>{{$i->descripcion}}</td> --}}
                    <td>{{$i->precioVenta}}</td>
                    <td>{{$i->ventaXpartes?'SI':'NO'}}</td>
                    {{-- <td>{{$i->estatus?'Activo':'Desactivado'}}</td> --}}
                    <td>{{$i->cantidad}}</td>    
                </tr>
                @endforeach                                
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div>    
</body>
</html>

$inventarios = Inventario::join('productos','inventarios.fk_producto','=','productos.id')
            ->join('categorias','productos.FkidCategoria','=','categorias.id') 
            ->select('inventarios.cantidad','productos.id', 'productos.FkidCategoria',
                     'categorias.nombre as nombre_categoria','productos.nombre', 
                     'productos.marca', 'productos.modelo','productos.codigoBarras',
                     'productos.descripcion','productos.precioVenta','productos.presentacion',
                     'productos.unidad','productos.ventaXpartes','productos.estatus')
            ->orderBy('productos.id', 'desc')->get();


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