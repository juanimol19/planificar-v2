import type { Materia, Periodo } from '@/types/planificacion'

export function usePeriodos() {
  function agregarPeriodo(materia: Materia) {
    const nuevoPeriodo: Periodo = {
      nombre: '',
      eje: '',
      saberes: '',
      consideraciones_didacticas: '',
      aprendizajes_esperados: '',
    }
    materia.periodos.push(nuevoPeriodo)
  }

  function eliminarPeriodo(materia: Materia, idx: number) {
    if (materia.periodos.length === 1) return
    materia.periodos.splice(idx, 1)
  }

  return {
    agregarPeriodo,
    eliminarPeriodo,
  }
}