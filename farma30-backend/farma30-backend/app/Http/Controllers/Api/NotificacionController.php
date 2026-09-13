<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificacionResource;
use App\Models\Notificacion;
use Illuminate\Http\Request;

/** RF09, RF11, RF12 — Notificaciones. */
class NotificacionController extends Controller
{
    public function porTipo(string $tipo)
    {
        $notificaciones = Notificacion::where('tipo', $tipo)->orderByDesc('created_at')->get();

        return NotificacionResource::collection($notificaciones);
    }

    public function marcarLeida(Notificacion $notificacion)
    {
        $notificacion->update(['leida' => true]);

        return new NotificacionResource($notificacion);
    }
}
