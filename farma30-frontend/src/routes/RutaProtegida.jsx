import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

/**
 * Guard de ruta: verifica sesión activa y, opcionalmente, rol requerido.
 * `rolRequerido` acepta un string o un arreglo de roles permitidos.
 */
export default function RutaProtegida({ children, rolRequerido }) {
  const { usuario } = useAuth();

  if (!usuario) {
    return <Navigate to="/login" replace />;
  }

  if (rolRequerido) {
    const permitidos = Array.isArray(rolRequerido) ? rolRequerido : [rolRequerido];
    if (!permitidos.includes(usuario.rol)) {
      return <Navigate to="/catalogo" replace />;
    }
  }

  return children;
}
