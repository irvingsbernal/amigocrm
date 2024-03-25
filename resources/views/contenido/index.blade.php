<!DOCTYPE html>
<html lang="en">

<head>
    <title>ÉCROU HEXAGONAL</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>

<body data-spy="scroll" data-target=".navbar" data-offset="50">
    <nav class="navbar navbar-light navbar-fixed-top" id="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <i class="fa fa-bars"></i>                     
                </button>
                <a class="navbar-brand" href="#">ÉCROU <label for="" style="color: #e9cb36;">HEXAGONAL</label></a>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#inicio">INICIO</a></li>
                    <li><a href="#proceso">NUESTRO PROCESO</a></li>
                    <li><a href="#servicios">SERVICIOS</a></li>
                    <li><a href="#citas">AGENDAR UNA CITA</a></li>
                    <li><a href="#profesionales">NUESTROS PROFESIONALES</a></li>
                    <li><a href="#instalaciones">INSTALACIONES</a></li>
                    <li><a href="#contacto">CONTACTO</a></li>
                    <a class="btn active mt-3" style="background-color: #e9cb36;" href="{{ url('/registro') }}">REGISTRO</a>
                    <a class="btn active mt-3" style="background-color: #e9cb36;" href="{{ url('/log') }}">INICIAR SESIÓN</a>
                </ul>
            </div>
        </div>
    </nav>

    <div id="inicio" class="jumbotron text-justify">
        <h1>Trabajamos por <b>tu auto</b>, para que nunca te detengas</h1>
        <div class="row text-justify">
            <div class="col-md-8">
                <p>Écrou Hexagonal sabe que tu automóvil y tu tiempo merecen el mejor taller mecánico</p>
            </div>
            <div class="col-md-4">
                <a class="btn active mt-3" style="background-color: #e9cb36;" href="https://youtu.be/HAhR6w89Ue8"><i class="fa fa-play"></i> Mira nuestro vídeo</a>
            </div>
        </div>
    </div>

    <div id="proceso" class="proceso text-center">
        <form id="regForm" action="/action_page.php">
            <h1>CONOCE NUESTRO PROCESO</h1>
            <!-- One "tab" for each step in the form: -->
            <div class="tab"><h3>Reserva</h3>
              <p class="pasos">Puedes agendar una cita dentro de nuestro taller mecánico Écrou Hexagonal con el beneficio de elegir el día y hora que mejor se acople a tu rutina, agilizando el proceso de diagnóstico de tu automóvil. <br>
                También puedes llegar a tu sucursal más cercana sin previa reservación y estaremos encantados de recibirte</p>
            </div>
            <div class="tab"><h3>Diagnóstico</h3>
                <p class="pasos">La identificación y análisis del proceso de diagnóstico de vehículo automotriz. Vamos a escuchar tus opiniones sobre los problemas que has detectado en el auto.<br>
                Vamos a proceder a una inspección visual de los componentes del problema buscando los daños posibles y haciendo lecturas de códigos de falla con equipo de diagnóstico </p>
            </div>
            <div class="tab"><h3>Información</h3>
                <p class="pasos">Te informamos sobre los problemas que presenta tu automóvil y que servicios recomendados por el experto puede requerir la corrección o mantenimiento.</p>
            </div>
            <div class="tab"><h3>Cotización</h3>
                <p class="pasos">El proceso de cotización, tiene como objeto comunicarte cual es el precio de un determinado servicio antes de proceder a ejecutarlo.</p>
            </div>
            <div class="tab"><h3>Servicio personalizado</h3>
                <p class="pasos">Nos adaptamos a las necesidades de tu automóvil<br>
                    Se puede desentender del mantenimiento preventivo y correctivo de su auto. Brindamos seguimiento personalizado de la bitácora de servicio de su automóvil en nuestro sistema <label class="go">AMI.GO</label>, conocelo.</p>
            </div>
            <div style="overflow:auto;">
              <div style="float:right;">
                <button type="button" id="prevBtn" onclick="nextPrev(-1)">Anterior</button>
                <button type="button" id="nextBtn" onclick="nextPrev(1)">Siguiente</button>
              </div>
            </div>
            <!-- Circles which indicates the steps of the form: -->
            <div style="text-align:center;margin-top:40px;">
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div>
          </form>
    </div>

    <div id="servicios" class="text-center servicios">
        <!-- <h2>NUESTROS SERVICIOS</h2> -->
        <div id="myCarousel" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
                <li data-target="#myCarousel" data-slide-to="3"></li>
                <li data-target="#myCarousel" data-slide-to="4"></li>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner">

                <div class="item active">
                    <img src="img/diagnostico.jpg" alt="Los Angeles" style="width:100%; height: 95vh;">
                    <div class="carousel-caption">
                        <h3>Dignóstico</h3>
                        <p>Identificamos cuáles pueden ser las posibles áreas que no están funcionando adecuadamente en el motor de un auto, realizamos un presupuesto del costo de las reparaciones y además, buscamos cuales son las mejores soluciones posibles
                            para dicho problema.</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/afinacion.jpg" alt="Chicago" style="width:100%; height: 95vh;">
                    <div class="carousel-caption">
                        <h3>Afinación</h3>
                        <p>Se cambian filtros, bujías, cambios de aceite y lavado de válvulas </p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/frenos.jpg" alt="New York" style="width:100%; height: 95vh;">
                    <div class="carousel-caption">
                        <h3>Frenos</h3>
                        <p>Cambio de balatas y rectificado de discos</p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/electrico.jpg" alt="New York" style="width:100%; height: 95vh;">
                    <div class="carousel-caption">
                        <h3>Eléctrico</h3>
                        <p>Inspección de cableado, luces, motor de arranque, alternador y sensores </p>
                    </div>
                </div>

                <div class="item">
                    <img src="img/suspension.jpg" alt="New York" style="width:100%; height: 95vh;">
                    <div class="carousel-caption">
                        <h3>Suspensión</h3>
                        <p>Rotulas, soportes, muelles y amortiguadores </p>
                    </div>
                </div>
            </div>

            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Anterior</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Siguiente</span>
            </a>
        </div>
    </div>

    <div id="citas" class="citas text-center">
        <h2>AGENDA TU CITA AHORA <br> MISMO</h2>
        <p>Conoce todos los beneficios que te ofrecemos en ÉCROU HEXAGONAL</p>
        <iframe width="560" height="315" src="https://www.youtube.com/embed/HAhR6w89Ue8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        <br><a class="btn btn-cita active mt-3" style="background-color: #e9cb36;" href="{{ url('/registro') }}"><i class="fa fa-calendar"></i> Agendar una cita</a>
    </div>

    <div id="profesionales" class="profesionales text-center">
        <h2>CONOCE A NUESTRO EQUIPO <br> DE PROFESIONALES</h2><br>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="img/empleado1.jpg" target="_blank">
                        <img src="img/empleado1.jpg" alt="Lights" style="width:100%">
                        <div class="caption">
                            <p>Jefe de taller</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="img/empleado2.jpg" target="_blank">
                        <img src="img/empleado2.jpg" alt="Nature" style="width:100%">
                        <div class="caption">
                            <p>Mecánico general</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="img/empleado3.jpg" target="_blank">
                        <img src="img/empleado3.jpg" alt="Fjords" style="width:100%">
                        <div class="caption">
                            <p>Mecánico general</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="img/empleado4.jpg" target="_blank">
                        <img src="img/empleado4.jpg" alt="Fjords" style="width:100%">
                        <div class="caption">
                            <p>Mecánico ayudante</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-2">
                <div class="thumbnail">
                    <a href="img/empleado5.jpg" target="_blank">
                        <img src="img/empleado5.jpg" alt="Fjords" style="width:100%">
                        <div class="caption">
                            <p>Asesor de servicio</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="instalaciones" class="instalaciones text-center">
        <h2>INSTALACIONES</h2>
        <div class="row">
            <div class="row col-md-5" style="margin-left: 5%">
                <div class="col-md-6">
                    <div class="thumbnail">
                        <a href="/w3images/lights.jpg" target="_blank">
                            <img src="img/taller.jpg" alt="Lights" style="width:100%">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <a href="/w3images/nature.jpg" target="_blank">
                            <img src="img/taller1.jpg" alt="Nature" style="width:100%">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <a href="/w3images/taller3.jpg" target="_blank">
                            <img src="img/taller2.jpg" alt="Fjords" style="width:100%">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="thumbnail">
                        <a href="/w3images/fjords.jpg" target="_blank">
                            <img src="img/taller3.jpg" alt="Fjords" style="width:100%">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.2247927628814!2d-101.58397696046083!3d21.06368216368673!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842b963652f40f0d%3A0xa7d88da0ad8eff8a!2sUniversidad%20Tecnol%C3%B3gica%20de%20Le%C3%B3n!5e0!3m2!1ses!2smx!4v1597504858471!5m2!1ses!2smx" width="600" height="450" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </div>
        </div>
    </div>

    <div id="contacto" class="contacto text-center">
        <section class="mb-4 form-contacto">
            <h2 class="h1-responsive font-weight-bold text-center my-4">CONTÁCTANOS</h2>
            <p class="text-center w-responsive mx-auto mb-5">¿Tienes dudas, preguntas o sugerencias? Por favor contáctanos directamente. Nuestro equipo se pondrá en contacto contigo, te atenderemos y resolveremos todas tus dudas.</p>
            <div class="row" style="  align-items: center;
            display: flex;
            justify-content: center;">
                <div class="col-md-4 info" >
                    <ul class="list-unstyled mb-0">
                        <li>
                            <p><i class="fa fa-map-marker fa-2x"></i> &nbsp; Blvd. Universidad Tecnológica 225, Universidad Tecnologica, San Carlos la Roncha, 37670 León, Gto.</p>
                        </li>

                        <li>
                            <p><i class="fa fa-phone mt-4 fa-2x"></i>&nbsp;477 123 45 67</p>
                        </li>

                        <li>
                            <p><i class="fa fa-envelope mt-4 fa-2x"></i>&nbsp;ecrouhexagonal@gmail.com</p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3 agen-cita">
                    AGENDA TU CITA<label for="">&nbsp; AHORA</label><br>
                    <a class="btn btn-cita active mt-3" style="background-color: #e9cb36;" href="{{ url('/registro') }}"><i class="fa fa-calendar"></i> Agendar una cita</a>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(window).scroll(function() {
            if ($("#navbar").offset().top > 56) {
                $("#navbar").addClass("bg-inverse");
            } else {
                $("#navbar").removeClass("bg-inverse");
            }
        });
    </script>
    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        
        function showTab(n) {
          // This function will display the specified tab of the form...
          var x = document.getElementsByClassName("tab");
          x[n].style.display = "block";
          //... and fix the Previous/Next buttons:
          if (n == 0) {
            document.getElementById("prevBtn").style.display = "none";
          } else {
            document.getElementById("prevBtn").style.display = "inline";
          }
          if (n == (x.length - 1)) {
            document.getElementById("nextBtn").className = "desaparecer";
          } else {
            document.getElementById("nextBtn").innerHTML = "Siguiente";
          }
          //... and run a function that will display the correct step indicator:
          fixStepIndicator(n)
        }
        
        function nextPrev(n) {
          // This function will figure out which tab to display
          var x = document.getElementsByClassName("tab");
          // Hide the current tab:
          x[currentTab].style.display = "none";
          // Increase or decrease the current tab by 1:
          currentTab = currentTab + n;
          // if you have reached the end of the form...
          if (currentTab >= x.length) {
            // ... the form gets submitted:
            document.getElementById("regForm").submit();
            return false;
          }
          // Otherwise, display the correct tab:
          showTab(currentTab);
        }
        
        function fixStepIndicator(n) {
          // This function removes the "active" class of all steps...
          var i, x = document.getElementsByClassName("step");
          for (i = 0; i < x.length; i++) {
            x[i].className = x[i].className.replace(" active", "");
          }
          //... and adds the "active" class on the current step:
          x[n].className += " active";
        }
    </script>
