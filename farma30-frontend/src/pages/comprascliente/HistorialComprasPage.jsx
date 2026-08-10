import { useEffect, useState } from "react";
import { obtenerHistorial, borrarHistorial, volverAComprar } from "../../services/comprasService";

export default function HistorialComprasPage() {
  const [historial, setHistorial] = useState([]);

  useEffect(() => {
    obtenerHistorial().then(setHistorial);
  }, []);

  async function manejarBorrar() {
    await borrarHistorial();
    setHistorial([]);
  }

  return (
    <div>
      <h1>Historial de compras</h1>
      <button onClick={manejarBorrar}>Borrar historial</button>
      <ul>
        {historial.map((compra) => (
          <li key={compra.id}>
            {compra.nombre_de_producto} — ${compra.valor_de_la_compra} — {compra.fecha_de_compra}
            <button onClick={() => volverAComprar(compra.id)}>Volver a comprar</button>
          </li>
        ))}
      </ul>
    </div>
  );
}
