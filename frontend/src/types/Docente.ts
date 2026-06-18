export interface PlanificacionResumen {
  id: number
  curso: string
  estado: 'Pendiente' | 'Aprobada' | 'Correccion'
}

export interface Docente {
  id: number
  nombre: string
  apellido: string
  dni: string
  email: string
  telefono: string
  grado: string
  fechaIngreso: string
  estado: 'Activo' | 'Inactivo'
  planificaciones: PlanificacionResumen[]
}