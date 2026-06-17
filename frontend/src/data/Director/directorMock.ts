import { reactive } from 'vue'
import type { Director } from '@/types/Director'

export const directorActual = reactive<Director>({
  nombre: 'Carlos',
  apellido: 'Rodríguez',
  dni: '24558712',
  email: 'carlos.rodriguez@escuela.com',
  telefono: '3624-998877',
  fotoUrl: null,
  institucion: 'Escuela N° 123 "General San Martín"',
  fechaIngreso: '2015-03-01',
})
