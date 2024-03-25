<template>
    <main>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card-group mb-0">
                <div class="card p-4" style=" border-bottom-left-radius: 15px; border-top-left-radius: 15px;">
                <form class="form-horizontal was-validated" enctype="multipart/form-data" method="POST" >
                        <div class="card-body">
                        <h1>Registro</h1>
                        <p class="text-muted">Control de acceso a AMI.GO</p>
                        <div class="row">
                            <div class="form-group mb-4 col-md-4">
                                <span class="input-group-addon"><i class="icon-people"></i></span>
                                <input type="text" v-model="nombre" class="form-control" placeholder="Nombre/s">
                            </div>
                            <div class="form-group mb-4 col-md-4">
                                <span class="input-group-addon"><i class="icon-people"></i></span>
                                <input type="text" v-model="apellidoPaterno" class="form-control" placeholder="Apellido paterno">
                            </div>
                            <div class="form-group mb-4 col-md-4">
                                <span class="input-group-addon"><i class="icon-people"></i></span>
                                <input type="text" v-model="apellidoMaterno" class="form-control" placeholder="Apellido materno">
                            </div>
                            <div class="form-group mb-4 col-md-8">
                                <span class="input-group-addon"><i class="icon-phone"></i></span>
                                <input type="number" v-model="telefono" class="form-control" placeholder="Teléfono">
                            </div><br>
                            <div class="form-group mb-4 col-md-8">
                                <span class="input-group-addon"><i class="icon-envelope-letter"></i></span>
                                <input type="email" v-model="correo" class="form-control" placeholder="Correo">
                            </div>
                            <div class="form-group mb-4 col-md-4">
                            <span class="input-group-addon"><i class="icon-lock"></i></span>
                            <input type="password" v-model="password" class="form-control" placeholder="Contraseña">
                            </div>
                        </div>
                        <div v-show="errorCliente" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                            <button type="button" class="btn btn-primary px-4" @click="registrarCliente()">Registrarme</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="card text-white bg-secondary d-md-down-none" style="width:44%; background-image: url('img/taller.jpg'); border-color: #c2cfd6;border-bottom-right-radius: 15px; border-top-right-radius: 15px;">
                    <div class="card-body text-center" style="background: #152560c4; padding-top: 10.5rem; border-bottom-right-radius: 15px; border-top-right-radius: 15px;">
                    <div>
                        <h2>AMI.GO: una herramienta de gestión de Écrou Hexagonal</h2>
                    <p><b>A</b>dvanced <b>M</b>echanical <b>I</b>mporve... <b>¡Go!</b></p>
                    <a href="/#citas" target="_blank" class="btn btn-warning active mt-3">Quiero saber más</a></div>
                    </div>
                </div>
                </div>
            </div>
        </div>
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
                telefono: '',
                errorCliente : 0,
                errorMostrarMsjCliente : [],
            }
        },
        computed:{
        },
        methods : {
            registrarCliente(){
                if (this.validarCliente()){
                    return;
                }
                
                let me = this;

                axios.post('/registrocliente',{
                    'nombre': this.nombre,
                    'apellidoPaterno': this.apellidoPaterno,
                    'apellidoMaterno': this.apellidoMaterno,
                    'telefono': this.telefono,
                    'correo': this.correo,
                    'password': this.password,
                }).then(function (response) {
                    Swal.fire({
                        title: '¡El registro ha sido completado!',
                        text: 'Este es tu código de activación de cuenta: ' + response.data,
                        icon: 'success',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'Okay'
                        }).then((result) => {
                        if (result.value) {
                            Swal.fire({
                                title: 'Código de activación de cuenta: ' + response.data,
                                text: 'Recuerda tú código de activación, se te va a solicitar en la siguiente pantalla',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'Sí, ir al siguiente paso'
                                }).then((result) => {
                                if (result.value) {
                                    window.location.href = '/activacion-cuenta';
                                }
                                })
                        }
                        })
                }).catch(function (error) {
                    // console.log(error);
                    Swal.fire('Ocurrio un problema', 'Favor de volver a intentarlo', 'error');
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
        },
        mounted() {
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