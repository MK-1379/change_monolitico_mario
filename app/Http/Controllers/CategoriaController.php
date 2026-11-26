<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function peticiones(Request $request, $id)
    {
        try {
            $categoria = Categoria::findOrFail($id);

            $peticiones = $categoria->peticiones()
                ->where('estado', 'aceptada')
                ->orderBy('created_at', 'desc')
                ->paginate(4);

            $categorias = Categoria::orderBy('nombre')->get();
        } catch (\Exception $exception) {
            return back()->withError('La categoría que buscas no existe.');
        }

        $titulo = 'Peticiones de ' . $categoria->nombre;
        $categoriaActual = $categoria->id;

        return view('peticiones.index', compact('peticiones', 'titulo', 'categorias', 'categoriaActual'));
    }
}
