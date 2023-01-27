@extends('layouts.app') 
    @section('content')
        <div class="container">
            <form action="{{url('/alumno/'.$alumno->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                {{method_field('PATCH')}}
                @include('alumno.form',['modo'=>'Editar']) 
            </form>
        </div>
    @endsection