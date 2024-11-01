<?php

namespace App\Http\Controllers;

use App\Models\Farmacia; // Asegúrate de que el nombre del modelo esté en singular y en mayúscula
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FarmaciasControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $farmacias = $this->mostrarFarmacia();

        // Verifica si se encontraron farmacias
        if (is_null($farmacias)) {
            return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
        }

        return view('admin/farmacia/farmacias', compact('farmacias')); // Pasa la variable a la vista
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/farmacia.create'); // Asegúrate de tener una vista para crear farmacias
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'rif' => 'required|string|max:15',
            'descripcion' => 'required|string',
            'imagen' => 'required|max:10000|mimes:jpeg,png,jpg', // Cambiado a 'imagen'
        ]);

        $datosFarmacias = $request->except('_token');

        // Ruta del directorio donde se almacenará la imagen
        $storagePath = storage_path('app/public/farmacia');

        // Verificar si la carpeta 'farmacia' no existe, y crearla
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true); // Crear el directorio con permisos adecuados
        }

        // Manejar la subida de la imagen
        if ($request->hasFile('imagen')) {
            $datosFarmacias['imagen'] = $request->file('imagen')->store('farmacia', 'public');
        }

        // Guardar los datos en la base de datos
        Farmacia::create($datosFarmacias);

        return redirect('admin/farmacia/farmacias')->with('success', 'Farmacia creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Farmacia $farmacias)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $farmacias = Farmacia::findOrFail($id);

        return view('/admin/farmacia/edit', compact('farmacias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar la solicitud
        $validatedData = $request->validate([
            'nombre_razon_social' => 'required|string|max:100',
            'rif' => 'required|string|max:15',
            'descripcion' => 'required|string', // Asegúrate de que esto esté bien definido
            'imagen' => 'nullable|max:10000|mimes:jpeg,png,jpg', // Imagen opcional
        ]);

        // Obtener la farmacia actual
        $farmacia = Farmacia::findOrFail($id);

        // Ruta del directorio donde se almacenará la imagen
        $storagePath = storage_path('app/public/farmacia');

        // Verificar si la carpeta 'farmacia' no existe, y crearla
        if (!File::exists($storagePath)) {
            File::makeDirectory($storagePath, 0755, true); // Crear el directorio con permisos adecuados
        }

        // Manejar la subida de la nueva imagen si se proporciona
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($farmacia->imagen) {
                Storage::delete('public/' . $farmacia->imagen);
            }

            // Almacenar la nueva imagen
            $validatedData['imagen'] = $request->file('imagen')->store('farmacia', 'public');
        }

        // Actualizar los datos de la farmacia
        $farmacia->update($validatedData); // Asegúrate de que 'descripcion' esté en $validatedData

        return redirect('admin/farmacia/farmacias')->with('Mensaje', 'Farmacia actualizada con éxito');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Farmacia $farmacias)
    {
        //
    }
    public function mostrarFarmacia()
    {
        $usuario = auth()->user();
        $farmacia = $usuario->farmacias()->first();

        if (!$farmacia) {
            // Retorna null o lanza una excepción si no hay farmacia
            return null;
        }

        // Obtiene las farmacias asociadas
        return Farmacia::where('id_farmacia', $farmacia->id_farmacia)->get();
    }
}
