import { useEffect, useMemo, useState } from "react";
import { NavLink, useLocation, useNavigate } from "react-router-dom";
import { useAuth } from "../context/AuthContext";
import "./Layout.css";

/**
 * Mapa de navegación del organizador lateral. Se agrupa por módulo
 * (como en el mapa de pantallas del proyecto) para que cada sección
 * pueda expandirse y no saturar el menú con enlaces sueltos.
 */
function construirGrupos(esIntegrante) {
  const grupos = [
    {
      id: "catalogo",
      icono: "🧴",
      texto: "Catálogo",
      enlaces: [
        { a: "/catalogo", texto: "Ver catálogo", fin: true },
        { a: "/catalogo/buscar", texto: "Búsqueda avanzada" },
        { a: "/catalogo/deseados", texto: "Lista de deseados" },
      ],
    },
  ];

  if (esIntegrante) {
    grupos.push(
      {
        id: "ventas",
        icono: "💳",
        texto: "Ventas",
        enlaces: [
          { a: "/ventas", texto: "Resumen de ventas", fin: true },
          { a: "/ventas/registrar", texto: "Registrar venta" },
        ],
      },
      {
        id: "inventario",
        icono: "📦",
        texto: "Inventario",
        enlaces: [
          { a: "/inventario", texto: "Gestión de inventario", fin: true },
          { a: "/inventario/alertas-vencimiento", texto: "Alertas de vencimiento" },
          { a: "/inventario/descuentos", texto: "Descuentos" },
        ],
      }
    );
  } else {
    grupos.push({
      id: "compras",
      icono: "🛒",
      texto: "Mis compras",
      enlaces: [
        { a: "/carrito", texto: "Carrito" },
        { a: "/historial-compras", texto: "Historial de compras" },
      ],
    });
  }

  const enlacesNotificaciones = [
    { a: "/notificaciones", texto: "Notificaciones del sistema", fin: true },
    { a: "/notificaciones/clientes", texto: "Descuentos para clientes" },
  ];
  if (esIntegrante) {
    enlacesNotificaciones.push({ a: "/notificaciones/empleados", texto: "Descuentos para empleados" });
  }
  grupos.push({
    id: "notificaciones",
    icono: "🔔",
    texto: "Notificaciones",
    enlaces: enlacesNotificaciones,
  });

  grupos.push({
    id: "perfil",
    icono: "👤",
    texto: "Perfil",
    enlaces: [
      { a: "/perfil", texto: "Mis datos", fin: true },
      { a: "/perfil/horarios", texto: "Horarios de atención" },
    ],
  });

  return grupos;
}

export default function Layout({ children }) {
  const { usuario, cerrarSesion } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();
  const [menuAbierto, setMenuAbierto] = useState(false);
  const esAdministrador = usuario?.rol === "administrador";
  const esIntegrante = usuario?.rol === "integrante" || esAdministrador;

  const grupos = useMemo(() => construirGrupos(esIntegrante), [esIntegrante]);

  const grupoActivo = useMemo(
    () => grupos.find((g) => g.enlaces.some((e) => location.pathname.startsWith(e.a)))?.id,
    [grupos, location.pathname]
  );

  const [expandidos, setExpandidos] = useState(() => new Set(grupoActivo ? [grupoActivo] : []));

  useEffect(() => {
    if (grupoActivo) {
      setExpandidos((prev) => new Set(prev).add(grupoActivo));
    }
  }, [grupoActivo]);

  function alternarGrupo(id) {
    setExpandidos((prev) => {
      const siguiente = new Set(prev);
      if (siguiente.has(id)) siguiente.delete(id);
      else siguiente.add(id);
      return siguiente;
    });
  }

  async function manejarSalir() {
    await cerrarSesion();
    navigate("/login");
  }

  return (
    <div className="app-shell">
      <aside className={`sidebar ${menuAbierto ? "sidebar-abierta" : ""}`}>
        <div className="sidebar-marca">
          <span className="sidebar-marca-icono">⚕</span>
          <span className="sidebar-marca-texto">Farma 30</span>
        </div>

        <nav className="sidebar-nav">
          {grupos.map((grupo) => {
            const abierto = expandidos.has(grupo.id) || grupo.id === grupoActivo;
            return (
              <div className="sidebar-grupo" key={grupo.id}>
                <button
                  type="button"
                  className={`sidebar-grupo-cabecera ${grupo.id === grupoActivo ? "sidebar-grupo-cabecera-activa" : ""}`}
                  onClick={() => alternarGrupo(grupo.id)}
                  aria-expanded={abierto}
                >
                  <span className="sidebar-enlace-icono" aria-hidden="true">{grupo.icono}</span>
                  <span className="sidebar-grupo-texto">{grupo.texto}</span>
                  <span className={`sidebar-grupo-flecha ${abierto ? "sidebar-grupo-flecha-abierta" : ""}`} aria-hidden="true">›</span>
                </button>

                <div className={`sidebar-subnav ${abierto ? "sidebar-subnav-abierta" : ""}`}>
                  {grupo.enlaces.map((enlace) => (
                    <NavLink
                      key={enlace.a}
                      to={enlace.a}
                      end={enlace.fin}
                      className={({ isActive }) => `sidebar-subenlace ${isActive ? "sidebar-subenlace-activo" : ""}`}
                      onClick={() => setMenuAbierto(false)}
                    >
                      {enlace.texto}
                    </NavLink>
                  ))}
                </div>
              </div>
            );
          })}
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
              <span className="sidebar-usuario-rol">
                {esAdministrador ? "Administrador" : esIntegrante ? "Integrante" : "Cliente"}
              </span>
            </div>
          </div>
          <button className="secundario sidebar-salir" onClick={manejarSalir}>
            Cerrar sesión
          </button>
        </div>
      </aside>

      {menuAbierto && <div className="sidebar-overlay" onClick={() => setMenuAbierto(false)} />}

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
