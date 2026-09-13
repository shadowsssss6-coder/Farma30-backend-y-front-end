import { useState } from "react";
import { buscarProductos } from "../../services/productoService";

export default function BusquedaPage() {
  const [texto, setTexto] = useState("");
  const [resultados, setResultados] = useState([]);
  const [cargando, setCargando] = useState(false);

  async function manejarBuscar(evento) {
    evento.preventDefault();
    setCargando(true);
    try {
      setResultados(await buscarProductos(texto));
    } finally {
      setCargando(false);
    }
  }

  return (
    <div>
      <h1>Buscar producto</h1>
      <form onSubmit={manejarBuscar}>
        <input type="text" placeholder="Nombre del producto" value={texto} onChange={(e) => setTexto(e.target.value)} />
        <button type="submit" disabled={cargando}>Buscar</button>
      </form>
      <ul>
        {resultados.map((producto) => (
          <li key={producto.id}>{producto.nombre} — ${producto.precio}</li>
        ))}
      </ul>
      {resultados.length === 0 && !cargando && <p>Sin resultados</p>}
    </div>
  );
}
