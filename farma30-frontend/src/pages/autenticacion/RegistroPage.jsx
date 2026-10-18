import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { useAuth } from "../../context/AuthContext";
import "./Auth.css";

export default function RegistroPage() {
  const { registrar } = useAuth();
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [contacto, setContacto] = useState("");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(false);

  async function manejarSubmit(evento) {
    evento.preventDefault();
    setError("");
    setCargando(true);
    try {
      await registrar({ email, password, rol: "cliente", numero_de_contacto: contacto });
      navigate("/catalogo");
    } catch (err) {
      setError(err.response?.data?.message ?? "No fue posible completar el registro.");
    } finally {
      setCargando(false);
    }
  }

  return (
    <div className="auth-pagina">
      <div className="auth-tarjeta tarjeta">
        <div className="auth-marca">
          <span className="auth-marca-icono">℞</span>
          <h1>Crear cuenta</h1>
        </div>
        <p className="auth-subtitulo">Regístrate como cliente para comprar en Farma 30.</p>

        <form onSubmit={manejarSubmit} className="auth-form">
          <div>
            <label htmlFor="email">Correo electrónico</label>
            <input id="email" type="email" placeholder="tu@correo.com" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div>
            <label htmlFor="password">Contraseña</label>
            <input id="password" type="password" placeholder="Mínimo 8 caracteres" value={password} onChange={(e) => setPassword(e.target.value)} required minLength={8} />
          </div>
          <div>
            <label htmlFor="contacto">Número de contacto</label>
            <input id="contacto" type="text" placeholder="300 000 0000" value={contacto} onChange={(e) => setContacto(e.target.value)} required />
          </div>
          {error && <p role="alert">{error}</p>}
          <button type="submit" disabled={cargando}>{cargando ? "Registrando..." : "Registrarme"}</button>
        </form>

        <div className="auth-enlaces">
          <Link to="/login">¿Ya tienes cuenta? Inicia sesión</Link>
        </div>
      </div>
    </div>
  );
}
