<?php

namespace App\Http\Controllers;

use App\Models\Categoria;

class PagesController extends Controller
{
    public function home()
    {
        $categorias = Categoria::orderBy('nombre')->get();

        return view('pages.home', compact('categorias'));
    }

}
