import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { obtenerProducto } from "../../services/productoService";
import { agregarAlCarrito } from "../../services/comprasService";

export default function DetalleProductoPage() {
  const { id } = useParams();
  const [producto, setProducto] = useState(null);
  const [mensaje, setMensaje] = useState("");

  useEffect(() => {
    obtenerProducto(id).then(setProducto);
  }, [id]);

  async function manejarAgregar() {
    await agregarAlCarrito(producto.id, 1);
    setMensaje("Agregado al carrito.");
  }

  if (!producto) return <p>Cargando...</p>;

  return (
    <div>
      <h1>{producto.nombre}</h1>
      <p>Precio: ${producto.precio}</p>
      <p>Disponibles: {producto.cantidad}</p>
      <p>Vence: {producto.fecha_vencimiento}</p>
      <button onClick={manejarAgregar}>Agregar al carrito</button>
      {mensaje && <p>{mensaje}</p>}
    </div>
  );
}
