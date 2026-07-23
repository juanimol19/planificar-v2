// ─── Tipos usados por los formularios del docente ────────────────────────────

export interface Periodo {
  nombre: string
  eje: string
  saberes: string
  consideraciones_didacticas: string
  aprendizajes_esperados: string
}

export interface Materia {
  nombre: string
  criterios_evaluacion: string
  instrumentos_evaluacion: string
  periodos: Periodo[]
}

export interface DatosAnual {
  fecha_presentacion: string
  diagnostico: string
  bibliografia: string
  grado: string
  ciclo: string
  anio: string
  materias: Materia[]
  saberes_transversales: string
}

export interface DatosDiaria {
  fecha_estimada: string
  fecha_desarrollada: string
  fecha_presentacion: string
  contenidos_especificos: string
  actividades: string
  tareas: string
}

// ─── Tipos de respuesta del back (Laravel) ───────────────────────────────────

export interface EstadoAnualAPI {
  id: number
  estado: string
  fecha: string
  observaciones?: string
  planificacion_anual_id: number
  created_at: string
  updated_at: string
}

export interface PlanificacionAnualAPI {
  id: number
  fecha_presentacion: string
  aprendizajes_esperados: string
  saberes: string
  criterios: string
  bibliografia: string
  diagnostico: string
  contenido: DatosAnual
  grado: string
  ciclo: string
  anio: string
  saberes_transversales: string
  areas_id: number
  persona_cargo_cursado_id: number
  tipo_planificacion: string
  created_at: string
  updated_at: string
  area?: { id: number; nombre: string }
  persona_cargo_cursado?: {
    id: number
    persona_cargo?: {
      persona?: { id: number; nombres: string; apellidos: string }
    }
    cursado?: {
      id: number
      curso?: { id: number; grado: string; seccion: string; turno: string }
    }
  }
  estados_anuales?: EstadoAnualAPI[]
}