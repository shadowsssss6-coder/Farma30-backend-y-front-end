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

          <Route path="/ventas" element={<Protegida rolRequerido={["integrante", "administrador"]}><ResumenVentasPage /></Protegida>} />
          <Route path="/ventas/registrar" element={<Protegida rolRequerido={["integrante", "administrador"]}><RegistroVentaPage /></Protegida>} />
          <Route path="/ventas/:id" element={<Protegida rolRequerido={["integrante", "administrador"]}><DetalleVentaPage /></Protegida>} />

          <Route path="/inventario" element={<Protegida rolRequerido={["integrante", "administrador"]}><EditorProductosPage /></Protegida>} />
          <Route path="/inventario/alertas-vencimiento" element={<Protegida rolRequerido={["integrante", "administrador"]}><AlertasVencimientoPage /></Protegida>} />
          <Route path="/inventario/descuentos" element={<Protegida rolRequerido={["integrante", "administrador"]}><DescuentosPage /></Protegida>} />

          <Route path="/carrito" element={<Protegida><CarritoPage /></Protegida>} />
          <Route path="/historial-compras" element={<Protegida><HistorialComprasPage /></Protegida>} />

          <Route path="/notificaciones" element={<Protegida><NotificacionesSistemaPage /></Protegida>} />
          <Route path="/notificaciones/clientes" element={<Protegida><DescuentosClientesPage /></Protegida>} />
          <Route path="/notificaciones/empleados" element={<Protegida rolRequerido={["integrante", "administrador"]}><DescuentosEmpleadosPage /></Protegida>} />

          <Route path="/perfil" element={<Protegida><PerfilPage /></Protegida>} />
          <Route path="/perfil/horarios" element={<Protegida><HorariosPage /></Protegida>} />
        </Routes>
      </AuthProvider>
    </BrowserRouter>
  );
}