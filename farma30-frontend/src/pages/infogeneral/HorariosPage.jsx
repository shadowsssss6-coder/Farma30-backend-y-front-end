import { useEffect, useState } from "react";
import { obtenerHorarios } from "../../services/infoGeneralService";

export default function HorariosPage() {
  const [horarios, setHorarios] = useState([]);

  useEffect(() => {
    obtenerHorarios().then(setHorarios);
  }, []);

  return (
    <div>
      <h1>Horarios de atención</h1>
      <ul>
        {horarios.map((h) => (
          <li key={h.dia_semana}>{h.dia_semana}: {h.hora_apertura} - {h.hora_cierre}</li>
        ))}
      </ul>
    </div>
  );
}
