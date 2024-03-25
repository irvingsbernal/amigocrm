<template>
  <canvas  ref="myChart" width="300" style="height:500px !important"></canvas>
</template>

<script>
import Chart from 'chart.js';
import numeral from 'numeral';

export default {
  name: 'reporte',
  data (){
            return {
                Ingresos : '',
                Gastos : '',
                arrayIngresos : [],
                arrayGastos : [],
                arraySaldos : [],
            }
        },
  methods: {
     consultarReporte(){
                let me=this;
                var url= '/finanzas/consultarReporte?anio=2020';
                axios.get(url).then(function (response) {
                  var respuesta= response.data;
                    var m = 1;
                    var aux = 0;
                    var total = respuesta.reporte.ingresos.length;
                    while(m <= 12 && aux < total){
                            console.log(respuesta.reporte.ingresos[aux].mes);
                            if ((respuesta.reporte.ingresos[aux].mes)==m){
                                me.arrayIngresos.push(parseFloat(respuesta.reporte.ingresos[aux].monto));
                                aux++;
                            }
                            else{
                                me.arrayIngresos.push(0);
                            }
                            m++;
                        }

                    var posicion = me.arrayIngresos.length;
                    while(posicion <12){
                      me.arrayIngresos.push(0);
                      posicion++;
                    }
                    console.log(me.arrayIngresos);
                    
                    var m = 1;
                    var aux = 0;
                    var total = respuesta.reporte.gastos.length;
                    while(m <= 12 && aux < total){
                            console.log(respuesta.reporte.gastos[aux].mes);
                            if ((respuesta.reporte.gastos[aux].mes)==m){
                                me.arrayGastos.push(parseFloat(respuesta.reporte.gastos[aux].monto));
                                aux++;
                            }
                            else{
                                me.arrayGastos.push(0);
                            }
                            m++;
                        }

                    var posicion = me.arrayGastos.length;
                    while(posicion <12){
                      me.arrayGastos.push(0);
                      posicion++;
                    }
                    console.log(me.arrayGastos);

                    me.crearGrafica();
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            crearGrafica(){
              new Chart(this.$refs.myChart, {
              type: 'line',
              data: {
                labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                datasets: [
                  {
                    label: 'Ingresos($)',
                    data: this.arrayIngresos,
                    backgroundColor: '#4caf5066',
                    borderColor: '#20B644'
                  },
                  {
                    label: 'Gastos($)',
                    data: this.arrayGastos,
                    backgroundColor: '#f5072891',
                    borderColor: '#EE533B'
                  }
                ]
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [{
                    ticks: {
                      beginAtZero: true,
                      lineTension: 0
                    }
                  }]
                },
                tooltips: {
                  callbacks: {
                    label(tooltipItem, data) {
                      // Get the dataset label.
                      const label = data.datasets[tooltipItem.datasetIndex].label;

                      // Format the y-axis value.
                      const value = numeral(tooltipItem.yLabel).format('$0,0');

                      return `${label}: ${value}`;
                    }
                  }
                }
              }
            });
            }   
  },
  components: {
            Chart,
            numeral
        },
  mounted() {
    this.consultarReporte();
    
  }
}
</script>
