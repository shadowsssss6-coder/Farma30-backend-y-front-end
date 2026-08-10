import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { useAuth } from "../../context/AuthContext";
import "./Auth.css";

export default function LoginPage() {
  const { iniciarSesion } = useAuth();
  const navigate = useNavigate();
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(false);

  async function manejarSubmit(evento) {
    evento.preventDefault();
    setError("");
    setCargando(true);
    try {
      await iniciarSesion(email, password);
      navigate("/catalogo");
    } catch (err) {
      setError(err.response?.data?.message ?? "Correo o contraseña incorrectos.");
    } finally {
      setCargando(false);
    }
  }

  return (
    <div className="auth-pagina">
      <div className="auth-tarjeta tarjeta">
        <div className="auth-marca">
          <span className="auth-marca-icono">℞</span>
          <h1>Farma 30</h1>
        </div>
        <p className="auth-subtitulo">Ingresa para ver el catálogo y tus pedidos.</p>

        <form onSubmit={manejarSubmit} className="auth-form">
          <div>
            <label htmlFor="email">Correo electrónico</label>
            <input id="email" type="email" placeholder="tu@correo.com" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div>
            <label htmlFor="password">Contraseña</label>
            <input id="password" type="password" placeholder="••••••••" value={password} onChange={(e) => setPassword(e.target.value)} required />
          </div>
          {error && <p role="alert">{error}</p>}
          <button type="submit" disabled={cargando}>{cargando ? "Ingresando..." : "Iniciar sesión"}</button>
        </form>

        <div className="auth-enlaces">
          <Link to="/registro">¿No tienes cuenta? Regístrate</Link>
          <Link to="/recuperar-clave">¿Olvidaste tu contraseña?</Link>
        </div>
      </div>
    </div>
  );
}