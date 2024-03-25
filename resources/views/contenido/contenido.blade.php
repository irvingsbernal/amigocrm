    @extends('principal')
    @section('contenido')

<!-- ASIGNAMOS BARRAS LATERALES DEPENDIENDO EL ROL PARA LAS OPCIONES DEL MENÚ --> 
    @if(Auth::check())
        @if(Auth::user()->rol == 'Administrador')

                <!-- TABLERO / ESCRITORIO DE INICIO ADMIN. -->
                <template v-if="menu==0">
                   <dashboard2></dashboard2>
                </template>

                 <!-- SECCIÓN CLIENTES ADMIN. -->
                <template v-if="menu==101">
                    <cliente></cliente>
                 </template>

                <template v-if="menu==102">
                    <auto></auto>   
                </template>

                <template v-if="menu==103">
                    <cotizaciones></cotizaciones>
                </template>

                <!-- SECCIÓN TALLER ADMIN. -->
                <template v-if="menu==201">
                    <servicio></servicio>
                </template>

                <template v-if="menu==202">
                    <subservicio></subservicio>
                </template>

                <template v-if="menu==203">
                    <ordenservicio></ordenservicio>
                </template>

                <template v-if="menu==204">
                    <ordenservicioadmin></ordenservicioadmin>
                </template>

                <template v-if="menu==205">
                    <ordenespagos></ordenespagos>
                </template>

                <!-- SECCIÓN ALMACÉN ADMIN. -->

                <template v-if="menu==301">
                  <inventario></inventario>
                </template>

                <template v-if="menu==302">
                    <ingreso></ingreso>
                </template>

                <template v-if="menu==303">
                    <historicoembarques></historicoembarques> 
                </template>

                <!-- SECCIÓN FINANZAS ADMIN. -->

                <template v-if="menu==401">
                    <finanzas></finanzas>
                </template>

                <template v-if="menu==402">
                    <reporteingresos></reporteingresos>
                </template>

                <template v-if="menu==403">
                    <reportegastos></reportegastos>
                </template>

                <!-- SECCIÓN INSUMOS/REFACCIONES ADMIN. -->

                <template v-if="menu==501">
                    <categoria></categoria>
                </template>
               
                <template v-if="menu==502">
                    <producto></producto>
                </template>

                <template v-if="menu==503">
                    <proveedor></proveedor>
                </template>

                 <!-- SECCIÓN EMPRESA ADMIN. -->
                <template v-if="menu==601">
                    <empleado></empleado>
                </template>

                <template v-if="menu==602">
                    <puesto></puesto>
                </template>

                <template v-if="menu==603">
                    <sucursal></sucursal>
                </template>

        <!-- ASIGNAMOS BARRAS LATERALES DEPENDIENDO EL ROL PARA LAS OPCIONES DEL MENÚ: CLIENTE --> 
        @elseif(Auth::user()->rol == 'Cliente')
            <template v-if="menu==0">
                <dashboard :id="{{ json_encode(Auth()->user()->id) }}"></dashboard>
            </template>
            <template v-if="menu==1">
                <cita :id="{{ json_encode(Auth()->user()->id) }}"></cita>
            </template>
            <template v-if="menu==2">
                <miautomovil :id="{{ json_encode(Auth()->user()->id) }}"></miautomovil>
            </template>
            <template v-if="menu==3">
                <perfilusuario :id="{{ json_encode(Auth()->user()->id) }}"></perfilusuario>
            </template>
            <template v-if="menu==4">
                <historico :id="{{ json_encode(Auth()->user()->id) }}"></historico>
            </template>
       
         <!-- ASIGNAMOS BARRAS LATERALES DEPENDIENDO EL ROL PARA LAS OPCIONES DEL MENÚ: EMPLEADO --> 
        @elseif(Auth::user()->rol == 'Empleado')
                <!-- TABLERO / ESCRITORIO DE INICIO EMPLEADO MECÁNICO -->
                <template v-if="menu==0">
                    <dashboard2></dashboard2>
                 </template>
 
                  <!-- SECCIÓN CLIENTES EMPLEADO MECÁNICO -->
                 <template v-if="menu==101">
                     <cliente></cliente>
                  </template>
 
                 <template v-if="menu==102">
                     <auto></auto>   
                 </template>
 
                 <template v-if="menu==103">
                     <cotizaciones></cotizaciones>
                 </template>
 
                 <!-- SECCIÓN TALLER EMPLEADO MECÁNICO -->
                 <template v-if="menu==201">
                     <servicio></servicio>
                 </template>
 
                 <template v-if="menu==202">
                     <subservicio></subservicio>
                 </template>
 
                 <template v-if="menu==203">
                     <ordenservicio ></ordenservicio>
                 </template>
 
                 <template v-if="menu==204">
                     <ordenserviciomecanico :id="{{ json_encode(Auth()->user()->id) }}"></ordenserviciomecanico>
                 </template>
 
                 <template v-if="menu==205">
                    <ordenespagosempleado :id="{{ json_encode(Auth()->user()->id) }}"></ordenespagosempleado>
                 </template>
 
                  <!-- SECCIÓN ALMACÉN EMPLEADO MECÁNICO -->
                 <template v-if="menu==301">
                   <inventario></inventario>
                 </template>
 
                <!--  No cuenta con permisos para hacer ingresos -->
                 {{-- <template v-if="menu==302">
                     <ingreso></ingreso>
                 </template> --}}
 
                 <template v-if="menu==303">
                     <historicoembarques></historicoembarques> 
                 </template>
 
                 
                
         <!-- ASIGNAMOS BARRAS LATERALES DEPENDIENDO EL ROL PARA LAS OPCIONES DEL MENÚ: rECEPCIONISTA --> 
        @elseif(Auth::user()->rol == 'Recepcionista')
                <!-- TABLERO / ESCRITORIO DE INICIO RECEPCIONISTA -->
                <template v-if="menu==0">
                    <dashboard2></dashboard2>
                 </template>
 
                  <!-- SECCIÓN CLIENTES RECEPCIONISTA -->
                 <template v-if="menu==101">
                     <cliente></cliente>
                  </template>
 
                 <template v-if="menu==102">
                     <auto></auto>   
                 </template>
 
                 <template v-if="menu==103">
                     <cotizaciones></cotizaciones>
                 </template>
 
                 <!-- SECCIÓN TALLER RECEPCIONISTA -->
                 <template v-if="menu==201">
                     <servicio></servicio>
                 </template>
 
                 <template v-if="menu==202">
                     <subservicio></subservicio>
                 </template>
 
                 <template v-if="menu==203">
                     <ordenservicio></ordenservicio>
                 </template>
 
                 <template v-if="menu==204">
                     <ordenservicioadmin></ordenservicioadmin>
                 </template>
 
                 <template v-if="menu==205">
                     <validarcita></validarcita>
                 </template>

 
                   <!-- SECCIÓN ALMACÉN RECEPCIONISTA -->
                 <template v-if="menu==301">
                   <inventario></inventario>
                 </template>
 
                 <template v-if="menu==302">
                     <ingreso></ingreso>
                 </template>
 
                 <template v-if="menu==304">
                     <historicoembarques></historicoembarques> 
                 </template>
 
                 
        @endif
    @endif
    
@endsection