import { createContext, useContext, useState } from "react";
import {
  iniciarSesion as iniciarSesionApi,
  registrar as registrarApi,
  cerrarSesion as cerrarSesionApi,
  obtenerUsuarioActual,
} from "../services/authService";

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [usuario, setUsuario] = useState(obtenerUsuarioActual());

  async function iniciarSesion(email, password) {
    const usuarioAutenticado = await iniciarSesionApi(email, password);
    setUsuario(usuarioAutenticado);
    return usuarioAutenticado;
  }

  async function registrar(payload) {
    const usuarioAutenticado = await registrarApi(payload);
    setUsuario(usuarioAutenticado);
    return usuarioAutenticado;
  }

  async function cerrarSesion() {
    await cerrarSesionApi();
    setUsuario(null);
  }

  return (
    <AuthContext.Provider value={{ usuario, iniciarSesion, registrar, cerrarSesion }}>
      {children}
    </AuthContext.Provider>
  );
}

export function useAuth() {
  const context = useContext(AuthContext);
  if (!context) throw new Error("useAuth debe usarse dentro de un AuthProvider");
  return context;
}
