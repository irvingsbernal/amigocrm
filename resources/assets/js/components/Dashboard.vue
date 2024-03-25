<template>
<main class="main">
    <!-- Breadcrumb -->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>

    <div class="container">
            <div class="row">
                        <div class="col-md-12">
                                                 
                                <h4>¡Bienvenido a AMI.GO! Citas próximas por atender:</h4>
                          
                                    <citadash></citadash>
        
               </div>         
           </div>
    </div>

    <!-- <div class="container">
            <div class="row">
                        <div class="col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>¡Bienvenido a AMI.GO! Citas próximas por atender:</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <citadash></citadash>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>textto </p>
                            </div>
                        </div>
                    </div>           
           </div>
    </div> -->

<div class="container">
    <div class="row">
        <div class="container">
            <div class="row">
                        <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Recibos de mercancía: </h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="ingresos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Gastos de los últimos meses</p>
                            </div>
                        </div>
                    </div>

                
                        <div class="col-md-6">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Retorno a proveedor: </h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <canvas id="retornos">                                                
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Devolución de mercancía</p>
                            </div>
                        </div>
                    </div>

                                      
           </div>
        </div>

        <div class="container">
            <div class="row">
                        <div class="col-md-12">
                        <div class="card card-chart">
                            <div class="card-header">
                                <h4>Plan de ventas VS Gastos y egresos 2020</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <reporte></reporte>
                                </div>
                            </div>
                            <div class="card-footer">
                                <p>Estadística de ingresos y gastos 2020</p>
                            </div>
                        </div>
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
                varIngreso:null,
                charIngreso:null,
                ingresos:[],
                varTotalIngreso:[],
                varMesIngreso:[], 
                
                varRetorno:null,
                charRetorno:null,
                retornos:[],
                varTotalRetorno:[],
                varMesRetorno:[], 

            }
        },
        methods : {
            getIngresos(){
                let me=this;
                var url= '/dashboard2';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.ingresos = respuesta.ingresos;
                    //cargamos los datos del chart
                    me.loadIngresos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            getRetornos(){
                let me=this;
                console.log('entra')
                var url= '/dashboard2';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    console.log(response.data);
                    me.retornos = respuesta.retornos;
                    //cargamos los datos del chart
                    me.loadRetornos();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            loadRetornos(){
                let me=this;
                 let meses = ["Enero", "Febrero", "Marzo", "Abril",
                              "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                              "Octubre", "Noviembre", "Diciembre"]; 
                me.retornos.map(function(x){
                    me.varMesRetorno.push(meses[x.mes-1]);
                    me.varTotalRetorno.push(x.total);
                });

                me.varRetorno=document.getElementById('retornos').getContext('2d');

                me.charRetorno = new Chart(me.varRetorno, {
                    type: 'bar',
                    data: {
                        labels: me.varMesRetorno,
                        datasets: [{
                            label: 'Retorno a proveedor',
                            data: me.varTotalRetorno,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
            },  

            loadIngresos(){
                let me=this;
                 let meses = ["Enero", "Febrero", "Marzo", "Abril",
                              "Mayo", "Junio", "Julio", "Agosto", "Septiembre", 
                              "Octubre", "Noviembre", "Diciembre"]; 
                me.ingresos.map(function(x){
                    me.varMesIngreso.push(meses[x.mes-1]);
                    me.varTotalIngreso.push(x.total);
                });
                me.varIngreso=document.getElementById('ingresos').getContext('2d');

                me.charIngreso = new Chart(me.varIngreso, {
                    type: 'bar',
                    data: {
                        labels: me.varMesIngreso,
                        datasets: [{
                            label: 'Embarques',
                            data: me.varTotalIngreso,
                            backgroundColor: 'rgba(244, 204, 42, 0.5)',
                            borderColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero:true
                                }
                            }]
                        }
                    }
                });
        },
        },
        mounted() {
            this.getIngresos();
            this.getRetornos();
            
        }
    }
</script>
