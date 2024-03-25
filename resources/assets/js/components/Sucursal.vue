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
                    <i class="fa fa-align-justify"></i> Sucursales
                    <button type="button" @click="abrirModal('sucursal','registrar')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="criterio">
                                    <option value="nombreComercial">Nombre comercial</option>
                                    <option value="razonSocial">Razón social</option>
                                </select>
                                <input type="text" v-model="buscar" @keyup.enter="listarSucursal(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                <button type="submit" @click="listarSucursal(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Nombre comercial</th>
                                <th>Razón Social</th>
                                <th>Dirección</th>
                                <th>Número de Empleados</th>
                                <th>Cupo de Autos</th>
                                <th>Cupo Actual</th>
                                <th>Horario</th>
                                <th>Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="sucursal in arraySucursal" :key="sucursal.id">
                                <td>
                                    <button type="button" @click="abrirModal('sucursal','actualizar',sucursal)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <!-- <button type="button" @click="abrirModalHorario('sucursal','actualizar',sucursal)" class="btn btn-primary btn-sm">
                                        <i class="icon-clock"></i>
                                    </button> &nbsp; -->
                                    <template v-if="sucursal.estatus">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarSucursal(sucursal.id)">
                                            <i class="icon-trash"></i>
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" class="btn btn-success btn-sm" @click="activarSucursal(sucursal.id)">
                                            <i class="icon-check"></i>
                                        </button>
                                    </template>
                                </td>
                                <td v-text="sucursal.nombreComercial"></td>
                                <td v-text="sucursal.razonSocial"></td>
                                <td v-text="sucursal.direccion"></td>
                                <td v-text="sucursal.numEmpleados"></td>
                                <td v-text="sucursal.cupoAutos"></td>
                                <td v-text="sucursal.stockCupo"></td>
                                <td v-text="sucursal.horaInicio+'-'+sucursal.horaFin"></td>
                                <td>
                                    <div v-if="sucursal.estatus">
                                        <span class="badge badge-success">Activo</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">Desactivado</span>
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
        <!--Inicio del modal agregar/actualizar-->
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
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Nombre Comercial:</label>
                                <div class="col-md-4">
                                    <input type="text" v-model="nombreComercial" class="form-control" placeholder="Ingrese el nombre comercial">
                                </div>
                            
                                <label class="col-md-2 form-control-label" for="email-input">Razón Social:</label>
                                <div class="col-md-4">
                                    <input type="text" v-model="razonSocial" class="form-control" placeholder="Ingrese la razón social">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Direccion:</label>
                                <div class="col-md-4">
                                    <textarea type="text" v-model="direccion" class="form-control" placeholder="Ingrese la dirección"></textarea>
                                    
                                </div>
                           
                                <label class="col-md-1 form-control-label" for="text-input">Numero Empleados:</label>
                                <div class="col-md-2">
                                    <input type="number" min="0" max="150" v-model="numEmpleados" class="form-control" placeholder="Ingrese el número de empleados">
                                    
                                </div>
                            
                                <label class="col-md-1 form-control-label" for="email-input">Cupo Autos:</label>
                                <div class="col-md-2">
                                    <input type="number" min="0" max="150" v-model="cupoAutos" class="form-control" placeholder="Ingrese el cupo de autos">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 form-control-label" for="text-input">Longitud:</label>
                                <div class="col-md-4">
                                    <input type="number" step="any" v-model="longitud" class="form-control" placeholder="Ingrese la longitud">
                                    
                                </div>
                            
                                <label class="col-md-2 form-control-label" for="email-input">Latitud:</label>
                                <div class="col-md-4">
                                    <input type="number" step="any" v-model="latitud" class="form-control" placeholder="Ingrese la latitud">
                                </div>
                           </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">Código Ubicación:</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="codigoUbicacion" class="form-control" placeholder="Ingrese el código de ubicación">
                                </div>
                            </div>
                            <div v-show="errorSucursal" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjSucursal" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSucursal()">Guardar</button>
                        <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSucursal()">Actualizar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->

        <!--Inicio del modal configurar horario-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalHorario}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModalHorario()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <!--<div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Hora Inicial</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="horaInicio" class="form-control" placeholder="Nombre de Comercial">
                                    <select v-model="horaInicio" class="form-control col-md-3">
                                        <option value="hora" >nombreComercial</option>
                                        <option value="nombreComercial" >nombreComercial</option>
                                        <option value="razonSocial">razonSocial</option>
                                    </select>
                                    <select v-model="horaInicio" class="form-control" id="horaI">
                                        <option {{v-model="horaInicio">{{sucursal.horaInicio}}</option>
                                    </select>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="docente">Docente</label>
                                            <select v-model="horaInicio" class="form-control" id="horaI">
                                                <option v-for="sucursal in arraySucursal" :key="sucursal.id">{{sucursal.horaInicio}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <h2>Docente seleccionado:</h2>
                                        {{horaInicio}}
                                    </div>
                                    <div class="input-group clockpicker" @click="clock()" data-placement="left" data-align="top" data-autoclose="true">
                                        <input type="text" class="form-control" value="13:14">
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-time"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>-->
                            <div class="form-group row">
                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control-label">Hora Inicial</label>
                                    <div class="col-xs-12 col-sm-16 col-md-12 col-lg-12">
                                        <input type="text" v-model="horaInicio" class="form-control" placeholder="Ingrese la hora de inicio" disabled>
                                    </div>
                                    <div class="col-xs-12 col-sm-16 col-md-12 col-lg-12">
                                        <select class="form-control" size="3" v-model="horaInicio">
                                            <option value="05:00">05:00</option>
                                            <option value="06:00">06:00</option>
                                            <option value="07:00">07:00</option>
                                            <option value="08:00">08:00</option>
                                            <option value="09:00">09:00</option>
                                            <option value="10:00">10:00</option>
                                            <option value="11:00">11:00</option>
                                            <option value="12:00">12:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="14:00">14:00</option>
                                            <option value="15:00">15:00</option>
                                            <option value="16:00">16:00</option>
                                            <option value="17:00">17:00</option>
                                            <option value="18:00">18:00</option>
                                            <option value="19:00">19:00</option>
                                            <option value="20:00">20:00</option>
                                            <option value="21:00">21:00</option>
                                            <option value="22:00">22:00</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                                    <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-control-label" for="email-input">Hora Final</label>
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                        <input type="text" v-model="horaFin" class="form-control" placeholder="Ingrese la hora final" disabled>
                                    </div>
                                    <div class="col-xs-12 col-sm-16 col-md-12 col-lg-12">
                                        <select class="form-control" size="3" v-model="horaFin">
                                            <option value="05:00">05:00</option>
                                            <option value="06:00">06:00</option>
                                            <option value="07:00">07:00</option>
                                            <option value="08:00">08:00</option>
                                            <option value="09:00">09:00</option>
                                            <option value="10:00">10:00</option>
                                            <option value="11:00">11:00</option>
                                            <option value="12:00">12:00</option>
                                            <option value="13:00">13:00</option>
                                            <option value="14:00">14:00</option>
                                            <option value="15:00">15:00</option>
                                            <option value="16:00">16:00</option>
                                            <option value="17:00">17:00</option>
                                            <option value="18:00">18:00</option>
                                            <option value="19:00">19:00</option>
                                            <option value="20:00">20:00</option>
                                            <option value="21:00">21:00</option>
                                            <option value="22:00">22:00</option>
                                        </select>
                                    </div>
                                 </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="cerrarModalHorario()">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="configurarHorario()">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
    export default {
        data (){
            return {
                sucursal_id: 0,
                nombreComercial : '',
                razonSocial : '',
                direccion : '',
                codigoUbicacion : '',
                numEmpleados : '',
                cupoAutos : '',
                stockCupo : '',
                longitud : '',
                latitud : '',
                horaInicio : '',
                horaFin : '',
                estatus : '',
                arraySucursal : [],
                modal : 0,
                modalHorario : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSucursal : 0,
                errorMostrarMsjSucursal : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombreComercial',
                buscar : ''
            }
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
          clock(){
            clockpicker(); 
          },
            listarSucursal (page,buscar,criterio){
                let me=this;
                var url= '/sucursal?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySucursal = respuesta.sucursales.data;
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
                me.listarSucursal(page,buscar,criterio);
            },
            registrarSucursal(){
                if (this.validarSucursal()){
                    return;
                }
                
                let me = this;
                if(this.numEmpleados<1 || this.cupoAutos<1){
                    swal(
                        'Cuidado!',
                        'El valor no puede ser menor a 1',
                        'warning'
                        )
                }else{
                axios.post('/sucursal/registrar',{
                    'nombreComercial': this.nombreComercial,
                    'razonSocial': this.razonSocial,
                    'direccion': this.direccion,
                    'codigoUbicacion': this.codigoUbicacion,
                    'numEmpleados': this.numEmpleados,
                    'cupoAutos': this.cupoAutos,
                    'longitud': this.longitud,
                    'latitud': this.latitud
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSucursal(1,'','nombreComercial');
                    swal(
                        '¡Agregado!',
                        'El registro ha sido agregado con éxito.',
                        'success'
                        )
                }).catch(function (error) {
                    console.log(error);
                });}
            },
            actualizarSucursal(){
               if (this.validarSucursal()){
                    return;
                }
                
                let me = this;
                if(this.numEmpleados<1 || this.cupoAutos<1){
                    swal(
                        'Cuidado!',
                        'El valor no puede ser menor a 1',
                        'warning'
                        )
                }else{
                axios.put('/sucursal/actualizar',{
                    'nombreComercial': this.nombreComercial,
                    'razonSocial': this.razonSocial,
                    'direccion': this.direccion,
                    'codigoUbicacion': this.codigoUbicacion,
                    'numEmpleados': this.numEmpleados,
                    'cupoAutos': this.cupoAutos,
                    'stockCupo': this.stockCupo,
                    'longitud': this.longitud,
                    'latitud': this.latitud,
                    'id': this.sucursal_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarSucursal(1,'','nombreComercial');
                    
                }).catch(function (error) {
                    console.log(error);
                }); 
                }
            },
            desactivarSucursal(id){
                swal({
                    title: '¿Esta seguro de desactivar esta Sucursal?',
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

                        axios.put('/sucursal/desactivar',{
                            'id': id
                        }).then(function (response) {
                            me.listarSucursal(1,'','nombreComercial');
                            swal(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito.',
                            'success'
                            )
                        }).catch(function (error) {
                            console.log(error);
                        });
                    } else if (
                        // Read more about handling dismissals
                        result.dismiss === swal.DismissReason.cancel
                    ){    
                    }
                }) 
            },
            activarSucursal(id){
               swal({
                title: 'Esta seguro de activar esta sucursal?',
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

                    axios.put('/sucursal/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarSucursal(1,'','nombreComercial');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            validarSucursal(){
                this.errorSucursal=0;
                this.errorMostrarMsjSucursal =[];

                if (!this.nombreComercial) this.errorMostrarMsjSucursal.push("El nombre comercial de la sucursal no puede estar vacío.");
                if (!this.razonSocial) this.errorMostrarMsjSucursal.push("La razón social de la sucursal no puede estar vacío.");
                if (!this.direccion) this.errorMostrarMsjSucursal.push("La dirección de la sucursal no puede estar vacío.");
                if (!this.codigoUbicacion) this.errorMostrarMsjSucursal.push("El código de la sucursal no puede estar vacío.");
                if (!this.numEmpleados) this.errorMostrarMsjSucursal.push("El número de empleados de la sucursal no puede estar vacío.");
                if (!this.cupoAutos) this.errorMostrarMsjSucursal.push("El cupo de autos de la sucursal no puede estar vacío.");
                if (!this.longitud) this.errorMostrarMsjSucursal.push("La longitud de la sucursal no puede estar vacío.");
                if (!this.latitud) this.errorMostrarMsjSucursal.push("La latitud de la sucursal no puede estar vacío.");

                if (this.errorMostrarMsjSucursal.length) this.errorSucursal = 1;

                return this.errorSucursal;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreComercial='';
                this.razonSocial='';
                this.direccion='';
                this.codigoUbicacion='';
                this.numEmpleados='';
                this.cupoAutos='';
                this.stockCupo='';
                this.longitud='';
                this.latitud='';
            },
            cerrarModalHorario(){
                this.modalHorario=0;
                this.horaInicio='';
                this.horaFin='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "sucursal":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Sucursal';
                                this.nombreComercial='';
                                this.razonSocial='';
                                this.direccion='';
                                this.codigoUbicacion='';
                                this.numEmpleados='';
                                this.cupoAutos='';
                                this.stockCupo='';
                                this.longitud='';
                                this.latitud='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Sucursal';
                                this.tipoAccion=2;
                                this.sucursal_id=data['id'];
                                this.nombreComercial=data['nombreComercial'];
                                this.razonSocial= data['razonSocial'];
                                this.direccion= data['direccion'];
                                this.codigoUbicacion= data['codigoUbicacion'];
                                this.numEmpleados= data['numEmpleados'];
                                this.cupoAutos= data['cupoAutos'];
                                this.stockCupo= data['stockCupo'];
                                this.longitud= data['longitud'];
                                this.latitud= data['latitud'];
                                break;
                            }
                        }
                    }
                }
            },
            abrirModalHorario(modelo, accion, data = []){
                switch(modelo){
                    case "sucursal":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modalHorario=1;
                                this.tituloModal='Configurar Horario';
                                this.tipoAccion=3;
                                this.sucursal_id=data['id'];
                                this.horaInicio=data['horaInicio'];
                                this.horaFin= data['horaFin'];
                                break;
                            }
                        }
                    }
                }
            },
            configurarHorario(){
              /* if (this.validarSucursal()){
                    return;
                }*/
                
                let me = this;

                if(this.horaInicio>=this.horaFin){
                        swal(
                        'Cuidado!',
                        'La hora inicio no puede mayor que la hora fin.',
                        'warning'
                        )
                    }else{

                    axios.put('/sucursal/configurarHorario',{
                        'horaInicio': this.horaInicio,
                        'horaFin': this.horaFin,
                        'id': this.sucursal_id,
                    }).then(function (response) {
                        me.cerrarModalHorario();
                        me.listarSucursal(1,'','nombreComercial');
                        swal(
                            'Horario modificado!',
                            'El horario ha sido modificado con éxito.',
                            'success'
                            )
                    }).catch(function (error) {
                        console.log(error);
                    });  
                }
            }
        },
        mounted() {
            this.listarSucursal(1,this.buscar,this.criterio);
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
