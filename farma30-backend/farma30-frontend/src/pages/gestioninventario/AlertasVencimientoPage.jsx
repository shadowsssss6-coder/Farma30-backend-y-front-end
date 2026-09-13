import { useEffect, useState } from "react";
import { obtenerAlertasVencimiento } from "../../services/productoService";

export default function AlertasVencimientoPage() {
  const [productos, setProductos] = useState([]);

  useEffect(() => {
    obtenerAlertasVencimiento().then(setProductos);
  }, []);

  return (
    <div>
      <h1>Alertas de vencimiento</h1>
      {productos.length === 0 && <p>Sin productos próximos a vencer.</p>}
      <ul>
        {productos.map((producto) => (
          <li key={producto.id}>{producto.nombre} — vence: {producto.fecha_vencimiento}</li>
        ))}
      </ul>
    </div>
  );
}
