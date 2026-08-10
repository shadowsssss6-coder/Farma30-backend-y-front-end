import api from "./api";

export async function iniciarSesion(email, password) {
  const { data } = await api.post("/auth/login", { email, password });
  localStorage.setItem("farma30_token", data.token);
  localStorage.setItem("farma30_usuario", JSON.stringify(data.usuario));
  return data.usuario;
}

export async function registrar(payload) {
  const { data } = await api.post("/auth/registro", payload);
  localStorage.setItem("farma30_token", data.token);
  localStorage.setItem("farma30_usuario", JSON.stringify(data.usuario));
  return data.usuario;
}

export async function recuperarClave(email) {
  const { data } = await api.post("/auth/recuperar-clave", { email });
  return data;
}

export async function actualizarPerfil(payload) {
  const { data } = await api.put("/usuarios/actualizar", payload);
  localStorage.setItem("farma30_usuario", JSON.stringify(data.data ?? data));
  return data;
}

export async function cerrarSesion() {
  await api.post("/auth/logout");
  localStorage.removeItem("farma30_token");
  localStorage.removeItem("farma30_usuario");
}

export function obtenerUsuarioActual() {
  const raw = localStorage.getItem("farma30_usuario");
  return raw ? JSON.parse(raw) : null;
}
