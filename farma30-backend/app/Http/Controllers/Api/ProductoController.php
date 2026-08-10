<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ActualizarProductoRequest;
use App\Http\Requests\CrearProductoRequest;
use App\Http\Resources\ProductoResource;
use App\Models\Producto;
use Illuminate\Http\Request;

/**
 * Controlador de Catálogo / Gestión de inventario (RF02, RF04, RF07, RF10).
 * Corresponde al componente Producto del diagrama de componentes.
 */
class ProductoController extends Controller
{
    public function index()
    {
        return ProductoResource::collection(Producto::all());
    }

    public function show(Producto $producto)
    {
        return new ProductoResource($producto);
    }

    public function buscar(Request $request)
    {
        $texto = $request->query('q', '');
        $productos = Producto::where('nombre', 'like', "%{$texto}%")->get();

        return ProductoResource::collection($productos);
    }

    public function porCodigoBarras(string $codigo)
    {
        $producto = Producto::where('codigo_barras', $codigo)->firstOrFail();

        return new ProductoResource($producto);
    }

    /** RF04 — alta de producto nuevo en el catálogo. Solo integrante/administrador. */
    public function crear(CrearProductoRequest $request)
    {
        $datos = $request->validated();
        $datos['fecha_de_ingreso'] ??= now()->toDateString();
        $datos['estado_de_disponibilidad'] ??= true;

        $producto = Producto::create($datos);

        return (new ProductoResource($producto))
            ->response()
            ->setStatusCode(201);
    }

    /** RF04 — cambio_de_info_de_un_producto(). */
    public function actualizar(ActualizarProductoRequest $request, Producto $producto)
    {
        $this->authorize('actualizar', $producto);
        $producto->update($request->validated());

        return new ProductoResource($producto);
    }

    /** RF04 — eliminar_producto_del_catalogo(); regla: no eliminar con existencia > 0. */
    public function eliminar(Request $request, Producto $producto)
    {
        $this->authorize('eliminar', $producto);

        if ($producto->cantidad > 0) {
            return response()->json([
                'mensaje' => 'No es posible eliminar un producto con existencias disponibles.',
            ], 422);
        }

        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado.']);
    }

    /** RF07 — alertas de vencimiento. */
    public function alertasVencimiento()
    {
        $productos = Producto::all()->filter(
            fn (Producto $p) => $p->estaVencido() || $p->estaProximoAVencer()
        )->values();

        return ProductoResource::collection($productos);
    }
}