</body>
<div class="footer-wrap">
    <div class="container">
        <div class="row">
            <div class="col-md-6 visible-lg">
                <h3>Software</h3>
                <label for="" class="ami"> AMI.<label class="go">GO</label></label>
                <p>El sistema AMI.GO (Advanced Mechanical Improve), es un sistema de gestión integrado desarrollado como aplicación web para mantener en un solo lugar la información que respecta a un negocio, permitiendo que esta fluya multidireccionalmente
                    y se relacione entre sí facilitando el acceso a la misma.</p>
            </div>
            <div class="col-sm-6 visible-lg">
                <h3>Nuestra empresa</h3>
                <div class="col-md-8">
                    <label class="go">Misión</label>
                    <p>Proporcionar soluciones a la altura de las necesidades de cada auto, haciendo uso de las tecnologías adecuadas, con el fin de mejorar nuestros servicios y ofrecer una mejor experiencia a nuestros clientes. </p>
                </div>
                <div class="col-md-4" style="color: white">
                    <label class="go">Servicios</label>
                    <p><li>Diagnóstico</li><li>Afinaciones</li><li>Ajuste de frenos</li><li>Eléctrico</li><li>Suspensiones</li></p>
                </div>
            </div>
            <div class="col-md-6 visible-md visible-sm visible-xs">
                <h3>Software</h3>
                <label for="" class="ami"> AMI.<label class="go">GO</label></label>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-1" />
                    <p class="read-more-wrap">El sistema AMI.GO (Advanced Mechanical Improve), es un sistema de gestión integrado <span class="read-more-target">desarrollado como aplicación web para mantener en un solo lugar la información que respecta a un negocio, permitiendo que esta fluya multidireccionalmente
                    y se relacione entre sí facilitando el acceso a la misma.</span></p>
                    <label for="post-1" class="read-more-trigger"></label>
                </div>
            </div>
            <div class="col-sm-6 visible-md visible-sm visible-xs">
                <h3>Nuestra empresa</h3>
                <div>
                    <input type="checkbox" class="read-more-state" id="post-2" />
                    <p class="read-more-wrap">Proporcionar soluciones a la altura de las necesidades de cada auto, <span class="read-more-target">haciendo uso de las tecnologías adecuadas, con el fin de mejorar nuestros servicios y ofrecer una mejor experiencia a nuestros clientes.
                    y se relacione entre sí facilitando el acceso a la misma.</span></p>
                    <label for="post-2" class="read-more-trigger"></label>
                </div>
            </div>
        </div>
        <div class="copyright">Copyright © 2020 Draexelmaier - Todos los derechos reservados.</div>
    </div>
</div>

</html>