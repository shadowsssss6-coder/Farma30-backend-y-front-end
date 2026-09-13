import axios from "axios";

// Instancia central de Axios: adjunta el token automáticamente y
// centraliza el manejo de errores 401 (sesión expirada).
const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || "http://localhost:8000/api",
});

api.interceptors.request.use((config) => {
  const token = localStorage.getItem("farma30_token");
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem("farma30_token");
      localStorage.removeItem("farma30_usuario");
      window.location.href = "/login";
    }
    return Promise.reject(error);
  }
);

export default api;
