import { useEffect, useState } from "react";
import { useParams } from "react-router-dom";
import { obtenerDetalleVenta } from "../../services/ventaService";

export default function DetalleVentaPage() {
  const { id } = useParams();
  const [venta, setVenta] = useState(null);

  useEffect(() => {
    obtenerDetalleVenta(id).then(setVenta);
  }, [id]);

  if (!venta) return <p>Cargando...</p>;

  return (
    <div>
      <h1>Detalle de venta</h1>
      <p>Producto: {venta.producto_nombre}</p>
      <p>Cantidad: {venta.cantidad_vendida}</p>
      <p>Valor: ${venta.valor_de_la_venta}</p>
      <p>Método de pago: {venta.metodo_de_pago}</p>
      <p>Fecha: {venta.fecha_hora}</p>
    </div>
  );
}
