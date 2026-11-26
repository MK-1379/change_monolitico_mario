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
                ->paginate(4);

            $categorias = Categoria::orderBy('nombre')->get();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('peticiones.index', compact('peticiones', 'categorias'));
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
                ->paginate(4);
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
                ->paginate(4);
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
            'files' => 'required|array|min:1',
            'files.*' => 'image|max:5120',
        ], [
            'required' => 'Este campo es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'category.exists' => 'La categoría elegida no existe.',
            'files.required' => 'Tienes que subir al menos una imagen.',
            'files.*.image' => 'Todos los archivos tienen que ser imágenes.',
            'files.*.max' => 'Cada imagen puede ocupar como máximo 5 MB.',
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

    public function fileUpload(Request $request, $peticione_id)
    {
        $files = $request->file('files');

        if (!$files) {
            return false;
        }

        foreach ($files as $indice => $file) {
            $filename = time() . '_' . $indice . '_' . $file->getClientOriginalName();
            $file->move(public_path('peticiones'), $filename);

            $fileModel = new File();
            $fileModel->peticione_id = $peticione_id;
            $fileModel->name = $filename;
            $fileModel->file_path = 'peticiones/' . $filename;

            if (!$fileModel->save()) {
                return false;
            }
        }

        return true;
    }

    public function edit(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);

            if ($peticion->user_id != Auth::id()) {
                return redirect()->route('peticiones.show', $id)->withError('Solo puedes editar tus propias peticiones.');
            }

            $categorias = Categoria::orderBy('nombre')->get();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return view('peticiones.edit', compact('peticion', 'categorias'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'destinatario' => 'required',
            'category' => 'required|exists:categorias,id',
            'files' => 'nullable|array',
            'files.*' => 'image|max:5120',
            'eliminar' => 'nullable|array',
            'eliminar.*' => 'integer',
        ], [
            'required' => 'Este campo es obligatorio.',
            'titulo.max' => 'El título no puede tener más de 255 caracteres.',
            'category.exists' => 'La categoría elegida no existe.',
            'files.*.image' => 'Todos los archivos tienen que ser imágenes.',
            'files.*.max' => 'Cada imagen puede ocupar como máximo 5 MB.',
        ]);

        try {
            $peticion = Peticione::findOrFail($id);

            if ($peticion->user_id != Auth::id()) {
                return redirect()->route('peticiones.show', $id)->withError('Solo puedes editar tus propias peticiones.');
            }

            $aBorrar = $peticion->files()->whereIn('id', $request->input('eliminar', []))->get();
            $nuevas = count($request->file('files', []));

            if ($peticion->files()->count() - $aBorrar->count() + $nuevas < 1) {
                return back()->withError('La petición tiene que tener al menos una imagen.')->withInput();
            }

            $categoria = Categoria::findOrFail($request->input('category'));

            $peticion->fill($request->only(['titulo', 'descripcion', 'destinatario']));
            $peticion->categoria()->associate($categoria);
            $peticion->save();

            foreach ($aBorrar as $file) {
                $this->borrarArchivo($file);
            }

            if ($nuevas > 0) {
                $this->fileUpload($request, $peticion->id);
            }
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }

        return redirect()->route('peticiones.show', $id)->with('success', 'Petición actualizada.');
    }

    public function delete(Request $request, $id)
    {
        try {
            $peticion = Peticione::findOrFail($id);

            if ($peticion->user_id != Auth::id()) {
                return redirect()->route('peticiones.show', $id)->withError('Solo puedes eliminar tus propias peticiones.');
            }

            if ($peticion->firmas()->exists()) {
                return back()->withError('No se puede eliminar una petición que ya tiene firmas.');
            }

            foreach ($peticion->files as $file) {
                $this->borrarArchivo($file);
            }
            $peticion->delete();
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage());
        }

        return redirect()->route('peticiones.mine')->with('success', 'Petición eliminada.');
    }

    private function borrarArchivo(File $file)
    {
        $ruta = public_path($file->file_path);
        if (file_exists($ruta)) {
            unlink($ruta);
        }
        $file->delete();
    }
}
