 <template>
         <main>
 <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Próximas citas
                    </div>
                    <div class="card-body">
                        <!-- <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="fecha">Fecha</option>
                                      <option value="estatus">Estatus</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarcita(buscar,criterio)" class="form-control" placeholder="Búsqueda...">
                                    <button type="submit" @click="listarcita(buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>          
                            </div>
                        </div> -->
                        <table class="table table-bordered table-responsive table-sm">
                            <thead>
                                <tr>
                                    <th>Comprobante</th>
                                    <th>Sucursal</th>
                                    <th>Dirección sucursal</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Auto</th>
                                    <th>Placa</th>
                                    <th>Estatus</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cita in arraycita" :key="cita.id">
                                    <td>
                                        <button type="button" @click="Imprimir(cita)" class="btn btn-info btn-sm">
                                          <i class="icon-doc">Imprimir</i>
                                        </button> &nbsp;
                                    </td>
                                    <td v-text="cita.nombreComercial"></td>
                                    <td v-text="cita.direccion"></td>
                                    <td v-text="cita.fecha"></td>
                                    <td v-text="cita.horaInicio + '-' + cita.horaFin"></td>
                                    <td v-text="cita.marca"></td>
                                    <td v-text="cita.placa"></td>
                                    <td>
                                        <!-- <div v-if="cita.estatus == 0">
                                            <span class="badge badge-primary">Por confirmar</span>
                                        </div> -->
                                        <div v-if="cita.estatus == 1">
                                            <span class="badge badge-success">Confirmada</span>
                                        </div>
                                        <div v-if="cita.estatus == 2">
                                            <span class="badge badge-danger">Cancelada</span>
                                        </div>
                                        <div v-if="cita.estatus == 3">
                                            <span class="badge badge-light">Atendida</span>
                                        </div>
                                    </td>
                                </tr>                                
                            </tbody>
                        </table>
                        <!-- <nav>
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
                        </nav> -->
                    </div>
                </div>
            </main>
                <!-- Fin ejemplo de tabla Listado -->
</template>
<script>
    import Datepicker from 'vuejs-datepicker';
    import * as lang from "vuejs-datepicker/src/locale";
    export default {
        data (){
            return {
                idUsuario: this.$attrs.id,
                format: "yyyy-MM-dd",
                language: "es",
                languages: lang,
                cita_id: 0,
                comentario : '',
                fecha: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                hora : '',
                estatus : '',
                fk_horario: 0,
                fk_auto : '',
                fk_sucursal : '',
                fk_usuario : '',
                nombreComercial : '',
                direccion : '',
                marca : '',
                placa : '',
                arraycita : [],
                arrayHorarios: [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorcita : 0,
                errorMostrarMsjCita : [],
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'estatus',
                //buscar : this.$attrs.id,
                buscar: '',
                arraySucursales: [],
                arrayAutomovil : [],
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
            Datepicker,
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
                 Imprimir(cita){
                window.open('http://127.0.0.1:8000/cita/generarPDF?usuario='+this.$attrs.id+'&idcita='+cita.id, '_blank');
            },
            listarHorariosSucursal() {
                //alert("d");
                //alert("auto"+ this.fk_auto);
                alert("sucursal: "+ this.fk_sucursal);
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
            listarcita (){
                let me=this;
                
                var url= '/obtenerCitasRecientes?usuario='+ this.$attrs.id;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraycita = respuesta.citas.data;
                    console.log(me.arraycita);
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
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
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarcita(page,buscar,criterio);
            },
            actualizarcita(){
               if (this.validarcita()){
                    return;
                }
                
                let me = this;

                axios.put('/cita/actualizar',{
                    'id': this.cita_id,
                    'fecha': this.fecha,
                    'fk_auto': this.fk_auto,
                    'fk_sucursal': this.fk_sucursal,
                    'fk_horario': this.fk_horario
                }).then(function (response) {
                    Swal.fire('¡Tu cita ha sido modificada!', 'Espera tu confirmación de reservación', 'success');
                    me.cerrarModal();
                    me.listarcita(1,'','fecha');
                }).catch(function (error) {
                    console.log(error);
                    Swal.fire('Algo ha salido mal', 'Vuelve a intentar', 'error');
                }); 
            },
            cancelarcita(id){
               swal({
                title: '¿Esta seguro de cancelar esta cita?',
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

                    axios.put('/cita/cancelar',{
                        'id': id
                    }).then(function (response) {
                        me.listarcita(1,'','fecha');
                        swal(
                        '¡Cancelada!',
                        'La cita ha sido cancelada con éxito.',
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
            validarcita(){
                this.errorcita=0;
                this.errorMostrarMsjCita =[];

                if (!this.fecha) this.errorMostrarMsjCita.push("Debes seleccionar una fecha válida");
                if (!this.fk_horario) this.errorMostrarMsjCita.push("Debes seleccionar una hora");
                if (!this.fk_sucursal) this.errorMostrarMsjCita.push("Debes seleccionar una sucursal");
                if (!this.fk_auto) this.errorMostrarMsjCita.push("Debes seleccionar un auto");

                if (this.errorMostrarMsjCita.length) this.errorcita = 1;

                return this.errorcita;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.comentario='';
                this.fecha= new Date();
                this.hora = '',
                this.fk_auto= 0,
                this.fk_sucursal= 0
            },
            abrirModal(modelo, accion, data = []){
                this.selectSucursal();
                this.listarAutomovil();
                
                switch(modelo){

                    case "cita":
                    {
                        switch(accion){
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Modificar cita';
                                this.tipoAccion=2;
                                this.cita_id=data['id'];
                                // this.fecha = data['fecha'].toString().replace(/-/g, '\/');
                                this.fk_horario= data['fk_horario'];
                                this.fk_sucursal= data['fk_sucursal'];
                                this.fk_auto= data['fk_auto'];
                                break;
                            }
                        }
                    }
                }
                this.listarHorariosSucursal();
            }
        },
        mounted() {
            this.listarcita();
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