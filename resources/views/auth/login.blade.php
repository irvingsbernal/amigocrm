@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4" style="border-top-left-radius: 15px;border-bottom-left-radius: 15px;">
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          {{ csrf_field() }}
              <div class="card-body">
              <h1>Login</h1>
              <p class="text-muted">Control de acceso a AMI.GO</p>
              <div class="form-group mb-3{{$errors->has('correo' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('correo')}}" name="correo" id="correo" class="form-control" placeholder="ejemplo@ejemplo.com">
                {!!$errors->first('correo','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-4 text-center">
                  <button type="submit" class="btn btn-primary px-4">Ingresar</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-white bg-secondary d-md-down-none" style="width:44%; background-image: url('img/taller2.jpg'); border-color: #c2cfd6;border-bottom-right-radius: 15px; border-top-right-radius: 15px;">
            <div class="card-body text-center" style="background: #152560c4; padding-top: 4.5rem; border-bottom-right-radius: 15px; border-top-right-radius: 15px;">
              <div>
                <h2>AMI.GO: una herramienta de gestión de Écrou Hexagonal</h2>
              <p><b>A</b>dvanced <b>M</b>echanical <b>I</b>mporve... <b>¡Go!</b></p>
              <a href="/#citas" target="_blank" class="btn btn-warning active mt-3">Quiero saber más</a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection