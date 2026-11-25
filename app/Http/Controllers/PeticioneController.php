<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\File;
use App\Models\Peticione;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;

class PeticioneController extends Controller implements HasMiddleware
{
    // Todas las acciones necesitan sesión iniciada menos el listado y el detalle
    public static function middleware(): array
    {
        return [
            new Middleware('auth', except: ['index', 'show']),
        ];
    }

    public function index(Request $request)
    {
        try {
            $peticiones = Peticione::where('estado', 'aceptada')
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('peticiones.index', compact('peticiones'));
    }

    public function show(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
        } catch (\Exception $exception) {
            return back()->withError('La petición que buscas no existe.');
        }

        return view('peticiones.show', compact('peticion'));
    }

    public function listMine(Request $request)
    {
        try {
            $peticiones = Peticione::where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(5);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        $titulo = 'Mis peticiones';

        return view('peticiones.index', compact('peticiones', 'titulo'));
    }

    public function peticionesFirmadas(Request $request)
    {
        try {
            $peticiones = Auth::user()->firmas()
                ->orderBy('peticiones.created_at', 'desc')
                ->paginate(5);
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        $titulo = 'Peticiones que he firmado';

        return view('peticiones.index', compact('peticiones', 'titulo'));
    }

    public function firmar(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);
            $user = Auth::user();

            if ($peticion->firmas()->where('peticione_user.user_id', $user->id)->exists()) {
                return back()->withError('Ya has firmado esta petición.');
            }

            $peticion->firmas()->attach($user->id);
            $peticion->firmantes = $peticion->firmantes + 1;
            $peticion->save();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return back()->with('success', 'Has firmado la petición. ¡Gracias!');
    }

    public function create(Request $request)
    {
        try {
            $categorias = Categoria::orderBy('nombre')->get();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('peticiones.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'category' => 'required|exists:categorias,id',
            'file' => 'required|image|max:5120',
        ], [
            'required' => 'Este campo es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'category.exists' => 'La categoría elegida no existe.',
            'file.required' => 'Tienes que subir una imagen.',
            'file.image' => 'El archivo tiene que ser una imagen.',
            'file.max' => 'La imagen no puede ocupar más de 5 MB.',
        ]);

        try {
            $categoria = Categoria::findOrFail($request->input('category'));

            $peticion = new Peticione($request->only(['titulo', 'descripcion', 'destinatario']));
            $peticion->categoria()->associate($categoria);
            $peticion->user()->associate(Auth::user());
            $peticion->firmantes = 0;
            $peticion->estado = 'pendiente';

            if ($peticion->save() && $this->fileUpload($request, $peticion->id)) {
                return redirect()->route('peticiones.mine')->with('success', 'Petición creada. Aparecerá en el listado público cuando sea aceptada.');
            }

            return back()->withError('Error creando la petición.')->withInput();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }

    // Guarda la imagen en public/peticiones y su nombre en la tabla files
    public function fileUpload(Request $request, $peticione_id)
    {
        $file = $request->file('file');

        if (!$file) {
            return false;
        }

        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('peticiones'), $filename);

        $fileModel = new File();
        $fileModel->peticione_id = $peticione_id;
        $fileModel->name = $filename;
        $fileModel->file_path = 'peticiones/' . $filename;

        return $fileModel->save();
    }
}
