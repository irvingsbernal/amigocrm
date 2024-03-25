<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Orden Servicio
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i> &nbsp; Nuevo
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="CLIENTE" selected>Cliente</option>
                                      <option value="SUCURSAL">Sucursal</option>
                                      <option value="EMPLEADO">NoEmpleado</option>
                                      <option value="ESTADO">Estado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarOrdenServicio(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarOrdenServicio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive table-sm">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Sucursal</th>
                                        <th>Cliente</th>
                                        <th>Empleado</th>
                                        <th>Cita</th>
                                        <th>total</th>
                                        <th>Estado Saldo</th>
                                        <th>Estado</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ordenservicio in arrayOrdenservicio" :key="ordenservicio.id">
                                        <td>
                                            <button type="button" @click="verOrdenServicio(ordenservicio.id)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                            <template v-if="ordenservicio.estatus=='1'">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarOrden(ordenservicio.id)">
                                                    <i class="icon-trash"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="ordenservicio.nombreComercial"></td>
                                        <td v-text="ordenservicio.nombre"></td>
                                        <td v-text="ordenservicio.noEmpleado"></td>
                                        <td v-text="ordenservicio.fk_cita"></td>
                                        <td v-text="ordenservicio.total"></td>
                                        <td v-text="ordenservicio.estadoSaldo"></td>
                                        <td v-text="ordenservicio.estado"></td>
                                        <td>
                                        <div v-if="ordenservicio.estatus">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>

                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--Fin Listado-->



                    <!-- Inicio Ingresar Orden-->
                    <template v-else-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Empleado(*)</label>
                                    <v-select
                                        @search="selectEmpleado"
                                        label="nombre"
                                        :options="arrayEmpleados"
                                        placeholder="Buscar Empleados..."
                                        @input="getDatosEmpleado"                                        
                                    >
                                    <span slot="no-options">No hay coincidencias... </span>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Sucursal(*)</label>
                                <select class="form-control" v-model="fk_sucursal">
                                    <option value="0" disabled>Seleccione sucursal</option>
                                    <option v-for="sucursal in arraySucursal" :key="sucursal.id" :value="sucursal.id" v-text="sucursal.nombreComercial"></option>
                                </select> 
                            </div>
        
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label for="">Cliente(*)</label>
                                    <v-select
                                        @search="selectCliente"
                                        label="nombre"
                                        :options="arrayCliente"
                                        placeholder="Buscar Cliente..."
                                        @input="getDatosCliente"                                        
                                    >
                                    <span slot="no-options">No hay coincidencias... </span>
                                    </v-select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="">Auto(*)</label>
                                <select class="form-control" v-model="fk_auto">
                                    <option value="0" disabled>Seleccione Auto</option>
                                    <option v-for="auto in arrayAuto"   :key="auto.id" :value="auto.id" v-text="auto.nombre"></option>
                                </select> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cita</label>
                                    <input type="text" class="form-control" v-model="fk_cita" placeholder="000x">
                                </div>
                            </div>
                            <!--<div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Documento(*)</label>
                                    <input type="text" class="form-control" v-model="noDocumento" placeholder="000xx">
                                </div>
                            </div> -->
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inicio Agregar Servicio -->
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Servicios <span style="color:red;" v-show="idServicio==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <button @click="abrirModalSubServicio()" class="btn btn-primary">Agregar Servicios</button>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Quitar</th>
                                            <th>Servicio</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="listaOrdenSubservicios.length">
                                        <tr v-for="(servicio,index) in listaOrdenSubservicios" :key="servicio.id">
                                            <td>
                                                <button @click="eliminarServicio(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="servicio.nombre">
                                            </td>
                                            <td v-text="servicio.precio">
                                                <!-- <input v-model="detalle.precio" type="number" value="3" class="form-control"> -->
                                            </td>
                                            <td>
                                                <!-- {{servicio.precio*servicio.cantidad}} -->
                                                {{servicio.precio}} 
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalProducto=(calcularTotalServicio).toFixed(2)}}</td>
                                            
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay servicios a ingresar...
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <!-- Fin Agregar Servicio -->
                        
                        <!-- Inicio Agregar Producto -->
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Productos <span style="color:red;" v-show="idProducto==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <button @click="abrirModal()" class="btn btn-primary">Agregar Productos</button>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Quitar</th>
                                            <th>Producto/Insumo</th>
                                            <th>Stock</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="productoAgregar.length">
                                        <tr v-for="(detalle,index) in productoAgregar" :key="detalle.id">
                                            <td>
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <td v-text="detalle.producto">
                                            </td>
                                            <td v-if="detalle.partes">Disponible {{detalle.stock }} {{detalle.unidad}} </td>
                                            <td v-else>Disponible {{detalle.stock}} pza. </td>
                                            <td v-text="detalle.precio">
                                                <!-- <input v-model="detalle.precio" type="number" value="3" class="form-control"> -->
                                            </td>
                                            <td>
                                                <input v-model="detalle.cantidad" type="number" value="2" class="form-control" min=1 max=detalle.stock   @keyup="validarStock(index,detalle.cantidad)">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalProducto=(calcularTotalProducto).toFixed(2)}}</td>
                                        </tr>
                                        
                                        <!-- <tr style="background-color: #CEECF5;">
                                            <td colspan="5" align="right"><strong>Total Neto:</strong></td>
                                            <td>$ {{total=(parseFloat(calcularTotalProducto)+parseFloat(calcularTotalServicio))}}</td>
                                        </tr> -->
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6">
                                                No hay productos/insumos a ingresar...
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                                <h5>Total Neto: $ {{total=(parseFloat(calcularTotalProducto)+parseFloat(calcularTotalServicio))}}</h5>
                            </div>
                        </div>
                        <!-- Fin Agregar Producto -->

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarOrdenServicio()">Registrar recibo</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- FIN Ingresar Orden-->
                    
                    


                    <!-- Inicio VER Orden-->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Empleado: </label>
                                    <p v-text="nombreEmpleado"></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Sucursal</label>
                                    <p v-text="nombreSucursal"></p>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Cliente</label>
                                    <p v-text="nombreCliente">{{nombreCliente}}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Auto</label>
                                    <p v-text="nombreAuto"></p>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Cita</label>
                                    <input type="text" class="form-control" v-model="fk_cita" placeholder="000x">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Inicio Agregar Servicio -->
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Servicios </label>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Servicio</th>
                                            <th>Precio</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="listaOrdenSubservicios.length">
                                        <tr v-for="(servicio) in listaOrdenSubservicios" :key="servicio.id"> 
                                            <td v-text="servicio.nombre">
                                            </td>
                                            <td v-text="servicio.precio">
                                                <!-- <input v-model="detalle.precio" type="number" value="3" class="form-control"> -->
                                            </td>
                                            <td>
                                                <!-- {{servicio.precio*servicio.cantidad}} -->
                                                {{servicio.precio}} 
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="2" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{(calcularTotalServicio).toFixed(2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay servicios
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                            </div>
                        </div>
                        <!-- Fin Agregar Servicio -->
                        
                        <!-- Inicio Agregar Producto -->
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Productos </label>
                                </div>
                            </div>
                            <div class="table-responsive col-md-12">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Producto/Insumo</th>
                                            <th>Precio</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="productoAgregar.length">
                                        <tr v-for="(detalle) in productoAgregar" :key="detalle.id">
                                            <td v-text="detalle.producto">
                                            </td>
                                            <td v-text="detalle.precio">
                                            </td>
                                            <td v v-text="detalle.cantidad">
                                            </td>
                                            <td>
                                                {{detalle.precio*detalle.cantidad}}
                                            </td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="3" align="right"><strong>Total Parcial:</strong></td>
                                            <td>$ {{totalProducto=(calcularTotalProducto).toFixed(2)}}</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay productos
                                            </td>
                                        </tr>
                                    </tbody>                                    
                                </table>
                                <h5>Total Neto: $ {{parseFloat(calcularTotalProducto)+parseFloat(calcularTotalServicio)}}</h5>
                            </div>
                        </div>
                        <!-- Fin Agregar Producto -->

                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- FIN VER Orden-->

                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>


            <!--Inicio  Modal agregar/actualizar Producto-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="codigo">Código</option>
                                        </select>
                                        <input type="text" v-model="buscarA" @keyup.enter="listarProducto(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarProducto(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th> + </th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th>Presentación</th>
                                            <th>Código de Barras</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Descripción</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in arrayProducto" :key="producto.id">
                                            <td>
                                                <button type="button" @click="agregarDetalleModal(producto)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="producto.id"></td>
                                            <td v-text="producto.nombre"></td>
                                            <td v-text="producto.nombre_categoria"></td>
                                            <td v-text="producto.marca"></td>
                                            <td v-text="producto.modelo"></td>
                                            <td v-text="producto.presentacion + ' ' + producto.unidad"></td>
                                            <td v-text="producto.codigoBarras"></td>
                                            <td v-text="producto.precioVenta"></td>
                                            <td v-text="producto.cantidad/producto.presentacion"></td>
                                            <td v-text="producto.descripcion"></td>
                                            <td>
                                                <div v-if="producto.estatus">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <!-- <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarOrden()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button> -->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal Producto-->



            <!--Inicio  Modal agregar/actualizar Servicio-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalSubservicio}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModalSubServicio()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <select class="form-control col-md-3" v-model="criterioServicio">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        </select>
                                        <input type="text" v-model="buscarServicio" @keyup.enter="listaSubservicio(buscarServicio,criterioServicio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listaSubservicio(buscarServicio,criterioServicio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th> + </th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Servicio</th>
                                            <th>Costo</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="Subservicio in arraySubServicio" :key="Subservicio.id">
                                            <td>
                                                <button type="button" @click="agregarServicioModal(Subservicio)" class="btn btn-success btn-sm">
                                                <i class="icon-check"></i>
                                                </button>
                                            </td>
                                            <td v-text="Subservicio.id"></td>
                                            <td v-text="Subservicio.nombre"></td>
                                            <td v-text="Subservicio.nombre_servicio"></td>
                                            <td v-text="Subservicio.costoServicio"></td>
                                            <td>
                                                <div v-if="Subservicio.estatus">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModalSubServicio()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarOrden()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal  Servicio -->
        </main>
</template>

<script>
//IMPORTAMOS LIBRERÍA DE ESTILO VUE-SELECT:
    import vSelect from 'vue-select';
    //import 'vue-select/dist/vue-select.css'

    export default {
        data (){
            return {
                cliente_seleccionado: null,
                // Orden Servicio
                ordenservicio_id: 0,
                fk_cliente : 0,
                fk_empleado : 0,
                fk_sucursal : 0,
                fk_auto : 0,
                fk_cita : 0,
                estadoSaldo: 0,
                estado : '',
                arrayOrdenservicio : [],
                // Ver Orden
                
                nombreEmpleado: '',
                nombreCliente: '',
                nombreSucursal: '',
                nombreAuto: '',
                 // Subservicio
                idServicio: 0,
                arraySubServicio: [],
                listaOrdenSubservicios : [],
                buscarServicio: '',
                criterioServicio:'nombre',
                totalServicio: 0,
                // Fin Subservicio

                //Empleado
                arrayEmpleados: [],
                arraySucursal: [],
                // Fin Empleado

                //Cliente
                arrayCliente: [],
                arrayAuto: [],
                // Fin Cliente

                listado:1,
                modal : 0,
                modalSubservicio: 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'noDocumento',
                buscar : '',

                //Producto
                criterioA:'nombre',
                buscarA: '',
                arrayProducto: [],
                productoAgregar :[],
                idProducto: 0,
                totalProducto: 0, 
                cantidadProducto: 0,
                cantidadStock: 0,
                // Fin producto

                codigo: '',
                producto: '',
                precio: 0,
                cantidad:0
            }   
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            },
            calcularTotalProducto: function(){
                var resultado=0.0;
                for(var i=0;i<this.productoAgregar.length;i++){
                    resultado=resultado+(this.productoAgregar[i].precio*this.productoAgregar[i].cantidad)
                }
                return resultado;
            },
            calcularTotalServicio: function(){
                var resultadoS=0.0;
                for(var i=0;i<this.listaOrdenSubservicios.length;i++){
                    resultadoS=resultadoS+(parseFloat(this.listaOrdenSubservicios[i].precio))
                }
                return resultadoS;
            }
        },
        methods : {
            sumarTotal(producto,servicio){
                var  total=0.0;
                total=producto+servicio;
                return total;
            },    
            listarOrdenServicio (page,buscar,criterio){
                let me=this;
                var url= '/ordenservicio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayOrdenservicio = respuesta.ordenServicio.data;
                    console.log(me.arrayOrdenservicio);
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectSucursal(){
                let me=this;
                var url= '/sucursal/selectSucursalOrden';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta = response.data;
                    me.arraySucursal=respuesta.sucursales;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectAuto(id){
                let me=this;
                var url= '/automovil/selectAutoOrden?filtro='+id;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta = response.data;
                    me.arrayAuto=respuesta.autos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEmpleado(search,loading){
                let me=this;
                loading(true)
                
                var url= '/empleado/selectEmpleadoOrden?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayEmpleados=respuesta.empleados;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectEmpleado2(search,loading){
                let me=this;
                loading(true)
                
                var url= '/empleado/selectEmpleadoOrden?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayEmpleados=respuesta.empleados;
                    me.cliente_seleccionado = me.arrayEmpleados.find(empleado => empledo.id === 1);
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosEmpleado(val1){
                let me = this;
                me.loading = true;
                me.fk_empleado = val1.id;
            },
            selectCliente(search,loading){
                let me=this;
                loading(true)
                
                var url= '/cliente/selectClienteOrden?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCliente=respuesta.clientes;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosCliente(val1){
                let me = this;
                me.loading = true;
                me.fk_cliente = val1.id;
                this.selectAuto(val1.id);
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarOrdenServicio(page,buscar,criterio);
            },
            encuentra(id){
                var sw=0;
                for(var i=0;i<this.productoAgregar.length;i++){
                    if(this.productoAgregar[i].idProducto==id){
                        sw=true;
                    }
                }
                return sw;
            },
            encuentraServicio(id){
                var sw=0;
                for(var i=0;i<this.listaOrdenSubservicios.length;i++){
                    if(this.listaOrdenSubservicios[i].idServicio==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.productoAgregar.splice(index, 1);
            },
            eliminarServicio(index){
                let me = this;
                me.listaOrdenSubservicios.splice(index, 1);
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Este producto ya se ha añadido.',
                            })
                    }
                    else{

                        if(data['ventaXpartes']==1){
                            me.productoAgregar.push({
                            idProducto: data['id'],
                            producto: data['nombre'],
                            precio: data['precioVenta'],
                            stock: data['cantidad'],
                            partes: data['ventaXpartes'],
                            presentacion : data['presentacion'],
                            unidad: data['unidad'],
                            cantidad: 1,
                            });
                        }else{
                            var stock = parseFloat(data['cantidad']) / parseFloat( data['presentacion']);
                            me.productoAgregar.push({
                            idProducto: data['id'],
                            producto: data['nombre'],
                            precio: data['precioVenta'],
                            stock: stock,
                            partes: data['ventaXpartes'],
                            presentacion : data['presentacion'],
                            unidad: data['unidad'],
                            cantidad: 1,
                            });
                        }    
                    }
                    console.log(this.productoAgregar);
            },
            agregarServicioModal(data =[]){
                let me=this;
                if(me.encuentraServicio(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Este servicio ya se ha añadido.',
                            })
                    }
                    else{
                       me.listaOrdenSubservicios.push({
                            idServicio: data['id'],
                            nombre: data['nombre'],
                            precio: data['costoServicio'],
                        }); 
                    }
            },

            listarProducto (buscar,criterio){
                let me=this;
                var url= '/inventario/listarProductoInventario?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listaSubservicio (buscar,criterio){
                let me=this;
                var url= '/subservicio/listarSubServicio?&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySubServicio = respuesta.subservicios.data;
                    me.pagination= respuesta.pagination;

                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarOrdenServicio(){
                if (this.validarIngreso()){
                    return;
                }
                let me = this;

                axios.post('/ordenservicio/registrar',{
                    'fk_cliente'        : this.fk_cliente,
                    'fk_empleado'       : this.fk_empleado,
                    'fk_sucursal'       : this.fk_sucursal,
                    'fk_auto'           : this.fk_auto,
                    'fk_cita'           : this.fk_cita,
                    'estadoSaldo'       : this.estadoSaldo,
                    'total'             : this.total,
                    'estado'            : this.estado,
                    'arrayOrdenservicio': this.listaOrdenSubservicios,
                    'productoAgregar'   : this.productoAgregar
                }).then(function (response) {
                    me.listado=1;
                    // me.listarOrdenServicio(1,'','noDocumento');
                    me.listarOrdenServicio(1,'','');
                    me.fk_cliente=0;
                    me.fk_empleado='Factura';
                    me.fk_sucursal ='';
                    me.fk_auto ='';
                    me.fk_cita=0.18;
                    me.estadoSaldo=0.0;
                    me.total=0;
                    me.estado='';
                    me.listaOrdenSubservicios=[];
                    me.productoAgregar=[];

                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarStock(id,input){
                console.log(input)
                console.log(this.productoAgregar[id].stock)
                //if()
                if(parseFloat(input)> parseFloat(this.productoAgregar[id].stock)){
                alert("No hay suficientes piezas");
                }
                if(parseFloat(input)<1){
                alert("No puedes pedir menos de 0");
                }
            },
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];
                
                
                
                
                 if (this.fk_cliente==0) this.errorMostrarMsjIngreso.push("Seleccione un Cliente");
                 if (this.fk_empleado==0) this.errorMostrarMsjIngreso.push("Seleccione un Empleado");
                 if (this.fk_sucursal==0) this.errorMostrarMsjIngreso.push("Seleccione una Sucursal");
                 if (this.fk_auto==0) this.errorMostrarMsjIngreso.push("Seleccione un Auto");
                 //if (this.fk_cita==0) this.errorMostrarMsjIngreso.push("Seleccione una Cita");
                
                //if (this.productoAgregar.length<=0) this.errorMostrarMsjIngreso.push("Ingrese productos");
                if (this.listaOrdenSubservicios.length<=0) this.errorMostrarMsjIngreso.push("Ingrese Servicios");

                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },

            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.fk_cliente = 0;
                me.fk_empleado = 0;
                me.fk_sucursal = 0;
                me.fk_auto = 0;
                me.fk_cita = 0;
                me.total = 0; 
                me.estadoSaldo = 0;
                me.estado = 0;

                me.idSubServicio= 0;
                me.idProducto = 0;
                //me.arrayOrdenservicio=[];
                me.productoAgregar=[];
                me.listaOrdenSubservicios=[];
                this.selectSucursal();
                
            },
            ocultarDetalle(){
                this.listado=1;
            },

            verOrdenServicio(id){

                let me=this;
                me.listado=2;
                var arrayOrdenservicioA=[];
                var arrayProductosOrden=[];
                var arrayServicioOrden=[];
                
                //Obtengo los datos de la orden recibida.
                var url= 'ordenservicio/getOrdenServicio?id=' + id;
                
                axios.get(url).then(function (response) {
                    
                    var respuesta= response.data;
                    arrayOrdenservicioA = respuesta.ordenservicio;
                    
                    
                    me.nombreEmpleado = arrayOrdenservicioA[0]['nombreEmpleado'];
                    me.nombreCliente =arrayOrdenservicioA[0]['nombre'];
                    me.nombreSucursal =arrayOrdenservicioA[0]['nombreComercial'];
                    me.nombreAuto =arrayOrdenservicioA[0]['auto'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los servicios

                var urld= '/ordenservicio/getOrdenSubservicio?id=' + id;
                axios.get(urld).then(function (response) {
                     var respuesta= response.data;
                    arrayServicioOrden = respuesta.ordenservicio;
                    me.listaOrdenSubservicios= arrayServicioOrden;
                })
                .catch(function (error) {
                    console.log(error);
                });   

                var urld= '/ordenservicio/getOrdenProductos?id=' + id;
                axios.get(urld).then(function (response) {
                     var respuesta= response.data;
                    arrayProductosOrden = respuesta.ordenservicio;
                    me.productoAgregar= arrayProductosOrden;
                })
                .catch(function (error) {
                    console.log(error);
                });   
                
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            }, 
            abrirModal(){             
                
                this.listarProducto('','');
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios productos/insumos';
            },
            cerrarModalSubServicio(){
                this.modalSubservicio=0;
                this.tituloModal='';
            },
            abrirModalSubServicio(){             
                this.listaSubservicio('','');
                this.modalSubservicio = 1;
                this.tituloModal = 'Seleccione uno o varios servicios';
            },
            desactivarOrden(id){
               swal({
                title: 'Esta seguro de cancelar este ingreso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/ordenservicio/desactivar',{
                        'id': id
                    }).then(function (response) {
                        //me.listarOrdenServicio(1,'','noDocumento');
                        swal(
                        '¡Cancelado!',
                        'La mercancía ha sido retornada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    this.listarOrdenServicio(1,this.buscar,this.criterio);
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
        },
        mounted() {
            this.listarOrdenServicio(1,this.buscar,this.criterio);
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
        overflow-y:auto;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }
</style>
