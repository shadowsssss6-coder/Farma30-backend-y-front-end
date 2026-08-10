import api from "./api";

export async function obtenerCatalogo() {
  const { data } = await api.get("/productos");
  return data.data ?? data;
}

export async function buscarProductos(texto) {
  const { data } = await api.get("/productos/buscar", { params: { q: texto } });
  return data.data ?? data;
}

export async function obtenerProducto(id) {
  const { data } = await api.get(`/productos/${id}`);
  return data.data ?? data;
}

export async function obtenerPorCodigoBarras(codigo) {
  const { data } = await api.get(`/productos/codigo/${codigo}`);
  return data.data ?? data;
}

export async function actualizarProducto(id, cambios) {
  const { data } = await api.patch(`/productos/${id}`, cambios);
  return data.data ?? data;
}

export async function eliminarProducto(id) {
  const { data } = await api.delete(`/productos/${id}`);
  return data;
}

export async function obtenerAlertasVencimiento() {
  const { data } = await api.get("/productos-alertas-vencimiento");
  return data.data ?? data;
}
