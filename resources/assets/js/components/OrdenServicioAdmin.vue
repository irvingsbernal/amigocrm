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
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==0">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="CLIENTE" selected>Cliente</option>
                                      <option value="SUCURSAL">Sucursal</option>
                                      <!-- <option value="EMPLEADO">NoEmpleado</option>
                                      <option value="ESTADO">Estado</option> -->
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarOrdenServicio(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
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
                                        <th>Estado</th>
                                        <th>Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ordenservicio in arrayOrdenservicio" :key="ordenservicio.id">
                                        <td>
                                            <button type="button" @click="verOrdenServicio(ordenservicio.id,ordenservicio.fk_sucursal)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button> &nbsp;
                                        </td>
                                        <td v-text="ordenservicio.nombreComercial"></td>
                                        <td v-text="ordenservicio.nombre"></td>
                                        <!-- <td v-text="ordenservicio.noEmpleado"></td> -->
                                        <td>
                                        <div v-if="ordenservicio.estado == 'EN PROCESO'">
                                            <span class="badge badge-warning">EN PROCESO</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-secondary">TERMINADA</span>
                                        </div>
                                        </td>

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
                                            <th>Completar</th>
                                            <th>Servicio</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <tr v-for="(servicio) in listaOrdenSubservicios" :key="servicio.id"> 
                                            <td>
                                                <template v-if="servicio.estatus">
                                                    <button type="button" class="btn btn-danger btn-sm" @click="pausarTarea(servicio.id)">
                                                        <i class="icon-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else>
                                                    <button type="button" class="btn btn-info btn-sm" @click="realizarTarea(servicio.id)">
                                                        <i class="icon-check"></i>
                                                    </button>
                                                </template>
                                                <!-- <button type="button" class="btn btn-info btn-sm" @click="realizarTarea(servicio.id)">
                                                <i class="icon-check"></i>
                                                    </button> -->
                                            </td>
                                            <td v-text="servicio.nombre">
                                            </td>
                                            <td>
                                                <div v-if="servicio.estatus">
                                                    <span class="badge badge-success">Realizado</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">En proceso</span>
                                                </div>
                                                
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- Fin Agregar Servicio -->

                        <div class="form-group row">
                            <div class="col-md-12" v-if="flag==0">
                                <button type="button" @click="terminarOrden(ordenservicio_id,fk_sucursal)" class="btn btn-secondary">Terminar Orden</button>
                            </div>
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
        </main>
</template>

<script>
//IMPORTAMOS LIBRERÍA DE ESTILO VUE-SELECT:
    import vSelect from 'vue-select';
    //import 'vue-select/dist/vue-select.css'

    export default {
        data (){
            return {
                //ID Empleado
                //idUsuario: this.$attrs.id,
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
                criterio : 'CLIENTE',
                // Fin Subservicio

                
                listado:0,
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
                buscar : '',

                codigo: '',
                producto: '',
                precio: 0,
                cantidad:0,
                flag:0
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
            }
        },
        methods : {
            
            listarOrdenServicio (page,buscar,criterio){  
                let me=this;
                var url= '/ordenservicio/listarOrdenAdmin?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;

                    me.arrayOrdenservicio = respuesta.ordenServicio.data;
                    me.pagination= respuesta.pagination;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarOrdenServicio(page,buscar,criterio);
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
            listaSubservicio (buscar,criterio){
                let me=this;
                var url= '/subservicio/listarSubServicio?&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log(respuesta);
                    me.arraySubServicio = respuesta.subservicios.data;
                    me.pagination= respuesta.pagination;

                })
                .catch(function (error) {
                    console.log(error);
                });
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


                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },

            ocultarDetalle(){
                this.listado=0;
                this.ordenservicio_id=0;
                this.fk_sucursal=0;
            },

            verOrdenServicio(id,idSucursal){
                let me=this;
                me.listado=2;
                me.ordenservicio_id=id;
                me.fk_sucursal=idSucursal;
                var arrayOrdenservicioA=[];
                var arrayServicioOrden=[];
                
                //Obtengo los datos de la orden recibida.
                var url= 'ordenservicio/getOrdenServicio?id=' + id;
                
                axios.get(url).then(function (response) {
                    
                    var respuesta= response.data;
                    arrayOrdenservicioA = respuesta.ordenservicio;
                    console.log(arrayOrdenservicioA);
                    me.nombreEmpleado = arrayOrdenservicioA[0]['noEmpleado'];
                    me.nombreCliente =arrayOrdenservicioA[0]['nombre'];
                    me.nombreSucursal =arrayOrdenservicioA[0]['nombreComercial'];
                    me.nombreAuto =arrayOrdenservicioA[0]['marca']+' Modelo: '+arrayOrdenservicioA[0]['modelo'];
                    
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los servicios

                var urld= '/ordenservicio/getOrdenSubservicio?id=' + id;
                axios.get(urld).then(function (response) {
                     var respuesta= response.data;
                    arrayServicioOrden = respuesta.ordenservicio;
                    console.log(arrayServicioOrden);
                    me.listaOrdenSubservicios= arrayServicioOrden;
                    me.flag=0;
                    me.terminarPP();
                })
                .catch(function (error) {
                    console.log(error);
                });   
                me.flag=0;
                me.terminarPP();
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.flag=0;
                this.listarOrdenServicio(1,this.buscar,this.criterio);
            },
            realizarTarea(id){
                let me=this;
                var arrayServicioOrden=[];
               swal({
                title: 'Esta seguro de terminar esta Tarea?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put('/ordenservicio/activarEmpleado',{
                        'id': id
                    }).then(function (response) {
                        swal(
                        'Desactivado!',
                        'Tarea Finalizada con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    var urld= '/ordenservicio/getOrdenSubservicio?id=' + me.ordenservicio_id;
                    axios.get(urld).then(function (response) {
                     var respuesta= response.data;
                    arrayServicioOrden = respuesta.ordenservicio;
                    console.log(arrayServicioOrden);
                    me.listaOrdenSubservicios= arrayServicioOrden;
                    me.flag=0;
                    me.terminarPP();
                })
                .catch(function (error) {
                    console.log(error);
                });
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                })
                //me.listaOrdenSubservicios=[];
                me.flag=0;
                me.terminarPP();                
            },
            pausarTarea(id){
                let me=this;
                var arrayServicioOrden=[];
               swal({
                title: 'Esta seguro de cancelar esta tarea?',
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
                    axios.put('/ordenservicio/desactivarEmpleado',{
                        'id': id
                    }).then(function (response) {
                        swal(
                        '¡Cancelado!',
                        'Tarea se ha cancelado éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                        var urld= '/ordenservicio/getOrdenSubservicio?id=' + me.ordenservicio_id;
                        axios.get(urld).then(function (response) {
                            var respuesta= response.data;
                            arrayServicioOrden = respuesta.ordenservicio;
                            console.log(arrayServicioOrden);
                            me.listaOrdenSubservicios= arrayServicioOrden;
                            me.flag=0;
                            me.terminarPP();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    //this.listarOrdenServicio(1,this.buscar,this.criterio);
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                });
                //me.listaOrdenSubservicios=[];
                me.flag=0;
                me.terminarPP();
            },
            terminarOrden(id,idSucursal){
                let me=this;
               swal({
                title: 'Esta seguro de terminar esta Orden?',
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
                    axios.put('/ordenservicio/terminarOrden',{
                        'id': id,
                        'idSucursal': idSucursal
                    }).then(function (response) {
                        me.flag=1;
                        swal(
                        '¡Terminado!',
                        'La Orden fue finalizada con éxito.',
                        'success'
                        )
                        me.listarOrdenServicio(1,me.buscar,me.criterio);
                    }).catch(function (error) {
                        console.log(error);
                    });
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                });
                me.flag=1;
                me.listarOrdenServicio(1,me.buscar,me.criterio);
                me.cerrarModal();
            },
            terminarPP(){
            let me=this;
            console.log('entro');
            for(var i=0;i<me.listaOrdenSubservicios.length;i++){
                    if(me.listaOrdenSubservicios[i].estatus==0){
                        me.flag=1;
                        console.log(me.flag);    
                    }
                    
            }
            
            }
            

        },
        mounted() {
            this.listarOrdenServicio(1,this.buscar,this.criterio);
            //this.listado=1;
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
