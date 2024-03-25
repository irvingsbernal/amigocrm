{{--  <!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema Ventas Laravel Vue Js- IncanatoIT">
  <meta name="author" content="Incanatoit.com">
  <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">

  <title>Registro - Écrou Hexagonal</title>

  <link href="css/plantilla.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card-group mb-0">
            <div class="card p-4">
              <form class="form-horizontal was-validated" method="POST">
            {{ csrf_field() }}
                <div class="card-body">
                <h1>Registro</h1>
                <p class="text-muted">Control de acceso al sistema</p>
                <div class="form-group mb-4{{$errors->has('nombre' ? 'is-invalid' : '')}}">
                    <span class="input-group-addon"><i class="icon-people"></i></span>
                    <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Nombre/s">
                    {!!$errors->first('nombre','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('apellidopaterno' ? 'is-invalid' : '')}}">
                    <span class="input-group-addon"><i class="icon-people"></i></span>
                    <input type="text" name="apellidopaterno" id="apellidopaterno" class="form-control" placeholder="Apellido paterno">
                    {!!$errors->first('apellidopaterno','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('apellidomaterno' ? 'is-invalid' : '')}}">
                    <span class="input-group-addon"><i class="icon-people"></i></span>
                    <input type="text" name="apellidomaterno" id="apellidomaterno" class="form-control" placeholder="Apellido materno">
                    {!!$errors->first('apellidomaterno','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('telefono' ? 'is-invalid' : '')}}">
                    <span class="input-group-addon"><i class="icon-phone"></i></span>
                    <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Teléfono">
                    {!!$errors->first('telefono','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('correo' ? 'is-invalid' : '')}}">
                    <span class="input-group-addon"><i class="icon-envelope-letter"></i></span>
                    <input type="email" name="correo" id="correo" class="form-control" placeholder="Correo">
                    {!!$errors->first('correo','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="form-group mb-4{{$errors->has('contrasenia' ? 'is-invalid' : '')}}">
                  <span class="input-group-addon"><i class="icon-lock"></i></span>
                  <input type="password" name="contrasenia" id="contrasenia" class="form-control" placeholder="Contrasenia">
                  {!!$errors->first('contrasenia','<span class="invalid-feedback">:message</span>')!!}
                </div>
                <div class="row">
                  <div class="col-6">
                    <button type="submit" class="btn btn-primary px-4">Acceder</button>
                  </div>
                </div>
              </div>
            </form>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <h2>Sistema de Ventas IncanatoIT</h2>
                  <p>Sistema de compras, Ventas desarrollado en PHP utilizando el Framework Laravel y Vue Js, con el gestor de base de datos MariaDB.</p>
                  <a href="https://www.udemy.com/user/juan-carlos-arcila-diaz/" target="_blank" class="btn btn-primary active mt-3">Ver el curso!</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

  <script src="js/plantilla.js"></script>

</body>
</html>  --}}

<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema de gestión de taller mecánico">
  <meta name="author" content="Écrou Hexagonal">
  <meta name="keyword" content="Amigo CRM">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Ami.go CRM</title>
  <link href="css/plantilla.css" rel="stylesheet">

</head>

<body class="app flex-row align-items-center">
  <div class="container" id="app">
    <registro></registro>
  </div>
  <script src="js/app.js"></script>
  <script src="js/plantilla.js"></script>

</body>
</html>