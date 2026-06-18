import { reactive } from 'vue'
import type { Docente } from '@/types/Docente'

export const docentesMock = reactive<Docente[]>([
  {
    id: 1,
    nombre: 'Juan',
    apellido: 'Pérez',
    dni: '28456789',
    email: 'juan@escuela.com',
    telefono: '3624-112233',
    grado: '5° A',
    fechaIngreso: '2019-03-01',
    estado: 'Activo',
    planificaciones: [
      { id: 1, curso: '5° A', estado: 'Pendiente' },
      { id: 6, curso: '5° A', estado: 'Aprobada' },
    ],
  },
  {
    id: 2,
    nombre: 'María',
    apellido: 'Gómez',
    dni: '30112233',
    email: 'maria@escuela.com',
    telefono: '3624-223344',
    grado: '4° B',
    fechaIngreso: '2020-02-15',
    estado: 'Activo',
    planificaciones: [
      { id: 2, curso: '4° B', estado: 'Aprobada' },
    ],
  },
  {
    id: 3,
    nombre: 'Carlos',
    apellido: 'López',
    dni: '27889900',
    email: 'carlos@escuela.com',
    telefono: '3624-334455',
    grado: '6° A',
    fechaIngreso: '2017-03-10',
    estado: 'Activo',
    planificaciones: [
      { id: 3, curso: '6° A', estado: 'Correccion' },
    ],
  },
  {
    id: 4,
    nombre: 'Ana',
    apellido: 'Martínez',
    dni: '31445566',
    email: 'ana@escuela.com',
    telefono: '3624-445566',
    grado: '3° A',
    fechaIngreso: '2021-04-01',
    estado: 'Activo',
    planificaciones: [
      { id: 4, curso: '3° A', estado: 'Pendiente' },
    ],
  },
  {
    id: 5,
    nombre: 'Luis',
    apellido: 'Fernández',
    dni: '29667788',
    email: 'luis@escuela.com',
    telefono: '3624-556677',
    grado: '2° B',
    fechaIngreso: '2022-03-01',
    estado: 'Inactivo',
    planificaciones: [
      { id: 5, curso: '2° B', estado: 'Aprobada' },
    ],
  },
])

let nextId = 6
export function agregarDocente(docente: Omit<Docente, 'id' | 'planificaciones'>) {
  docentesMock.push({
    ...docente,
    id: nextId++,
    planificaciones: [],
  })
}
