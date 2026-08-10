import { useState } from "react";
import { useNavigate } from "react-router-dom";
import { registrarVenta } from "../../services/ventaService";

export default function RegistroVentaPage() {
  const navigate = useNavigate();
  const [productoId, setProductoId] = useState("");
  const [cantidad, setCantidad] = useState("");
  const [valor, setValor] = useState("");
  const [metodoPago, setMetodoPago] = useState("efectivo");
  const [error, setError] = useState("");
  const [cargando, setCargando] = useState(false);

  async function manejarSubmit(evento) {
    evento.preventDefault();
    setError("");
    setCargando(true);
    try {
      const venta = await registrarVenta({
        producto_id: Number(productoId),
        cantidad_vendida: Number(cantidad),
        valor_de_la_venta: Number(valor),
        metodo_de_pago: metodoPago,
      });
      navigate(`/ventas/${venta.id}`);
    } catch (err) {
      setError(err.response?.data?.message ?? "No fue posible registrar la venta.");
    } finally {
      setCargando(false);
    }
  }

  return (
    <div>
      <h1>Registrar venta</h1>
      <form onSubmit={manejarSubmit}>
        <input type="number" placeholder="Id del producto" value={productoId} onChange={(e) => setProductoId(e.target.value)} required />
        <input type="number" placeholder="Cantidad" value={cantidad} onChange={(e) => setCantidad(e.target.value)} required />
        <input type="number" step="0.01" placeholder="Valor total" value={valor} onChange={(e) => setValor(e.target.value)} required />
        <label><input type="radio" checked={metodoPago === "efectivo"} onChange={() => setMetodoPago("efectivo")} /> Efectivo</label>
        <label><input type="radio" checked={metodoPago === "electronico"} onChange={() => setMetodoPago("electronico")} /> Electrónico</label>
        {error && <p role="alert">{error}</p>}
        <button type="submit" disabled={cargando}>{cargando ? "Registrando..." : "Registrar venta"}</button>
      </form>
    </div>
  );
}
