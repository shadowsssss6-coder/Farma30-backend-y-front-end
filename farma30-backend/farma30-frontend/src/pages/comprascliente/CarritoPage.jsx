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