<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/main">Escritorio</a></li>
        </ol>
        <div class="container-fluid">
            <h3>Dashboard</h3>
            <div class="row">
                <div class="card ml-3" style="width:30%" v-for="auto in arrayAutomovil" :key="auto.id">
                    <img v-if="auto.fotografia == null" class="card-img-top" src="img/placeholder.jpg" alt="Card image" style="width:100%;">
                    <img v-else-if="auto.fotografia != null" class="card-img-top" :src="auto.fotografia" alt="Card image" style="width:100%;">
                    <div class="card-body">
                    <h4 class="card-title">{{auto.marca}} &nbsp; {{auto.modelo}}</h4>
                    <p class="card-text">{{auto.placa}}</p>
                    </div>
                </div>
            </div>

           <citasrecientes :id="idUsuario"></citasrecientes>

            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    Servicios programados
                </div>
                <div class="card-body">
                    <!-- <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3">
                                    <option value="fecha">Fecha</option>
                                </select>
                                <input type="date" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div> -->
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Sucursal</th>
                                    <th colspan="2">Fecha y hora cita</th>
                                    <th colspan="2">Auto</th>
                                    <th colspan="2">Mecánico responsable</th>
                                    <th>Total</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="servicio in arrayServicio" :key="servicio.id">
                                    <td>
                                        <button @click="cargarServicio(servicio)" type="button" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td v-text="servicio.nombreComercial"></td>
                                    <td v-text="servicio.fecha"></td>
                                    <td v-text="servicio.horaInicio - servicio.horaFin"></td>
                                    <td v-text="servicio.marca"></td>
                                    <td v-text="servicio.modelo"></td>
                                    <td v-text="servicio.nombre+' '+servicio.apellidoPaterno"></td>
                                    <td v-text="servicio.correo"></td>
                                    <td v-text="servicio.total"></td>
                                    <td>
                                        <div v-if="servicio.estatus == 0">
                                            <span class="badge badge-primary">Servicio en proceso</span>
                                        </div>
                                        <div v-if="servicio.estatus == 1">
                                            <span class="badge badge-success">Servicio terminado</span>
                                        </div>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
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
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" text="Detalle servicio"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body" style="text-align:center;">
                        <div class="row" >
                            <div class="col-md-2"><img src="img/logoeh.png" width="100%" height="50vh"></div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5"><h6>ORDEN DE SERVICIO</h6>ÉCROU HEXAGONAL</div>
                            <div class="col-md-4">FECHA {{fecha}}</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="card col-md-5 ml-5" style="padding: 0 !important;">
                                <div class="card-header">Datos cita</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Fecha: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="fecha" class="form-control" placeholder="Fecha" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Hora inicio: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="horaInicio - horaFin" class="form-control" placeholder="Hora" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Sucursal: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="nombreComercial" class="form-control" placeholder="Sucursal" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer small">La cita ha sido atendida</div>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="card col-md-5" style="padding: 0 !important;">
                                <div class="card-header">Datos de contacto mecánico asignado</div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Nombre: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="nombre + ' ' + apellidoPaterno" class="form-control" placeholder="Nombre mecánico" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Teléfono: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="telefono" class="form-control" placeholder="Teléfono" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-md-3 form-control-label" for="text-input">Correo: </label>
                                        <div class="col-md-9">
                                            <input type="text" :value="correo" class="form-control" placeholder="Correo" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer small">Solo contactar en caso de emergencia</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5 ml-5" style="padding: 0 !important;">
                                <h6>Productos</h6>
                                <table class="table table-bordered table-responsive table-sm table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th>Marca</th>
                                            <th>Categoría</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="producto in arrayProductos" :key="producto.id">
                                            <td v-text="producto.nombre"></td>
                                            <td v-text="producto.descripcion"></td>
                                            <td v-text="producto.marca"></td>
                                            <td v-text="producto.categoria"></td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5" style="padding: 0 !important;">
                                <h6>Servicios</h6>
                                <table class="table table-bordered table-responsive table-sm table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Servicio</th>
                                            <th>Costo</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="servicio in arraySubservicios" :key="servicio.id">
                                            <td v-text="servicio.servicio"></td>
                                            <td v-text="servicio.subservicio"></td>
                                            <td v-text="servicio.precioServicio"></td>
                                            <td>
                                                <div v-if="servicio.estatus">
                                                    <span class="badge badge-success">En proceso</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Atendida</span>
                                                </div>
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </main>
</template>

<script>
    export default {
        data (){
            return {
                
                idUsuario: this.$attrs.id,                 modal : 0, fk_cliente : 0, arrayCliente : [],
                fotografia: '',
                id_orden: 0, fk_empleado: 0, fk_sucursal: 0, fk_auto: 0, fk_cita: 0, total: 0, estadoSaldo: 0,
                estado: 0, estatus: 0, nombre: '', apellidoPaterno: '', telefono: '', correo: '', 
                nombreComercial: '', direccion: '', marca: '', modelo: '', fecha: '', horaInicio: '', horaFin: '',
                id_orden_productos: 0, nombre_producto: '', marca_producto: '', categoria_producto: '',
                id_orden_subservicio: 0, precio_servicio: 0, estatus_subservicio: 0, nombre_subservicio: '',
                nombre_servicio: '',
                arrayAutomovil : [], arrayServicio : [], arrayProductos: [], arraySubservicios: [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
            }
        },
        components: {
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

            }
        },
        methods : {
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarcita(page,buscar,criterio);
            },
            obtenerCliente() {
                let me=this;
                var url= '/obtenerCliente?idUsuario=' + me.idUsuario;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayCliente = respuesta.cliente.data;
                    me.fk_cliente = me.arrayCliente[0].id;
                    me.listarServicios(me.arrayCliente[0].id);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarAutomovil (){
                let me=this;
                var url= '/automovilesCliente?idUsuario=' + me.idUsuario;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayAutomovil = respuesta.autos.data;
                    console.log(me.arrayAutomovil);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarServicios (id){
                let me=this;
                var url= '/servicios?fk_cliente=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayServicio = respuesta.ordenservicio.data;
                    console.log(me.arrayServicio);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cargarServicio(data=[]) {
                                                this.modal = 1;
                this.id_orden = data['id'];
                this.total = data['total'];
                this.estadoSaldo = data['estadoSaldo'];
                this.estado = data['estado'];
                this.estatus = data['estatus'];
                this.nombre = data['nombre'];
                this.apellidoPaterno = data['apellidoPaterno'];
                this.correo = data['correo'];
                this.telefono = data['telefono'];
                this.nombreComercial = data['nombreComercial'];
                this.direccion = data['direccion'];
                this.marca = data['marca'];
                this.modelo = data['modelo'];
                this.fecha = data['fecha'];
                this.horaInicio = data['horaInicio'];
                this.horaFin = data['horaFin'];
                let me=this;
                var url= '/productos/servicio?id_orden=' + me.id_orden;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayProductos = respuesta.productos.data;
                    console.log(me.arrayProductos);
                })
                .catch(function (error) {
                    console.log(error);
                });
                var url1= '/subservicios/servicio?id_orden=' + me.id_orden;
                axios.get(url1).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arraySubservicios = respuesta.subservicios.data;
                    console.log(me.arraySubservicios);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                this.modal=0;
            },
        },
        mounted() {
            console.log(this.idUsuario);
            this.listarAutomovil(); this.obtenerCliente();
        }
    }
</script>
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .modal-body {
        width: 100%;
        height: 60vh;
        overflow-y: scroll;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>