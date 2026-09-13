<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarritoItemResource;
use App\Http\Resources\HistorialCompraResource;
use App\Models\CarritoItem;
use App\Models\HistorialCompra;
use Illuminate\Http\Request;

class HistorialComprasController extends Controller
{
    public function index(Request $request)
    {
        $historial = HistorialCompra::where('user_id', $request->user()->id)
            ->orderByDesc('fecha_de_compra')
            ->get();

        return HistorialCompraResource::collection($historial);
    }

    /** borrar_historial() del diagrama de clases. */
    public function borrar(Request $request)
    {
        HistorialCompra::where('user_id', $request->user()->id)->delete();

        return response()->json(['mensaje' => 'Historial borrado.']);
    }

    /** volver_a_comprar() — agrega de nuevo el producto al carrito. */
    public function volverAComprar(Request $request, HistorialCompra $historialCompra)
    {
        abort_if($historialCompra->user_id !== $request->user()->id, 403);

        $item = CarritoItem::create([
            'user_id' => $request->user()->id,
            'producto_id' => $historialCompra->producto_id,
            'cantidad_deseada' => 1,
            'dia_de_adiccion' => now()->toDateString(),
        ]);

        return new CarritoItemResource($item->load('producto'));
    }
}
