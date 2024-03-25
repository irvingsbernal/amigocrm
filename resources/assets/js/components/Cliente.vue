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
                        <i class="fa fa-align-justify"></i> Clientes registrados
                        <button type="button" @click="abrirModal('cliente','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="telefono">Teléfono</option>
                                      <option value="correo">Correo</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarCliente(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarCliente(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Número cliente</th>
                                    <th>Nombre completo</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Correo</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                    <td>
                                        <button type="button" @click="abrirModal('cliente','actualizar',cliente)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="cliente.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCliente(cliente.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCliente(cliente.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="cliente.numerocliente"></td>
                                    <td v-text="cliente.nombre+' '+cliente.apellidoPaterno"></td>
                                    <td v-text="cliente.telefono"></td>
                                    <td v-text="cliente.direccion"></td>
                                    <td v-text="cliente.correo"></td>
                                    <td>
                                        <div v-if="cliente.estatus">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                        
                                    </td>
                                    <!-- <td>
                                        <img class="img-circle" :src="cliente.foto" alt = "" >
                                    </td> -->
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
                                    <div class="col-md-3">
                                        <img v-if="foto!=null" class="img-circle" :src="foto" alt = "" width="50%" height="100vh">
                                        <img v-else-if="foto==null" src="img/placeholder.jpg" width="50%" height="100vh">
                                        <input class="mt-3" style="color: transparent" type="file" name="image" @change="getImage" accept="image/*">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-md-12 form-control-label" for="text-input">Nombre:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de cliente">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-md-12 form-control-label" for="email-input">Apellido paterno:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="apellidoPaterno" class="form-control" placeholder="Apellido paterno">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="col-md-12 form-control-label" for="email-input">Apellido materno:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="apellidoMaterno" class="form-control" placeholder="Apellido materno">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="col-md-12 form-control-label" for="email-input">RFC:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="rfc" class="form-control" placeholder="rfc">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <label class="col-md-12 form-control-label" for="email-input">Dirección:</label>
                                        <div class="col-md-12">
                                            <textarea type="text" v-model="direccion" class="form-control" placeholder="Dirección"></textarea>
                                        </div>   
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-md-12 form-control-label" for="email-input">Teléfono:</label>
                                        <div class="col-md-12">
                                            <input type="number" v-model="telefono" class="form-control" placeholder="Teléfono">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label class="col-md-12 form-control-label" for="email-input">Correo:</label>
                                        <div class="col-md-12">
                                            <input type="email" v-model="correo" class="form-control" placeholder="Correo">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-md-12 form-control-label" for="email-input">Contraseña:</label>
                                        <div class="col-md-12">
                                            <input type="password" v-model="password" class="form-control" placeholder="Contraseña">
                                        </div>
                                    </div>
                                </div>
                                <div v-show="errorCliente" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCliente()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()">Actualizar</button>
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
                correo: '',
                password: '',
                nombre: '',
                apellidoPaterno: '',
                apellidoMaterno: '',
                rfc: '',
                direccion: '',
                telefono: '',
                foto: '',
                cliente_id: 0,
                numerocliente: '',
                codigoactivacion: '',
                estatus: 0,
                avatar: '',
                arrayCliente : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorCliente : 0,
                errorMostrarMsjCliente : [],
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
            listarCliente (page,buscar,criterio){
                let me=this;
                var url= '/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                // let me=this;
                // axios.get('/cliente').then(function (response) {
                //     console.log(response);
                //     me.arrayCliente = response.data;

                // }).catch(function (error) {
                //     console.log(error);
                // })
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCliente(page,buscar,criterio);
            },
            registrarCliente(){
                if (this.validarCliente()){
                    return;
                }
                
                let me = this;

                axios.post('/cliente/registrar',{
                    'nombre': this.nombre,
                    'apellidoPaterno': this.apellidoPaterno,
                    'apellidoMaterno': this.apellidoMaterno,
                    'rfc': this.rfc,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'foto': this.avatar,
                    'correo': this.correo,
                    'password': this.password,
                }).then(function (response) {
                    Swal.fire('¡El registro ha sido completado!', 'Ahora da de alta el automovil del cliente', 'success');
                    me.cerrarModal();
                    me.listarCliente(1,'','nombre');
                }).catch(function (error) {
                    // console.log(error);
                    Swal.fire('Ocurrio un problema', 'Favor de volver a intentarlo', 'error');
                });
            },
            actualizarCliente(){
               if (this.validarCliente()){
                    return;
                }
                
                let me = this;

                axios.put('/cliente/actualizar',{
                    'nombre': this.nombre,
                    'apellidoPaterno': this.apellidoPaterno,
                    'apellidoMaterno': this.apellidoMaterno,
                    'rfc': this.rfc,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo,
                    'foto': this.foto,
                    'id': this.cliente_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarCliente(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarCliente(id){
               swal({
                title: 'Esta seguro de desactivar este cliente?',
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

                    axios.put('/cliente/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCliente(1,'','nombre');
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
            activarCliente(id){
               swal({
                title: 'Esta seguro de activar este cliente?',
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

                    axios.put('/cliente/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCliente(1,'','nombre');
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
            validarCliente(){
                this.errorCliente=0;
                this.errorMostrarMsjCliente =[];

                if (!this.nombre || !this.apellidoPaterno) this.errorMostrarMsjCliente.push("El nombre y apellido paterno del cliente no puede estar vacío.");
                if (!this.telefono) this.errorMostrarMsjCliente.push("El teléfono no puede estar vacío.");
                if (!this.correo) this.errorMostrarMsjCliente.push("El correo electrónico no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjCliente.push("La contraseña no puede estar vacía ni contener espacios.");
                if (this.errorMostrarMsjCliente.length) this.errorCliente = 1;

                return this.errorCliente;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.descripcion='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "cliente":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar cliente';
                                this.cliente_id = 0;
                                this.correo = '',
                                this.password = '',
                                this.nombre = '',
                                this.apellidoPaterno = '',
                                this.apellidoMaterno = '',
                                this.rfc = '',
                                this.direccion = '',
                                this.telefono = '',
                                this.foto = null,
                                this.avatar = '',
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar cliente';
                                this.tipoAccion=2;
                                this.cliente_id=data['id'];
                                this.correo = data['correo'],
                                //this.password = data['password'],
                                this.nombre = data['nombre'],
                                this.apellidoPaterno = data['apellidoPaterno'],
                                this.apellidoMaterno = data['apellidoMaterno'],
                                this.rfc = data['rfc'],
                                this.direccion = data['direccion'],
                                this.telefono = data['telefono'],
                                this.foto = data['foto']
                                break;
                            }
                        }
                    }
                }
            },
            getImage(e){
                let image = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
                    this.foto = this.avatar;
                }
                this.loaded = true;
            }    
        },
        mounted() {
            this.listarCliente(1,this.buscar,this.criterio);
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