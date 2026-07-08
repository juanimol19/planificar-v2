export interface PlanificacionResumen {
  id: number
  curso: string
  estado: string
}

export interface Docente {
  id: number
  nombre: string
  apellido: string
  dni: string | null
  email: string
  telefono: string
  grado: string
  planificaciones: PlanificacionResumen[]
}