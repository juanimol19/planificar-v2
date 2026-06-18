import type { Periodo, Materia } from '@/types/planificacion'

// ─── Períodos sugeridos ───────────────────────────────────────────────────────

export const PERIODOS_SUGERIDOS: string[] = [
  'Marzo - Abril',
  'Mayo - Junio',
  'Julio - Agosto - Septiembre',
  'Octubre - Noviembre',
  'Diciembre',
]

// ─── Sugerencias de eje por materia ──────────────────────────────────────────

const SUGERENCIAS_EJE: Record<string, string[]> = {
  'matemática':         ['Números y operaciones', 'Geometría y medida', 'Álgebra', 'Estadística y probabilidad'],
  'lengua':             ['Lectura y comprensión', 'Producción escrita', 'Oralidad', 'Gramática y normativa'],
  'ciencias naturales': ['Seres vivos', 'El cuerpo humano', 'Materia y energía', 'El universo'],
  'ciencias sociales':  ['Historia', 'Geografía', 'Economía y sociedad', 'Ciudadanía'],
  'educación física':   ['Habilidades motrices', 'Juegos y deportes', 'Vida en la naturaleza', 'Expresión corporal'],
  'música':             ['Apreciación musical', 'Ritmo y melodía', 'Producción vocal', 'Historia de la música'],
  'plástica':           ['Dibujo y pintura', 'Escultura y volumen', 'Lenguaje visual', 'Arte y cultura'],
  'tecnología':         ['Materiales y procesos', 'Informática', 'Diseño y construcción', 'Tecnología y sociedad'],
  'inglés':             ['Reading & Comprehension', 'Writing', 'Listening & Speaking', 'Grammar'],
  'formación ética':    ['Valores y convivencia', 'Derechos y responsabilidades', 'Identidad y diversidad', 'Participación ciudadana'],
}

const EJE_GENERICO = 'Ej: Eje temático del período'

export function sugerenciaEje(nombreMateria: string): string {
  const clave = nombreMateria.trim().toLowerCase()
  const coincidencia = Object.keys(SUGERENCIAS_EJE).find(k => clave.includes(k))
  const sugerencias = coincidencia ? SUGERENCIAS_EJE[coincidencia] : null
  if (!sugerencias) return EJE_GENERICO
  return sugerencias.join(' · ')
}

// ─── Materias predefinidas ────────────────────────────────────────────────────

export const MATERIAS_PREDEFINIDAS: string[] = Object.keys(SUGERENCIAS_EJE).map(
  nombre => nombre.charAt(0).toUpperCase() + nombre.slice(1)
)

// ─── Factories ────────────────────────────────────────────────────────────────

export function periodosIniciales(): Periodo[] {
  return PERIODOS_SUGERIDOS.map(nombre => ({
    nombre,
    eje: '',
    saberes: '',
    consideraciones_didacticas: '',
    aprendizajes_esperados: '',
  }))
}

export function materiaVacia(nombre: string = ''): Materia {
  return {
    nombre,
    criterios_evaluacion: '',
    instrumentos_evaluacion: '',
    periodos: periodosIniciales(),
  }
}