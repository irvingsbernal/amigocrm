<template>
            <main class="main" style="margin-left:0px;">
            <!-- Breadcrumb -->
            <!-- <div class="container-fluid"> CONTENEDOR INICIO-->
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="numerocliente" selected> No. cliente</option>
                                      <option value="id">No. cita</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarcita(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <!-- <button type="submit" @click="listarcita(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button> -->
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-responsive table-sm">
                            <thead>
                                <tr>
                                    <!-- <th>Opciones</th> -->
                                    <th>Sucursal</th>
                                    <th>Nombre cliente</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Auto</th>
                                    <th>Placa</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cita in arraycita" :key="cita.id">
                                    <!-- <td>
                                        <button type="button" v-if="cita.estatus == 0" @click="abrirModal('cita','actualizar',cita)" class="btn btn-warning btn-sm">
                                          <i class="icon-check"></i>
                                        </button> &nbsp;
                                        <button type="button" v-if="cita.estatus == 1 || cita.estatus == 2 || cita.estatus == 3" @click="abrirModal('cita','actualizar',cita)" class="btn btn-warning btn-sm">
                                            <i class="icon-eye"></i>
                                        </button> &nbsp;
                                    </td> --> 
                                    <td v-text="cita.nombreComercial"></td>
                                    <td v-text="cita.nombre+' '+cita.apellidoPaterno"></td>
                                    <td v-text="cita.telefono"></td>
                                    <td v-text="cita.correo"></td>
                                    <td v-text="cita.fecha"></td>
                                    <td v-text="cita.horaInicio +'-'+ cita.horaFin"></td>
                                    <td v-text="cita.marca"></td>
                                    <td v-text="cita.placa"></td>
                                    <td>
                                        <!-- <div v-if="cita.estatus == 0">
                                            <span class="badge badge-primary">Por confirmar</span>
                                        </div> -->
                                        <div v-if="cita.estatus == 1">
                                            <span class="badge badge-success">Confirmada</span>
                                        </div>
                                        <div v-if="cita.estatus == 2">
                                            <span class="badge badge-danger">Cancelada</span>
                                        </div>
                                        <div v-if="cita.estatus == 3">
                                            <span class="badge badge-light">Atendida</span>
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
            <!-- </div>CONTENERDOR FIN --> 
           
        </main>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    import * as lang from "vuejs-datepicker/src/locale";
    export default {
        data (){
            return {
                cita_id: 0,
                comentario : '',
                fecha : '',
                hora : '',
                horaInicio : '',
                horaFin : '',
                estatus : '',
                fk_auto : '',
                fk_sucursal : '',
                fk_usuario : '',
                nombreComercial : '',
                direccion : '', cupo: 0,
                marca : '',
                placa : '',
                modelo: '',
                nombre: '', apellidoPaterno: '', telefono: '', correo: '',
                arraycita : [], arraycitadia: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorcita : 0,
                errorMostrarMsjcita : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'id',
                buscar : ''
            }
        },
        components: {
            Datepicker,
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

            
            listarcita (page,buscar,criterio){
                let me=this;
                var url= '/obtenerCitasDashboard?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraycita = respuesta.citas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            listarcitadia (fecha,hora,id){
                let me=this;
                var url= '/listarCitas/dia?fecha=' + fecha + '&hora='+ hora + '&id=' + id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraycitadia = respuesta.citas.data;
                    me.pagination= respuesta.pagination;
                    console.log(me.arraycitadia);
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
                me.listarcita(page,buscar,criterio);
            },
            autorizarcita(){
                let me = this;

                axios.put('/autorizar',{
                    'id': this.cita_id
                }).then(function (response) {
                    Swal.fire('¡La cita ha sido autorizada!', 'Espera la visita del cliente', 'success');
                    me.cerrarModal();
                    me.listarcita(1,'','fecha');
                }).catch(function (error) {
                    console.log(error);
                    Swal.fire('Algo ha salido mal', 'Vuelve a intentar', 'error');
                }); 
            },
            rechazarcita(id){
               swal({
                title: '¿Esta seguro de rechazar esta cita?',
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

                axios.put('/rechazar',{
                    'id': this.cita_id
                }).then(function (response) {
                    Swal.fire('La cita ha sido rechazada', 'warning');
                    me.cerrarModal();
                    me.listarcita(1,'','fecha');
                }).catch(function (error) {
                    console.log(error);
                    Swal.fire('Algo ha salido mal', 'Vuelve a intentar', 'error');
                }); 
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.comentario='';
                this.fecha= new Date();
                this.hora = '',
                this.fk_auto= 0,
                this.fk_sucursal= 0
            },
            abrirModal(modelo, accion, data = []){
                this.listarcitadia(data['fecha'], data['hora'], data['id']);
                switch(modelo){
                    case "cita":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Validar cita';
                                this.tipoAccion=2;
                                this.cita_id=data['id'];
                                this.nombre = data['nombre'];
                                this.apellidoPaterno = data['apellidoPaterno'];
                                this.telefono = data['telefono'];
                                this.correo = data['correo'];
                                this.marca = data['marca'];
                                this.modelo = data['modelo'];
                                this.placa = data['placa'];
                                this.nombreComercial = data['nombreComercial'];
                                this.direccion = data['direccion'];
                                this.cupo = data['cupoAutos'];
                                this.fecha = data['fecha'];
                                this.hora = data['hora'];
                                this.estatus = data['estatus'];
                                this.comentario = data['comentario'];

                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarcita(1,this.buscar,this.criterio);
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