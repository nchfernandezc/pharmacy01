<?php

namespace App\Http\Controllers;

use App\Models\Apartado;
use App\Models\Medicamento;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class HomeControllerAdmin extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        // Verifica si el usuario está autenticado
        if (!$usuario) {
            throw new \Exception('Usuario no autenticado.');
        }

        // Obtiene la primera farmacia asociada al usuario
        $farmacia = $usuario->farmacias()->first();

        // Manejo de la ausencia de farmacia
        if (!$farmacia) {
            throw new \Exception('No se encontró ninguna farmacia asociada al usuario.');
        }

        // Contar la cantidad de usuarios en la tabla 'users'
        $userCount = User::count();

        // Contar solo los medicamentos de la farmacia asociada
        $medCount = Medicamento::where('id_farmacia', $farmacia->id_farmacia)->count();

        // Contar solo los apartados aprobados de la farmacia asociada
        $apaCount = Apartado::where('estado', 'aprobado')
            ->where('id_farmacia', $farmacia->id_farmacia)
            ->count();

        $apaCount2 = Apartado::where('estado', 'pendiente')
        ->where('id_farmacia', $farmacia->id_farmacia)
        ->count();

        // Obtener resultados para gráficos filtrados por farmacia
        $resultados = Medicamento::select('pais_fabricacion', DB::raw('count(*) as total'), DB::raw('(pais_fabricacion) as pais1'))
            ->where('id_farmacia', $farmacia->id_farmacia)
            ->groupBy('pais_fabricacion')
            ->orderBy('pais1')
            ->get();

        $resultados1 = Medicamento::select('categoria', DB::raw('count(*) as total1'), DB::raw('(categoria) as cat'))
            ->where('id_farmacia', $farmacia->id_farmacia)
            ->groupBy('categoria')
            ->orderBy('cat')
            ->get();

        // Pasar la cantidad a la vista
        return view('admin.dashboard', [
            'userCount' => $userCount,
            'medCount' => $medCount,
            'resultados' => $resultados,
            'resultados1' => $resultados1,
            'resultadosApa' => $apaCount,
            'resultadosApa2' => $apaCount2
        ]);
    }

}
