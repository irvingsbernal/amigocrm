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
                    MI AUTOMÓVIL &nbsp;
                    <button type="button" class="btn btn-secondary" @click="abrirModal('automovil','registrar')">
                        <i class="fa fa-plus"></i>&nbsp;Agregar
                    </button>
                </div>
                <div class="card-body" v-for="automovil in arrayAutomovil" :key="automovil.id">
                    <div class="container">
                        <div class="row my-2">
                            <div class="col-lg-8 order-lg-2">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a href="" data-target="#profile" data-toggle="tab" class="nav-link active">Mi portafolio</a>
                                    </li>
                                </ul>
                                <div class="tab-content py-4">
                                    <div class="tab-pane active" id="profile">
                                        <h5 class="mb-3">Mi automóvil</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h6>Placa</h6>
                                                <p>
                                                    <input type="text" :value="automovil.placa" class="form-control" placeholder="Placa" disabled>
                                                </p>
                                                <p>
                                                    <button type="button" class="btn btn-secondary" @click="cargaDatos(automovil)">
                                                        <i class="fa fa-plus"></i>&nbsp;Editar
                                                    </button>
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <h6>Código QR</h6>
                                                <qrcode-vue :value="automovil.placa" size="100" foreground="#9ca9d3" level="H"></qrcode-vue>
                                            </div>
                                        </div>
                                       <!--/SELECIÓN DE AUTO-->
                                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal" v-if="formedicion==automovil.id">
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Marca</label>
                                                <div class="col-lg-9">
                                                    <select class="form-control" v-model="marca">
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="marca in arrayMarcas" :key="marca" :value="marca" v-text="marca"></option>
                                                    </select>  
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Modelo</label>
                                                <div class="col-lg-9">
                                                    <select class="form-control" v-model="modelo">
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="modelo in arrayModelos" :key="modelo" :value="modelo" v-text="modelo"></option>
                                                    </select> 
                                                </div>
                                            </div>
                                            <!--/SELECIÓN DE AUTO-->
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Año</label>
                                                <div class="col-lg-9">
                                                    <input type="number" v-model="anio" class="form-control" placeholder="Año modelo">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Número VIN</label>
                                                <div class="col-lg-9">
                                                        <input type="text" v-model="numerovinserie" class="form-control" placeholder="VIN">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Placa</label>
                                                <div class="col-lg-9">
                                                    <input type="text" v-model="placa" class="form-control" placeholder="Ingrese placa">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label">Color</label>
                                                <div class="col-lg-3">
                                                    <select class="form-control" v-model="color">
                                                        <option value="0" disabled>Seleccione</option>
                                                        <option v-for="color in arrayColores" :key="color" :value="color" v-text="color"></option>
                                                    </select> 
                                                </div>
                                                <label class="col-lg-3 col-form-label form-control-label">Kilometraje</label>
                                                <div class="col-lg-3">
                                                    <input type="number" v-model="kilometraje" class="form-control" placeholder="Kilometraje">
                                                </div>
                                            </div>
                                            <div v-show="errorAutomovil" class="form-group row div-error">
                                                <div class="text-center text-error">
                                                    <div v-for="error in errorMostrarMsjAutomovil" :key="error" v-text="error">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                                <div class="col-lg-9">
                                                    <input type="reset" class="btn btn-secondary" value="Cancelar" @click="formedicion=0">
                                                    <input type="button" class="btn btn-primary" @click="actualizarAutomovil()" value="Guardar cambios">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 order-lg-1 text-center">
                                <img v-if="automovil.fotografia != null" :src="automovil.fotografia" class="mx-auto img-fluid img-circle d-block" :alt="automovil.nombre">
                                <img v-else-if="automovil.fotografia == null" src="img/placeholder.jpg" class="mx-auto img-fluid img-circle d-block" :alt="automovil.nombre">
                                <!-- Fin ejemplo de tabla Listado -->
                                <label class="custom-file">
                                    <input type="file" @change="getImage" id="file" class="custom-file-input" disabled>
                                    <span class="custom-file-control">Foto del </span>
                                    <br>
                                </label>
                                <!-- Fin ejemplo de tabla Listado -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                <div class="col-md-3">
                                    <img v-if="fotografia!=null" class="img-circle" :src="fotografia" alt = "" width="50%" height="100vh">
                                    <img v-else-if="fotografia==null" src="img/placeholder.jpg" width="50%" height="100vh">
                                    <input class="mt-3" style="color: transparent" type="file" name="image" @change="getImage" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                        <label class="col-md-12 form-control-label" for="text-input">Marca:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="marca">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="marca in arrayMarcas" :key="marca" :value="marca" v-text="marca"></option>
                                            </select>                                        
                                        </div>
                                    </div>

                                    <div class="col-md-4" v-if="marca == 'Acura'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayacura" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>

                                    <div class="col-md-4" v-else-if="marca == 'Audi'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayaudi" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'BMW'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraybmw" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Chevrolet'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraychevrolet" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Chrysler'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraychrysler" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Dodge'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraydodge" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Fiat'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayfiat" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Ford Motor Company'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayford" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'GMC'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraygmc" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Honda'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayhonda" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Hyundai'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayhyundai" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Jaguar'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayjaguar" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Jeep'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayjeep" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Kia'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraykia" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Mazda'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraymazda" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Mercedes-Benz'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraymercedes" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'MINI'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraymini" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Mitsubishi Motors'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraymitsubishi" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Nissan'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraynissan" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Peugeot'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraypeugeot" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Renault'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayrenault" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'SEAT'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayseat" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Tesla'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraytesla" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                    <div class="col-md-4" v-else-if="marca == 'Toyota'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arraytoyota" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>

                                    <div class="col-md-4" v-else-if="marca == 'Volkswagen'">
                                        <label class="col-md-12 form-control-label" for="text-input">Modelo:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="modelo">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="modelo in arrayvw" :key="modelo" :value="modelo" v-text="modelo"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                <div class="col-md-2">
                                    <label class="col-md-12 form-control-label" for="text-input">Año</label>
                                    <div class="col-md-12">
                                        <input type="number" v-model="anio" class="form-control" placeholder="Año modelo">                                        
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">

                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <label class="col-md-12 form-control-label" for="text-input">Número VIN</label>
                                    <div class="col-md-12">
                                        <input type="text" v-model="numerovinserie" class="form-control" placeholder="VIN">                                        
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-md-12 form-control-label" for="text-input">Color</label>
                                    <div class="col-md-12">
                                        <select class="form-control" v-model="color">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="color in arrayColores" :key="color" :value="color" v-text="color"></option>
                                        </select>                                       
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-md-12 form-control-label" for="email-input">Placa</label>
                                    <div class="col-md-12">
                                        <input type="text" v-model="placa" class="form-control" placeholder="Ingrese placa">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-md-12 form-control-label" for="email-input">Kilometraje</label>
                                    <div class="col-md-12">
                                        <input type="number" v-model="kilometraje" class="form-control" placeholder="Kilometraje">
                                    </div>
                                </div>
                            </div>
                            <div v-show="errorAutomovil" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjAutomovil" :key="error" v-text="error">

                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="registrarAutomovil()">Guardar</button>
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
    import QrcodeVue from 'qrcode.vue'
    export default {
        data (){
            return {
                idUsuario: this.$attrs.id,
                marca : '',
                modelo : '',
                anio : 0,
                numerovinserie : 0,
                color : '',
                placa : 0,
                kilometraje : 0,
                fotografia: '',
                edicion: true,
                formedicion: 0,
                automovil_id: 0,
                fk_cliente: 0,
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                arrayAutomovil : [],
                errorAutomovil : 0,
                errorMostrarMsjAutomovil : [],
                arrayCliente: [],
                arrayMarcas: ['Acura', 'Audi', 'BMW', 'Chevrolet', 'Chrysler', 'Dodge', 'Fiat', 'Ford Motor Company', 
                              'GMC', 'Honda', 'Hyundai', 'Jaguar', 'Jeep', 'Kia', 'Mazda', 'Mercedes-Benz', 'MINI', 
                              'Mitsubishi Motors', 'Nissan', 'Peugeot', 'Renault', 'SEAT', 'Tesla', 'Toyota', 'Volkswagen'],
                
                arrayacura: ['Acura RDX', 'ACURA TLX', 'ACURA MDX', 'ACURA ILX', 'ACURA NSX'],
                arrayaudi: ['AUDI A1', 'AUDI A3', 'AUDI A4', 'AUDI A6', 'AUDI Q3', 'AUDI Q5', 'AUDI A8', 'AUDI TT', 'AUDI R8'],
                arraybmw: ['BMW X1', 'BMW X3', 'BMW X5', 'BMW X6', 'BMW Serie 7 Sedán', 'BMW M5'],
                arraychevrolet: ['AVEO', 'CAMARO', 'CAPTIVA', 'CORVETTE', 'CRUZE', 'MALIBU', 'ORLANDO', 'SPARK'],
                arraychrysler: ['CHRYSLER PACIFICA', 'CHRYSLER 300C', 'CHRYSLER CRUISER', 'CHRYSLER TOWN&COUNTRY'],
                arraydodge: ['DODGE ATTITUDE', 'DODGE CARAVAN', 'DODGE CHARGER', 'DODGE CHALLENGER', 'DODGE DURANGO', 'DODGE NEON'],
                arrayfiat: ['FIAT DUCATO', 'FIAT PALIO', 'FIAT MOBI', 'FIAT 500L', 'FIAT UNO'],
                arrayford: ['FORD FIGO', 'FORD FUSION', 'FORD ESCAPE', 'FORD EDGE', 'FORD EXPEDITION', 'FORD LOBO'],
                arraygmc: ['GMC ACADIA', 'GMC TERRAIN', 'GMC SIERRA', 'GMC YUKON'],
                arrayhonda: ['Honda Civic', 'Honda Pilot', 'Honda CR-V', 'Honda Acccord', 'Honda Fit', 'Honda City'],
                arrayhyundai: ['HYUNDAI GRANDi10', 'HYUNDAI IONIQ', 'HYUNDAI CRETA', 'HYUNDAI TUCSON', 'HYUNDAI ELANTRA', 'HYUNDAI SANTAFe'],
                arrayjaguar: ['JAGUAR F-TYPE', 'JAGUAR XF', 'JAGUAR F-PACE', 'JAGUAR XE', 'JAGUAR E-PACE', 'JAGUAR I-PACE'],
                arrayjeep: ['JEEP WRANLER', 'JEEP CHEROKEE', 'JEEP RENEGADE', 'JEEP COMPASS', 'JEEP SAHARA', 'JEEP GLADIATOR'],
                arraykia: ['KIA SPORTAGE', 'KIA RIO', 'KIA SELTOS', 'KIA SORENTO', 'KIA STINGER', 'KIA SOUL'],
                arraymazda: ['MAZDA 2', 'MAZDA 3', 'MAZDA 6', 'MAZDA CX-3', 'MAZDA CX-5', 'MAZDA CX-9'],
                arraymercedes: ['MERCEDES-BENZ CLASE A', 'MERCEDES-BENZ CLASE C', 'MERCEDES-BENZ CLASE G', 'MERCEDES-BENZ CLA', 'MERCEDES-BENZ GLA', 'MERCEDES-BENZ CLASE E'],
                arraymini: ['MINI COOPER', 'MINI COUNTRYMAN', 'MINI CLUBMAN'],
                arraymitsubishi: ['MITSUBISHI OUTLANDER', 'MITSUBISHI MIRAGE', 'MITSUBISHI L200', 'MITSUBISHI ECLIPSE', 'MITSUBISHI MONTERO'],
                arraynissan: ['Nissan Altima', 'Nissan Kicks', 'Nissan NP300 Frontier', 'Nissan Sentra', 'Nissan Versa', 'Nissan X-Trail'],
                arraypeugeot: ['PEUGEOT 2008', 'PEUGEOT 5008', 'PEUGEOT 208', 'PEUGEOT 308', 'PEUGEOT 301', 'PEUGEOT EXPERT'],
                arrayrenault: ['RENAULT DUSTER', 'RENAULT KOLEOS', 'RENAULT CLIO', 'RENAULT SANDERO', 'RENAULT STEPWAY', 'RENAULT KANGOO'],
                arrayseat: ['SEAT IBIZA', 'SEAT LEÓN', 'SEAT ATECA', 'SEAT ARONA', 'SEAT TARRACO'],
                arraytesla: ['TESLA MODEL 3', 'TESLA MODEL S', 'TESLA MODEL X', 'TESLA MODEL Y'],
                arraytoyota: ['TOYOTA YARIS', 'TOYOTA AVANZA', 'TOYOTA SIENNA', 'TOYOTA TACOMA', 'TOYOTA COROLLA', 'TOYOTA PRIUS', 'TOYOTA RAV4', 'TOYOTA CAMRY', 'TOYOTA HILUX'],
                arrayvw: ['VW VENTO', 'VW VIRTUS', 'VW JETTA', 'VW TIGUAN', 'VW POLO', 'VW GOLF', 'VW GOLF TSI', 'VW GOL', 'VW JETTA GLI', 'VW T-CROSS'],
                arrayColores: ['Blanco', 'Negro', 'Plata', 'Gris', 'Rojo', 'Azul', 'Café o baige', 'Amarillo', 'Verde', 'Naranja', 'Dorado', 'Otro'],
            }
        },
        components: {
        'barcode': VueBarcode,
        QrcodeVue,
        },
        computed:{
        },
        methods : {
            obtenerCliente() {
                let me=this;
                var url= '/obtenerCliente?idUsuario=' + me.idUsuario;
                console.log(me.idUsuario);
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    // me.fotografia = respuesta.autos.data[0].fotografia;
                    me.arrayCliente = respuesta.cliente.data;
                    me.fk_cliente = me.arrayCliente[0].id;
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
            registrarAutomovil(){
                if (this.validarAutomovil()){
                    return;
                }
                
                let me = this;

                axios.post('/automovil/registrar',{
                    'marca': this.marca,
                    'modelo': this.modelo,
                    'anio': this.anio,
                    'numerovinserie': this.numerovinserie,
                    'color': this.color,
                    'placa': this.placa,
                    'kilometraje': this.kilometraje,
                    'fotografia': this.avatar,
                    'fk_cliente': this.fk_cliente
                }).then(function (response) {
                    Swal.fire('¡El registro ha sido completado!', 'Sigue con el proceso de mantenimiento', 'success');
                    me.cerrarModal();
                    console.log(me.fk_cliente);
                    me.listarAutomovil(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                    console.log(me.fk_cliente);
                    Swal.fire('Ocurrio un problema', 'Favor de volver a intentarlo', 'error');
                });
            },
            actualizarAutomovil(){
               if (this.validarAutomovil()){
                    return;
                }
                
                let me = this;

                axios.put('/automovil/actualizar',{
                    'marca': this.marca,
                    'modelo': this.modelo,
                    'anio': this.anio,
                    'numerovinserie': this.numerovinserie,
                    'color': this.color,
                    'placa': this.placa,
                    'kilometraje': this.kilometraje,
                    'fotografia': this.fotografia,
                    'fk_cliente': this.fk_cliente,
                    'id': this.automovil_id
                }).then(function (response) {
                    Swal.fire('¡Tu automóvil ha sido actualizado!', 'Sigue al día con el mantenimiento de tu automóvil', 'success');
                }).catch(function (error) {
                    Swal.fire('¡Algo salio mal!', 'Intentalo de nuevo', 'error');
                }); 
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.fk_cliente= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
		        this.errorAutomovil=0;
            },
            validarAutomovil(){
                this.errorAutomovil=0;
                this.errorMostrarMsjAutomovil =[];

                if (!this.marca) this.errorMostrarMsjAutomovil.push("Seleccione una marca");
                if (!this.anio) this.errorMostrarMsjAutomovil.push("Introduce un año");
                if (!this.color) this.errorMostrarMsjAutomovil.push("Seleccione un color");
                if (!this.numerovinserie) this.errorMostrarMsjAutomovil.push("Introduce un número VIN");
                if (!this.placa) this.errorMostrarMsjAutomovil.push("Introduce el número de placa");

                if (this.errorMostrarMsjAutomovil.length) this.errorAutomovil = 1;

                return this.errorAutomovil;
            },
            cargaDatos(data = []){
                this.automovil_id=data['id'];
                this.fk_cliente=data['fk_cliente'];
                this.marca=data['marca'];
                this.modelo=data['modelo'];
                this.anio=data['anio'];
                this.numerovinserie=data['numerovinserie'];
                this.color=data['color'];
                this.placa=data['placa'];
                this.kilometraje=data['kilometraje'];
                this.fotografia=data['fotografia'];
                this.edicion = false;
                this.formedicion = data['id'];
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "automovil":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar automóvil';
                                this.automovil_id=0;
                                this.marca='';
                                this.modelo='';
                                this.anio=2000;
                                this.numerovinserie='';
                                this.color='';
                                this.placa='';
                                this.kilometraje=0;
                                this.tipoAccion = 1;
                                this.fotografia = null;
                                break;
                            }
                        }
                    }
                }
            },
            getImage(e){
                let image = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(image);
                reader.onload = e => {
                    this.avatar = e.target.result;
                    this.fotografia = this.avatar;
                }
                this.loaded = true;
            }
        },
        mounted() {
            this.listarAutomovil(1,this.buscar,this.criterio);
            this.obtenerCliente();
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