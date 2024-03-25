<div class="sidebar">
            <nav class="sidebar-nav">
                <ul class="nav">
                    <li @click="menu=0" class="nav-item">
                        <a class="nav-link active" href="#"><i class="icon-chart"></i>Tablero</a>
                    </li>

                    {{-- SECCIÓN CLIENTES COMPONENTES: 100-199 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-briefcase"></i>Clientes</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=101" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i>Registro</a>
                            </li>
                            <li @click="menu=102" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Autos</a>
                            </li>
                            <li @click="menu=103" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-grid"></i>Cotizaciones</a>
                            </li>
                        </ul>
                    </li>

                    {{-- SECCIÓN TALLER COMPONENTES: 200-299 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-list"></i>Taller</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=201" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-tag"></i>Servicios</a>
                            </li>
                            <li @click="menu=202" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i>Subservicios</a>
                            </li>
                            <li @click="menu=203" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-tag"></i>Orden de servicio</a>
                            </li>
                            <li @click="menu=204" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i>Ordenes al día</a>
                            </li>
                            <li @click="menu=205" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i>Cobros<span class="badge badge-danger">PDF</span></a>
                            </li>
                        </ul>
                    </li>
                    
                    {{-- SECCIÓN ALMACÉN COMPONENTES: 300-399 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-bag"></i>Almacén</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=301" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Inventario <span class="badge badge-danger">PDF</span></a>
                            </li>
                            <li @click="menu=302" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Recibo de mercancía</a>
                            </li>
                                <li @click="menu=303" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-bag"></i>Histórico de embarques</a>
                            </li>
                        </ul>
                    </li>
                     
                    {{-- SECCIÓN FINANZAS COMPONENTES: 400-499 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-wallet"></i>Finanzas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=401" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-wallet"></i>Administración</a>
                            </li>
                            <li @click="menu=402" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Reporte de ingresos</a>
                            </li>
                            <li @click="menu=403" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Reporte de gastos</a>
                            </li>
                        </ul>
                    </li>

                    {{-- SECCIÓN FINANZAS COMPONENTES: 500-599 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-basket"></i>Insumos/Refacciones</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=501" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i>Categorías</a>
                            </li>
                            <li @click="menu=502" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Productos/Artículos</a>
                            </li>
                            <li @click="menu=503" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Proveedores</a>
                            </li>
                        </ul>
                    </li>

                    {{-- SECCIÓN FINANZAS COMPONENTES: 600-699 --}}
                    <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-user"></i>Empresa</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=601" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-basket-loaded"></i>Empleados</a>
                            </li>
                            <li @click="menu=602" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Puestos</a>
                            </li>
                            <li @click="menu=603" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-notebook"></i>Sucursales</a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-people"></i> Acceso</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=14" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user"></i> Usuarios</a>
                            </li>
                            <li @click="menu=15" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-user-following"></i> Roles</a>
                            </li>
                        </ul>
                    </li> --}}
                    {{-- <li class="nav-item nav-dropdown">
                        <a class="nav-link nav-dropdown-toggle" href="#"><i class="icon-calculator"></i> Finanzas</a>
                        <ul class="nav-dropdown-items">
                            <li @click="menu=14" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-calculator"></i>Ingresos/Gastos</a>
                            </li>
                            <li @click="menu=16" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Ingresos</a>
                            </li>
                            <li @click="menu=17" class="nav-item">
                                <a class="nav-link" href="#"><i class="icon-chart"></i> Reporte Gastos</a>
                            </li>
                        </ul>
                    </li> --}}
                    
                    <li @click="menu=1001" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-book-open"></i> Ayuda <span class="badge badge-danger">PDF</span></a>
                    </li>

                    <li @click="menu=1002" class="nav-item">
                        <a class="nav-link" href="#"><i class="icon-info"></i> Acerca de...<span class="badge badge-info">IT</span></a>
                    </li>

                </ul>
            </nav>
            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>