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
                        HACER CITA PARA MANTENIMIENTO &nbsp;
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="row my-2">
                                <div class="col-lg-5 order-lg-2">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Reservación</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content py-4">
                                        <div class="tab-pane active" id="profile">
                                            <h5 class="mb-3">Detalles reservación</h5>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Sucursal:</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" v-model="fk_sucursal.nombreSucursal" class="form-control" placeholder="Sucursal" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Dirección:</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" v-model="fk_sucursal.direccion" class="form-control" placeholder="Dirección" readonly>
                                                        </div>
                                                    </div>
                                                    <!-- <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Fecha:</label>
            
                                                         <div class="col-lg-9">
                                                            {{fecha}}
                                                        </div> 
                                                     </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Hora:</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" v-model="hora" class="form-control" placeholder="Hora">
                                                        </div>
                                                    </div> -->
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label form-control-label">Automóvil:</label>
                                                        <div class="col-lg-9">
                                                            <input type="text" v-model="fk_auto.marca" class="form-control" placeholder="Marca" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <div class="col-lg-5">
                                                            <img :src="fk_auto.foto" class="mx-auto img-fluid img-circle d-block" :alt="fk_auto.placa">
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input type="text" v-model="fk_auto.placa" class="form-control" placeholder="Placa" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-4 col-form-label form-control-label">Comentarios:</label>
                                                        <div class="col-lg-8">
                                                            <textarea type="text" v-model="comentario" class="form-control" placeholder="Comentarios"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <button type="button" class="btn btn-primary px-4" @click="registrarCita()">Agendar cita</button>
                                                </div>
                                                <div v-show="errorCita" class="form-group row div-error">
                                                    <div class="text-center text-error">
                                                        <div v-for="error in errorMostrarMsjCita" :key="error" v-text="error">

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--/row-->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-7 order-lg-1 text-center">
                                    
                                    <h6>Selecciona una sucursal:</h6>
                                    <select class="form-control" v-model="fk_sucursal" >
                                        <option value="0" disabled>Seleccione--</option>
                                        <option v-for="sucursal in arraySucursales" :key="sucursal.id" @click="listarHorariosSucursal()" v-bind:value="{ id: sucursal.id, nombreSucursal: sucursal.nombreComercial, direccion: sucursal.direccion }"  v-text="sucursal.nombreComercial"></option>
                                    </select> 
                                    <!-- v-bind:value="{ id: sucursal.id, nombreSucursal: sucursal.nombreComercial, direccion: sucursal.direccion }"  -->
                                 
                                    <div class="row" v-if="fk_sucursal != 0">
                                        <div class="col-md-6">
                                            <h6 class="mt-3">Selecciona una fecha:</h6>
                                            <datepicker :disabledDates="disabledDates" format="MM/DD/yyyy" v-model="fecha" @input="listarHorariosSucursal()" :inline="true" :language="languages[language]"></datepicker>
                                        </div>

                                        <div class="col-md-6">
                                            <h6 class="mt-3">Selecciona el horario de tu preferencia:</h6>
                                             <select class="form-control" size="10" v-model="fk_horario" @change="listarHorariosSucursal()">
                                            <option value="0" disabled>Seleccione--</option>
                                            <option v-for="horarios in arrayHorarios" :key="horarios.id" :value="horarios.id" v-text="horarios.horaInicio + ' - ' + horarios.horaFin"></option>
                                            </select>     
                                        </div>
                                    </div>

                                    <h6>Selecciona tu automóvil:</h6>
                                    <select class="form-control" v-model="fk_auto">
                                        <option value="0" disabled>Seleccione--</option>
                                        <option v-for="auto in arrayAutomovil" :key="auto.id" v-bind:value="{ id: auto.id, marca: auto.marca, modelo: auto.modelo, foto: auto.fotografia, placa: auto.placa }" v-text="auto.marca+' '+auto.modelo"></option>
                                    </select>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </main>
</template>

