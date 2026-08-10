<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HorarioResource;
use App\Models\Horario;

/** RF13 — Info General (horarios). */
class InfoGeneralController extends Controller
{
    private const ORDEN_DIAS = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

    public function horarios()
    {
        $horarios = Horario::all()->sortBy(
            fn (Horario $h) => array_search($h->dia_semana, self::ORDEN_DIAS)
        )->values();

        return HorarioResource::collection($horarios);
    }
}
