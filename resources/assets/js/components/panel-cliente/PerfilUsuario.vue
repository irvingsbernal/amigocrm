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
                        PERFIL DE USUARIO &nbsp;
                    </div>
                    <div class="card-body" v-for="cliente in arrayCliente" :key="cliente.id">
                        <div class="container">
                            <div class="row my-2">
                                <div class="col-lg-8 order-lg-2">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="" data-target="#profile"  data-toggle="tab" class="nav-link active">Mi perfil</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="" @click="abrirModal(cliente)" data-target="#edit" data-toggle="tab" class="nav-link">Editar datos</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content py-4">
                                        <div class="tab-pane active" id="profile">
                                            <h5 class="mb-3">Perfil de usuario</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Número de cliente:</h6>
                                                    <p>
                                                        <input type="text" :value="cliente.numerocliente" class="form-control" placeholder="Número de cliente" disabled>
                                                    </p>
                                                    <h6>Estatus:</h6>
                                                
                                                    <p v-if="cliente.estatus">
                                                        <span class="badge badge-primary"><i class="fa fa-toggle-on"></i> &nbsp;Activo</span>
                                                    </p>
                                                    <p v-else>
                                                        <span class="badge badge-warning"><i class="fa fa-toggle-on"></i> &nbsp;Inactivo</span>
                                                    </p>

                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Código QR:</h6>
                                                    <qrcode-vue :value="cliente.numerocliente" size="100" foreground="#9ca9d3" level="H"></qrcode-vue>
                                                </div>
                                            </div>
                                            <!--/row-->
                                        </div>
                                        <div class="tab-pane" id="edit">
                                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Nombre</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre/s">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Apellido paterno</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" v-model="apellidoPaterno" class="form-control" placeholder="Apellido paterno">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Apellido materno</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" v-model="apellidoMaterno" class="form-control" placeholder="Apellido materno">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">RFC</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" v-model="RFC" class="form-control" placeholder="RFC">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Dirección</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="text" v-model="direccion" placeholder="Colonia">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                                    <div class="col-lg-6">
                                                        <input class="form-control" type="text" value="" placeholder="Calle">
                                                    </div>
                                                    <div class="col-lg-3">
                                                        <input class="form-control" type="text" value="" placeholder="Número">
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Time Zone</label>
                                                    <div class="col-lg-9">
                                                        <select id="user_time_zone" class="form-control" size="0">
                                                            <option value="Hawaii">(GMT-10:00) Hawaii</option>
                                                            <option value="Alaska">(GMT-09:00) Alaska</option>
                                                            <option value="Pacific Time (US &amp; Canada)">(GMT-08:00) Pacific Time (US &amp; Canada)</option>
                                                            <option value="Arizona">(GMT-07:00) Arizona</option>
                                                            <option value="Mountain Time (US &amp; Canada)">(GMT-07:00) Mountain Time (US &amp; Canada)</option>
                                                            <option value="Central Time (US &amp; Canada)" selected="selected">(GMT-06:00) Central Time (US &amp; Canada)</option>
                                                            <option value="Eastern Time (US &amp; Canada)">(GMT-05:00) Eastern Time (US &amp; Canada)</option>
                                                            <option value="Indiana (East)">(GMT-05:00) Indiana (East)</option>
                                                        </select>
                                                    </div>
                                                </div> -->
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Teléfono</label>
                                                    <div class="col-lg-9">
                                                        <input type="text" v-model="telefono" class="form-control" placeholder="Teléfono">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Correo</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="email" v-model="correo">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Contraseña</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="password" v-model="password">
                                                    </div>
                                                </div>
                                                <div v-show="errorCliente" class="form-group row div-error">
                                                    <div class="text-center text-error">
                                                        <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                                    <div class="col-lg-9">
                                                        <input class="form-control" type="password" value="11111122333">
                                                    </div>
                                                </div> -->
                                                <div class="form-group row">
                                                    <label class="col-lg-3 col-form-label form-control-label"></label>
                                                    <div class="col-lg-9">
                                                        <input type="reset" class="btn btn-secondary" value="Cancelar">
                                                        <input type="button" class="btn btn-primary" @click="actualizarCliente()" value="Guardar cambios">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 order-lg-1 text-center">
                                    <img v-if="fotografia != null" :src="fotografia" class="mx-auto img-fluid img-circle d-block" :alt="cliente.nombre">
                                    <img v-else-if="fotografia == null" src="img/placeholder.jpg" class="mx-auto img-fluid img-circle d-block" :alt="cliente.nombre">
                                    <h6 class="mt-2">Cambiar mi foto de perfil</h6>
                                    <label class="custom-file">
                                        <input type="file" @change="getImage" id="file" class="custom-file-input" :disabled="edicion">
                                        <span class="custom-file-control">Elige una fotografía</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <!--Fin del modal-->
        </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';
    import QrcodeVue from 'qrcode.vue'
    export default {
        data (){
            return {
                idUsuario: this.$attrs.id,
                correo: '',
                password: '',
                nombre: '',
                apellidoPaterno: '',
                apellidoMaterno: '',
                RFC: '',
                direccion: '',
                telefono: '',
                fotografia: '',
                edicion: true,
                cliente_id: 109, /** ------------------------------------- Session - ID Cliente que ingreso ------------------------------- */
                criterio : 'id',
                buscar : this.$attrs.id, /** ------------------------------------- Session - ID Cliente que ingreso ------------------------------- */
                arrayCliente : [],
                errorCliente : 0,
                errorMostrarMsjCliente : [],
            }
        },
        components: {
        'barcode': VueBarcode,
        QrcodeVue,
        },
        computed:{
            
        },
        methods : {
            listarCliente (page,buscar,criterio){
                let me=this;
                var url= '/cliente?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.clientes.data[0].foto;
                    me.arrayCliente = respuesta.clientes.data;
                    console.log(me.arrayCliente);
                })
                .catch(function (error) {
                    console.log(error);
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
                    'RFC': this.RFC,
                    'direccion': this.direccion,
                    'telefono': this.telefono,
                    'correo': this.correo,
                    'password': this.password,
                    'foto': this.fotografia,
                    'id': this.cliente_id
                }).then(function (response) {
                    Swal.fire('¡Tu perfil ha sido actualizado!', 'Sigue al día con el mantenimiento de tu automóvil', 'success');
                }).catch(function (error) {
                    Swal.fire('¡Algo salio mal!', 'Intentalo de nuevo', 'error');
                }); 
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
            abrirModal(data = []){
                this.cliente_id=data['id'];
                this.correo = data['correo'],
                //this.password = data['password'],
                this.nombre = data['nombre'],
                this.apellidoPaterno = data['apellidoPaterno'],
                this.apellidoMaterno = data['apellidoMaterno'],
                this.RFC = data['RFC'],
                this.direccion = data['direccion'],
                this.telefono = data['telefono'],
                this.fotografia= data['foto'],
                this.edicion = false
            },
            getImage(e){
                let image = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
                    this.fotografia = this.avatar;
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