import api from "./api";

export async function obtenerCarrito() {
  const { data } = await api.get("/carrito");
  return data.data ?? data;
}

export async function agregarAlCarrito(productoId, cantidadDeseada) {
  const { data } = await api.post("/carrito", { producto_id: productoId, cantidad_deseada: cantidadDeseada });
  return data.data ?? data;
}

export async function editarCantidadCarrito(itemId, cantidadDeseada) {
  const { data } = await api.patch(`/carrito/${itemId}`, { cantidad_deseada: cantidadDeseada });
  return data.data ?? data;
}

export async function eliminarDelCarrito(itemId) {
  const { data } = await api.delete(`/carrito/${itemId}`);
  return data;
}

export async function obtenerHistorial() {
  const { data } = await api.get("/historial-compras");
  return data.data ?? data;
}

export async function borrarHistorial() {
  const { data } = await api.delete("/historial-compras");
  return data;
}

export async function volverAComprar(historialId) {
  const { data } = await api.post(`/historial-compras/${historialId}/volver-a-comprar`);
  return data.data ?? data;
}
