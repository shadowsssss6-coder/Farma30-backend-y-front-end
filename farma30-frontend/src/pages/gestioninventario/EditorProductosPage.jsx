import { useEffect, useState } from "react";
import { obtenerCatalogo, actualizarProducto, crearProducto, eliminarProducto } from "../../services/productoService";
import "./Gestion.css";

const PRODUCTO_VACIO = {
  nombre: "",
  precio: "",
  cantidad: "",
  fecha_vencimiento: "",
  codigo_barras: "",
};

export default function EditorProductosPage() {
  const [productos, setProductos] = useState([]);
  const [cargando, setCargando] = useState(true);
  const [mensaje, setMensaje] = useState("");
  const [error, setError] = useState("");
  const [nuevo, setNuevo] = useState(PRODUCTO_VACIO);
  const [creando, setCreando] = useState(false);

  useEffect(() => {
    cargar();
  }, []);

  function cargar() {
    setCargando(true);
    obtenerCatalogo()
      .then(setProductos)
      .finally(() => setCargando(false));
  }

  async function manejarCambio(id, campo, valor) {
    try {
      const actualizado = await actualizarProducto(id, { [campo]: valor });
      setProductos((previos) => previos.map((p) => (p.id === id ? actualizado : p)));
      setMensaje("Producto actualizado.");
      setError("");
    } catch {
      setError("No fue posible actualizar el producto.");
    }
  }

  async function manejarEliminar(id) {
    if (!window.confirm("¿Eliminar este producto del catálogo?")) return;
    try {
      await eliminarProducto(id);
      setProductos((previos) => previos.filter((p) => p.id !== id));
      setMensaje("Producto eliminado.");
      setError("");
    } catch (err) {
      setError(err.response?.data?.mensaje ?? "No fue posible eliminar el producto.");
    }
  }

  async function manejarCrear(evento) {
    evento.preventDefault();
    setCreando(true);
    setError("");
    try {
      const creado = await crearProducto({
        ...nuevo,
        precio: Number(nuevo.precio),
        cantidad: Number(nuevo.cantidad),
        codigo_barras: nuevo.codigo_barras || undefined,
      });
      setProductos((previos) => [creado, ...previos]);
      setNuevo(PRODUCTO_VACIO);
      setMensaje("Producto agregado al catálogo.");
    } catch (err) {
      setError(err.response?.data?.message ?? "No fue posible agregar el producto.");
    } finally {
      setCreando(false);
    }
  }

  return (
    <div>
      <h1>Gestión de inventario</h1>
      <p className="page-sub">Agrega productos nuevos y edita precio, existencia o vencimiento de los ya registrados.</p>

      {mensaje && <p className="gestion-aviso gestion-aviso-ok">{mensaje}</p>}
      {error && <p role="alert">{error}</p>}

      <form onSubmit={manejarCrear} className="tarjeta gestion-form">
        <h3>Agregar producto</h3>
        <div className="gestion-form-grid">
          <div>
            <label htmlFor="nombre">Nombre</label>
            <input
              id="nombre"
              type="text"
              value={nuevo.nombre}
              onChange={(e) => setNuevo({ ...nuevo, nombre: e.target.value })}
              required
            />
          </div>
          <div>
            <label htmlFor="precio">Precio</label>
            <input
              id="precio"
              type="number"
              min="0"
              step="0.01"
              value={nuevo.precio}
              onChange={(e) => setNuevo({ ...nuevo, precio: e.target.value })}
              required
            />
          </div>
          <div>
            <label htmlFor="cantidad">Cantidad</label>
            <input
              id="cantidad"
              type="number"
              min="0"
              value={nuevo.cantidad}
              onChange={(e) => setNuevo({ ...nuevo, cantidad: e.target.value })}
              required
            />
          </div>
          <div>
            <label htmlFor="fecha_vencimiento">Fecha de vencimiento</label>
            <input
              id="fecha_vencimiento"
              type="date"
              value={nuevo.fecha_vencimiento}
              onChange={(e) => setNuevo({ ...nuevo, fecha_vencimiento: e.target.value })}
              required
            />
          </div>
          <div>
            <label htmlFor="codigo_barras">Código de barras (opcional)</label>
            <input
              id="codigo_barras"
              type="text"
              value={nuevo.codigo_barras}
              onChange={(e) => setNuevo({ ...nuevo, codigo_barras: e.target.value })}
            />
          </div>
        </div>
        <button type="submit" disabled={creando}>{creando ? "Agregando..." : "Agregar producto"}</button>
      </form>

      <div className="tarjeta gestion-tabla-envoltura">
        {cargando ? (
          <p style={{ padding: 20 }}>Cargando catálogo...</p>
        ) : (
          <table>
            <thead>
              <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Vencimiento</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              {productos.map((producto) => (
                <tr key={producto.id}>
                  <td>{producto.nombre}</td>
                  <td>
                    <input
                      type="number"
                      className="gestion-input-tabla"
                      defaultValue={producto.precio}
                      onBlur={(e) => manejarCambio(producto.id, "precio", Number(e.target.value))}
                    />
                  </td>
                  <td>
                    <input
                      type="number"
                      className="gestion-input-tabla"
                      defaultValue={producto.cantidad}
                      onBlur={(e) => manejarCambio(producto.id, "cantidad", Number(e.target.value))}
                    />
                  </td>
                  <td>
                    <input
                      type="date"
                      className="gestion-input-tabla"
                      defaultValue={producto.fecha_vencimiento?.slice(0, 10)}
                      onBlur={(e) => manejarCambio(producto.id, "fecha_vencimiento", e.target.value)}
                    />
                  </td>
                  <td>
                    <button className="peligro" type="button" onClick={() => manejarEliminar(producto.id)}>
                      Eliminar
                    </button>
                  </td>
                </tr>
              ))}
              {productos.length === 0 && (
                <tr>
                  <td colSpan={5} style={{ textAlign: "center", padding: 20 }}>
                    No hay productos registrados todavía.
                  </td>
                </tr>
              )}
            </tbody>
          </table>
        )}
      </div>
    </div>
  );
}
