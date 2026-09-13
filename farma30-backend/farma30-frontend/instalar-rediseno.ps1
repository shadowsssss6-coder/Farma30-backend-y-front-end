# Script generado - escribe todos los archivos del rediseno Farma 30
# directamente en disco, sin BOM, sobrescribiendo lo que exista.
# Ejecutar desde la RAIZ de farma30-frontend (donde esta package.json)

$raiz = Get-Location

# --- 1. Limpiar carpetas/archivos duplicados ---
Remove-Item -Recurse -Force ".\pages" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\routes" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\services" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\components" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\context" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\src\pages\pages" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\src\routes\routes" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\src\services\services" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\src\components\components" -ErrorAction SilentlyContinue
Remove-Item -Recurse -Force ".\src\context\context" -ErrorAction SilentlyContinue
Get-ChildItem -Path ".\src" -Recurse -File | Where-Object { $_.Name -match "\(\d+\)" } | Remove-Item -Force

function Escribir-Archivo($rutaRelativa, $contenido) {
    $rutaCompleta = Join-Path $raiz $rutaRelativa
    $carpeta = Split-Path $rutaCompleta -Parent
    if (-not (Test-Path $carpeta)) { New-Item -ItemType Directory -Path $carpeta -Force | Out-Null }
    [System.IO.File]::WriteAllText($rutaCompleta, $contenido, (New-Object System.Text.UTF8Encoding($false)))
    Write-Host "Escrito: $rutaRelativa"
}

# --- 2. Escribir cada archivo ---
$contenido = @'
@import url('https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,400;9..144,500;9..144,600;9..144,700&family=Inter:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&display=swap');

/* ============================================================
   FARMA 30 — Sistema de diseño
   Paleta inspirada en frascos de botica: verde botica oscuro,
   ámbar de vidrio, hueso de etiqueta de papel.
   ============================================================ */
:root {
  --verde-900: #16332A;
  --verde-800: #1D4438;
  --verde-700: #24594A;
  --verde-100: #E6EFE9;
  --verde-050: #F1F5F2;

  --ambar: #C4842A;
  --ambar-suave: #FBF0DC;
  --ambar-texto: #7A5015;

  --rojo: #B2412F;
  --rojo-suave: #F8E4DF;
  --rojo-texto: #7C2C1F;

  --hueso: #F6F4EE;
  --papel: #FFFFFF;
  --borde: #E2E0D4;

  --texto: #212A22;
  --texto-suave: #5D6A5E;
  --texto-inv: #F3F5F1;

  --radio-s: 6px;
  --radio-m: 10px;
  --radio-l: 16px;
  --sombra: 0 1px 2px rgba(23, 41, 33, 0.06), 0 8px 24px -12px rgba(23, 41, 33, 0.18);

  --display: 'Fraunces', Georgia, serif;
  --sans: 'Inter', system-ui, 'Segoe UI', Roboto, sans-serif;
  --mono: 'IBM Plex Mono', ui-monospace, Consolas, monospace;

  color-scheme: light;
  color: var(--texto);
  background: var(--hueso);
  font-family: var(--sans);
  font-size: 16px;
  line-height: 1.5;
  -webkit-font-smoothing: antialiased;
}

* { box-sizing: border-box; }

html, body, #root { height: 100%; }

body {
  margin: 0;
  background: var(--hueso);
  color: var(--texto);
}

#root {
  display: flex;
  flex-direction: column;
  min-height: 100svh;
}

h1, h2, h3 {
  font-family: var(--display);
  font-weight: 600;
  color: var(--verde-900);
  letter-spacing: -0.01em;
  margin: 0 0 4px;
}

h1 { font-size: 34px; }
h2 { font-size: 24px; }
h3 { font-size: 18px; }

p { margin: 0 0 12px; color: var(--texto-suave); }

a {
  color: var(--verde-700);
  text-decoration: none;
  font-weight: 500;
}
a:hover { text-decoration: underline; }

/* ---------- Formularios ---------- */
label {
  display: block;
  font-size: 13px;
  font-weight: 600;
  color: var(--texto-suave);
  margin-bottom: 6px;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="number"],
