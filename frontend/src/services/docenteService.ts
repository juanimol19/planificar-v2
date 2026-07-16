import apiClient from '@/api/axios'

// ─── Tipos de la respuesta del backend ───────────────────────────────────────

export interface CursoAPI {
  id: number
  ciclo: string
  grado: string
  seccion: string
  turno: string
}

export interface CursadoAPI {
  id: number
  curso: CursoAPI
}

export interface PersonaCargoCursadoAPI {
  id: number
  cursado: CursadoAPI
}

export interface CargoAPI {
  id: number
  cargo: string
}

export interface PersonaCargoAPI {
  id: number
  cargo: CargoAPI
  persona_cargo_cursados: PersonaCargoCursadoAPI[]
}

export interface RolAPI {
  id: number
  name: string
}

export interface UserAPI {
  id: number
  name: string
  email: string
  roles: RolAPI[]
}

export interface DocenteAPI {
  id: number
  nombres: string
  apellidos: string
  dni: string | null
  'e-mail': string | null
  telefono: string
  direccion: string
  fecha_nacimiento: string | null
  user: UserAPI | null
  persona_cargos: PersonaCargoAPI[]
}

// ─── Docentes ─────────────────────────────────────────────────────────────────

/**
 * Obtiene la lista de personas con rol docente, incluyendo cargo y curso asignado.
 */
export const getDocentes = async (): Promise<DocenteAPI[]> => {
  const { data } = await apiClient.get('/personas-docentes')
  return data
}

// ─── Alta de docente (creación en cascada) ─────────────────────────────────────

export interface CrearDocentePayload {
  // Usuario
  name: string
  email: string
  password: string
  password_confirmation: string

  // Persona
  apellidos: string
  nombres: string
  dni?: string | null
  telefono: string
  direccion: string
  fecha_nacimiento?: string | null

  // Persona-Cargo
  cargos_id: number
  sit_revista_id: number

  // Cursado (curso ya elegido + año lectivo nuevo)
  cursos_id: number
  anio_lectivo: string
  fecha_inicio: string
  fecha_fin: string
}

export interface CrearDocenteResponse {
  mensaje: string
  docente: {
    user: UserAPI
    persona: DocenteAPI
    persona_cargo: PersonaCargoAPI
    cursado: CursadoAPI
    persona_cargo_cursado: PersonaCargoCursadoAPI
  }
}

/**
 * Crea un docente completo: User + Persona + PersonaCargo + Cursado + PersonaCargoCursado.
 */
export const crearDocente = async (payload: CrearDocentePayload): Promise<CrearDocenteResponse> => {
  const { data } = await apiClient.post('/docentes', payload)
  return data
}