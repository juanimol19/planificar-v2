import { reactive } from 'vue'
import type { Curso } from '@/types/Curso'

export const cursosMock = reactive<Curso[]>([
  {
    id: 1,
    nombre: '1° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'Ana Martínez',
    cantidadAlumnos: 24,
    planificaciones: [
      { id: 4, titulo: 'Unidad 3 - Números naturales', estado: 'Pendiente' },
    ],
  },
  {
    id: 2,
    nombre: '1° B',
    ciclo: 'Primario',
    turno: 'Tarde',
    docente: 'Luis Fernández',
    cantidadAlumnos: 22,
    planificaciones: [
      { id: 5, titulo: 'Unidad 2 - El cuerpo humano', estado: 'Aprobada' },
    ],
  },
  {
    id: 3,
    nombre: '2° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'Luis Fernández',
    cantidadAlumnos: 26,
    planificaciones: [],
  },
  {
    id: 4,
    nombre: '3° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'Ana Martínez',
    cantidadAlumnos: 23,
    planificaciones: [
      { id: 4, titulo: 'Unidad 3 - Números naturales', estado: 'Pendiente' },
    ],
  },
  {
    id: 5,
    nombre: '3° B',
    ciclo: 'Primario',
    turno: 'Tarde',
    docente: 'María Gómez',
    cantidadAlumnos: 25,
    planificaciones: [
      { id: 2, titulo: 'Unidad 1 - Sistema solar', estado: 'Aprobada' },
    ],
  },
  {
    id: 6,
    nombre: '4° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'María Gómez',
    cantidadAlumnos: 27,
    planificaciones: [
      { id: 2, titulo: 'Unidad 1 - Sistema solar', estado: 'Aprobada' },
    ],
  },
  {
    id: 7,
    nombre: '5° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'Juan Pérez',
    cantidadAlumnos: 24,
    planificaciones: [
      { id: 1, titulo: 'Unidad 4 - Fracciones', estado: 'Pendiente' },
      { id: 6, titulo: 'Unidad 3 - Geometría', estado: 'Aprobada' },
    ],
  },
  {
    id: 8,
    nombre: '6° A',
    ciclo: 'Primario',
    turno: 'Mañana',
    docente: 'Carlos López',
    cantidadAlumnos: 21,
    planificaciones: [
      { id: 3, titulo: 'Unidad 2 - Revolución de mayo', estado: 'Correccion' },
    ],
  },
])

let nextId = 9
export function agregarCurso(curso: Omit<Curso, 'id' | 'planificaciones'>) {
  cursosMock.push({
    ...curso,
    id: nextId++,
    planificaciones: [],
  })
}
