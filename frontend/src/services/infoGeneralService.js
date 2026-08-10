import api from "./api";

export async function obtenerHorarios() {
  const { data } = await api.get("/info-general/horarios");
  return data.data ?? data;
}
