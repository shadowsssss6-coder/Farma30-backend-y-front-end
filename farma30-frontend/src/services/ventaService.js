import api from "./api";

export async function registrarVenta(payload) {
  const { data } = await api.post("/ventas", payload);
  return data.data ?? data;
}

export async function obtenerResumenVentas() {
  const { data } = await api.get("/ventas/resumen");
  return data;
}

export async function obtenerDetalleVenta(id) {
  const { data } = await api.get(`/ventas/${id}`);
  return data.data ?? data;
}
