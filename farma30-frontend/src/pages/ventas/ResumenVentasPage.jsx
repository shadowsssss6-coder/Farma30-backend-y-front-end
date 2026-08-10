import { useEffect, useState } from "react";
import { obtenerResumenVentas } from "../../services/ventaService";

export default function ResumenVentasPage() {
  const [resumen, setResumen] = useState(null);
  const [periodo, setPeriodo] = useState("dia");

  useEffect(() => {
    obtenerResumenVentas().then(setResumen);
  }, []);

  if (!resumen) return <p>Cargando...</p>;

  const claves = {
    dia: "cantidad_vendida_en_el_dia",
    semana: "cantidad_vendida_en_la_semana",
    mes: "cantidad_vendida_en_el_mes",
  };

  return (
    <div>
      <h1>Resumen de ventas</h1>
      <label><input type="radio" checked={periodo === "dia"} onChange={() => setPeriodo("dia")} /> Día</label>
      <label><input type="radio" checked={periodo === "semana"} onChange={() => setPeriodo("semana")} /> Semana</label>
      <label><input type="radio" checked={periodo === "mes"} onChange={() => setPeriodo("mes")} /> Mes</label>
      <p style={{ fontSize: "2rem" }}>{resumen[claves[periodo]]}</p>
    </div>
  );
}
