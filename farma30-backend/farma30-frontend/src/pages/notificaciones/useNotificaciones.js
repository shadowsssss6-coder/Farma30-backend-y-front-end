import { useEffect, useState } from "react";
import api from "../../services/api";

/** Hook compartido por las 3 pantallas de Notificaciones (Sistema, Clientes, Empleados). */
export function useNotificaciones(endpoint) {
  const [notificaciones, setNotificaciones] = useState([]);
  const [cargando, setCargando] = useState(true);

  function cargar() {
    setCargando(true);
    api.get(endpoint).then(({ data }) => setNotificaciones(data)).finally(() => setCargando(false));
  }

  useEffect(cargar, [endpoint]);

  async function marcarLeida(id) {
    await api.patch(`/notificaciones/${id}/leida`);
    cargar();
  }

  return { notificaciones, cargando, marcarLeida };
}
