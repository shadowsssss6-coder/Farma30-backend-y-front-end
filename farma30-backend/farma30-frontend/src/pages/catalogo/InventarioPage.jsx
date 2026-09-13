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