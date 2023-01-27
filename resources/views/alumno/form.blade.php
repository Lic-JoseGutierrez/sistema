<h1> {{$modo}} alumno </h1> 
@if (count($errors)>0) 
    <div class="alert alert-danger" role="alert">
        <ul>    
            @foreach ($errors->all() as $error) 
                <li>{{$error}}</li> 
            @endforeach
        </ul>
    </div>
@endif
<div class="form-group">
    <label for="nombre">Nombre</label> 
    <input type="text" class="form-control" name="nombre" value="{{isset($alumno->nombre)?$alumno->nombre:old('nombre')}}" id="nombre"> 
</div>

<div class="form-group">
    <label for="apellido">Apellido</label>
    <input type="text" class="form-control" name="apellido" value="{{isset($alumno->apellido)?$alumno->apellido:old('apellido')}}" id="apellido">
</div>

<div class="form-group">
    <label for="correo">Correo</label>
    <input type="text" class="form-control" name="correo" value="{{isset($alumno->correo)?$alumno->correo:old('correo')}}" id="correo">
</div>

<div class="form-group">
    <label for="foto"></label>
    @if(isset($alumno->foto))
        <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$alumno->foto}}" width="100" alt=""> 
    @endif
    <input type="file" class="form-control" name="foto" value="" id="foto">
</div>

<br/>

<input class="btn btn-success" type="submit" value="{{$modo}} alumno"> 
<a class="btn btn-primary" href="{{url ('alumno/')}}">Regresar</a> 

<br>