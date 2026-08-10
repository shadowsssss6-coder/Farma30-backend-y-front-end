import { useEffect, useState } from "react";
import { obtenerCatalogo } from "../../services/productoService";

/** RF05 — reutiliza el catálogo; si más adelante existe una lista de
 *  deseados propia por usuario, este componente solo cambia su fuente de datos. */
export default function DeseadosPage() {
  const [productos, setProductos] = useState([]);

  useEffect(() => {
    obtenerCatalogo().then(setProductos);
  }, []);

  return (
    <div>
      <h1>Productos deseados</h1>
      <ul>
        {productos.map((producto) => (
          <li key={producto.id}>♥ {producto.nombre} — ${producto.precio}</li>
        ))}
      </ul>
    </div>
  );
}
