<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarritoController;
use App\Http\Controllers\Api\HistorialComprasController;
use App\Http\Controllers\Api\InfoGeneralController;
use App\Http\Controllers\Api\NotificacionController;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\VentaController;
use Illuminate\Support\Facades\Route;

// --- Autenticación (RF01, RF14) — rutas públicas ---
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/registro', [AuthController::class, 'registrar']);
Route::post('/auth/recuperar-clave', [AuthController::class, 'recuperarClave']);

// --- Rutas protegidas: requieren token Sanctum válido ---
Route::middleware('auth:sanctum')->group(function () {

    // Perfil / sesión (RF15)
    Route::put('/usuarios/actualizar', [AuthController::class, 'actualizarPerfil']);
    Route::post('/auth/logout', [AuthController::class, 'cerrarSesion']);

    // Catálogo (RF02, RF04, RF05, RF10) — lectura abierta a cualquier usuario autenticado
    Route::get('/productos', [ProductoController::class, 'index']);
    Route::get('/productos/buscar', [ProductoController::class, 'buscar']);
    Route::get('/productos/codigo/{codigo}', [ProductoController::class, 'porCodigoBarras']);
    Route::get('/productos/{producto}', [ProductoController::class, 'show']);

    // Gestión de inventario (RF04, RF07) — la Policy exige rol integrante o administrador
    Route::post('/productos', [ProductoController::class, 'crear']);
    Route::patch('/productos/{producto}', [ProductoController::class, 'actualizar']);
    Route::delete('/productos/{producto}', [ProductoController::class, 'eliminar']);
    Route::get('/productos-alertas-vencimiento', [ProductoController::class, 'alertasVencimiento']);

    // Ventas (RF03, RF06, RF08) — el propio Request exige rol integrante
    Route::get('/ventas/resumen', [VentaController::class, 'resumen']);
    Route::post('/ventas', [VentaController::class, 'registrar']);
    Route::get('/ventas/{venta}', [VentaController::class, 'show']);

    // Compras cliente — carrito
    Route::get('/carrito', [CarritoController::class, 'index']);
    Route::post('/carrito', [CarritoController::class, 'agregar']);
    Route::patch('/carrito/{carritoItem}', [CarritoController::class, 'editarCantidad']);
    Route::delete('/carrito/{carritoItem}', [CarritoController::class, 'eliminar']);

    // Compras cliente — historial
    Route::get('/historial-compras', [HistorialComprasController::class, 'index']);
    Route::delete('/historial-compras', [HistorialComprasController::class, 'borrar']);
    Route::post('/historial-compras/{historialCompra}/volver-a-comprar', [HistorialComprasController::class, 'volverAComprar']);

    // Notificaciones (RF09, RF11, RF12)
    Route::get('/notificaciones/{tipo}', [NotificacionController::class, 'porTipo']);
    Route::patch('/notificaciones/{notificacion}/leida', [NotificacionController::class, 'marcarLeida']);

    // Info General (RF13)
    Route::get('/info-general/horarios', [InfoGeneralController::class, 'horarios']);
});
