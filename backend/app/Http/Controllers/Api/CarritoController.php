<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AgregarCarritoRequest;
use App\Http\Resources\CarritoItemResource;
use App\Models\CarritoItem;
use Illuminate\Http\Request;

/** Controlador de Compras cliente (RF04/RF05 — carrito). */
class CarritoController extends Controller
{
    public function index(Request $request)
    {
        $items = CarritoItem::with('producto')->where('user_id', $request->user()->id)->get();

        return CarritoItemResource::collection($items);
    }

    public function agregar(AgregarCarritoRequest $request)
    {
        $item = CarritoItem::create([
            'user_id' => $request->user()->id,
            'producto_id' => $request->producto_id,
            'cantidad_deseada' => $request->cantidad_deseada,
            'dia_de_adiccion' => now()->toDateString(),
        ]);

        return new CarritoItemResource($item->load('producto'));
    }

    /** editar_la_cantidad() del diagrama de clases. */
    public function editarCantidad(Request $request, CarritoItem $carritoItem)
    {
        $request->validate(['cantidad_deseada' => 'required|integer|min:1']);
        abort_if($carritoItem->user_id !== $request->user()->id, 403);

        $carritoItem->update(['cantidad_deseada' => $request->cantidad_deseada]);

        return new CarritoItemResource($carritoItem->load('producto'));
    }

    public function eliminar(Request $request, CarritoItem $carritoItem)
    {
        abort_if($carritoItem->user_id !== $request->user()->id, 403);
        $carritoItem->delete();

        return response()->json(['mensaje' => 'Producto retirado del carrito.']);
    }
}
