export interface PlanificacionResumenCurso {
  id: number
  titulo: string
  estado: 'Pendiente' | 'Aprobada' | 'Correccion'
}

export interface Curso {
  id: number
  nombre: string
  ciclo: string
  turno: 'Mañana' | 'Tarde'
  docente: string
  cantidadAlumnos: number
  planificaciones: PlanificacionResumenCurso[]
}
