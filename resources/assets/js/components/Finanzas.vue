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
                        <i class="fa fa-align-justify"></i> Finanzas
                        <button type="button" @click="abrirModal('finanzas','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                            
                        </button>
                        <button type="button" @click="abrirModal('finanzas','reporte')" class="btn btn-success">
                            <i class="icon-chart"></i>&nbsp;Reporte Ingresos - Gastos
                        </button>
                    </div>
                    <!-- Listado-->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-4" v-model="criterio">
                                      <option value="tipo">Tipo</option>
                                      <option value="fecha">Fecha</option>
                                      <option value="concepto">Concepto</option>
                                      <option value="documento">Tipo de Documento</option>
                                      <option value="documento">No. Documento</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarfinanzas(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarfinanzas(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Registro</th>
                                    <th>Tipo</th>
                                    <th>Concepto</th>
                                    <th>Documento</th>
                                    <th>Folio de Documento</th>
                                    <th>Fecha</th>
                                    <th>Monto</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="finanzas in arrayfinanzas" :key="finanzas.id">
                                    <td>
                                        <button type="button" @click="abrirModal('finanzas','actualizar',finanzas)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button>
                                        <template v-if="finanzas.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarfinanzas(finanzas.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarfinanzas(finanzas.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="finanzas.registro"></td>
                                    <td v-text="finanzas.tipo"></td>
                                    <td v-text="finanzas.concepto"></td>
                                    <td v-text="finanzas.documento"></td>
                                    <td v-text="finanzas.serieDocumento"></td>
                                    <td v-text="finanzas.fecha"></td>
                                    <td v-text="finanzas.monto"></td>
                                    <td>
                                        <div v-if="finanzas.estatus">
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
                    </template>
                    <!--Fin Listado-->
                    <!-- Detalle-->
                    <template v-else-if="listado==2">
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                        <label class="form-control-label mr-4">Registro(*):</label>
                                        <div class="form-group">
                                            <label class="mr-3" for="">Ingreso</label> 
                                            <input type="radio" v-model="registro" value="Ingreso" class="form-control-label mr-5">
                                            <label class="mr-3" for="">Gasto</label> 
                                            <input type="radio" v-model="registro" value="Gasto" class="form-control-label mr-5">
                                        </div>
                                    </div>
                            <div class="col-md-6">
                                <label class="form-control-label">Tipo: </label>
                                <select class="form-control" v-model="tipo">
                                                <option value="0">Seleccione--</option>
                                                <option v-if="registro=='Ingreso'" value="Venta de Servicios">Venta de Servicios</option>
                                                <option v-if="registro=='Ingreso'" value="Otros ingresos">Otros ingresos</option>
                                                <option v-if="registro=='Gasto'" value="Agua">Agua</option>
                                                <option v-if="registro=='Gasto'" value="Energía Eléctrica">Energía Eléctrica</option>
                                                <option v-if="registro=='Gasto'" value="Insumos">Insumos</option>
                                                <option v-if="registro=='Gasto'" value="Mantenimiento">Mantenimiento</option>
                                                <option v-if="registro=='Gasto'" value="Capacitación">Capacitación</option>
                                                <option v-if="registro=='Gasto'" value="Papelería">Papelería</option>
                                                <option v-if="registro=='Gasto'" value="Viaticos">Viaticos</option>
                                                <option v-if="registro=='Gasto'" value="Servicios Internet">Servicios Internet</option>
                                                <option v-if="registro=='Gasto'" value="Otros gastos">Otros gastos</option>
                                            </select>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Concepto(*):</label>
                                    <input type="text" class="form-control" v-model="concepto" placeholder="">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Monto ($):</label>
                                <input type="number" class="form-control" v-model="monto" placeholder="XXX">
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Fecha:</label>
                                            <input type="date" class="form-control" v-model="fecha" placeholder="--/--/--">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label>Tipo de documento(*):</label>
                                 <select class="form-control" v-model="documento">
                                    <option value="0">Seleccione--</option>
                                    <option value="Manifiesto">Manifiesto</option>
                                    <option value="Factura">Factura</option>
                                    <option value="Ticket">Ticket</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Folio documento:</label>
                                    <input type="text" class="form-control" v-model="serieDocumento" placeholder="XXX">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>No. Documento(*):</label>
                                    <input type="text" class="form-control" v-model="noDocumento" placeholder="XXX">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div v-show="errorfinanzas" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjfinanzas" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <button type="button" class="btn btn-primary" @click="registrarfinanzas()">Guardar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!-- Fin Detalle-->
                    <template v-if="listado==3">
                    <div class="card-body">
                        <div class="form-group">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row col-md-12">
                                    <div class="col-md-6">
                                        <label>Año:</label>
                                        <select class="form-control" v-model="anio" @change="consultarReporte()">
                                            <option value="0" disabled>Seleccione un año...</option>
                                            <option v-for="anio in arrayAnios" :key="anio.anio" :value="anio.anio" v-text="anio.anio"></option>
                                        </select>                                        
                                    </div>
                                    <div class="col-md-6" >
                                        <div class="form-group text-center">
                                            <h4>Total Ingresos: $</h4>
                                            <h3 v-text="totalS+' MXN'"></h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <table class="table table-bordered table-responsive table-sm">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Enero</th>
                                                <th>Febrero</th>
                                                <th>Marzo</th>
                                                <th>Abril</th>
                                                <th>Mayo</th>
                                                <th>Junio</th>
                                                <th>Julio</th>
                                                <th>Agosto</th>
                                                <th>Septiembre</th>
                                                <th>Octubre</th>
                                                <th>Noviembre</th>
                                                <th>Diciembre</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            <tr>
                                                <td style="background:#E6FAC6;">Ingresos($):</td>
                                                <td style="background:#E6FAC6;" v-for="ingreso in 12" :key="ingreso">
                                                     <label v-text="arrayIngresos[ingreso-1]"></label>
                                                </td>
                                                <td style="background:#E6FAC6;" v-text="totalI"></td>
                                            </tr> 
                                            <tr>
                                                <td style="background:#FDA08F;">Gastos($):</td>
                                                <td style="background:#FDA08F;" v-for="gasto in 12" :key="gasto+12">
                                                     <label v-text="arrayGastos[gasto-1]"></label>
                                                </td>
                                                <td style="background:#FDA08F;" v-text="totalG"></td>
                                            </tr> 
                                            <tr>
                                                <td style="background:#FEE596;">Total($):</td>
                                                <td style="background:#FEE596;" v-for="saldo in 12" :key="saldo+24">
                                                     <label v-text="arraySaldos[saldo-1]"></label>
                                                </td>
                                                <td style="background:#FEE596;" v-text="totalS"></td>
                                            </tr>                                
                                        </tbody>
                                    </table>
                                </div>
                                <div v-if="anio!=0" class="form-group col-md-12">
                                    <reporte></reporte>
                                </div>
                                <div v-show="errorfinanzas" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjfinanzas" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!--Fin Listado-->
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
                listado: 1,
                id: 0,
                registro : '',
                tipo : '',
                concepto : '',
                fecha : '',
                monto : 0,
                documento : '',
                serieDocumento : '',
                anio : 0,
                noDocumento : '',
                arrayfinanzas : [],
                arrayAnios : [],
                arrayIngresos : [],
                arrayGastos : [],
                arraySaldos : [],
                totalI : 0,
                totalG : 0,
                totalS :0,
                errorfinanzas : 0,
                errorMostrarMsjfinanzas : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 5,
                criterio : 'tipo',
                buscar : ''
            }
        },
        components: {
            vSelect
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
            listarfinanzas (page,buscar,criterio){
                let me=this;
                var url= '/finanzas?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayfinanzas = respuesta.finanzas.data;
                    me.pagination= respuesta.pagination;
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
            consultarReporte(){
                let me=this;
                var url= '/finanzas/consultarReporte?anio=' + this.anio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    var m = 1;
                    var aux = 0;
                    var total = respuesta.reporte.ingresos.length;
                    while(m <= 12 && aux < total){
                            if ((respuesta.reporte.ingresos[aux].mes)==m){
                                me.arrayIngresos.push(respuesta.reporte.ingresos[aux].monto);
                                me.totalI = parseFloat(me.totalI)+parseFloat(respuesta.reporte.ingresos[aux].monto);
                                aux++;
                            }
                            else{
                                me.arrayIngresos.push(' ');
                            }
                            m++;
                            
                        }
                    
                    var m = 1;
                    var aux = 0;
                    var total = respuesta.reporte.gastos.length;
                    while(m <= 12 && aux < total){
                            if ((respuesta.reporte.gastos[aux].mes)==m){
                                me.arrayGastos.push(respuesta.reporte.gastos[aux].monto);
                                me.totalG = parseFloat(me.totalG)+parseFloat(respuesta.reporte.gastos[aux].monto);
                                aux++;
                            }
                            else{
                                me.arrayGastos.push(' ');
                            }
                            m++;
                        }
                    
                    var m = 1;
                    var aux = 0;
                    var total = respuesta.reporte.saldos.length;
                    while(m <= 12 && aux < total){
                            if ((respuesta.reporte.saldos[aux].mes)==m){
                                me.arraySaldos.push(respuesta.reporte.saldos[aux].monto);
                                me.totalS = parseFloat(me.totalS)+parseFloat(respuesta.reporte.saldos[aux].monto);
                                aux++;
                            }
                            else{
                                me.arraySaldos.push(' ');
                            }
                            m++;
                        }
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
                me.listarfinanzas(page,buscar,criterio);
            },
            registrarfinanzas(){
                if (this.validarfinanzas()){
                    return;
                }
                
                let me = this;

                axios.post('/finanzas/registrar',{
                    'registro': this.registro,
                    'tipo': this.tipo,
                    'concepto': this.concepto,
                    'fecha': this.fecha,
                    'monto': this.monto,
                    'documento': this.documento,
                    'serieDocumento': this.serieDocumento,
                    'noDocumento': this.noDocumento
                }).then(function (response) {
                    me.ocultarDetalle();
                    me.listarfinanzas(1,'','tipo');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarfinanzas(){
               if (this.validarfinanzas()){
                    return;
                }
                
                let me = this;

                axios.put('/finanzas/actualizar',{
                    'registro': this.registro,
                    'tipo': this.tipo,
                    'concepto': this.concepto,
                    'fecha': this.fecha,
                    'monto': this.monto,
                    'documento': this.documento,
                    'serieDocumento': this.serieDocumento,
                    'noDocumento': this.noDocumento,
                    'id': this.id
                }).then(function (response) {
                    me.ocultarDetalle();
                    me.listarfinanzas(1,'','tipo');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarfinanzas(id){
               swal({
                title: 'Esta seguro de desactivar este registro?',
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

                    axios.put('/finanzas/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarfinanzas(1,'','tipo');
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
            activarfinanzas(id){
               swal({
                title: 'Esta seguro de activar este registro?',
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

                    axios.put('/finanzas/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarfinanzas(1,'','tipo');
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
            validarfinanzas(){
                this.errorfinanzas=0;
                this.errorMostrarMsjfinanzas =[];

                if (!this.tipo) this.errorMostrarMsjfinanzas.push("El tipo de Ingreso/Gasto no puede estar vacío.");
                if (!this.fecha) this.errorMostrarMsjfinanzas.push("La fecha del registro no puede estar vacía.");
                if (!this.concepto) this.errorMostrarMsjfinanzas.push("El concepto del registro no puede estar vacío.");
                if (!this.monto) this.errorMostrarMsjfinanzas.push("El monto del registro no puede estar vacío.");
                if (!this.documento) this.errorMostrarMsjfinanzas.push("El tipo de documento no puede estar vacío.");
                if (!this.noDocumento) this.errorMostrarMsjfinanzas.push("El No. Documento no puede estar vacío.");
                
                if (this.errorMostrarMsjfinanzas.length) this.errorfinanzas = 1;

                return this.errorfinanzas;
            },
            ocultarDetalle(){
                this.listado=1;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "finanzas":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.tipo='';
                                this.registro='';
                                this.fecha='';
                                this.concepto='';
                                this.monto=0;
                                this.documento='';
                                this.serieDocumento='';
                                this.noDocumento='';
                                this.listado = 2;
                                break;
                            }
                            case 'actualizar':
                            {
                                console.log(data.concepto);
                                this.id=data['id'];
                                this.tipo=data['tipo'];
                                this.registro=data['registro'];
                                this.fecha=data['fecha'];
                                this.concepto=data['concepto'];
                                this.monto=data['monto'];
                                this.documento=data['documento'];
                                this.serieDocumento=data['serieDocumento'];
                                this.noDocumento=data['noDocumento'];
                                this.listado=2;
                                break;
                            }
                            case 'reporte':
                            {
                                //console.log(data);
                                this.totalS = 0;
                                this.totalI = 0;
                                this.totalG = 0;
                                this.arrayIngresos = [];
                                this.arrayGastos = [];
                                this.arraySaldos = [];
                                this.consultarReporte();
                                this.seleccionarAnios();
                                this.listado=3;
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarfinanzas(1,this.buscar,this.criterio);
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