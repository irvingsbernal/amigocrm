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
                        <i class="fa fa-align-justify"></i> Automóviles
                        <button type="button" @click="abrirModal('auto','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="marca">Marca</option>
                                      <option value="modelo">Modelo</option>
                                      <option value="placa">Placa</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarauto(1,buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarauto(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Año</th>
                                    <th>Número VIN</th>
                                    <th>Color</th>
                                    <th>Placa</th>
                                    <th>Kilometraje</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="auto in arrayauto" :key="auto.id">
                                    <td>
                                        <button type="button" @click="abrirModal('auto','actualizar',auto)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="auto.estatus">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarauto(auto.id)">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarauto(auto.id)">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="auto.marca"></td>
                                    <td v-text="auto.modelo"></td>
                                    <td v-text="auto.anio"></td>
                                    <td v-text="auto.numerovinserie"></td>
                                    <td v-text="auto.color"></td>
                                    <td v-text="auto.placa"></td>
                                    <td v-text="auto.kilometraje"></td>
                                    <td>
                                        <div v-if="auto.estatus">
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
                                    <div class="col-md-9">
                                        <label class="col-md-12 form-control-label" for="text-input">Cliente:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="fk_cliente">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="categoria in arrayCliente" :key="categoria.id" :value="categoria.id" v-text="categoria.numerocliente"></option>
                                            </select>                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">

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
                                        <label class="col-md-12 form-control-label" for="text-input">Año:</label>
                                        <div class="col-md-12">
                                            <input type="number" v-model="anio" class="form-control" placeholder="Año modelo">                                        
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-4">
                                        <label class="col-md-12 form-control-label" for="text-input">Número VIN:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="numerovinserie" class="form-control" placeholder="VIN">                                        
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-md-12 form-control-label" for="text-input">Color:</label>
                                        <div class="col-md-12">
                                            <select class="form-control" v-model="color">
                                                <option value="0" disabled>Seleccione--</option>
                                                <option v-for="color in arrayColores" :key="color" :value="color" v-text="color"></option>
                                            </select>                                       
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-md-12 form-control-label" for="email-input">Placa:</label>
                                        <div class="col-md-12">
                                            <input type="text" v-model="placa" class="form-control" placeholder="Ingrese placa">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="col-md-12 form-control-label" for="email-input">Kilometraje:</label>
                                        <div class="col-md-12">
                                            <input type="number" v-model="kilometraje" class="form-control" placeholder="Kilometraje">
                                        </div>
                                    </div>
                                </div>
                                <div v-show="errorauto" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjauto" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarauto()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarauto()">Actualizar</button>
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
                auto_id: 0,
                fk_cliente : 0,
                nombre_cliente : '',
                marca : '',
                modelo : '',
                anio : 0,
                numerovinserie : 0,
                color : '',
                placa : 0,
                kilometraje : 0,
                fotografia: '',
                avatar: '',
                estatus : '',
                arrayauto : [],
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
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorauto : 0,
                errorMostrarMsjauto : [],
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
                arrayCliente :[]
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
            listarauto (page,buscar,criterio){
                let me=this;
                var url= '/auto?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayauto = respuesta.autos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCliente(){
                let me=this;
                var url= '/cliente/selectCliente';
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayCliente = respuesta.clientes;
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
                me.listarauto(page,buscar,criterio);
            },
            registrarauto(){
                if (this.validarauto()){
                    return;
                }
                
                let me = this;

                axios.post('/auto/registrar',{
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
                   
                    me.cerrarModal();
                    me.listarauto(1,'','nombre');
                    swal(
                        '¡Agregado!',
                        'El automóvil ha sido agregado con éxito.',
                        'success'
                        )
                }).catch(function (error) {
                    console.log(error);
                    Swal.fire('Ocurrio un problema', 'Favor de volver a intentarlo', 'error');
                });
            },
            actualizarauto(){
               if (this.validarauto()){
                    return;
                }
                
                let me = this;

                axios.put('/auto/actualizar',{
                    'marca': this.marca,
                    'modelo': this.modelo,
                    'anio': this.anio,
                    'numerovinserie': this.numerovinserie,
                    'color': this.color,
                    'placa': this.placa,
                    'kilometraje': this.kilometraje,
                    'fotografia': this.fotografia,
                    'fk_cliente': this.fk_cliente,
                    'id': this.auto_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarauto(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                    Swal.fire('Ocurrio un problema', 'Favor de volver a intentarlo', 'error');
                }); 
            },
            desactivarauto(id){
               swal({
                title: '¿Esta seguro de desactivar este automóvil?',
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

                    axios.put('/auto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarauto(1,'','nombre');
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
            activarauto(id){
               swal({
                title: '¿Esta seguro de activar este automóvil?',
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

                    axios.put('/auto/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarauto(1,'','nombre');
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
            validarauto(){
                this.errorauto=0;
                this.errorMostrarMsjauto =[];

                if (!this.fk_cliente) this.errorMostrarMsjauto.push("Seleccione un cliente");
                if (!this.marca) this.errorMostrarMsjauto.push("Seleccione una marca");
                if (!this.anio) this.errorMostrarMsjauto.push("Introduce un año");
                if (!this.color) this.errorMostrarMsjauto.push("Seleccione un color");
                if (!this.numerovinserie) this.errorMostrarMsjauto.push("Introduce un número VIN");
                if (!this.placa) this.errorMostrarMsjauto.push("Introduce el número de placa");

                if (this.errorMostrarMsjauto.length) this.errorauto = 1;

                return this.errorauto;
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
		        this.errorauto=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "auto":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar automóvil';
                                this.auto_id=0;
                                this.fk_cliente=0;
                                this.nombre_cliente='';
                                this.marca='';
                                this.modelo='';
                                this.anio=2000;
                                this.numerovinserie='';
                                this.color='';
                                this.placa='';
                                this.kilometraje=0;
                                this.tipoAccion = 1;
                                this.fotografia = ''
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar automóvil';
                                this.tipoAccion=2;
                                this.auto_id=data['id'];
                                this.fk_cliente=data['fk_cliente'];
                                this.nombre_cliente=data['nombre_cliente'];
                                this.marca=data['marca'];
                                this.modelo=data['modelo'];
                                this.anio=data['anio'];
                                this.numerovinserie=data['numerovinserie'];
                                this.color=data['color'];
                                this.placa=data['placa'];
                                this.kilometraje=data['kilometraje'];
                                this.fotografia=data['fotografia'];
                                break;
                            }
                        }
                    }
                }
                this.selectCliente();
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
            this.listarauto(1,this.buscar,this.criterio);
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