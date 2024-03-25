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
                    <i class="fa fa-align-justify"></i> Cotización
                </div>
                <div v-if="this.subServiciosItems.length>0" class="col-md-12 col-lg-12" style="padding-top: 15px">
                    <button type="button" @click="abrirModal('Producto')" class="btn btn-secondary col-md-2 col-lg-2 fa-pull-right">
                        <i class="icon-plus"></i>&nbsp;Productos
                    </button>
                </div>

                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-9 col-lg-9 card-body" style="box-shadow: 2px 2px 5px #999;">
                            <table v-if="this.subServiciosItems.length>0" class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Nombre</th>
                                        <th>Costo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(Subservicio,index) in subServiciosItems" :key="Subservicio.id">
                                        <td>
                                            <button @click="eliminarServicio(index)" type="button" class="btn btn-danger btn-sm">
                                                <i class="icon-close"></i>
                                            </button>
                                        </td>
                                        <td v-text="Subservicio.message"></td>
                                        <td v-text="'$'+Subservicio.costo"></td>
                                    </tr>                                 
                                </tbody>
                            </table>       
                            <div v-else class="card-body">
                                <h4>Agrege servicios</h4>  
                            </div>    
                        </div>

                        <div class="col-md-3 col-lg-3 card-body" style="box-shadow: 2px 2px 5px #999;">
                            <table v-if="this.subServiciosItems.length>0 || this.productosItems.length>0" class="table table-hover">
                                <tbody>
                                     <tr>
                                        <td>Cantidad Servicios:</td>
                                        <td v-text="this.catidadServicios"></td>
                                    </tr> 
                                     <tr>
                                        <td>Cantidad Productos:</td>
                                        <td v-text="this.cantidadProductos"></td>
                                    </tr> 
                                    <tr>
                                        <td>Total:</td>
                                        <td v-text="'$'+this.mostrarTotal"></td>
                                    </tr>                                 
                                </tbody>
                            </table>  
                            <div class="input-group">
                                <button type="button" @click="abrirModal('Subservicio')" class="btn btn-secondary">
                                    <i class="icon-plus"></i>&nbsp;Agregar Servicio
                                </button>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
<!-- Fin ejemplo de tabla Listado -->

<!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalSubservicio}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal('Subservicio')" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">Servicio</label>
                                <div class="col-md-9">
                                    <select class="form-control" v-model="Subservicio_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="servicio in arraySubServicio" :key="servicio.id" :value="servicio.id" v-text="servicio.nombre"></option>
                                    </select>                        
                                </div>
                            </div>
                            <div v-show="errorSubservicio" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjSubservicio" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal('Subservicio')">Cerrar</button>
                        <button type="button" class="btn btn-primary" @click="agregarSubServicios()">Guardar</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
<!--Fin del modal-->

