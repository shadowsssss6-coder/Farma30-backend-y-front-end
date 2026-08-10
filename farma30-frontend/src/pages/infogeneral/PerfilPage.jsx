import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../../context/AuthContext";
import { actualizarPerfil } from "../../services/authService";

export default function PerfilPage() {
  const { usuario, cerrarSesion } = useAuth();
  const navigate = useNavigate();
  const [numeroContacto, setNumeroContacto] = useState(usuario?.numero_de_contacto ?? "");
  const [mensaje, setMensaje] = useState("");

  async function manejarGuardar(evento) {
    evento.preventDefault();
    await actualizarPerfil({ numero_de_contacto: numeroContacto });
    setMensaje("Perfil actualizado.");
  }

  async function manejarCerrarSesion() {
    await cerrarSesion();
    navigate("/login");
  }

  return (
    <div>
      <h1>Perfil de usuario</h1>
      <form onSubmit={manejarGuardar}>
        <input type="text" value={numeroContacto} onChange={(e) => setNumeroContacto(e.target.value)} placeholder="Número de contacto" />
        <button type="submit">Guardar cambios</button>
      </form>
      {mensaje && <p>{mensaje}</p>}
      <button onClick={manejarCerrarSesion}>Cerrar sesión</button>
    </div>
  );
}
