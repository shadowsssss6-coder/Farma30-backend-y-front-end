/**
 * Insignia visual de estado de un producto, según cantidad y
 * fecha de vencimiento. Es el elemento visual que se repite en
 * Catálogo, Inventario y Alertas de vencimiento.
 */
export default function Insignia({ producto }) {
  const hoy = new Date();
  const vencimiento = producto.fecha_vencimiento ? new Date(producto.fecha_vencimiento) : null;
  const diasParaVencer = vencimiento ? Math.ceil((vencimiento - hoy) / 86400000) : null;

  let clase = "insignia-disponible";
  let texto = "Disponible";

  if (producto.cantidad <= 0) {
    clase = "insignia-agotado";
    texto = "Agotado";
  } else if (diasParaVencer !== null && diasParaVencer < 0) {
    clase = "insignia-vencido";
    texto = "Vencido";
  } else if (diasParaVencer !== null && diasParaVencer <= 30) {
    clase = "insignia-por-vencer";
    texto = `Vence en ${diasParaVencer}d`;
  }

  return <span className={`insignia ${clase}`}>{texto}</span>;
}