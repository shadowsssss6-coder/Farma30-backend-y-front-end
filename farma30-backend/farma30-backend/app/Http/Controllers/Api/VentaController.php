<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrarVentaRequest;
use App\Http\Resources\VentaResource;
use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controlador de Ventas (RF03, RF06, RF08). Corresponde al componente
 * Ventas, que depende de Producto para validar existencia (CU02).
 */
class VentaController extends Controller
{
    /** RF06 — registrar venta, descontando inventario en una transacción. */
    public function registrar(RegistrarVentaRequest $request)
    {
        $venta = DB::transaction(function () use ($request) {
            $producto = Producto::lockForUpdate()->findOrFail($request->producto_id);

            if ($producto->cantidad < $request->cantidad_vendida) {
                abort(422, 'La cantidad solicitada supera la existencia disponible.');
            }

            $producto->decrement('cantidad', $request->cantidad_vendida);

            return Venta::create([
                'producto_id' => $producto->id,
                'integrante_id' => $request->user()->id,
                'valor_de_la_venta' => $request->valor_de_la_venta,
                'cantidad_vendida' => $request->cantidad_vendida,
                'metodo_de_pago' => $request->metodo_de_pago,
            ]);
        });

        return new VentaResource($venta->load('producto'));
    }

    /** RF03 — resumen de ventas por día, semana o mes. */
    public function resumen()
    {
        $hoy = now();

        return response()->json([
            'cantidad_vendida_en_el_dia' => Venta::whereDate('fecha_hora', $hoy->toDateString())->sum('cantidad_vendida'),
            'cantidad_vendida_en_la_semana' => Venta::whereBetween('fecha_hora', [$hoy->copy()->startOfWeek(), $hoy->copy()->endOfWeek()])->sum('cantidad_vendida'),
            'cantidad_vendida_en_el_mes' => Venta::whereMonth('fecha_hora', $hoy->month)->sum('cantidad_vendida'),
        ]);
    }

    /** RF08 — detalle de una venta. */
    public function show(Venta $venta)
    {
        return new VentaResource($venta->load('producto'));
    }
}