<!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modalProducto}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal('Producto')" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-12 col-lg-12 form-control-label" for="text-input">Productos</label>
                                <div class="col-md-9 col-lg-9">
                                    <select class="form-control" v-model="Producto_id">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="servicio in arrayProducto" :key="servicio.id" :value="servicio.id" v-text="servicio.nombre+' - '+servicio.presentacionInterfaz+' '+servicio.unidad"></option>
                                    </select>
                                </div> 
                                <div class="col-md-3 col-lg-3">
                                    <input type="number" step="any" min="1" max="150" v-model="cantidadProducto" class="form-control" placeholder="Ingrese la cantidad">
                                </div>  
                                <div class="col-md-12 col-lg-12">                        
                                    <button type="button" @click="agregarProductos()" class="btn btn-secondary col-md-2 col-lg-2 fa-pull-right">
                                        <i class="icon-plus"></i>
                                    </button> 
                                </div>  
                            </div>
                            
                            <table v-if="this.productosItems.length>0" class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th>Acciones</th>
                                        <th>Nombre</th>
                                        <th>Presentación</th>
                                        <th>Costo Unitario</th>
                                        <th>Cantidad</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(Subservicio,index2) in productosItems" :key="Subservicio.id">
                                        <td>
                                            <button @click="eliminarProducto(index2)" type="button" class="btn btn-danger btn-sm">
                                                <i class="icon-close"></i>
                                            </button>
                                        </td>
                                        <td v-text="Subservicio.message"></td>
                                        <td v-text="Subservicio.presentacion+' '+Subservicio.uni"></td>
                                        <td v-text="'$'+Subservicio.costo"></td>
                                        <td v-text="Subservicio.cantidad"></td>
                                        <td v-text="'$'+Subservicio.total"></td>
                                    </tr>                                 
                                </tbody>
                            </table>    


                            <div v-show="errorSubservicio" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjSubservicio" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="cerrarModal('Producto')">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="agregar()">Guardar</button>
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
    import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                subServiciosItems: [],
                productosItems : [],
                arraySubServicio :[],
                arrayProducto :[],

                productoRepetido : [],
                servicioRepetido : [],

                Subservicio_id: 0,
                fk_servicio : 0,
                nombre_servicio : '',
                nombre : '',
                costoServicio : 0,
                Producto_id: 0,
                nombre_producto : '',
                costoProducto : 0,
                presentacionPro : '',
                unidadPro : 0,
                cantidadProducto : 0,

                catidadServicios : 0,
                cantidadProductos: 0,
                totalProducto : 0,
                totalServicios : 0,
                totalFinal : 0,
                total : 0.00,
                catidadTotal : 0,
                mostrarTotal: 0,

                modalSubservicio : 0,
                modalProducto : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorSubservicio : 0,
                errorMostrarMsjSubservicio : [],
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
        components: {
        'barcode': VueBarcode
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
            abrirModal(modelo){
                switch(modelo){
                    case "Subservicio":
                    {
                        this.modalSubservicio = 1;
                        this.tituloModal = 'Agregar Servicios';
                        this.Subservicio_id=0;

                        this.selectSubServicio();
                        break;
                    }
                    case "Producto":
                    {
                        this.modalProducto = 1;
                        this.tituloModal = 'Agregar Productos';
                        this.cantidadProducto = 0;
                        this.Producto_id = 0;
                        this.selectProducto();
                        break;
                    }
                }
            },
            cerrarModal(modelo){
                switch(modelo){
                    case "Subservicio":
                    {
                        this.modalSubservicio=0;
                        this.tituloModal='';
                        this.Subservicio_id= 0;
                        this.errorSubservicio=0;
                    }
                    case "Producto":
                    {
                        this.modalProducto=0;
                        this.tituloModal='';
                        this.Subservicio_id= 0;
                        this.errorSubservicio=0;
                    }
                }
            },
            selectSubServicio(){
                let me=this;
                var url= '/cotizacion/selectSubServicioCoti';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySubServicio = respuesta.subServicios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProducto(){
                let me=this;
                var url= '/cotizacion/selectProductoCoti';
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProducto = respuesta.productos;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            agregarSubServicios(){
                if (this.validarSubservicio()){
                    return;
                }
                let me=this;
                var element = this.Subservicio_id;
                var idx = me.servicioRepetido.indexOf(element);
                if(idx<0){
                var url= '/cotizacion/anadirServicioCoti';
                axios.post(url,{
                    'id': this.Subservicio_id
                }).then(function (response) {
                    var respuesta= response.data;
                    me.fk_servicio = respuesta.subServicios.id;
                    me.nombre_servicio = respuesta.subServicios.nombre;
                    me.costoServicio = respuesta.subServicios.costoServicio;
                    me.servicioRepetido.push(me.fk_servicio);


                    var PrecioServicio = (me.costoServicio)*1;
                    var servicios = (me.totalServicios)*1;
                    var productos = (me.totalFinal)*1;
                    var valorfinal = (me.total)*1;

                    me.totalServicios = (servicios + PrecioServicio)*1;
                    me.total =  (me.totalServicios + productos)*1;
                    let val = (me.total/1).toFixed(2).replace('.', '.');
                    me.mostrarTotal = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                    me.subServiciosItems.push({id:me.fk_servicio,message: me.nombre_servicio, costo:me.costoServicio});
                
                    me.catidadServicios = me.subServiciosItems.length;
                    //me.cantidadProductos = me.catidadTotal;
                    me.Subservicio_id = 0;
                })
                .catch(function (error) {
                    console.log(error);
                });
                this.cerrarModal('Subservicio');
            }else{
                swal(
                        'Cuidado!',
                        'El servicio ya fue agregado',
                        'warning'
                        )
            }
            },
            agregarProductos(){
                if (this.validarProducto()){
                    return;
                }
                let me=this;
                var element = this.Producto_id;
                var idx = me.productoRepetido.indexOf(element);
                if(idx<0){
                    var url= '/cotizacion/anadirProductoCoti';
                    axios.post(url,{
                        'id': this.Producto_id
                    }).then(function (response) {

                        var respuesta= response.data;
                        me.Producto_id = respuesta.productos.id;
                        me.nombre_producto = respuesta.productos.nombre;
                        me.costoProducto = respuesta.productos.precioVenta;
                        me.presentacionPro = respuesta.productos.presentacionInterfaz;
                        me.unidadPro = respuesta.productos.unidad;
                        me.productoRepetido.push(me.Producto_id);

                        me.totalProducto = me.costoProducto * me.cantidadProducto;
                        var uno = me.presentacionPro * me.cantidadProducto;
                        me.totalFinal = me.totalFinal + me.totalProducto;
                        me.total =  (me.totalServicios + me.totalFinal)*1.00;
                        let val1 = (me.costoProducto/1).toFixed(2).replace('.', '.');
                        var tres = val1.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                        let val2 = (me.totalProducto/1).toFixed(2).replace('.', '.');
                        var dos = val2.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                        me.productosItems.push({id:me.Producto_id, message: me.nombre_producto, costo: tres, cantidad: me.cantidadProducto, total: dos, presentacion: uno, uni:me.unidadPro});
                        me.catidadServicios = me.subServiciosItems.length; 
                        me.catidadTotal = me.catidadTotal + (me.cantidadProducto)*1
                        me.cantidadProductos = me.catidadTotal;

                        let val = (me.total/1).toFixed(2).replace('.', '.');
                        me.mostrarTotal = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");

                        me.cantidadProducto = 0;
                        me.Producto_id = 0;
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }else{
                    swal(
                        'Cuidado!',
                        'El producto ya fue agregado',
                        'warning'
                        )
                }
            },
            eliminarServicio(index){
                let me = this;
                var servis = me.subServiciosItems[index];
                var servi = (servis.costo)*1
                me.total = me.total - servi;
                me.totalServicios = me.totalServicios - servi;
                me.catidadServicios = me.catidadServicios - 1; 

                let val = (me.total/1).toFixed(2).replace('.', '.');
                me.mostrarTotal = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
                me.subServiciosItems.splice(index, 1);

                if(me.servicioRepetido.length==1){

                    me.productoRepetido = [];
                    me.productosItems = [];
                    me.total = 0;
                    me.totalFinal = 0;
                    me.cantidadProductos = 0;
                    me.catidadTotal = 0;
                }  

                var element = servis.id;
                var idx = me.servicioRepetido.indexOf(element);
                me.servicioRepetido.splice(idx, 1);
                me.Subservicio_id = 0;
            },
            eliminarProducto(index){
                let me = this;
                var produc = me.productosItems[index];
                var pro = (produc.total)*1
                me.totalFinal = me.totalFinal - pro;
                me.total =  (me.totalServicios + me.totalFinal)*1;
                me.cantidadProductos = me.cantidadProductos - produc.cantidad;
                me.catidadTotal = me.catidadTotal - produc.cantidad;

                me.productosItems.splice(index, 1);


                var element = produc.id;
                var idx = me.productoRepetido.indexOf(element);
                me.productoRepetido.splice(idx, 1);
                me.cantidadProducto = 0;
                me.Producto_id = 0;

                let val = (me.total/1).toFixed(2).replace('.', '.');
                me.mostrarTotal = val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            },
            validarSubservicio(){
                this.errorSubservicio=0;
                this.errorMostrarMsjSubservicio =[];

                if (this.Subservicio_id==0) this.errorMostrarMsjSubservicio.push("Seleccione una servicio.");
                if (this.errorMostrarMsjSubservicio.length) this.errorSubservicio = 1;

                return this.errorSubservicio;
            },
            validarProducto(){
                this.errorSubservicio=0;
                this.errorMostrarMsjSubservicio =[];

                if (this.Producto_id==0) this.errorMostrarMsjSubservicio.push("Seleccione una servicio.");
                if (!this.cantidadProducto) this.errorMostrarMsjSubservicio.push("La cantidad no puede estar vacía.");
                if (this.errorMostrarMsjSubservicio.length) this.errorSubservicio = 1;

                return this.errorSubservicio;
            }
            /*onchange (){
                console.log("Daniel");
                let me=this;
                var url= '/cotizacion/verSubServicio';
                axios.post(url,{
                    'fk_servicio': this.fk_servicio
                }).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    console.log(response.data);
                    console.log(response.data.subservicios);
                    console.log(response.data.subservicios.data);
                    console.log(respuesta.subServicios.data);
                    me.productos = respuesta.subServicios.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            }*/
        },
        mounted() {
            //this.listaSubservicio(1,this.buscar,this.criterio);
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
