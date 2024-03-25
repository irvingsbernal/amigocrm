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
                        <i class="fa fa-align-justify"></i> Proveedores
                        <button type="button" @click="abrirModal('proveedor','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-7">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="criterio">
                                      <option value="nombreComercial">Nombre Comercial</option>
                                      <option value="razonSocial">Razon Social</option>
                                      <option value="rfc">RFC</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarproveedor(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarproveedor(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre Comercial</th>
                                    <th>Razón Social</th>
                                    <th>RFC</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="proveedor in arrayproveedor" :key="proveedor.id">
                                    <td>
                                        <button type="button" @click="abrirModal('proveedor','actualizar',proveedor)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="proveedor.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarproveedor(proveedor.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarproveedor(proveedor.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="proveedor.id"></td>
                                    <td v-text="proveedor.nombreComercial"></td>
                                    <td v-text="proveedor.razonSocial"></td>
                                    <td v-text="proveedor.rfc"></td>
                                    <td v-text="proveedor.direccion"></td>
                                    <td v-text="proveedor.telefono"></td>
                                    <td v-text="proveedor.correo"></td>
                                    <td>
                                        <div v-if="proveedor.estatus">
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
                            <h5 class="modal-title" v-text="tituloModal"></h5>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Nombre Comercial:</label>
                                    <div class="col-md-5">
                                        <input type="text" v-model="nombreComercial" class="form-control" placeholder="Nombre Comercial">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Razón Social:</label>
                                    <div class="col-md-5">
                                        <input type="text" v-model="razonSocial" class="form-control" placeholder="Razón Social">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">RFC:</label>
                                    <div class="col-md-2">
                                        <input type="text" v-model="rfc" class="form-control" placeholder="RFC">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Teléfono:</label>
                                    <div class="col-md-2">
                                        <input type="text" min="10" max="10" v-model="telefono" class="form-control" placeholder="Teléfono">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Dirección:</label>
                                    <div class="col-md-5">
                                        <textarea v-model="direccion" class="form-control" placeholder="Calle No., Colonia , C.P. Ciudad,Estado." cols="3" rows="2"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    
                                    <label class="col-md-1 form-control-label" for="text-input">Correo:</label>
                                    <div class="col-md-5">
                                        <input type="text" v-model="correo" class="form-control" placeholder="example@example.com">                                        
                                    </div>
                                </div>
                                <div v-show="errorproveedor" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjproveedor" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarproveedor()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarproveedor()">Actualizar</button>
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
                id: 0,
                nombreComercial : '',
                razonSocial : '',
                rfc : '',
                direccion: '',
                correo : '',
                telefono: '',
                arrayproveedor : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorproveedor : 0,
                errorMostrarMsjproveedor : [],
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
                buscar : '',
                arrayCategoria :[]
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
            listarproveedor (page,buscar,criterio){
                let me=this;
                var url= '/proveedor?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayproveedor = respuesta.proveedores.data;
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
                me.listarproveedor(page,buscar,criterio);
            },
            registrarproveedor(){
                if (this.validarproveedor()){
                    return;
                }
                
                let me = this;

                axios.post('/proveedor/registrar',{
                    'nombreComercial': this.nombreComercial,
                    'razonSocial': this.razonSocial,
                    'rfc': this.rfc,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo,
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarproveedor(1,'','nombreComercial');
                    swal(
                        '¡Agregado!',
                        'El proveedor ha sido agregado con éxito.',
                        'success'
                        )
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarproveedor(){
               if (this.validarproveedor()){
                    return;
                }
                
                let me = this;

                axios.put('/proveedor/actualizar',{
                    'nombreComercial': this.nombreComercial,
                    'razonSocial': this.razonSocial,
                    'rfc': this.rfc,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarproveedor(1,'','nombreComercial');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarproveedor(id){
               swal({
                title: '¿Esta seguro de desactivar a este proveedor?',
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

                    axios.put('/proveedor/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarproveedor(1,'','nombreComercial');
                        swal(
                        '¡Desactivado!',
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
            activarproveedor(id){
               swal({
                title: '¿Esta seguro de activar a este proveedor?',
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

                    axios.put('/proveedor/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarproveedor(1,'','nombreComercial');
                        swal(
                        '¡Activado!',
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
            validarproveedor(){
                this.errorproveedor=0;
                this.errorMostrarMsjproveedor =[];

                if (!this.nombreComercial) this.errorMostrarMsjproveedor.push("El Nombre Comercial del proveedor no puede quedar vacío.");
                if (!this.razonSocial) this.errorMostrarMsjproveedor.push("La Razón Social del proveedor no puede quedar vacía.");
                if (!this.rfc) this.errorMostrarMsjproveedor.push("El RFC del proveedor no puede quedar vacío.");
                if (!this.telefono) this.errorMostrarMsjproveedor.push("El teléfono del proveedor debe ser un número de 10 dígitos y no puede quedar vacío.");
                
                if (this.errorMostrarMsjproveedor.length) this.errorproveedor = 1;

                return this.errorproveedor;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombreComercial = '';
                this.razonSocial = '';
                this.rfc = '';
                this.direccion = '';
                this.telefono = 0;
                this.correo = '';
		        this.errorproveedor=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "proveedor":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar proveedor';
                                this.nombreComercial = '';
                                this.razonSocial = '';
                                this.rfc = '';
                                this.direccion = '';
                                this.telefono = 0;
                                this.correo = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar proveedor';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.nombreComercial=data['nombreComercial'];
                                this.razonSocial=data['razonSocial'];
                                this.rfc=data['rfc'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.correo = data['correo'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarproveedor(1,this.buscar,this.criterio);
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
