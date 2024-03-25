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
                        <i class="fa fa-align-justify"></i> Subservicios
                        <button type="button" @click="abrirModal('Subservicio','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre" selected>Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listaSubservicio(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listaSubservicio(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Servicio</th>
                                    <th>Costo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="Subservicio in arraySubservicio" :key="Subservicio.id">
                                    <td>
                                        <button type="button" @click="abrirModal('Subservicio','actualizar',Subservicio)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="Subservicio.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarSubservicio(Subservicio.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarSubservicio(Subservicio.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Servicio:</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="fk_servicio">
                                            <option value="0" disabled>Seleccione--</option>
                                            <option v-for="servicio in arrayServicio" :key="servicio.id" :value="servicio.id" v-text="servicio.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del subservicio">                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Costo SubServicio</label>
                                    <div class="col-md-9">
                                        <input type="number" v-model="costoServicio" class="form-control" placeholder="$0.00">                                        
                                    </div>
                                </div>
                                <div v-show="errorSubservicio" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSubservicio" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSubservicio()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSubservicio()">Actualizar</button>
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
    import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                Subservicio_id: 0,
                fk_servicio : 0,
                nombre_servicio : '',
                nombre : '',
                costoServicio : 0,
                arraySubservicio : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorSubservicio : 0,
                errorMostrarMsjSubservicio : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
                buscar : '',
                arrayServicio :[]
            }
        },
        components: {
        'barcode': VueBarcode
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
            listaSubservicio (page,buscar,criterio){
                let me=this;
                var url= '/subservicio?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySubservicio = respuesta.subservicios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectServicio(){
                let me=this;
                var url= '/servicio/selectServicio';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayServicio = respuesta.servicio;
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
                me.listaSubservicio(page,buscar,criterio);
            },
            registrarSubservicio(){
                if (this.validarSubservicio()){
                    return;
                }
                console.log('Bien');
                console.log(this.nombre);
                console.log(this.fk_servicio);
                console.log(this.costoServicio);
                let me = this;

                axios.post('/subservicio/registrar',{
                    'fk_servicio': this.fk_servicio,
                    'nombre': this.nombre,
                    'costoServicio': this.costoServicio
                }).then(function (response) {
                    me.cerrarModal();
                    me.listaSubservicio(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarSubservicio(){
               if (this.validarSubservicio()){
                    return;
                }
                
                let me = this;

                axios.put('/subservicio/actualizar',{
                    'fk_servicio': this.fk_servicio,
                    'nombre': this.nombre,
                    'costoServicio': this.costoServicio,
                    'id': this.Subservicio_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listaSubservicio(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarSubservicio(id){
               swal({
                title: 'Esta seguro de desactivar este subServicio?',
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

                    axios.put('/subservicio/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listaSubservicio(1,'','nombre');
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
                ) {
                    
                }
                }) 
            },
            activarSubservicio(id){
               swal({
                title: 'Esta seguro de activar este SubServicio?',
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

                    axios.put('/subservicio/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listaSubservicio(1,'','nombre');
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
            validarSubservicio(){
                this.errorSubservicio=0;
                this.errorMostrarMsjSubservicio =[];

                if (this.fk_servicio==0) this.errorMostrarMsjSubservicio.push("Seleccione una servicio.");
                if (!this.nombre) this.errorMostrarMsjSubservicio.push("El nombre del subservicio no puede estar vacío.");
                if (!this.costoServicio) this.errorMostrarMsjSubservicio.push("El costo del subservicio debe ser un número y no puede estar vacío.");
                if (this.errorMostrarMsjSubservicio.length) this.errorSubservicio = 1;

                return this.errorSubservicio;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.fk_servicio= 0;
                this.nombre_servicio = '';
                this.costoServicio = '';
                this.nombre = '';
                this.errorSubservicio=0;
            },
            abrirModal(modelo, accion, data = []){
                    switch(modelo){
                    case "Subservicio":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Subservicio';
                                this.fk_servicio=0;
                                this.nombre_servicio='';
                                this.nombre= '';
                                this.costoServicio=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Subservicio';
                                this.tipoAccion=2;
                                this.Subservicio_id=data['id'];
                                this.fk_servicio=data['fk_servicio'];
                                this.costoServicio=data['costoServicio'];
                                this.nombre = data['nombre'];
                                break;
                            }
                        }
                    }
                }
                this.selectServicio();
            }
        },
        mounted() {
            this.listaSubservicio(1,this.buscar,this.criterio);
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
