import apiClient from '@/api/axios'

export interface PersonaCursoAPI {
  id: number
  nombres: string
  apellidos: string
}

export interface PersonaCargoCursoAPI {
  id: number
  persona: PersonaCursoAPI | null
}

export interface PersonaCargoCursadoCursoAPI {
  id: number
  persona_cargo: PersonaCargoCursoAPI | null
}

export interface CursadoAPI {
  id: number
  anio_lectivo: number
  fecha_inicio: string
  fecha_fin: string
  persona_cargo_cursados: PersonaCargoCursadoCursoAPI[]
}

export interface CursoAPI {
  id: number
  ciclo: string
  grado: string
  seccion: string
  turno: string
  cursados: CursadoAPI[]
}

export async function getCursosConDocente(): Promise<CursoAPI[]> {
  const { data } = await apiClient.get<CursoAPI[]>('/cursos-con-docente')
  return data
}