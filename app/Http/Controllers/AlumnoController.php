<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AlumnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $texto=trim($request->get('texto'));
        if (empty($texto)) {
            $alumnos = Alumno::orderBy('id', 'asc')
                             ->paginate(3); 
        } else {
            $alumnos = Alumno::select('id', 'nombre', 'apellido', 'correo','foto')
                             ->where('nombre', 'LIKE', '%'.$texto.'%')
                             ->orWhere('apellido', 'LIKE', '%'.$texto.'%')
                             ->orWhere('id', 'LIKE', '%'.$texto.'%')
                             ->orWhere('correo', 'LIKE', '%'.$texto.'%')
                             ->orderBy('nombre', 'asc')
                             ->paginate(3);
        }
        return view('alumno.index', compact('alumnos', 'texto')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('alumno.create'); 
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $campos=[ 
            'nombre'=>'required|string|max:100',
            'apellido'=>'required|string|max:100',
            'correo'=>'required|email',
            'foto'=>'required|max:10000|mimes:jpeg,png,jpg',
        ];
        $mensaje=[ 
            'required'=>'El :attribute es requerido',
            'foto.required'=>'La foto es requerida', 

        ]; 
        $this->validate($request, $campos, $mensaje);   
        $datosAlumno = request()->except('_token'); 

    if($request->hasFile('foto')) { 
        $datosAlumno['foto']=$request->file('foto')->store('uploads','public'); 
    }
        Alumno::insert($datosAlumno); 
        return redirect('alumno')->with('mensaje','Alumno agregado con éxito'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alumno=Alumno::findOrFail($id);
        return view('alumno.edit', compact('alumno')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $campos=[ 
            'nombre'=>'required|string|max:100',
            'apellido'=>'required|string|max:100',
            'correo'=>'required|email',
        ];
        $mensaje=[ 
            'required'=>'El :attribute es requerido',
            
        ]; 
        
        if($request->hasFile('foto')) {
            $campos=['foto'=>'required|max:10000|mimes:jpeg,png,jpg'];
            $mensaje=['foto.required'=>'La foto es requerida']; 
        }
        
        $this->validate($request, $campos, $mensaje);   
        $datosAlumno = request()->except(['_token','_method']); 
        
        if($request->hasFile('foto')) { 
            $alumno=Alumno::findOrFail($id); 
            Storage::delete('public/'.$alumno->foto); 
            $datosAlumno['foto']=$request->file('foto')->store('uploads','public'); 
        }
        
        Alumno::where('id','=',$id)->update($datosAlumno); 
        $alumno=Alumno::findOrFail($id); 
        return redirect('alumno')->with('mensaje','Alumno modificado con éxito'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alumno  $alumno
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alumno=Alumno::findOrFail($id); 
        if(Storage::delete('public/'.$alumno->foto)){ 
            Alumno::destroy($id); 
        }
        return redirect('alumno')->with('mensaje','Alumno borrado con éxito'); 
    }
}