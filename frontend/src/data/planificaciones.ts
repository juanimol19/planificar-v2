export type Tipo = 'anual' | 'diaria'
export type Estado = 'borrador' | 'confirmada' | 'rechazada'

export interface Planificacion {
  id: number
  cursoId: number
  tipo: Tipo
  materia: string
  grado: string
  fecha: string
  estado: Estado
}

export const planificaciones: Planificacion[] = [
  { id: 1, cursoId: 4, tipo: 'anual',  materia: 'Matemáticas',        grado: '3° grado', fecha: '05 jun 2026', estado: 'confirmada' },
  { id: 2, cursoId: 7, tipo: 'diaria', materia: 'Lengua y Literatura', grado: '4° grado', fecha: '03 jun 2026', estado: 'borrador'   },
  { id: 3, cursoId: 3, tipo: 'anual',  materia: 'Ciencias Naturales',  grado: '2° grado', fecha: '01 jun 2026', estado: 'confirmada' },
  { id: 4, cursoId: 7, tipo: 'diaria', materia: 'Educación Física',    grado: '5° grado', fecha: '28 may 2026', estado: 'borrador'   },
  { id: 5, cursoId: 1, tipo: 'anual',  materia: 'Ciencias Sociales',   grado: '1° grado', fecha: '20 may 2026', estado: 'rechazada'  },
]

export const etiquetaEstado: Record<Estado, string> = {
  borrador: 'Borrador',
  confirmada: 'Aceptado',
  rechazada: 'Rechazada',
}