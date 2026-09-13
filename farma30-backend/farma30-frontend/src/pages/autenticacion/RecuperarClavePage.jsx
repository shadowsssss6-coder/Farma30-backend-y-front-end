import { useState } from "react";
import { recuperarClave } from "../../services/authService";

export default function RecuperarClavePage() {
  const [email, setEmail] = useState("");
  const [mensaje, setMensaje] = useState("");
  const [cargando, setCargando] = useState(false);

  async function manejarSubmit(evento) {
    evento.preventDefault();
    setCargando(true);
    try {
      const respuesta = await recuperarClave(email);
      setMensaje(respuesta.mensaje);
    } catch {
      setMensaje("No fue posible procesar la solicitud.");
    } finally {
      setCargando(false);
    }
  }

  return (
    <div>
      <h1>Recuperar contraseña</h1>
      <form onSubmit={manejarSubmit}>
        <input type="email" placeholder="Correo electrónico" value={email} onChange={(e) => setEmail(e.target.value)} required />
        <button type="submit" disabled={cargando}>{cargando ? "Enviando..." : "Enviar instrucciones"}</button>
      </form>
      {mensaje && <p>{mensaje}</p>}
    </div>
  );
}
