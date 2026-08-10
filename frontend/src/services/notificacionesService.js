import api from "./api";

export async function obtenerNotificaciones(tipo) {
  const { data } = await api.get(`/notificaciones/${tipo}`);
  return data.data ?? data;
}

export async function marcarNotificacionLeida(id) {
  const { data } = await api.patch(`/notificaciones/${id}/leida`);
  return data.data ?? data;
}
