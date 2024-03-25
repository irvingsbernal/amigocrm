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
                        <i class="fa fa-align-justify"></i> Empleados
                        <button type="button" @click="abrirModal('empleado','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="noEmpleado">No. Empleado</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarempleado(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarempleado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>No.Empleado</th>
                                    <th>Puesto</th>
                                    <th>Nombre</th>
                                    <th>Cuenta</th>
                                    <th>Rol</th>
                                    <th>NSS</th>
                                    <th>RFC</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="empleado in arrayempleado" :key="empleado.id">
                                    <td>
                                        <button type="button" @click="abrirModal('empleado','actualizar',empleado)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="empleado.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarempleado(empleado.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarempleado(empleado.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="empleado.noEmpleado"></td>
                                    <td v-text="empleado.puesto"></td>
                                    <td v-text="empleado.nombre+' '+empleado.apellidoPaterno+' '+empleado.apellidoMaterno"></td>
                                    <td v-text="empleado.correo"></td>
                                    <td v-text="empleado.rol"></td>
                                    <td v-text="empleado.nss"></td>
                                    <td v-text="empleado.rfc"></td>
                                    <td v-text="empleado.direccion"></td>
                                    <td v-text="empleado.telefono"></td>
                                    <td>
                                        <div v-if="empleado.estatus">
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
                                    <h6 class="form-control-label col-md-3" style="color: #6279a4;">Datos Personales</h6>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Fotografia:</label>
                                        <div class="col-md-2">
                                            <img :src="foto" class="image mb-1" alt="Imagen" width="120" height="120" style="border-radius:5px; border: solid 1px #c2cfd6;">
                                        </div>
                                        <input type="file" @change="actualizarFoto" name="image" class="form-input" accept="image/*">  
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Nombre(s):</label>
                                        <div class="col-md-4">
                                            <input type="text" v-model="nombre" class="form-control" placeholder="Nombre(s)">                                        
                                        </div>
                                        <label class="col-md-1 form-control-label" for="text-input">Apellidos:</label>
                                        <div class="col-md-3">
                                            <input type="text" v-model="apellidoPaterno" class="form-control" placeholder="Apellido Paterno">                                        
                                        </div>
                                        <div class="col-md-3">
                                            <input type="text" v-model="apellidoMaterno" class="form-control" placeholder="Apellido Materno">                                        
                                        </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Dirección:</label>
                                    <div class="col-md-4">
                                        <textarea v-model="direccion" class="form-control" cols="30" rows="2" placeholder="Calle No., Colonia , C.P. Ciudad,Estado."></textarea>
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">RFC:</label>
                                    <div class="col-md-3">
                                        <input type="text" v-model="rfc" class="form-control" placeholder="RFC">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Teléfono:</label>
                                    <div class="col-md-2">
                                        <input type="text" v-model="telefono" patern="[0-9]" class="form-control" placeholder="Teléfono">                                        
                                    </div>
                                </div>
                                <br>
                                
                                <div class="form-group row" v-if="tipoAccion==1">
                                    <label class="col-md-1 form-control-label" for="text-input">NSS:</label>
                                    <div class="col-md-4">
                                        <input type="text" v-model="nss" class="form-control" pattern="[0-9]" placeholder="NSS">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Puesto:</label>
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="fk_puesto">
                                            <option value="0" disabled>Seleccione un puesto...</option>
                                            <option v-for="puesto in arraypuesto" :key="puesto.id" :value="puesto.id" v-text="puesto.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h6 class="form-control-label col-md-3" style="color: #6279a4;">Credenciales</h6>
                                </div>

                                <div class="form-group row" v-if="tipoAccion==1">
                                     <label class="col-md-1 form-control-label" for="text-input">Contraseña:</label>
                                    <div class="col-md-4">
                                        <input type="password" id="pass" v-model="password" class="form-control" placeholder="Contraseña" required>
                                        <!-- <input type="checkbox" @click="showPass();" > <span toggle="#input-pwd" class="fa fa-fw fa-eye field-icon toggle-password" style="color: #6279a4;"></span>                                         -->
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Rol:</label>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="rol">
                                            <option value="0" disabled>Seleccione un rol...</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Empleado">Empleado técnico</option>
                                            <option value="Recepcionista">Recepcionista</option>
                                        </select>                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row" v-if="tipoAccion==2">
                                    <label class="col-md-1 form-control-label" for="text-input">No.Empleado:</label>
                                    <div class="col-md-3">
                                        <input type="text" v-model="noEmpleado" class="form-control" disabled>                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">NSS:</label>
                                    <div class="col-md-3">
                                        <input type="text" v-model="nss" class="form-control" pattern="[0-9]" placeholder="NSS">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Puesto:</label>
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="fk_puesto">
                                            <option value="0" disabled>Seleccione un puesto...</option>
                                            <option v-for="puesto in arraypuesto" :key="puesto.id" :value="puesto.id" v-text="puesto.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                 <div class="form-group row" v-if="tipoAccion==2">
                                   <label class="col-md-1 form-control-label" for="text-input">Firma:</label>
                                    <div class="col-md-3">
                                        <input type="text" v-model="correo" class="form-control" placeholder="Cuenta" readonly>                                        
                                    </div>
                                     <label class="col-md-1 form-control-label" for="text-input">Contraseña:</label>
                                    <div class="col-md-3">
                                        <input type="password" v-model="password" class="form-control" placeholder="Contraseña" required>
                                        <!-- <input type="checkbox" @click="showPass();"> <span toggle="#input-pwd" class="fa fa-fw fa-eye field-icon toggle-password"></span>                                           -->
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Rol:</label>
                                    <div class="col-md-3">
                                        <select class="form-control" v-model="rol">
                                            <option value="0" disabled>Seleccione un rol...</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Empleado">Empleado técnico</option>
                                            <option value="Recepcionista">Recepcionista</option>
                                        </select>                                        
                                    </div>
                                </div>
                                
                                <div v-show="errorempleado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjempleado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarempleado()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarempleado()">Actualizar</button>
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
                passwordFieldType: 'password',
                id: 0,
                nombre : '',
                apellidoPaterno : '',
                apellidoMaterno : '',
                rfc : '',
                direccion : '',
                telefono : '',
                foto : '',
                
                correo: '',
                password: '',
                rol: '',

                fk_puesto : 0,
                noEmpleado : '',
                nss : '',

                arrayempleado : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorempleado : 0,
                errorMostrarMsjempleado : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'noEmpleado',
                buscar : '',
                arraypuesto :[]
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

            showPass() {
                this.passwordFieldType = this.passwordFieldType === 'password' ? 'text' : 'password'
            },

            actualizarFoto(e){
                let image = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.foto = e.target.result;
                }
                this.loaded = true;
            },

            listarempleado (page,buscar,criterio){
                let me=this;
                var url= '/empleado?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayempleado = respuesta.empleados.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            seleccionarpuesto(){
                let me=this;
                var url= '/puesto/seleccionarPuesto';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arraypuesto = respuesta.puestos;
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
                me.listarempleado(page,buscar,criterio);
            },
            registrarempleado(){
                if (this.validarempleado()){
                    return;
                }
                
                let me = this;

                axios.post('/empleado/registrar',{
                    'nombre': this.nombre,
                    'apellidoPaterno': this.apellidoPaterno,
                    'apellidoMaterno': this.apellidoMaterno,
                    'rfc': this.rfc.toUpperCase(),
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'foto': this.foto,
                    'fk_puesto': this.fk_puesto,
                    'nss': this.nss,
                    'correo': this.correo.toLowerCase(),
                    'password': this.password,
                    'rol': this.rol
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarempleado(1,'','noEmpleado');
                    swal(
                        '¡Agregado!',
                        'El empleado ha sido registrado con éxito.',
                        'success'
                        )
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarempleado(){
               if (this.validarempleado()){
                    return;
                }
                
                let me = this;

                axios.put('/empleado/actualizar',{
                    'nombre': this.nombre,
                    'apellidoPaterno': this.apellidoPaterno,
                    'apellidoMaterno': this.apellidoMaterno,
                    'rfc': this.rfc.toUpperCase(),
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'foto': this.foto,
                    'fk_puesto': this.fk_puesto,
                    'nss': this.nss,
                    'correo': this.correo.toLowerCase(),
                    'password': this.password,
                    'rol': this.rol,
                    'id': this.id
                    
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarempleado(1,'','noEmpleado');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarempleado(id){
               swal({
                title: '¿Esta seguro de desactivar este empleado?',
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

                    axios.put('/empleado/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarempleado(1,'','noEmpleado');
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
            activarempleado(id){
               swal({
                title: '¿Esta seguro de activar este empleado?',
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

                    axios.put('/empleado/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarempleado(1,'','noEmpleado');
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
            validarempleado(){
                this.errorempleado=0;
                this.errorMostrarMsjempleado =[];

                if (this.fk_puesto==0) this.errorMostrarMsjempleado.push("Seleccione un puesto.");
                if (!this.nombre) this.errorMostrarMsjempleado.push("El nombre del empleado no puede quedar vacío.");
                if (!this.apellidoPaterno) this.errorMostrarMsjempleado.push("El apellido paterno del empleado no puede quedar vacío.");
                if (!this.nss) this.errorMostrarMsjempleado.push("El NSS del empleado debe ser un número y no puede quedar vacío.");
                if (!this.rfc) this.errorMostrarMsjempleado.push("El RFC del empleado no puede quedar vacío.");
                if (this.rfc.length < 12) this.errorMostrarMsjempleado.push("RFC no válido. Verificar que cuente con 12 o 13 caracteres.");
                if (this.rfc.length > 13) this.errorMostrarMsjempleado.push("RFC no válido. Verificar que cuente con 12 o 13 caracteres.");
                if (!this.password) this.errorMostrarMsjempleado.push("La contraseña de acceso del empleado debe ingresarse antes de cualquier registro.");
                if (!this.rol) this.errorMostrarMsjempleado.push("El rol del empleado no puede quedar vacío.");
                
                if (this.errorMostrarMsjempleado.length) this.errorempleado = 1;

                return this.errorempleado;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.id = 0;
                this.nombre = '';
                this.apellidoPaterno = '';
                this.apellidoMaterno = '';
                this.rfc = '';
                this.direccion = '';
                this.telefono = '';
                this.foto = '';
                this.fk_puesto = 0;
                this.noEmpleado = '';
                this.nss = '';
		        this.errorempleado=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "empleado":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar empleado';
                                this.id = 0;
                                this.nombre = '';
                                this.apellidoPaterno = '';
                                this.apellidoMaterno = '';
                                this.rfc = '';
                                this.direccion = '';
                                this.telefono = '';
                                this.foto = '';
                                this.fk_puesto = 0;
                                this.noEmpleado = '';
                                this.nss = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar empleado';
                                this.tipoAccion=2;

                                this.id=data['id'];
                                this.nombre=data['nombre'];
                                this.apellidoPaterno=data['apellidoPaterno'];
                                this.apellidoMaterno=data['apellidoMaterno'];
                                this.rfc=data['rfc'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.foto = data['foto'];
                                this.fk_puesto = data['fk_puesto'];
                                this.correo = data['correo'];
                                this.password = data['password'];
                                this.rol = data['rol']
                                this.noEmpleado=data['noEmpleado'];
                                this.nss=data['nss'];
                                break;
                            }
                        }
                    }
                }
                this.seleccionarpuesto();
            }
        },
        mounted() {
            this.listarempleado(1,this.buscar,this.criterio);
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
