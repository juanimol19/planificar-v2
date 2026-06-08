export interface Planificacion {
  id: number
  docente: string
  curso: string
  estado: 'Pendiente' | 'Aprobada' | 'Correccion'
}