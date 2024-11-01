<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Inventario;
use App\Http\Controllers\Controller;
use App\Models\Medicamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlmacenControllerAdmin extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // En el modelo Almacen
    //

    public function index()
    {
        $Almacen = $this->mostrarApartados();

        // Verifica si se encontraron farmacias
        if (is_null($Almacen)) {
            return redirect()->back()->withErrors('Este administrador no tiene una farmacia asociada.');
        }
        return view('admin/almacen/almacen', compact('Almacen'));
    }

    public function mostrarApartados()
    {
        $usuario = auth()->user();
        $Almacen = $usuario->farmacias()->first();

        if (!$Almacen) {
            // Retorna null o lanza una excepción si no hay farmacia
            return null;
        }

        // Obtiene las farmacias asociadas
        return Inventario::where('id_farmacia', $Almacen->id_farmacia)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $farmacia = Auth::user()->farmacias->first();

        if ($farmacia) {
            $datos['Medicamentos'] = $farmacia->medicamentos;
        } else {
            $datos['Medicamentos'] = collect();
        }

        return view('admin/almacen.create', $datos);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        //
        $validatedData = $request->validate(
            [
                'id_medicamento' => 'required|integer',
                'id_farmacia' => 'required|integer',
                'numero_lote' => 'required|string',
                'fecha_vencimiento' => 'required|date',
                'cantidad_disponible' => 'required|integer',
            ],
            $mensaje = [
                "required" => 'Rellenar el campo :attribute es obligatorio.'
            ]
        );

        $datosAlmacen = request()->except('_token');


        Inventario::insert($datosAlmacen);

        return redirect('admin/almacen/almacen')->with('Mensaje', 'Producto agregado con exito');
    }


    /**
     * Display the specified resource.
     */
    public function show(Inventario $almacen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    public function edit($id)
    {
        $almacen = Inventario::where('id_inventario', $id)->firstOrFail();
        $farmacia = Auth::user()->farmacias->first();

        if ($farmacia) {
            $datos['Medicamentos'] = $farmacia->medicamentos;
        } else {
            $datos['Medicamentos'] = collect();
        }

        return view('/admin/almacen/edit', compact('almacen'), $datos);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_medicamento' => 'required|integer',
            'id_farmacia' => 'required|integer',
            'numero_lote' => 'required|string',
            'fecha_vencimiento' => 'required|date',
            'cantidad_disponible' => 'required|integer',
        ], [
            "required" => 'Rellenar el campo :attribute es obligatorio.'
        ]);
        $datosAlmacen = request()->except(['_token', '_method']);
        $inventario = Inventario::findOrFail($id);
        $inventario->update($datosAlmacen);

        return redirect()->route('almacen.index')->with('Mensaje', 'Producto modificado con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventario $almacen, $id) {}
}
