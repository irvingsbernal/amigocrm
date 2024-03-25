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
                        <i class="fa fa-align-justify"></i> Reporte General de Ingresos
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6 form-group">
                                <label>Año:</label>
                                    <select class="form-control" v-model="anio" @change="listarIngresos()">
                                        <option v-for="anio in arrayAnios" :key="anio.anio" :value="anio.anio" v-text="anio.anio"></option>
                                    </select> 
                            </div>
                            <div class="col-md-6" >
                                <div class="form-group text-center">
                                    <h4>Total Ingresos: </h4>
                                    <h3 v-text="'$'+totalAnio+' MXN'"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-responsive table-sm">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Mes</th>
                                        <th>Cantidad de Ingresos</th>
                                        <th>Total Ingresos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ingreso in arrayMeses" :key="ingreso.mes">
                                        <td>
                                            <button type="button" @click="verIngresos(anio,ingreso.mes,ingreso.monto)" class="btn btn-success btn-sm">
                                            <i class="icon-eye"></i>
                                            </button>
                                        </td>
                                        <td v-if="ingreso.mes=='01'">Enero</td>
                                        <td v-if="ingreso.mes=='02'">Febrero</td>
                                        <td v-if="ingreso.mes=='03'">Marzo</td>
                                        <td v-if="ingreso.mes=='04'">Abril</td>
                                        <td v-if="ingreso.mes=='05'">Mayo</td>
                                        <td v-if="ingreso.mes=='06'">Junio</td>
                                        <td v-if="ingreso.mes=='07'">Julio</td>
                                        <td v-if="ingreso.mes=='08'">Agosto</td>
                                        <td v-if="ingreso.mes=='09'">Septiembre</td>
                                        <td v-if="ingreso.mes=='10'">Octubre</td>
                                        <td v-if="ingreso.mes=='11'">Noviembre</td>
                                        <td v-if="ingreso.mes=='12'">Diciembre</td>
                                        <td v-text="ingreso.total"></td>
                                        <td v-text="ingreso.monto"></td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12" >
                                <div class="form-group text-center">
                                    <h4 v-text="'Total Ingresos('+mes+','+anio+') $'"></h4>
                                    <h3 v-text="totalMes+' MXN'"></h3>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <table class="table table-bordered table-striped table-responsive table-sm">
                                <thead>
                                    <tr>
                                        <th>Cantidad</th>
                                        <th>Tipo Ingreso</th>
                                        <th>Total ($)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ingreso in arrayIngresos" :key="ingreso.tipo">
                                        <td v-text="ingreso.total"></td>
                                        <td v-text="ingreso.tipo"></td>
                                        <td v-text="ingreso.monto"></td>
                                    </tr>                                
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                anio : '2020',
                mes: 0,
                totalMes: 0,
                totalAnio: 0,
                arrayMeses : [],
                arrayIngresos: [],
                arrayAnios : [],
                listado:1,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
            }
        },
        components: {
            vSelect
        },
        computed:{
            
        },
        methods : {
            listarIngresos(){
                let me=this;
                var url= '/finanzas/mesesIngresos?anio=' + me.anio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayMeses = respuesta.meses;

                    var aux=0;
                    while(aux < me.arrayMeses.length){
                        me.totalAnio = me.totalAnio + parseFloat(me.arrayMeses[aux].monto);
                        aux++;
                    }

                    console.log(me.arrayMeses);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            seleccionarAnios(){
                let me=this;
                var url= '/finanzas/seleccionarAnios';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAnios = respuesta.anios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            verIngresos(a,m,tot){
                let me=this;
                var url= '/finanzas/ingresosMes?anio=' + a + '&mes='+ m;
                me.totalMes = tot;
                axios.get(url).then(function (response) {
                    switch(m){
                            case '01':{me.mes = 'Enero';break;}
                            case '02':{me.mes = 'Febrero';break;}
                            case '03':{me.mes = 'Marzo';break;}
                            case '04':{me.mes = 'Abril';break;}
                            case '05':{me.mes = 'Mayo';break;}
                            case '06':{me.mes = 'Junio';break;}
                            case '07':{me.mes = 'Julio';break;}
                            case '08':{me.mes = 'Agosto';break;}
                            case '09':{me.mes = 'Septiembre';break;}
                            case '10':{me.mes = 'Octubre';break;}
                            case '11':{me.mes = 'Noviembre';break;}
                            case '12':{me.mes = 'Diciembre';break;}
                            
                        }

                    var respuesta= response.data;
                    me.arrayIngresos = respuesta.ingresos;
                    console.log(me.arrayIngresos);
                    me.listado=2;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            ocultarDetalle(){
                this.listado=1;
            },
        },
        mounted() {
            this.listarIngresos();
            this.seleccionarAnios();
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
        overflow-y:auto;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
    @media (min-width: 600px) {
        .btnagregar {
            margin-top: 2rem;
        }
    }

</style>
