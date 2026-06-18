export type EstadoPlanificacion = 'Pendiente' | 'Aprobada' | 'Correccion' | 'Rechazada'

export interface Comentario {
  id: number
  autor: string
  texto: string
  fecha: string
}

export interface VersionHistorial {
  version: number
  fecha: string
  estado: EstadoPlanificacion
  nota: string
}

export interface Planificacion {
  id: number
  titulo: string
  docente: string
  curso: string
  estado: EstadoPlanificacion
  fechaEnvio: string
  archivoNombre: string
  objetivos: string
  contenidos: string
  actividades: string
  comentarios: Comentario[]
  historial: VersionHistorial[]
}
