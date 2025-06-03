<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;

class FrontClasesController extends Controller
{
    /**METODO PARA LA VISTA DE CREACION
     * Este servira para mostrar la vista del formulario de creacion de clase
     */
    public function create()
    {
        // Almacenar a los profes que ya tienen clase, para la seleccion mas tarde.
        $profesoresConClase = Clase::pluck('profe_id')->toArray();

        $profesores = User::where('rol', 'profe')
            ->whereNotIn('id', $profesoresConClase)->get();
        $clase = null;

        return view('ClaseForm', compact('profesores', 'clase'));
    }

    /** METODO PARA ALMACENAR CLASES
     * Este metodo "store" servira para almacenar clases.
     */
    public function store(Request $request)
    {
        $datosValidar = $request->validate([
            'nombre' => 'required|string|unique:classes',
            'tipo' => 'required|in:arabe,religion',
            'nivel' => 'required|string|max:255',
            'profe_id' => 'required|string|unique:classes',
        ]);

        $clase = new Clase();
        $clase->nombre = $datosValidar['nombre'];
        $clase->tipo = $datosValidar['tipo'];
        $clase->nivel = $datosValidar['nivel'];
        $clase->profe_id = $datosValidar['profe_id'];
        $clase->imagen_horario = '/images/horario.png'; // De momento, por defecto

        $clase->save();

        return redirect()->route('classes')->with('success', 'Clase creada correctamente.');
    }

    /** METODO PARA LA VISTA DE EDICION */
    public function edit($id)
    {
        $clase = Clase::findOrFail($id);
        $profesores = User::where('rol', 'profe')->get();

        return view('ClaseForm', compact('clase', 'profesores'));
    }


    /** METODO PARA EDITAR CLASES
     * Este metodo "update" servira para editar clases.
     * Se usa el ID de la clase para encontrarlo en la BD.
     */
    public function update(Request $request, string $id)
    {
        $clase = Clase::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255|unique:classes,nombre,' . $id, // Al poner este id, se puede excluir
            'tipo' => 'required|in:arabe,religion',
            'nivel' => 'required|string|max:255',
            'profe_id' => 'required||unique:classes,profe_id,' . $id,
        ]);

        $clase->nombre = $request->nombre;
        $clase->tipo = $request->tipo;
        $clase->nivel = $request->nivel;
        $clase->profe_id = $request->profe_id;

        $clase->save();

        return redirect()->route('classes')->with('success', 'Clase actualizada correctamente.');
    }

    /** METODO PARA ELIMINAR CLASES
     * Este metodo "destroy" servirá para eliminar ciertas clases.
     * Se usa el ID de la clase para encontrarla en la BD.
     * Se usa un "try-catch" para otros errores que ocurran en el proceso.
     */
    public function destroy($id)
    {
        try {
            $clase = Clase::findOrFail($id);

            $clase->delete();
            return redirect()->route('classes')->with('success', 'La clase ha sido eliminada correctamente.');
        } catch (\Illuminate\Database\QueryException $error) {
            return redirect()->back()->with('error', 'Hubo un error en la base de datos...');
        } catch (\Exception $error) {
            return redirect()->back()->with('error', 'Hubo un error inesperado...');
        }
    }
}
