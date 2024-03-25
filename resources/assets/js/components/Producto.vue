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
                        <i class="fa fa-align-justify"></i> Productos/Refacciones
                        <button type="button" @click="abrirModal('producto','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarproducto(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarproducto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Código</th>
                                    <th>Nombre</th>
                                    <th>Categoría</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Presentación</th>
                                    <th>Código de Barras</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Venta suministrada</th>
                                    <th>Descripción</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="producto in arrayproducto" :key="producto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('producto','actualizar',producto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="producto.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarproducto(producto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-success btn-sm" @click="activarproducto(producto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="producto.id"></td>
                                    <td v-text="producto.nombre"></td>
                                    <td v-text="producto.nombre_categoria"></td>
                                    <td v-text="producto.marca"></td>
                                    <td v-text="producto.modelo"></td>
                                    <td v-text="producto.presentacion + ' ' + producto.unidad"></td>
                                    <td v-text="producto.codigoBarras"></td>
                                    <td v-text="producto.precioCompra"></td>
                                    <td v-text="producto.precioVenta"></td>
                                    <td>
                                        <div v-if="producto.ventaXpartes">
                                            <span class="badge badge-success">SI</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">NO</span>
                                        </div>
                                       </td>
                                    <td v-text="producto.descripcion"></td>
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
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-text="tituloModal"></h5>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                    <label class="col-md-2 form-control-label" for="text-input">Producto:</label>
                                        <div class="col-md-5">
                                            <img :src="imagen" class="image mb-1" alt="Imagen" width="200" height="200" style="border-radius:5px; border: solid 1px #c2cfd6;">
                                        </div>
                                        <input type="file" @change="actualizarImagen" name="image" class="form-input" accept="image/*">     
                                </div>

                                <div class="form-group row">
                                   <label class="col-md-1 form-control-label" for="text-input">Nombre del producto: </label>
                                    <div class="col-md-5">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre del producto">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Categoría: </label>
                                    <div class="col-md-5">
                                        <select class="form-control" v-model="FkidCategoria">
                                            <option value="0" disabled>Seleccione una categoria...</option>
                                            <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                        </select>                                        
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <h6 class="form-control-label col-md-3" style="color: #6279a4;">Información general</h6>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Marca:</label>
                                    <div class="col-md-2">
                                        <input type="text" v-model="marca" class="form-control" placeholder="Marca">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Modelo:</label>
                                    <div class="col-md-2">
                                        <input type="text" v-model="modelo" class="form-control" placeholder="Modelo">                                        
                                    </div>

                                    <label class="col-md-1 form-control-label" for="email-input">Descripción</label>
                                    <div class="col-md-5">
                                        <textarea type="text" v-model="descripcion" class="form-control" placeholder="Ingrese una descripción..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">

                                 
                                    <label class="col-md-1 form-control-label" for="text-input">Presentación:</label>
                                    <div class="col-md-2">
                                        <input type="number" v-model="presentacionInterfaz" class="form-control" placeholder="0.00"> 
                                        <!-- <input type="hidden" v-model="presentacion" class="invisible"> -->
                                    </div>
                                
                                     <label class="col-md-1 form-control-label" for="text-input">Unidad:</label>
                                    <div class="col-md-2">
                                        <select class="form-control" v-model="unidad">
                                            <option value="0" disabled selected>Seleccione--</option>
                                            <option value="Kg.">Kg.</option>
                                            <option value="L.">L.</option>
                                            <option value="Pzas.">Pizas</option>
                                        </select>                                        
                                    </div>

                                     <label class="col-md-1 form-control-label" for="text-input">Precio de Compra: </label>
                                    <div class="col-md-2">
                                        <input type="number" v-model="precioCompra" class="form-control" placeholder="$0.00">                                        
                                    </div>
                                    <label class="col-md-1 form-control-label" for="text-input">Precio de Venta: </label>
                                    <div class="col-md-2">
                                        <input type="number" v-model="precioVenta" class="form-control" placeholder="$0.00">                                        
                                    </div>
                                    <label class="col-md-2 form-control-label" for="text-input">Venta por Partes: </label>
                                    <div class="col-md-3">
                                    <input type="checkbox" id="toggle1" v-model="ventaXpartes" class="offscreen"><label for="toggle1" class="switch2"></label>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-1 form-control-label" for="text-input">Código</label>
                                    <div class="col-md-5">
                                        <input type="text" v-model="codigoBarras" class="form-control" placeholder="Código de barras"> 
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-5">
                                        <barcode :value="codigoBarras" :options="{ format: 'EAN-13' }">
                                            Generando código de barras.    
                                        </barcode> 
                                    </div>
                                </div>
                                <div v-show="errorproducto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjproducto" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarproducto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarproducto()">Actualizar</button>
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
                id: 0,
                FkidCategoria : 0,
                nombre_categoria : '',
                codigoBarras : '',
                nombre : '',
                marca: '',
                modelo: '',
                presentacionInterfaz: '',
                presentacion: 0,
                unidad: '',
                precioVenta : 0,
                precioCompra : 0,
                ventaXpartes : 0,
                descripcion : '',
                imagen: '',
                arrayproducto : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorproducto : 0,
                errorMostrarMsjproducto : [],
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

            actualizarImagen(e){
                let image = e.target.files[0];
                let reader = new FileReader();

                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.imagen = e.target.result;
                }
                this.loaded = true;
            },

            listarproducto (page,buscar,criterio){
                let me=this;
                var url= '/producto?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayproducto = respuesta.productos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            seleccionarCategoria(){
                let me=this;
                var url= '/categoria/seleccionarCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
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
                me.listarproducto(page,buscar,criterio);
            },
            registrarproducto(){
                if (this.validarproducto()){
                    return;
                }
                
                let me = this;

                axios.post('/producto/registrar',{
                    'FkidCategoria': this.FkidCategoria,
                    'nombre': this.nombre,
                    'marca': this.marca,
                    'modelo': this.modelo,
                    'presentacionInterfaz': this.presentacionInterfaz,
                    'presentacion': this.presentacionInterfaz,
                    'unidad': this.unidad,
                    'codigoBarras': this.codigoBarras,
                    'descripcion': this.descripcion,
                    'precioCompra': this.precioCompra,
                    'precioVenta': this.precioVenta,
                    'imagen': this.imagen,
                    'ventaXpartes': this.ventaXpartes
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarproducto(1,'','nombre');
                    swal(
                        '¡Agregado!',
                        'El insumo/refacción ha sido agregado con éxito.',
                        'success'
                        )
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarproducto(){
               if (this.validarproducto()){
                    return;
                }
                
                let me = this;

                axios.put('/producto/actualizar',{
                    'FkidCategoria': this.FkidCategoria,
                    'nombre': this.nombre,
                    'marca': this.marca,
                    'modelo': this.modelo,
                    'presentacionInterfaz': this.presentacionInterfaz,
                    'presentacion': this.presentacionInterfaz,
                    'unidad': this.unidad,
                    'codigoBarras': this.codigoBarras,
                    'descripcion': this.descripcion,
                    'precioCompra': this.precioCompra,
                    'precioVenta': this.precioVenta,
                    'imagen': this.imagen,
                    'ventaXpartes': this.ventaXpartes,
                    'id': this.id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarproducto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarproducto(id){
               swal({
                title: '¿Esta seguro de desactivar este item?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
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
                        me.listarproducto(1,'','nombre');
                        swal(
                        '¡Desactivado!',
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
            activarproducto(id){
               swal({
                title: '¿Esta seguro de activar este item?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
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
                        me.listarproducto(1,'','nombre');
                        swal(
                        '¡Activado!',
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
            validarproducto(){
                this.errorproducto=0;
                this.errorMostrarMsjproducto =[];

                if (this.FkidCategoria==0) this.errorMostrarMsjproducto.push("Seleccione una categoría.");
                if (!this.nombre) this.errorMostrarMsjproducto.push("El nombre del producto no puede quedar vacío.");
                if (!this.marca) this.errorMostrarMsjproducto.push("La marca del producto no puede quedar vacía.");
                //if (!this.ventaXpartes) this.errorMostrarMsjproducto.push("El ventaXpartes del producto debe ser un número y no puede quedar vacío.");
                if (!this.precioVenta) this.errorMostrarMsjproducto.push("El precio de venta del artículo debe ser un número y no puede quedar vacío.");
                if (!this.precioCompra) this.errorMostrarMsjproducto.push("El precio de compra del artículo debe ser un número y no puede quedar vacío.");
                if (this.presentacionInterfaz != '' && !this.unidad) this.errorMostrarMsjproducto.push("Agregue la unidad de medida en la que viene la presentación del insumo (Kilogramos o Litros)");

                if (this.errorMostrarMsjproducto.length) this.errorproducto = 1;

                return this.errorproducto;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.FkidCategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.presentacion = 0;
                this.unidad = '';
                this.nombre = '';
                this.imagen = '';
                this.precioCompra = 0;
                this.precioVenta = 0;
                this.ventaXpartes = 0;
                this.descripcion = '';
		        this.errorproducto=0;
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
                                this.FkidCategoria=0;
                                this.nombre_categoria='';
                                this.codigoBarras='';
                                this.nombre= '';
                                this.marca= '';
                                this.modelo= '';
                                this.presentacionInterfaz = '';
                                this.presentacion = 0;
                                this.unidad = '';
                                this.imagen = '';
                                this.precioCompra=0;
                                this.precioVenta=0;
                                this.ventaXpartes=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Producto';
                                this.tipoAccion=2;
                                this.id=data['id'];
                                this.FkidCategoria=data['FkidCategoria'];
                                this.codigoBarras=data['codigoBarras'];
                                this.nombre = data['nombre'];
                                this.marca = data['marca'];
                                this.modelo = data['modelo'];
                                this.presentacionInterfaz = data['presentacion'];
                                this.presentacion = data['presentacion'];
                                this.unidad = data['unidad'];
                                this.imagen = data['imagen'];
                                this.ventaXpartes=data['ventaXpartes'];
                                this.precioCompra=data['precioCompra'];
                                this.precioVenta=data['precioVenta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
                this.seleccionarCategoria();
            }
        },
        mounted() {
            this.listarproducto(1,this.buscar,this.criterio);
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
    .switch2 {
        position: relative;
        display: inline-block;
        width: 40px;
        height: 20px;
        background-color: rgba(0, 0, 0, 0.25);
        border-radius: 20px;
        transition: all 0.3s;
    }
    .switch2::after {
        content: '';
        position: absolute;
        width: 18px;
        height: 18px;
        border-radius: 18px;
        background-color: white;
        top: 1px;
        left: 1px;
        transition: all 0.3s;
    }

    input[type='checkbox']:checked + .switch2::after {
        transform: translateX(20px);
    }

    input[type='checkbox']:checked + .switch2 {
        background-color: #7983ff;
    }

    .offscreen {
        position: absolute;
        left: -9999px;
    } 
   
</style>
