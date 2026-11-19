<?php

namespace App\Http\Controllers;

use App\Models\Peticione;
use Illuminate\Http\Request;

class PeticioneController extends Controller
{
    public function index()
    {
        $peticiones = Peticione::all();
        return view('peticiones.index', compact('peticiones'));
    }

    public function show($id)
    {
        $peticion = Peticione::findOrFail($id);
        return view('peticiones.show', compact('peticion'));
    }
}
