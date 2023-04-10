<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Nivel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AlumnoController extends Controller
{
    /**
     * Mostrar una lista del recurso.
     */
    public function index()
    {
        $alumnos = Alumno::all();
        return view('alumnos.index', ['alumnos'=> $alumnos]); //[] le pasamos los datos con el nombre 'alunos' y el valor $alumnos
    }

    /**
     * Muestra el formulario para crear un nuevo recurso
     */
    public function create()
    {
        $niveles= Nivel::all();  //llamamos al modelo
        return view('alumnos.create', ['niveles'=> Nivel::all()]); //[];los enviamos a la vista, se va a llamar 'niveles => le vamos a enviar $niveles o el llamado Nivel::all
    }

    /**
     *Almacene un recurso recién creado en el almacenamiento.
     */
    public function store(Request $request)
    {
       $request->validate([
        'matricula'=> 'required|unique:alumnos|max:10',
        'nombre'=>'required|max:255',
        'fecha'=>'required|date',
        'telefono'=>'required',
        'email'=>'nullable|email',
        'nivel'=>'required'
       ]);

       $alumno = new Alumno();
       $alumno->matricula = $request->input('matricula');
       $alumno->nombre = $request->input('nombre');
       $alumno->fecha_nacimiento = $request->input('fecha');
       $alumno->telefono = $request->input('telefono');
       $alumno->email = $request->input('email');
       $alumno->nivel_id = $request->input('nivel');
       $alumno->save();

       return view("alumnos.message", ['msg'=>"registro guardado"]);

    }

    /**
     * Muestra el recurso especificado
     */
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Muestra el formulario para editar el recurso especificado.
     */
    public function edit($id) //necesito que reciba el objeto id
    {
      
$alumno= Alumno::find($id);
return view('alumnos.edit', ['alumno'=>$alumno, 'niveles'=>Nivel::all()]); //[] lepasamos los datos 'alumno'=>$alumno mediante una variable y  'niveles'=>Nivel::all() llama al metodo

    }

    /**
     * Actualizar el recurso especificado en el almacenamiento.
     */
    public function update(Request $request, $id) //se puede recibir Alumno $alumno o el $id
    {
        $request->validate([
            'matricula'=> 'required|max:10|unique:alumnos,matricula,'. $id,//este campo es unico pero si el id corresponde a este campo omita esa validacion, porque el dato de matricula le corresponde a este egistro
            'nombre'=>'required|max:255',
            'fecha'=>'required|date',
            'telefono'=>'required',
            'email'=>'nullable|email',
            'nivel'=>'required'
           ]);
    
           $alumno = Alumno::find($id); //Alumno::find($id)actualiza el registro y no lo inserta
           $alumno->matricula = $request->input('matricula');
           $alumno->nombre = $request->input('nombre');
           $alumno->fecha_nacimiento = $request->input('fecha');
           $alumno->telefono = $request->input('telefono');
           $alumno->email = $request->input('email');
           $alumno->nivel_id = $request->input('nivel');
           $alumno->save();

           return view("alumnos.message", ['msg'=>"registro guardado"]);
    }

    /**
     * Elimina el recurso especificado del almacenamiento.
     */
    public function destroy($id)
    {
       $alumno =Alumno::find($id); //va a buscar el id
       $alumno->delete(); //cuando lo encuentra lo elimina

       return redirect("alumnos");
    }
}
