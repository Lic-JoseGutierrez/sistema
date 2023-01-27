@extends('layouts.app') 
@section('content')
    <div class="container">
    
        @if(Session::has('mensaje')) 
            <div class="alert alert-success alert-dismissible" role="alert">
                {{Session::get('mensaje')}} 
            </div>
        @endif
        
        <nav class="flex justify-content: between navbar">    
                    <a href="{{url ('alumno/create')}}" class="btn btn-success">Registrar nuevo alumno</a> 
                
                    <form class="d-flex" role="search" action="{{route('alumno.index')}}" method="GET">
                        <div class="px-1">
                            <input type="text" class="form-control" name="texto" value="{{$texto}}">
                        </div>
                        
                        <div>
                            <input type="submit" class="btn btn-primary" value="Buscar">
                        </div>            
                    </form>
        </nav>    
        <hr>
        <table class="table table-light">

            <thead class="thead-light"> 
                <tr>
                    <th>#</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
        
            <tbody> 
                
                @if(count($alumnos)<=0)
                    <tr>
                        <td colspan="6" class="text-bg-info p-3">No hay resultados</td>
                    </tr>    
                @else
                    
                    @foreach ($alumnos as $alumno) 
                                
                        <tr>
                            <td>{{$alumno->id}}</td> 

                            <td>
                                <img class="img-thumbnail img-fluid" src="{{asset('storage').'/'.$alumno->foto}}" width="100" alt=""> 
                        
                            </td>

                            <td>{{$alumno->nombre}}</td>
                            <td>{{$alumno->apellido}}</td>
                            <td>{{$alumno->correo}}</td>
                            <td>
                                <a href="{{url('/alumno/'.$alumno->id.'/edit')}}" class="btn btn-warning"> 
                                    Editar
                                </a>
                                <form action="{{url('alumno/'.$alumno->id)}}" class="d-inline" method="post"> 
                                    @csrf     
                                    {{method_field('DELETE')}} 
                                    <input class="btn btn-danger" type="submit" onclick="return confirm('¿Desea borrar el alumno?')" value="Borrar"> 
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        {!! $alumnos->links() !!} 
    </div>
@endsection