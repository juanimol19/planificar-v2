export interface PlanificacionResumenCurso {
  id: number
  titulo: string
  estado: string
}

export interface Curso {
  id: number
  nombre: string
  ciclo: string
  turno: string
  docente: string
  planificaciones: PlanificacionResumenCurso[]
}