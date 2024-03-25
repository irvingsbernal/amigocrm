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
                        <i class="fa fa-align-justify"></i> Inventario
                       
                        <button type="button" @click="generarPDF()" class="btn btn-info">
                            <i class="icon-doc"></i>&nbsp; Imprimir
                        </button>
                
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listaProducto(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listaProducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm table-responsive">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Categoría</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Precio Venta</th>
                                    <th>Cantidad</th>
                                    <th>Presentación</th>
                                    <th>Venta por Piezas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in arrayInventario" :key="producto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="producto.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarProducto(producto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarProducto(producto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    
                                    <td v-text="producto.codigoBarras"></td>
                                    <td v-text="producto.nombre_categoria"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.marca"></td>
                                    <td v-text="producto.precioVenta"></td>
                                    <td v-if="producto.ventaXpartes">Disponible {{producto.cantidad }} {{producto.unidad}} </td>
                                    <td v-else>Disponible {{Math.round(producto.cantidad/producto.presentacion)}} pzas. </td>
                                    <td v-text="producto.presentacion+producto.unidad"></td>
                                    <!-- <td v-text="producto.ventaXpartes"></td> -->
                                    <td>
                                        <div v-if="producto.ventaXpartes">
                                            <span class="badge badge-success">SI</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">NO</span>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div v-if="producto.estatus">
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
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none; overflow-y:auto;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Categoría</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="FkidCategoria">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigoBarras" class="form-control" placeholder="Código de barras"> 
                                        <barcode :value="codigoBarras" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode>                                       
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de artículo">                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Marca</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="marca" class="form-control" placeholder="Marca de artículo">                                        
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="descripcion" class="form-control" placeholder="Ingrese descripción">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Precio Venta</label>
                                    <div class="col-md-4">
                                        <input type="number" v-model="precioVenta" class="form-control" placeholder="">                                        
                                    </div>
                                    <label class="col-md-2 form-control-label" for="text-input">Precio Compra</label>
                                    <div class="col-md-3">
                                        <input type="number" v-model="precioCompra" class="form-control" placeholder="">                                        
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Presentación</label>
                                    <div class="col-md-2">
                                        <input type="number" v-model="presentacion" class="form-control" placeholder="">                                        
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control" v-model="unidad">
                                            <option value="0" disabled>Seleccione</option>
                                            <option value="LITROS" >LITROS</option>
                                            <option value="KILOGRAMOS" >KG</option>
                                            <option value="SET" >SET </option>
                                        </select>                                        
                                    </div>
                                    <label class="col-md-2 form-control-label" for="text-input">Venta por Partes</label>
                                    <div class="col-md-3">
                                    <input type="checkbox" id="toggle1" v-model="ventaXpartes" class="offscreen"><label for="toggle1" class="switch2"></label>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    
                                </div>
                                    

                                
                                <div v-show="errorProducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjProducto" :key="error" v-text="error">
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarProducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarProducto()">Actualizar</button>
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
                Producto_id: 0,
                FkidCategoria : 0,
                nombre_categoria : '',
                codigoBarras : '',
                nombre : '',
                marca : '',
                descripcion : '',
                precioCompra : 0,
                precioVenta : 0,
                presentacion : 0, 
                unidad : 0,
                ventaXpartes : 0,
                arrayInventario : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProducto : 0,
                errorMostrarMsjProducto : [],
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
                buscar : '',
                arrayCategoria :[]
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
            generarPDF(){
                window.open('http://127.0.0.1:8000/inventario/generarPDF', '_blank');
            },
            listaProducto (page,buscar,criterio){
                console.log(criterio);
                console.log(buscar);
                let me=this;
                var url= '/inventario?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                     console.log(respuesta.inventarios.data);
                    me.arrayInventario = respuesta.inventarios.data;
                    me.pagination= respuesta.pagination;

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
                me.listaProducto(page,buscar,criterio);
            },
            registrarProducto(){
                if (this.validarProducto()){
                    return;
                }
                
                let me = this;
                    console.log(this.FkidCategoria);
                    console.log(this.unidad);
                    console.log(this.ventaXpartes);
                axios.post('/producto/registrar',{
                    
                    'FkidCategoria': this.FkidCategoria,
                    'nombre': this.nombre,
                    'marca': this.marca,
                    'modelo': "tools",
                    'codigoBarras': this.codigoBarras,
                    'descripcion': this.descripcion,
                    'precioCompra': this.precioCompra,
                    'precioVenta': this.precioVenta,
                    'presentacion': this.presentacion,
                    'unidad': this.unidad

                }).then(function (response) {
                    me.cerrarModal();
                    me.listaProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarProducto(){
               if (this.validarProducto()){
                    return;
                }
                
                let me = this;

                axios.put('/producto/update',{
                    'FkidCategoria': this.FkidCategoria,
                    'nombre': this.nombre,
                    'marca': this.marca,
                    'modelo': "tools",
                    'codigoBarras': this.codigoBarras,
                    'descripcion': this.descripcion,
                    'precioCompra': this.precioCompra,
                    'precioVenta': this.precioVenta,
                    'presentacion': this.presentacion,
                    'unidad': this.unidad,

                    'id': this.Producto_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listaProducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },

            desactivarProducto(id){
               swal({
                title: 'Esta seguro de desactivar este producto?',
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

                    axios.put('/producto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listaProducto(1,'','nombre');
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
            activarProducto(id){
               swal({
                title: 'Esta seguro de activar este artículo?',
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

                    axios.put('/producto/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listaProducto(1,'','nombre');
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
            validarProducto(){
                this.errorProducto=0;
                this.errorMostrarMsjProducto =[];

                if (this.FkidCategoria==0) this.errorMostrarMsjProducto.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjProducto.push("El nombre del artículo no puede estar vacío.");
                //if (!this.stock) this.errorMostrarMsjProducto.push("El stock del artículo debe ser un número y no puede estar vacío.");
                if (!this.precioVenta) this.errorMostrarMsjProducto.push("El precio venta del artículo debe ser un número y no puede estar vacío.");

                if (this.errorMostrarMsjProducto.length) this.errorProducto = 1;

                return this.errorProducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.FkidCategoria= 0;
                this.nombre_categoria = '';
                this.codigoBarras = '';
                this.nombre = '';
                this.precioVenta = 0;
                this.stock = 0;
                this.descripcion = '';
		        this.errorProducto=0;
            },
            abrirModal(modelo, accion, data = []){
                    switch(modelo){
                    case "producto":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Producto';
                                this.tipoAccion = 1;
                                
                                this.FkidCategoria=0;
                                this.nombre_categoria='';
                                this.codigoBarras='';
                                this.nombre= '';
                                this.marca = '';
                                this.descripcion='';
                                this.precioCompra= 0;
                                this.precioVenta = 0;
                                this.presentacion = 0; 
                                this.unidad = 0;
                                
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Producto';
                                this.tipoAccion=2;

                                this.Producto_id=data['id'];
                                this.FkidCategoria=data['FkidCategoria'];
                                this.codigoBarras=data['codigoBarras'];
                                this.nombre = data['nombre'];
                                this.marca = data['marca'];
                                this.descripcion= data['descripcion'];
                                this.precioVenta=data['precioVenta'];
                                this.precioCompra=data['precioCompra'];
                                this.presentacion=data['presentacion'];
                                this.unidad=data['unidad'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            }
        },
        mounted() {
            this.listaProducto(1,this.buscar,this.criterio);
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