input[type="date"],
input[type="search"],
select,
textarea {
  width: 100%;
  padding: 11px 13px;
  font-size: 15px;
  font-family: var(--sans);
  color: var(--texto);
  background: var(--papel);
  border: 1px solid var(--borde);
  border-radius: var(--radio-s);
  outline: none;
  transition: border-color 0.15s, box-shadow 0.15s;
}

input:focus-visible,
select:focus-visible,
textarea:focus-visible,
button:focus-visible,
a:focus-visible {
  border-color: var(--verde-700);
  box-shadow: 0 0 0 3px var(--verde-100);
}

input::placeholder { color: #9CA69B; }

button {
  font-family: var(--sans);
  font-weight: 600;
  font-size: 14.5px;
  padding: 11px 20px;
  border-radius: var(--radio-s);
  border: 1px solid var(--verde-900);
  background: var(--verde-900);
  color: var(--texto-inv);
  cursor: pointer;
  transition: background 0.15s, transform 0.05s;
}
button:hover { background: var(--verde-700); }
button:active { transform: translateY(1px); }
button:disabled { opacity: 0.55; cursor: not-allowed; }

button.secundario {
  background: transparent;
  color: var(--verde-900);
  border: 1px solid var(--borde);
}
button.secundario:hover { background: var(--verde-050); }

button.peligro {
  background: var(--rojo);
  border-color: var(--rojo);
}
button.peligro:hover { background: var(--rojo-texto); }

/* ---------- Mensajes de error / vacío ---------- */
[role="alert"] {
  background: var(--rojo-suave);
  color: var(--rojo-texto);
  border: 1px solid rgba(178, 65, 47, 0.25);
  border-radius: var(--radio-s);
  padding: 10px 14px;
  font-size: 14px;
  font-weight: 500;
  margin: 4px 0 16px;
}

/* ---------- Tarjetas ---------- */
.tarjeta {
  background: var(--papel);
  border: 1px solid var(--borde);
  border-radius: var(--radio-m);
  box-shadow: var(--sombra);
}

/* ---------- Tablas ---------- */
table {
  width: 100%;
  border-collapse: collapse;
  font-size: 14.5px;
}
th {
  text-align: left;
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 0.04em;
  color: var(--texto-suave);
  padding: 10px 14px;
  border-bottom: 1px solid var(--borde);
}
td {
  padding: 12px 14px;
  border-bottom: 1px solid var(--borde);
}
tr:last-child td { border-bottom: none; }

/* ---------- Listas simples (páginas aún sin rediseñar) ---------- */
ul { padding-left: 20px; }

/* ---------- Insignia de estado (firma visual de la app) ---------- */
.insignia {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  font-family: var(--mono);
  font-size: 12px;
  font-weight: 500;
  padding: 3px 9px;
  border-radius: 999px;
  white-space: nowrap;
}
.insignia::before {
  content: "";
  width: 6px;
  height: 6px;
  border-radius: 50%;
  background: currentColor;
}
.insignia-disponible { background: var(--verde-100); color: var(--verde-800); }
.insignia-por-vencer { background: var(--ambar-suave); color: var(--ambar-texto); }
.insignia-vencido,
.insignia-agotado { background: var(--rojo-suave); color: var(--rojo-texto); }

/* ---------- Precio / datos numéricos ---------- */
.precio, .dato-mono {
  font-family: var(--mono);
  font-variant-numeric: tabular-nums;
}

.envoltura-principal {
  flex: 1;
  display: flex;
  flex-direction: column;
  min-height: 100svh;
}
'@
Escribir-Archivo "src/index.css" $contenido

$contenido = @'
/**
 * Insignia visual de estado de un producto, según cantidad y
 * fecha de vencimiento. Es el elemento visual que se repite en
 * Catálogo, Inventario y Alertas de vencimiento.
 */
export default function Insignia({ producto }) {
  const hoy = new Date();
  const vencimiento = producto.fecha_vencimiento ? new Date(producto.fecha_vencimiento) : null;
  const diasParaVencer = vencimiento ? Math.ceil((vencimiento - hoy) / 86400000) : null;

  let clase = "insignia-disponible";
  let texto = "Disponible";

  if (producto.cantidad <= 0) {
    clase = "insignia-agotado";
    texto = "Agotado";
  } else if (diasParaVencer !== null && diasParaVencer < 0) {
    clase = "insignia-vencido";
    texto = "Vencido";
  } else if (diasParaVencer !== null && diasParaVencer <= 30) {
    clase = "insignia-por-vencer";
    texto = `Vence en ${diasParaVencer}d`;
  }

  return <span className={`insignia ${clase}`}>{texto}</span>;
}
'@
Escribir-Archivo "src/components/Insignia.jsx" $contenido

$contenido = @'
import { useState } from "react";
import { NavLink, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import "./Layout.css";

const ICONOS = {
  catalogo: "🧴",
  ventas: "💳",
  inventario: "📦",
  carrito: "🛒",
  historial: "🕘",
  notificaciones: "🔔",
  perfil: "👤",
};

export default function Layout({ children }) {
  const { usuario, cerrarSesion } = useAuth();
  const navigate = useNavigate();
  const [menuAbierto, setMenuAbierto] = useState(false);
  const esIntegrante = usuario?.rol === "integrante";

  async function manejarSalir() {
    await cerrarSesion();
    navigate("/login");
  }

  const enlaces = [
    { a: "/catalogo", icono: ICONOS.catalogo, texto: "Catálogo" },
    ...(esIntegrante
      ? [
          { a: "/ventas", icono: ICONOS.ventas, texto: "Ventas" },
          { a: "/inventario", icono: ICONOS.inventario, texto: "Inventario" },
        ]
      : [
          { a: "/carrito", icono: ICONOS.carrito, texto: "Carrito" },
          { a: "/historial-compras", icono: ICONOS.historial, texto: "Mis compras" },
        ]),
    { a: "/notificaciones", icono: ICONOS.notificaciones, texto: "Notificaciones" },
    { a: "/perfil", icono: ICONOS.perfil, texto: "Perfil" },
  ];

  return (
    <div className="app-shell">
      <aside className={`sidebar ${menuAbierto ? "sidebar-abierta" : ""}`}>
        <div className="sidebar-marca">
          <span className="sidebar-marca-icono">℞</span>
          <span className="sidebar-marca-texto">Farma 30</span>
        </div>

        <nav className="sidebar-nav">
          {enlaces.map((enlace) => (
            <NavLink
              key={enlace.a}
              to={enlace.a}
              className={({ isActive }) => `sidebar-enlace ${isActive ? "sidebar-enlace-activo" : ""}`}
              onClick={() => setMenuAbierto(false)}
            >
              <span className="sidebar-enlace-icono" aria-hidden="true">{enlace.icono}</span>
              {enlace.texto}
            </NavLink>
          ))}
        </nav>

        <div className="sidebar-pie">
          <div className="sidebar-usuario">
            <div className="sidebar-usuario-avatar">
              {(usuario?.nombre_del_integrante || usuario?.email || "?").charAt(0).toUpperCase()}
            </div>
            <div className="sidebar-usuario-info">
              <span className="sidebar-usuario-nombre">
                {usuario?.nombre_del_integrante || usuario?.email}
              </span>
              <span className="sidebar-usuario-rol">{esIntegrante ? "Integrante" : "Cliente"}</span>
            </div>
          </div>
          <button className="secundario sidebar-salir" onClick={manejarSalir}>
            Cerrar sesión
          </button>
        </div>
      </aside>

      <button
        className="topbar-hamburguesa"
        onClick={() => setMenuAbierto((v) => !v)}
        aria-label="Abrir menú"
      >
        ☰
      </button>

      <main className="contenido-principal">{children}</main>
    </div>
  );
}
'@
Escribir-Archivo "src/components/Layout.jsx" $contenido

$contenido = @'
.app-shell {
  display: flex;
  min-height: 100svh;
  width: 100%;
}

.sidebar {
  width: 240px;
  flex-shrink: 0;
  background: var(--verde-900);
  color: var(--texto-inv);
  display: flex;
  flex-direction: column;
  padding: 24px 16px;
  position: sticky;
  top: 0;
  height: 100svh;
}

.sidebar-marca {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 8px;
  margin-bottom: 32px;
}
.sidebar-marca-icono {
  font-size: 22px;
  color: var(--ambar);
}
.sidebar-marca-texto {
  font-family: var(--display);
  font-size: 21px;
  font-weight: 600;
  color: var(--texto-inv);
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 2px;
  flex: 1;
}

.sidebar-enlace {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 10px 12px;
  border-radius: var(--radio-s);
  color: rgba(243, 245, 241, 0.72);
  font-weight: 500;
  font-size: 14.5px;
}
.sidebar-enlace:hover {
  background: rgba(243, 245, 241, 0.06);
  color: var(--texto-inv);
  text-decoration: none;
}
.sidebar-enlace-activo {
  background: var(--verde-700);
  color: var(--texto-inv);
}
.sidebar-enlace-icono {
  font-size: 16px;
  width: 20px;
  text-align: center;
}

.sidebar-pie {
  border-top: 1px solid rgba(243, 245, 241, 0.12);
  padding-top: 16px;
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.sidebar-usuario {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 8px;
}
.sidebar-usuario-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: var(--ambar);
  color: var(--verde-900);
  font-family: var(--display);
  font-weight: 700;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.sidebar-usuario-info {
  display: flex;
  flex-direction: column;
  min-width: 0;
}
.sidebar-usuario-nombre {
  font-size: 13.5px;
  font-weight: 600;
  color: var(--texto-inv);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.sidebar-usuario-rol {
  font-size: 12px;
  color: rgba(243, 245, 241, 0.6);
  text-transform: capitalize;
}

.sidebar-salir {
  width: 100%;
  border-color: rgba(243, 245, 241, 0.2) !important;
  color: var(--texto-inv) !important;
  background: transparent !important;
}
.sidebar-salir:hover {
  background: rgba(243, 245, 241, 0.08) !important;
}

.topbar-hamburguesa {
  display: none;
  position: fixed;
  top: 14px;
  left: 14px;
  z-index: 30;
  width: 42px;
  height: 42px;
  padding: 0;
  border-radius: var(--radio-s);
}

.contenido-principal {
  flex: 1;
  padding: 40px 48px;
  min-width: 0;
}

@media (max-width: 900px) {
  .sidebar {
    position: fixed;
    inset: 0 auto 0 0;
    transform: translateX(-100%);
    transition: transform 0.2s ease;
    z-index: 40;
    width: 260px;
  }
  .sidebar-abierta { transform: translateX(0); }
  .topbar-hamburguesa { display: block; }
  .contenido-principal { padding: 88px 20px 32px; }
}
'@
Escribir-Archivo "src/components/Layout.css" $contenido

$contenido = @'
import { BrowserRouter, Routes, Route, Navigate } from "react-router-dom";
import { AuthProvider } from "../context/AuthContext";
import RutaProtegida from "../components/RutaProtegida";
import Layout from "../components/Layout";

import LoginPage from "../pages/autenticacion/LoginPage";
import RegistroPage from "../pages/autenticacion/RegistroPage";
import RecuperarClavePage from "../pages/autenticacion/RecuperarClavePage";

import InventarioPage from "../pages/catalogo/InventarioPage";
import BusquedaPage from "../pages/catalogo/BusquedaPage";
import DeseadosPage from "../pages/catalogo/DeseadosPage";
import DetalleProductoPage from "../pages/catalogo/DetalleProductoPage";

import ResumenVentasPage from "../pages/ventas/ResumenVentasPage";
import RegistroVentaPage from "../pages/ventas/RegistroVentaPage";
import DetalleVentaPage from "../pages/ventas/DetalleVentaPage";

import EditorProductosPage from "../pages/gestioninventario/EditorProductosPage";
import AlertasVencimientoPage from "../pages/gestioninventario/AlertasVencimientoPage";
import DescuentosPage from "../pages/gestioninventario/DescuentosPage";

import CarritoPage from "../pages/comprascliente/CarritoPage";
import HistorialComprasPage from "../pages/comprascliente/HistorialComprasPage";

import NotificacionesSistemaPage from "../pages/notificaciones/NotificacionesSistemaPage";
import DescuentosClientesPage from "../pages/notificaciones/DescuentosClientesPage";
import DescuentosEmpleadosPage from "../pages/notificaciones/DescuentosEmpleadosPage";

import HorariosPage from "../pages/infogeneral/HorariosPage";
import PerfilPage from "../pages/infogeneral/PerfilPage";

/**
 * Envuelve una página protegida con el guard de rol y el Layout
 * (sidebar + topbar) para que la navegación aparezca en todos los
 * módulos internos de la app.
 */
function Protegida({ children, rolRequerido }) {
  return (
    <RutaProtegida rolRequerido={rolRequerido}>
      <Layout>{children}</Layout>
    </RutaProtegida>
  );
}

/**
 * Enrutador principal, correspondiente al mapa de navegación web ya
 * documentado. Las rutas de Gestión de Inventario exigen rol "integrante".
 */
export default function AppRoutes() {
  return (
    <BrowserRouter>
      <AuthProvider>
        <Routes>
          <Route path="/" element={<Navigate to="/login" replace />} />
          <Route path="/login" element={<LoginPage />} />
          <Route path="/registro" element={<RegistroPage />} />
          <Route path="/recuperar-clave" element={<RecuperarClavePage />} />

          <Route path="/catalogo" element={<Protegida><InventarioPage /></Protegida>} />
          <Route path="/catalogo/buscar" element={<Protegida><BusquedaPage /></Protegida>} />
          <Route path="/catalogo/deseados" element={<Protegida><DeseadosPage /></Protegida>} />
          <Route path="/catalogo/:id" element={<Protegida><DetalleProductoPage /></Protegida>} />

          <Route path="/ventas" element={<Protegida rolRequerido="integrante"><ResumenVentasPage /></Protegida>} />
          <Route path="/ventas/registrar" element={<Protegida rolRequerido="integrante"><RegistroVentaPage /></Protegida>} />
          <Route path="/ventas/:id" element={<Protegida rolRequerido="integrante"><DetalleVentaPage /></Protegida>} />

          <Route path="/inventario" element={<Protegida rolRequerido="integrante"><EditorProductosPage /></Protegida>} />
          <Route path="/inventario/alertas-vencimiento" element={<Protegida rolRequerido="integrante"><AlertasVencimientoPage /></Protegida>} />
          <Route path="/inventario/descuentos" element={<Protegida rolRequerido="integrante"><DescuentosPage /></Protegida>} />

          <Route path="/carrito" element={<Protegida><CarritoPage /></Protegida>} />
          <Route path="/historial-compras" element={<Protegida><HistorialComprasPage /></Protegida>} />

          <Route path="/notificaciones" element={<Protegida><NotificacionesSistemaPage /></Protegida>} />
          <Route path="/notificaciones/clientes" element={<Protegida><DescuentosClientesPage /></Protegida>} />
          <Route path="/notificaciones/empleados" element={<Protegida rolRequerido="integrante"><DescuentosEmpleadosPage /></Protegida>} />

          <Route path="/perfil" element={<Protegida><PerfilPage /></Protegida>} />
          <Route path="/perfil/horarios" element={<Protegida><HorariosPage /></Protegida>} />
        </Routes>
      </AuthProvider>
    </BrowserRouter>
  );
}
'@
Escribir-Archivo "src/routes/AppRoutes.jsx" $contenido

$contenido = @'
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
'@
Escribir-Archivo "src/pages/autenticacion/LoginPage.jsx" $contenido

$contenido = @'
import { useState } from "react";
import { useNavigate, Link } from "react-router-dom";
import { useAuth } from "../../context/AuthContext";
import "./Auth.css";

export default function RegistroPage() {
  const { registrar } = useAuth();
  const navigate = useNavigate();
  const [rol, setRol] = useState("cliente");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [campoExtra, setCampoExtra] = useState("");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(false);

  async function manejarSubmit(evento) {
    evento.preventDefault();
    setError("");
    setCargando(true);
    try {
      await registrar({
        email,
        password,
        rol,
        numero_de_contacto: rol === "cliente" ? campoExtra : undefined,
        nombre_del_integrante: rol === "integrante" ? campoExtra : undefined,
      });
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
        <p className="auth-subtitulo">Elige el tipo de cuenta para empezar.</p>

        <form onSubmit={manejarSubmit} className="auth-form">
          <div className="auth-rol-selector">
            <button
              type="button"
              className={rol === "cliente" ? "" : "secundario"}
              onClick={() => setRol("cliente")}
            >
              Cliente
            </button>
            <button
              type="button"
              className={rol === "integrante" ? "" : "secundario"}
              onClick={() => setRol("integrante")}
            >
              Integrante
            </button>
          </div>

          <div>
            <label htmlFor="email">Correo electrónico</label>
            <input id="email" type="email" placeholder="tu@correo.com" value={email} onChange={(e) => setEmail(e.target.value)} required />
          </div>
          <div>
            <label htmlFor="password">Contraseña</label>
            <input id="password" type="password" placeholder="Mínimo 8 caracteres" value={password} onChange={(e) => setPassword(e.target.value)} required minLength={8} />
          </div>
          <div>
            <label htmlFor="campoExtra">{rol === "cliente" ? "Número de contacto" : "Nombre completo"}</label>
            <input
              id="campoExtra"
              type="text"
              placeholder={rol === "cliente" ? "300 000 0000" : "Nombre y apellido"}
              value={campoExtra}
              onChange={(e) => setCampoExtra(e.target.value)}
              required
            />
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
'@
Escribir-Archivo "src/pages/autenticacion/RegistroPage.jsx" $contenido

$contenido = @'
.auth-pagina {
  flex: 1;
  min-height: 100svh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: var(--verde-900);
  background-image: radial-gradient(circle at 15% 20%, rgba(196, 132, 42, 0.15), transparent 45%),
    radial-gradient(circle at 85% 85%, rgba(36, 89, 74, 0.5), transparent 50%);
  padding: 24px;
}

.auth-tarjeta {
  width: 100%;
  max-width: 400px;
  padding: 36px 34px;
}

.auth-marca {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 4px;
}
.auth-marca-icono {
  font-size: 26px;
  color: var(--ambar);
}
.auth-marca h1 { margin: 0; }

.auth-subtitulo {
  margin-bottom: 24px;
  font-size: 14.5px;
}

.auth-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.auth-rol-selector {
  display: flex;
  gap: 8px;
}
.auth-rol-selector button {
  flex: 1;
}

.auth-enlaces {
  margin-top: 22px;
  display: flex;
  flex-direction: column;
  gap: 8px;
  font-size: 13.5px;
}
'@
Escribir-Archivo "src/pages/autenticacion/Auth.css" $contenido

$contenido = @'
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { obtenerCatalogo } from "../../services/productoService";
import Insignia from "../../components/Insignia";
import "./Catalogo.css";

const formatoCOP = new Intl.NumberFormat("es-CO", { style: "currency", currency: "COP", maximumFractionDigits: 0 });

export default function InventarioPage() {
  const [productos, setProductos] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [error, setError] = useState("");

  useEffect(() => {
    obtenerCatalogo()
      .then(setProductos)
      .catch(() => setError("No fue posible cargar el catálogo."))
      .finally(() => setCargando(false));
  }, []);

  return (
    <div>
      <div className="catalogo-encabezado">
        <div>
          <h1>Catálogo</h1>
          <p>{productos.length} producto{productos.length === 1 ? "" : "s"} disponibles en droguería.</p>
        </div>
        <Link to="/catalogo/buscar"><button className="secundario">Buscar producto</button></Link>
      </div>

      {error && <p role="alert">{error}</p>}

      {cargando ? (
        <p>Cargando catálogo...</p>
      ) : productos.length === 0 ? (
        <div className="tarjeta catalogo-vacio">
          <p>Todavía no hay productos registrados en el catálogo.</p>
        </div>
      ) : (
        <div className="catalogo-grid">
          {productos.map((producto) => (
            <Link to={`/catalogo/${producto.id}`} key={producto.id} className="tarjeta producto-tarjeta">
              <div className="producto-tarjeta-encabezado">
                <h3>{producto.nombre}</h3>
                <Insignia producto={producto} />
              </div>
              <div className="producto-tarjeta-pie">
                <span className="precio">{formatoCOP.format(producto.precio)}</span>
                <span className="producto-stock">stock: {producto.cantidad}</span>
              </div>
            </Link>
          ))}
        </div>
      )}
    </div>
  );
}
'@
Escribir-Archivo "src/pages/catalogo/InventarioPage.jsx" $contenido

$contenido = @'
.catalogo-encabezado {
  display: flex;
  align-items: flex-end;
  justify-content: space-between;
  gap: 16px;
  margin-bottom: 28px;
  flex-wrap: wrap;
}
.catalogo-encabezado p { margin: 0; }

.catalogo-vacio {
  padding: 48px 24px;
  text-align: center;
}
.catalogo-vacio p { margin: 0; }

.catalogo-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 16px;
}

.producto-tarjeta {
  display: flex;
  flex-direction: column;
  gap: 20px;
  padding: 18px 20px;
  color: inherit;
  transition: transform 0.12s, box-shadow 0.12s;
}
.producto-tarjeta:hover {
  text-decoration: none;
  transform: translateY(-2px);
  box-shadow: 0 4px 8px rgba(23, 41, 33, 0.08), 0 16px 32px -16px rgba(23, 41, 33, 0.28);
}

.producto-tarjeta-encabezado {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 10px;
}
.producto-tarjeta-encabezado h3 {
  margin: 0;
  font-size: 16px;
  line-height: 1.3;
}

.producto-tarjeta-pie {
  display: flex;
  align-items: baseline;
  justify-content: space-between;
}
.producto-tarjeta-pie .precio {
  font-size: 17px;
  font-weight: 600;
  color: var(--verde-800);
}
.producto-stock {
  font-size: 12.5px;
  color: var(--texto-suave);
}
'@
Escribir-Archivo "src/pages/catalogo/Catalogo.css" $contenido

$contenido = @'
import { useEffect, useState } from "react";
import { Link } from "react-router-dom";
import { obtenerCarrito, editarCantidadCarrito, eliminarDelCarrito } from "../../services/comprasService";
import "./Carrito.css";

export default function CarritoPage() {
  const [items, setItems] = useState([]);
  const [cargando, setCargando] = useState(true);

  useEffect(() => {
    obtenerCarrito().then(setItems).finally(() => setCargando(false));
  }, []);

  async function cambiarCantidad(item, delta) {
    const nuevaCantidad = item.cantidad_deseada + delta;
    if (nuevaCantidad < 1) return;
    const actualizado = await editarCantidadCarrito(item.id, nuevaCantidad);
    setItems((previos) => previos.map((i) => (i.id === item.id ? actualizado : i)));
  }

  async function quitar(item) {
    await eliminarDelCarrito(item.id);
    setItems((previos) => previos.filter((i) => i.id !== item.id));
  }

  const total = items.reduce((suma, item) => suma + item.cantidad_deseada, 0);

  return (
    <div>
      <h1>Carro de compras</h1>
      <p>{total} artículo{total === 1 ? "" : "s"} en total.</p>

      {cargando ? (
        <p>Cargando carrito...</p>
      ) : items.length === 0 ? (
        <div className="tarjeta carrito-vacio">
          <p>Tu carrito está vacío por ahora.</p>
          <Link to="/catalogo"><button>Ir al catálogo</button></Link>
        </div>
      ) : (
        <div className="tarjeta carrito-lista">
          {items.map((item) => (
            <div className="carrito-item" key={item.id}>
              <span className="carrito-item-nombre">{item.producto_nombre}</span>
              <div className="carrito-item-stepper">
                <button className="secundario" onClick={() => cambiarCantidad(item, -1)} aria-label="Quitar uno">−</button>
                <span className="dato-mono">{item.cantidad_deseada}</span>
                <button className="secundario" onClick={() => cambiarCantidad(item, 1)} aria-label="Agregar uno">+</button>
              </div>
              <button className="peligro" onClick={() => quitar(item)}>Quitar</button>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
'@
Escribir-Archivo "src/pages/comprascliente/CarritoPage.jsx" $contenido

$contenido = @'
.carrito-vacio {
  padding: 48px 24px;
  text-align: center;
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 16px;
}
.carrito-vacio p { margin: 0; }

.carrito-lista {
  padding: 6px 22px;
}

.carrito-item {
  display: flex;
  align-items: center;
  gap: 18px;
  padding: 16px 0;
  border-bottom: 1px solid var(--borde);
}
.carrito-item:last-child { border-bottom: none; }

.carrito-item-nombre {
  flex: 1;
  font-weight: 500;
}

.carrito-item-stepper {
  display: flex;
  align-items: center;
  gap: 10px;
}
.carrito-item-stepper button {
  width: 32px;
  height: 32px;
  padding: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  line-height: 1;
}
.carrito-item-stepper span {
  min-width: 20px;
  text-align: center;
}
'@
Escribir-Archivo "src/pages/comprascliente/Carrito.css" $contenido

Write-Host ""
Write-Host "Listo. Ahora corre: npm run dev" -ForegroundColor Green