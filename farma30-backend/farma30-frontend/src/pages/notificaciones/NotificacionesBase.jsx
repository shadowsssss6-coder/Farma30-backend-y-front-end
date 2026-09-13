import { useEffect, useState } from "react";
import { obtenerNotificaciones, marcarNotificacionLeida } from "../../services/notificacionesService";

/** Componente compartido por las 3 pantallas de Notificaciones (mismo patrón que en Android). */
export default function NotificacionesBase({ tipo }) {
  const [notificaciones, setNotificaciones] = useState([]);

  useEffect(() => {
    obtenerNotificaciones(tipo).then(setNotificaciones);
  }, [tipo]);

  async function manejarClick(id) {
    await marcarNotificacionLeida(id);
    setNotificaciones((previas) => previas.map((n) => (n.id === id ? { ...n, leida: true } : n)));
  }

  return (
    <ul>
      {notificaciones.map((n) => (
        <li key={n.id} onClick={() => manejarClick(n.id)}>
          {!n.leida && "● "}{n.mensaje}
        </li>
      ))}
    </ul>
  );
}
