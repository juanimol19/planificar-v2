import apiClient from '@/api/axios'
import type { PlanificacionAnualAPI, EstadoAnualAPI } from '@/types/planificacionAPI'

// ─── Tipos del payload ────────────────────────────────────────────────────────

export interface CrearPlanificacionAnualPayload {
  fecha_presentacion: string
  aprendizajes_esperados: string
  saberes: string
  criterios: string
  bibliografia: string
  diagnostico: string
  areas_id: number
  persona_cargo_cursado_id: number
  tipo_planificacion: string
}

export interface CrearEstadoPayload {
  estado: string
  fecha: string
  planificacion_anual_id: number
  observaciones?: string
}

export interface CrearPlanificacionDiariaPayload {
  fecha_estimada: string
  fecha_desarrollada: string
  fecha_presentacion: string
  contenidos_especificos: string
  actividades: string
  tareas: string
  persona_cargo_cursado_id: number
  tipo_planificacion: string
}

// ─── Planificaciones ──────────────────────────────────────────────────────────

/**
 * Obtiene todas las planificaciones anuales.
 * Director: ve todas. Docente: el back filtra las suyas según el token.
 */
export const getPlanificaciones = async (): Promise<PlanificacionAnualAPI[]> => {
  const { data } = await apiClient.get('/planificacion-anual')
  return data
}

/**
 * Obtiene el detalle de una planificación por id, incluyendo estadosAnuales.
 */
export const getPlanificacion = async (id: number): Promise<PlanificacionAnualAPI> => {
  const { data } = await apiClient.get(`/planificacion-anual/${id}`)
  return data
}

/**
 * Crea una nueva planificación anual (la usa el docente al enviar el formulario).
 */
export const crearPlanificacion = async (
  payload: CrearPlanificacionAnualPayload,
): Promise<PlanificacionAnualAPI> => {
  const { data } = await apiClient.post('/planificacion-anual', payload)
  // El back devuelve { mensaje, planificacion }
  return data.planificacion ?? data
}

/**
 * Actualiza campos de una planificación (uso futuro).
 */
export const actualizarPlanificacion = async (
  id: number,
  payload: Partial<CrearPlanificacionAnualPayload>,
): Promise<PlanificacionAnualAPI> => {
  const { data } = await apiClient.put(`/planificacion-anual/${id}`, payload)
  return data.planificacion ?? data
}

/**
 * Elimina una planificación.
 */
export const eliminarPlanificacion = async (id: number): Promise<void> => {
  await apiClient.delete(`/planificacion-anual/${id}`)
}

// ─── Estados ──────────────────────────────────────────────────────────────────

/**
 * Crea un nuevo estado para una planificación.
 * Estados válidos: 'presentada' | 'aprobada' | 'correccion' | 'rechazada'
 */
export const crearEstado = async (payload: CrearEstadoPayload): Promise<EstadoAnualAPI> => {
  const { data } = await apiClient.post('/estados-anual', payload)
  return data.estado ?? data
}

export const crearPlanificacionDiaria = async (
  payload: CrearPlanificacionDiariaPayload,
): Promise<any> => {
  const { data } = await apiClient.post('/planificacion-diaria', payload)
  return data.planificacion ?? data
}

// ─── Helpers ──────────────────────────────────────────────────────────────────

/**
 * Devuelve el estado actual (último) de una planificación.
 */
export const estadoActual = (estados: EstadoAnualAPI[]): string => {
  if (!estados || estados.length === 0) return 'sin estado'
  const ordenados = [...estados].sort(
    (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime(),
  )
  return ordenados[0]?.estado ?? 'sin estado'
}

/**
 * Mapea el estado del back al label que muestra el front.
 */
export const labelEstado = (estado: string): string => {
  const mapa: Record<string, string> = {
    presentada: 'Pendiente',
    aprobada:   'Aprobada',
    correccion: 'Corrección',
    rechazada:  'Rechazada',
  }
  return mapa[estado.toLowerCase()] ?? estado
}

/**
 * Mapea el estado del back a la clase CSS de badge del director.
 */
export const claseEstado = (estado: string): string => {
  const mapa: Record<string, string> = {
    presentada: 'badge-pendiente',
    aprobada:   'badge-aprobada',
    correccion: 'badge-correccion',
    rechazada:  'badge-rechazada',
  }
  return mapa[estado.toLowerCase()] ?? ''
}

/**
 * Convierte el estado del front (botón director) al valor que espera el back.
 */
export const estadoFrontABack = (estadoFront: string): string => {
  const mapa: Record<string, string> = {
    Aprobada:   'aprobada',
    Correccion: 'correccion',
    Rechazada:  'rechazada',
  }
  return mapa[estadoFront] ?? estadoFront.toLowerCase()
}
