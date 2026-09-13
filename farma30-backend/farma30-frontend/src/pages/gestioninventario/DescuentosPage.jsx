import { useEffect, useState } from "react";
import { obtenerAlertasVencimiento, actualizarProducto } from "../../services/productoService";

/** RF08 — aplicar descuentos, apoyado en los productos con alerta de vencimiento. */
export default function DescuentosPage() {
  const [productos, setProductos] = useState([]);

  useEffect(() => {
    obtenerAlertasVencimiento().then(setProductos);
  }, []);

  async function aplicarDescuento(id, precioActual) {
    const nuevoPrecio = Number((precioActual * 0.7).toFixed(2));
    await actualizarProducto(id, { precio: nuevoPrecio });
    setProductos((previos) => previos.map((p) => (p.id === id ? { ...p, precio: nuevoPrecio } : p)));
  }

  return (
    <div>
      <h1>Descuentos</h1>
      <ul>
        {productos.map((producto) => (
          <li key={producto.id}>
            {producto.nombre} — ${producto.precio}
            <button onClick={() => aplicarDescuento(producto.id, producto.precio)}>Aplicar 30% de descuento</button>
          </li>
        ))}
      </ul>
    </div>
  );
}
