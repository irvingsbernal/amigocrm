<template>
    <main>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card-group mb-0">
                <div class="card p-4">
                <form class="form-horizontal was-validated" enctype="multipart/form-data" method="POST">
                        <div class="card-body">
                        <h1>Activación de cuenta</h1>
                        <p class="text-muted">Control de acceso a AMI.GO</p>
                        <div class="form-group mb-4">
                            <span class="input-group-addon"><i class="icon-bell"></i></span>
                            <input type="text" v-model="codigoactivacion" class="form-control" placeholder="Código activación">
                        </div>
                        <div v-show="errorCliente" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjCliente" :key="error" v-text="error">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                            <button type="button" class="btn btn-primary px-4" @click="activarCuenta()">Activar cuenta</button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
                <div class="card text-white bg-secondary py-5 d-md-down-none" style="width:44%">
                    <div class="card-body text-center">
                    <div>
                        <h2>AMI.GO: una herramienta de gestión de Écrou Hexagonal</h2>
                    <p><b>A</b>dvanced <b>M</b>echanical <b>I</b>mporve... <b>¡Go!</b></p>
                    <a href="#" target="_blank" class="btn btn-warning active mt-3">Quiero saber más</a></div>
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
                codigoactivacion: '',
                errorCliente : 0,
                errorMostrarMsjCliente : [],
            }
        },
        computed:{
        },
        methods : {
            activarCuenta(){
                if (this.validarCliente()){
                    return;
                }
                
                let me = this;

                axios.post('/cliente/activarcuenta',{
                    'codigoactivacion': this.codigoactivacion,
                }).then(function (response) {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Tu cuenta ha sido activada con éxito',
                        html: 'Se te redirigirá al login',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = '/';
                    });
                }).catch(function (error) {
                    // console.log(error);
                    Swal.fire('Tu código no fue encontrado', 'Asegurate de introducirlo correctamente', 'error');
                });
            },
            validarCliente(){
                this.errorCliente=0;
                this.errorMostrarMsjCliente =[];

                if (!this.codigoactivacion) this.errorMostrarMsjCliente.push("Debes introducir tu código de activación");
                if (this.errorMostrarMsjCliente.length) this.errorCliente = 1;

                return this.errorCliente;
            },  
        },
        mounted() {
        }
    }
</script>