<script>
    import VueBarcode from 'vue-barcode';
    import QrcodeVue from 'qrcode.vue';
    import Datepicker from 'vuejs-datepicker';
    import * as lang from "vuejs-datepicker/src/locale";
    export default {
        data (){
            return {
                idUsuario: this.$attrs.id,
                format: "yyyy-MM-dd",
                language: "es",
                languages: lang,
                fecha: new Date(new Date().getTime() + 24 * 60 * 60 * 1000), hora: '', comentario: '',
                fk_sucursal: 0, fk_auto: 0, fk_horario: 0,
                arraySucursales: [],
                arrayHorarios: [],
                arrayAutomovil : [],
                errorCita : 0,
                errorMostrarMsjCita : [],

                disabledDates: {
                    days: [0],
                    dates: [ // Disable an array of dates
                        // new Date('2020-08-15'.replace(/-/g, '\/')),
                        // new Date(2016, 9, 17),
                        // new Date(2016, 9, 18)
                    ],
                    ranges: [{ // Disable dates in given ranges (exclusive).
                        from: new Date(2016, 11, 25),
                        to: new Date()
                        }
                    ],
                },
            }
        },
        components: {
        'barcode': VueBarcode,
        Datepicker,
        QrcodeVue,
        },
        computed:{
        },
        methods : {
            selectSucursal(){
                let me=this;
                var url= '/sucursales';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arraySucursales = respuesta.sucursales;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            // onchangeServicio(id){
            //     alert("d"+this.id);
            //     console.log(this.id);
            //     let me=this;
            //     var url= '/horarios?fk_sucursal='+id;
            //     axios.get(url).then(function (response) {
            //         console.log(response);
            //         var respuesta= response.data;
            //         me.arrayHorarios = respuesta.horarios;
            //     })
            //     .catch(function (error) {
            //         console.log(error);
            //     });
            // },
            // mandaralert(){
            //     alert(this.fk_horario);
            // },
            listarHorariosSucursal() {
                //alert("d");
                //alert("auto"+ this.fk_auto);
                console.log(this.fk_sucursal);

                let me=this;
                var url= '/horarios?fecha='+me.fecha.toISOString().substring(0,10)+'&fk_sucursal='+me.fk_sucursal.id;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayHorarios = respuesta.horarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            listarAutomovil (){
                let me=this;
                var url= '/automovilesCliente?idUsuario=' + me.idUsuario;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayAutomovil = respuesta.autos.data;
                    console.log(me.arrayAutomovil);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarCita(){

                if (this.validarCita()){
                    return;
                }

                
                let me = this;
                console.log(new Date(this.fecha.toString().replace(/-/g, '\/')));

                axios.post('/cita/registrar',{
                    'comentario': this.comentario,
                    'fecha': this.fecha,
                    //'hora': this.fk_horario,
                    'fk_auto': this.fk_auto.id,
                    'fk_usuario': this.idUsuario,
                    'fk_sucursal': this.fk_sucursal.id,
                    'fk_horario': this.fk_horario
                   
                }).then(function (response) {
                    // Swal.fire('¡Tu cita ha sido agendada!', 'Espera tu confirmación de reservación', 'success');
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: '¡La cita ha sido agendada!',
                        html: '**Consulta el horario de tu cita, cuentas con 15 min. de toleracia a partir de la hora de inicio (Considera el tiempo que tomará diagnóstico)',
                        showConfirmButton: true,
                        confirmButtonColor: '#e9cb36;',
                        confirmButtonText: 'De acuerdo',
                        // timer: 5000
                    }).then((result) => {
                        if (result.value) {
                                   location.reload();
                        }  
                    });
                }).catch(function (error) {
                    Swal.fire('Algo ha salido mal', 'Vuelve a intentar', 'error');
                    console.log(error);
                });
            },
            validarCita(){
                this.errorCita=0;
                this.errorMostrarMsjCita =[];

                //if (!this.comentario) this.errorMostrarMsjCita.push("Debes agregar un comentario");
                if (!this.fecha) this.errorMostrarMsjCita.push("Debes seleccionar una fecha válida");
                if (!this.fk_horario) this.errorMostrarMsjCita.push("Debes seleccionar una hora");
                if (!this.fk_sucursal) this.errorMostrarMsjCita.push("Debes seleccionar una sucursal");
                if (!this.fk_auto.id) this.errorMostrarMsjCita.push("Debes seleccionar un auto");

                if (this.errorMostrarMsjCita.length) this.errorCita = 1;

                return this.errorCita;
            },
        },
        mounted() {
            this.selectSucursal(); this.listarAutomovil();
        }
    }
</script>
<style>    
</style>