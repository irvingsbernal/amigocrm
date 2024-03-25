
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import swal from 'sweetalert2';
window.Swal = swal;

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Tablero: 0
Vue.component('dashboard2', require('./components/Dashboard.vue'));
Vue.component('citadash', require('./components/CitaDashboard.vue'));

//Sección cliente: 100-199
Vue.component('cliente', require('./components/Cliente.vue'));
Vue.component('auto', require('./components/Auto.vue'));
Vue.component('cotizaciones',require('./components/Cotizacion.vue'));

//Sección taller: 200-299
Vue.component('servicio', require('./components/Servicio.vue'));
Vue.component('subservicio', require('./components/SubServicio.vue'));
Vue.component('ordenservicio', require('./components/OrdenServicio.vue'));
Vue.component('ordenserviciomecanico', require('./components/OrdenServicioMecanico.vue'));
Vue.component('ordenservicioadmin', require('./components/OrdenServicioAdmin.vue'));
Vue.component('ordenespagos', require('./components/OrdenesPagos.vue'));
Vue.component('ordenespagosempleado', require('./components/OrdenesPagosEmpleado.vue'));

//Sección almacén: 300-399
Vue.component('inventario', require('./components/Inventario.vue'));
Vue.component('ingreso', require('./components/Ingreso.vue'));
Vue.component('historicoembarques', require('./components/HistoricoEmbarques.vue'));

//Sección finanzas: 400-499
Vue.component('finanzas', require('./components/Finanzas.vue'));
Vue.component('reporte', require('./components/Reporte.vue'));
Vue.component('reporteingresos', require('./components/ReporteIngresos.vue'));
Vue.component('reportegastos', require('./components/ReporteGastos.vue'));

//Sección insumos/refacciones: 500-599
Vue.component('categoria', require('./components/Categoria.vue'));
Vue.component('producto', require('./components/Producto.vue'));
Vue.component('proveedor', require('./components/Proveedor.vue'));

//Sección empresa: 600-699
Vue.component('puesto', require('./components/Puesto.vue'));
Vue.component('empleado', require('./components/Empleado.vue'));
Vue.component('sucursal', require('./components/Sucursal.vue'));


//Vistas para el CRM de cliente:
Vue.component('dashboard', require('./components/panel-cliente/Dashboard.vue'));
Vue.component('miautomovil', require('./components/panel-cliente/Auto.vue'));
Vue.component('perfilusuario', require('./components/panel-cliente/PerfilUsuario.vue'));
Vue.component('registro', require('./components/panel-cliente/Registro.vue'));
Vue.component('activacioncuenta', require('./components/panel-cliente/ActivacionCuenta.vue'));
Vue.component('cita', require('./components/panel-cliente/Cita.vue'));
Vue.component('historico', require('./components/panel-cliente/Historico.vue'));
Vue.component('citasrecientes', require('./components/panel-cliente/CitasRecientes.vue'));

Vue.component('codigo-qr', require('./components/panel-cliente/CodigoQR.vue'));

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        ruta : '',
    }
});
