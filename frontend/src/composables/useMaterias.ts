import { ref } from 'vue'
import type { Materia } from '@/types/planificacion'
import { materiaVacia } from '@/utils/planificacionAnual'

export function useMaterias(materias: Materia[]) {
  const materiaActivaIdx = ref(0)

  function agregarMateria(nombre: string = '') {
    materias.push(materiaVacia(nombre))
    materiaActivaIdx.value = materias.length - 1
  }

  function eliminarMateria(idx: number) {
    if (materias.length === 1) return
    materias.splice(idx, 1)
    if (materiaActivaIdx.value >= materias.length) {
      materiaActivaIdx.value = materias.length - 1
    }
  }

  return {
    materiaActivaIdx,
    agregarMateria,
    eliminarMateria,
  }
}