<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//MIDDLEWARE GRUPO: INVITADOS (VISITANTES AÚN NO AUTENTICADOS)
Route::group(['middleware' => ['guest']], function() {

    Route::get('/', function () {
          return view('contenido/index');
    })->name('index');

    //LOGIN
    Route::get('/log', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');

        //REGISTRO
        Route::get('/registro', 'RegistroController@showRegistroForm');
        Route::post('/registrocliente', 'RegistroController@registroCliente');
        Route::get('/activacion-cuenta', 'RegistroController@showActivacionForm');
        Route::post('/cliente/activarcuenta', 'RegistroController@activarCuenta');
});

//MIDDLEWARE GRUPO: AUTENTICADOS (USUARIOS AUTENTICADOS)
Route::group(['middleware' => ['auth']], function() {

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard2', 'DashboardController2');

    //MIDDLEWARE GRUPO: ADMINISTRADOR -------------------------------------------------------------------------------------------------------------------------------------------
    Route::group(['middleware' => ['Administrador']], function() {

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');

        //CITAS - ADMINISTRADOR
        Route::get('/listarCitas', 'CitaController@listarCitasEmpleados');
        Route::get('/listarCitas/dia', 'CitaController@listarCitasEmpleadosDia');
        Route::get('/automovilesCliente', 'DashboardController@listarAutosCliente');
        Route::put('/autorizar', 'CitaController@autorizarCita');
        Route::put('/rechazar', 'CitaController@rechazarCita');
        Route::get('/listarCitasOrden', 'CitaController@listarCitasOrden');
        Route::get('/obtenerCitasDashboard', 'CitaController@obtenerCitasDashboard');
        
        //CATEGORIAS - ADMINISTRADOR
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@guardar');
        Route::put('/categoria/actualizar', 'CategoriaController@actualizar');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/seleccionarCategoria', 'CategoriaController@seleccionarCategoria');
        
        //PRODUCTOS - ADMINISTRADOR
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@guardar');
        Route::put('/producto/actualizar', 'ProductoController@actualizar');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        
        //PROVEEDORES - ADMINISTRADOR
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@guardar');
        Route::put('/proveedor/actualizar', 'ProveedorController@actualizar');
        Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
        Route::put('/proveedor/activar', 'ProveedorController@activar');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        
        //PUESTOS - ADMINISTRADOR
        Route::get('/puesto', 'PuestoController@index');
        Route::post('/puesto/registrar', 'PuestoController@guardar');
        Route::put('/puesto/actualizar', 'PuestoController@actualizar');
        Route::put('/puesto/desactivar', 'PuestoController@desactivar');
        Route::put('/puesto/activar', 'PuestoController@activar');
        Route::get('/puesto/seleccionarPuesto', 'PuestoController@seleccionarPuesto');
        
        //EMPLEADOS - ADMINISTRADOR
        Route::get('/empleado', 'EmpleadoController@index');
        Route::post('/empleado/registrar', 'EmpleadoController@guardar');
        Route::put('/empleado/actualizar', 'EmpleadoController@actualizar');
        Route::put('/empleado/desactivar', 'EmpleadoController@desactivar');
        Route::put('/empleado/activar', 'EmpleadoController@activar');
	    Route::get('/empleado/selectEmpleadoOrden', 'EmpleadoController@selectEmpleadoOrden');
        
        // CLIENTES - ADMINISTRADOR
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        Route::get('/cliente/selectClienteOrden', 'ClienteController@selectClienteOrden');
        
        // AUTOS - ADMINISTRADOR
        Route::get('/auto', 'AutoController@index');
        Route::post('/auto/registrar', 'AutoController@store');
        Route::put('/auto/actualizar', 'AutoController@update');
        Route::put('/auto/desactivar', 'AutoController@desactivar');
        Route::put('/auto/activar', 'AutoController@activar');
        
        //EMAIL - ADMINISTRADOR
        Route::post('/contactar', 'EmailController@contact')->name('contact');
        
        //SUCURSALES - ADMINISTRADOR
        Route::get('/sucursal', 'SucursalController@index');
        Route::post('/sucursal/registrar', 'SucursalController@store');
        Route::put('/sucursal/actualizar', 'SucursalController@update');
        Route::put('/sucursal/desactivar', 'SucursalController@desactivar');
        Route::put('/sucursal/activar', 'SucursalController@activar');
        Route::put('/sucursal/configurarHorario', 'SucursalController@configurarHorario');
	    Route::get('/sucursal/selectSucursalOrden', 'SucursalController@selectSucursalOrden');
        
        // INVENTARIO - ADMINISTRADOR
        Route::get('/inventario', 'InventarioController@index');
        Route::get('/inventario/selectProducto', 'InventarioController@selectProductoOrden');
        Route::get('/inventario/listarProductoInventario', 'InventarioController@listarProductoInventario');
        Route::get('/inventario/generarPDF', 'InventarioController@generarPDF')->name('inventarios_pdf');

	    //FINANZAS - ADMINISTRADOR
        Route::get('/finanzas', 'FinanzasController@index');
        Route::post('/finanzas/registrar', 'FinanzasController@guardar');
        Route::put('/finanzas/actualizar', 'FinanzasController@actualizar');
        Route::put('/finanzas/desactivar', 'FinanzasController@desactivar');
        Route::put('/finanzas/activar', 'FinanzasController@activar');
        Route::get('/finanzas/seleccionarAnios','FinanzasController@seleccionarAnios');
        Route::get('/finanzas/consultarReporte','FinanzasController@datosReporte');
        Route::get('/finanzas/mesesIngresos','FinanzasController@mesesIngresos');
        Route::get('/finanzas/ingresosMes','FinanzasController@IngresosMes');
        Route::get('/finanzas/mesesGastos','FinanzasController@mesesGastos');
        Route::get('/finanzas/GastosMes','FinanzasController@GastosMes');

        //INGRESOS - ADMINISTRADOR
        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@guardar');
        Route::put('/ingreso/desactivar', 'IngresoController@anular');
        Route::get('/ingreso/obtenerIngreso', 'IngresoController@obtenerIngreso');
        Route::get('/ingreso/obtenerDetallesDeIngreso', 'IngresoController@obtenerDetallesDeIngreso');

        // SERVICIO - ADMINISTRADOR
        Route::get('/servicio', 'ServicioController@index');
        Route::get('/servicio/selectServicio', 'ServicioController@selectServicio');
        Route::post('/servicio/registrar', 'ServicioController@store');
        Route::put('/servicio/actualizar', 'ServicioController@update');
        Route::put('/servicio/desactivar', 'ServicioController@desactivar');
        Route::put('/servicio/activar', 'ServicioController@activar');

        // SUBSERVICIO - ADMINISTRADOR
        Route::get('/subservicio', 'SubServicioController@index');
        Route::post('/subservicio/registrar', 'SubServicioController@store');
        Route::put('/subservicio/actualizar', 'SubServicioController@update');
        Route::put('/subservicio/desactivar', 'SubServicioController@desactivar');
        Route::put('/subservicio/activar', 'SubServicioController@activar');
        Route::get('/subservicio/listarSubServicio', 'SubServicioController@listarSubServicio');

        //ORDEN SERVICIO - ADMINISTRADOR
        Route::get('/ordenservicio', 'OrdenServicioController@index');
        Route::post('/ordenservicio/registrar', 'OrdenServicioController@store');
        Route::put('/ordenservicio/actualizar', 'OrdenServicioController@update');
        Route::put('/ordenservicio/desactivar', 'OrdenServicioController@desactivar');
        Route::put('/ordenservicio/activar', 'OrdenServicioController@activar');
        Route::get('/ordenservicio/getOrdenServicio', 'OrdenServicioController@getOrdenServicio');
        Route::get('/ordenservicio/getOrdenSubservicio', 'OrdenServicioController@getOrdenSubservicio');
        Route::get('/ordenservicio/getOrdenProductos', 'OrdenServicioController@getOrdenProductos');
        Route::get('/automovil/selectAutoOrden', 'AutoController@selectAutoOrden');
        Route::get('/ordenservicio/listarOrdenMecanico', 'OrdenServicioController@listarOrdenMecanico');
        Route::get('/ordenservicio/obtenerOrdenesFinalizadas', 'OrdenServicioController@obtenerOrdenesFinalizadas');
        Route::put('/ordenservicio/pagado', 'OrdenServicioController@pagado');
        Route::get('/ordenservicio/generarPDF', 'OrdenServicioController@generarPDF');
        Route::get('/ordenservicio/listarOrdenAdmin', 'OrdenServicioController@listarOrdenAdmin');

    
        //COTIZACIÓN - ADMINISTRADOR
        Route::get('/cotizacion/selectSubServicioCoti', 'CotizacionController@selectSubServicioCoti');
        Route::get('/cotizacion/selectProductoCoti', 'CotizacionController@selectProductoCoti');
        Route::post('/cotizacion/anadirServicioCoti', 'CotizacionController@anadirServicioCoti');
        Route::post('/cotizacion/anadirProductoCoti', 'CotizacionController@anadirProductoCoti');

        //ORDEN SUBSERVICIO - ADMINISTRADOR
        Route::put('/ordenservicio/desactivarEmpleado', 'OrdenServicioController@desactivarEmpleado');
        Route::put('/ordenservicio/activarEmpleado', 'OrdenServicioController@activarEmpleado');
        Route::put('/ordenservicio/terminarOrden', 'OrdenServicioController@terminarOrden');


    });

    //MIDDLEWARE GRUPO: CLIENTES -------------------------------------------------------------------------------------------------------------------------------------------
    Route::group(['middleware' => ['Cliente']], function() {
        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');;

        //DASHBOARD - CLIENTE
        Route::get('/automovilesCliente', 'DashboardController@listarAutosCliente');
        Route::get('/obtenerCliente', 'DashboardController@obtenerCliente');

        //AUTOMÓVIL - CLIENTE
        Route::get('/automovil', 'AutoController@index');
        Route::post('/automovil/registrar', 'AutoController@store');
        Route::put('/automovil/actualizar', 'AutoController@update');
        Route::put('/automovil/desactivar', 'AutoController@desactivar');
        Route::put('/automovil/activar', 'AutoController@activar');

        //SUCURSAL - CLIENTE
        Route::get('/sucursales', 'CitaController@selectSucursal');
         
        //Cotización
        Route::get('/cotizacion/selectSubServicioCoti', 'CotizacionController@selectSubServicioCoti');
        Route::get('/cotizacion/selectProductoCoti', 'CotizacionController@selectProductoCoti');
        Route::post('/cotizacion/anadirServicioCoti', 'CotizacionController@anadirServicioCoti');
        Route::post('/cotizacion/anadirProductoCoti', 'CotizacionController@anadirProductoCoti');

        //CITA - CLIENTE
        Route::get('/cita', 'CitaController@index');
        Route::get('/obtenerCitasRecientes', 'CitaController@obtenerCitasRecientes');
        Route::post('/cita/registrar', 'CitaController@store');
        Route::put('/cita/actualizar', 'CitaController@update');
        Route::put('/cita/cancelar', 'CitaController@cancelarCita');
        Route::get('/cita/generarPDF', 'CitaController@generarPDF')->name('citas_pdf');

        //HORARIOS - CLIENTE
        Route::get('/horarios', 'HorarioController@obtenerHorarioPorSucursal');

        //HISTORIAL - CLIENTE
        Route::get('/servicios', 'DashboardController@serviciosCliente');
        Route::get('/productos/servicio', 'DashboardController@obtenerProductosServicio');
        Route::get('/subservicios/servicio', 'DashboardController@obtenerSubservicioServicio');
    });
    
    //MIDDLEWARE GRUPO: EMPLEADOS (TÉCNICOS MECÁNICOS) -------------------------------------------------------------------------------------------------------------------------------------------
    Route::group(['middleware' => ['Empleado']], function() {
        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');;
         
        //PRODUCTOS - EMPLEADO
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@guardar');
        Route::put('/producto/actualizar', 'ProductoController@actualizar');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        
        // CLIENTES - EMPLEADO
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        //SERVICIOS - EMPLEADO
        Route::get('/ordenservicio/listarOrdenMecanico', 'OrdenServicioController@listarOrdenMecanico');
        Route::get('/ordenservicio/obtenerOrdenesFinalizadasEmpleado', 'OrdenServicioController@obtenerOrdenesFinalizadasEmpleado');
        Route::get('/ordenservicio/obtenerEmpleadoConUsuario', 'OrdenServicioController@obtenerEmpleadoConUsuario');
        
        // AUTOS - EMPLEADO
        Route::get('/auto', 'AutoController@index');
        Route::post('/auto/registrar', 'AutoController@store');
        Route::put('/auto/actualizar', 'AutoController@update');
        Route::put('/auto/desactivar', 'AutoController@desactivar');
        Route::put('/auto/activar', 'AutoController@activar');
        
        //EMAIL - EMPLEADO 
        Route::post('/contactar', 'EmailController@contact')->name('contact');
        
        
        //SUCURSALES - EMPLEADO
        Route::get('/sucursal', 'SucursalController@index');
        Route::post('/sucursal/registrar', 'SucursalController@store');
        Route::put('/sucursal/actualizar', 'SucursalController@update');
        Route::put('/sucursal/desactivar', 'SucursalController@desactivar');
        Route::put('/sucursal/activar', 'SucursalController@activar');
        Route::put('/sucursal/configurarHorario', 'SucursalController@configurarHorario');
        
        // INVENTARIO - EMPLEADO
        Route::get('/inventario', 'InventarioController@index');
        Route::get('/inventario/selectProducto', 'InventarioController@selectProductoOrden');
        Route::get('/inventario/generarPDF', 'InventarioController@generarPDF')->name('inventarios_pdf');
        
        //INGRESOS - EMPLEADO
        // Route::get('/ingreso', 'IngresoController@index');
        // Route::post('/ingreso/registrar', 'IngresoController@guardar');
        // Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        // Route::get('/ingreso/obtenerCabecera', 'IngresoController@getIngreso');
        // Route::get('/ingreso/obtenerDetalles', 'IngresoController@getDetalles');
        
        //Cotización
        Route::get('/cotizacion/selectSubServicioCoti', 'CotizacionController@selectSubServicioCoti');
        Route::get('/cotizacion/selectProductoCoti', 'CotizacionController@selectProductoCoti');
        Route::post('/cotizacion/anadirServicioCoti', 'CotizacionController@anadirServicioCoti');
        Route::post('/cotizacion/anadirProductoCoti', 'CotizacionController@anadirProductoCoti');

    });

    //MIDDLEWARE GRUPO: RECEPCIONISTA -------------------------------------------------------------------------------------------------------------------------------------------
    Route::group(['middleware' => ['Recepcionista']], function() {

        Route::get('/main', function () {
            return view('contenido/contenido');
        })->name('main');;
        
        //CATEGORIAS - RECEPCIONISTA
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@guardar');
        Route::put('/categoria/actualizar', 'CategoriaController@actualizar');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/seleccionarCategoria', 'CategoriaController@seleccionarCategoria');
        
        //PRODUCTOS - RECEPCIONISTA
        Route::get('/producto', 'ProductoController@index');
        Route::post('/producto/registrar', 'ProductoController@guardar');
        Route::put('/producto/actualizar', 'ProductoController@actualizar');
        Route::put('/producto/desactivar', 'ProductoController@desactivar');
        Route::put('/producto/activar', 'ProductoController@activar');
        Route::get('/producto/buscarProducto', 'ProductoController@buscarProducto');
        Route::get('/producto/listarProducto', 'ProductoController@listarProducto');
        
        //PROVEEDORES - RECEPCIONISTA
        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@guardar');
        Route::put('/proveedor/actualizar', 'ProveedorController@actualizar');
        Route::put('/proveedor/desactivar', 'ProveedorController@desactivar');
        Route::put('/proveedor/activar', 'ProveedorController@activar');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');
        
        // CLIENTES - RECEPCIONISTA
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::put('/cliente/desactivar', 'ClienteController@desactivar');
        Route::put('/cliente/activar', 'ClienteController@activar');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');
        
        // AUTOS - RECEPCIONISTA
        Route::get('/auto', 'AutoController@index');
        Route::post('/auto/registrar', 'AutoController@store');
        Route::put('/auto/actualizar', 'AutoController@update');
        Route::put('/auto/desactivar', 'AutoController@desactivar');
        Route::put('/auto/activar', 'AutoController@activar');
        
        //EMAIL - RECEPCIONISTA
        Route::post('/contactar', 'EmailController@contact')->name('contact');
        
        
        //SUCURSALES - RECEPCIONISTA
        Route::get('/sucursal', 'SucursalController@index');
        Route::post('/sucursal/registrar', 'SucursalController@store');
        Route::put('/sucursal/actualizar', 'SucursalController@update');
        Route::put('/sucursal/desactivar', 'SucursalController@desactivar');
        Route::put('/sucursal/activar', 'SucursalController@activar');
        Route::put('/sucursal/configurarHorario', 'SucursalController@configurarHorario');
        
        // INVENTARIO - RECEPCIONISTA
        Route::get('/inventario', 'InventarioController@index');
        Route::get('/inventario/selectProducto', 'InventarioController@selectProductoOrden');
        Route::get('/inventario/generarPDF', 'InventarioController@generarPDF')->name('inventarios_pdf');
        
        //INGRESOS - RECEPCIONISTA
       Route::get('/ingreso', 'IngresoController@index');
       Route::post('/ingreso/registrar', 'IngresoController@guardar');
       Route::put('/ingreso/desactivar', 'IngresoController@anular');
       Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerIngreso');
       Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetallesDeIngreso');
      
       //FINANZAS - ADMINISTRADOR
        Route::get('/finanzas', 'FinanzasController@index');
        Route::post('/finanzas/registrar', 'FinanzasController@guardar');
        Route::put('/finanzas/actualizar', 'FinanzasController@actualizar');
        Route::put('/finanzas/desactivar', 'FinanzasController@desactivar');
        Route::put('/finanzas/activar', 'FinanzasController@activar');
        Route::get('/finanzas/seleccionarAnios','FinanzasController@seleccionarAnios');
        Route::get('/finanzas/consultarReporte','FinanzasController@datosReporte');
        Route::get('/finanzas/mesesIngresos','FinanzasController@mesesIngresos');
        Route::get('/finanzas/ingresosMes','FinanzasController@IngresosMes');
        Route::get('/finanzas/mesesGastos','FinanzasController@mesesGastos');
        Route::get('/finanzas/GastosMes','FinanzasController@GastosMes');
        
        //Cotización
        Route::get('/cotizacion/selectSubServicioCoti', 'CotizacionController@selectSubServicioCoti');
        Route::get('/cotizacion/selectProductoCoti', 'CotizacionController@selectProductoCoti');
        Route::post('/cotizacion/anadirServicioCoti', 'CotizacionController@anadirServicioCoti');
        Route::post('/cotizacion/anadirProductoCoti', 'CotizacionController@anadirProductoCoti');

              //CITAS - RECEPCIONISTA
              Route::get('/listarCitas', 'CitaController@listarCitasEmpleados');
              Route::get('/listarCitas/dia', 'CitaController@listarCitasEmpleadosDia');
              Route::get('/automovilesCliente', 'DashboardController@listarAutosCliente');
              Route::put('/autorizar', 'CitaController@autorizarCita');
              Route::put('/rechazar', 'CitaController@rechazarCita');
              Route::get('/listarCitasOrden', 'CitaController@listarCitasOrden');

        //ORDEN SERVICIO - RECEPCIONISTA
        Route::get('/ordenservicio', 'OrdenServicioController@index');
        Route::post('/ordenservicio/registrar', 'OrdenServicioController@store');
        Route::put('/ordenservicio/actualizar', 'OrdenServicioController@update');
        Route::put('/ordenservicio/desactivar', 'OrdenServicioController@desactivar');
        Route::put('/ordenservicio/activar', 'OrdenServicioController@activar');
        Route::get('/ordenservicio/getOrdenServicio', 'OrdenServicioController@getOrdenServicio');
        Route::get('/ordenservicio/getOrdenSubservicio', 'OrdenServicioController@getOrdenSubservicio');
        Route::get('/ordenservicio/getOrdenProductos', 'OrdenServicioController@getOrdenProductos');
        Route::get('/automovil/selectAutoOrden', 'AutoController@selectAutoOrden');
        Route::get('/ordenservicio/listarOrdenMecanico', 'OrdenServicioController@listarOrdenMecanico');
        Route::get('/ordenservicio/obtenerOrdenesFinalizadas', 'OrdenServicioController@obtenerOrdenesFinalizadas');
        Route::put('/ordenservicio/pagado', 'OrdenServicioController@pagado');
        Route::get('/ordenservicio/generarPDF', 'OrdenServicioController@generarPDF');
        Route::get('/ordenservicio/listarOrdenAdmin', 'OrdenServicioController@listarOrdenAdmin');
    });


});

//No la usamos...
//Route::get('/home', 'HomeController@index')->name('home');
