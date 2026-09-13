import { Navigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";

/**
 * Protege rutas según sesión activa y, opcionalmente, rol requerido.
 * `rolRequerido` acepta un string ("integrante") o un arreglo de roles
 * permitidos (["integrante", "administrador"]).
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
