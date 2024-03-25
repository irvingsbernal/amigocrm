<!DOCTYPE html>
    <html lang="en">
    <head>
    <title>Recibo de pago</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        * {
        box-sizing: border-box;
        }
    
        body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
        }
        
        /* Style the header */
        .header {
        background-color: #6279a4;
        padding: 5px;
        text-align: center;
        font-size: 35px;
        color:white;
        }
        
        /* Create three equal columns that floats next to each other */
        .column {
        float: left;
        padding: 10px;
        height: 300px; /* Should be removed. Only for demonstration */
        }
        
        /* Left and right column */
        .column.side {
        width: 25%;
        }
        
        /* Middle column */
        .column.middle {
        width: 50%;
        }
        
        /* Clear floats after the columns */
        .row:after {
        content: "";
        display: table;
        clear: both;
        }
        
        /* Style the footer */
        .footer {
        background-color: #6279a4;
        padding: 10px;
        text-align: center;
        }
        
        table {
        border-collapse: collapse;
        width: 100%;
        }
        
        th, td {
        text-align: left;
        padding: 8px;
        }
        
        tr:nth-child(even){background-color: #f2f2f2}
        
        th {
        background-color: white;
        color: black;
        }
        
        /* Responsive layout - makes the three columns stack on top of each other instead of next to each other */
        @media (max-width: 600px) {
        .column {
            width: 100%;
        }
        }
    </style>
    </head>
    <body>
    <div class="header">
      <h4>Recibo de pago Écrou Hexagonal</h4>
    </div>

    <div class="row">
      <div class="column side" style="background-color:white;">Datos cita <br><br>
        @foreach ($ordenservicio as $o)
      <label for="fname">Fecha:</label><br>
      <label>{{$o->fecha}}</label><br>
      <label for="lname">Horario:</label><br>
      <label>{{$o->horaInicio.'-'.$o->horaFin}}</label><br>
      <label for="fname">Auto:</label><br>
      <label>{{$o->marca.'/'.$o->modelo}}</label><br>
      <label for="lname">Sucursal:</label><br>
      <label>{{$o->nombreComercial}}</label><br>
      <label for="lname">Dirección:</label><br>
      <label>{{$o->direccion}}</label><br>
      @endforeach
        </div>

    <div class="column middle" style="background-color:white;">Datos orden de servicio <br><br>
    <b>Servicios</b>
    <table>
      <tr>
        <th>Servicio</th>
        <th>Subservicio</th>
        <th>Estatus</th>
      </tr>
      @foreach ($subservicios as $s)
      <tr>
        <td>{{$s->servicio}}</td>
        <td>{{$s->subservicio}}</td>
        <td>{{$s->estatus}}</td>
      </tr>
      @endforeach
    </table>
    <br><br>
    <b>Productos</b>
    <table>
      <tr>
        <th>Nombre</th>
        <th>Descripcion</th>
        <th>Marca</th>
      </tr>
      @foreach ($productos as $p)
      <tr>
        <td>{{$p->nombre}}</td>
        <td>{{$p->descripcion}}</td>
        <td>{{$p->marca}}</td>
      </tr>
      @endforeach
    </table>
    </div>
        
      <div class="column side" style="background-color:white;">Datos mecánico<br><br>
    
        @foreach ($ordenservicio as $o)
        <label for="fname">Mecánico asignado:</label><br>
        <label>{{$o->nombre.' '.$o->apellidoPaterno}}<label><br>
        <label for="lname">Teléfono:</label><br>
        <label>{{$o->telefono}}</label><br>
        <label for="fname">Correo:</label><br>
        <label>{{$o->correo}}</label><br>
        @endforeach
    </div>
    </div>
    
    <div class="footer">
        @foreach ($ordenservicio as $o)
        <label><b>Total: </b></label><label>${{$o->total}}<label><br>
            @endforeach
    </div>
    <p>Favor de guardar este comprobante de pago para futuras referencias</p>
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