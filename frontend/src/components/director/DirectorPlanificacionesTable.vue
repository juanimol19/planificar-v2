<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  getPlanificaciones,
  estadoActual,
  labelEstado,
  claseEstado,
} from '@/services/planificacionService'
import type { PlanificacionAnualAPI } from '@/types/planificacionAPI'

const route  = useRoute()
const router = useRouter()

const planificaciones  = ref<PlanificacionAnualAPI[]>([])
const cargando         = ref(true)
const error            = ref<string | null>(null)
const filtroEstado     = ref<string>((route.query.estado as string) || 'Todas')

watch(() => route.query.estado, (nuevo) => {
  filtroEstado.value = (nuevo as string) || 'Todas'
})

const planificacionesFiltradas = computed(() => {
  if (filtroEstado.value === 'Todas') return planificaciones.value
  return planificaciones.value.filter(p => {
    const label = labelEstado(estadoActual(p.estados_anuales ?? []))
    return label === filtroEstado.value
  })
})

const cambiarFiltro = (estado: string) => {
  filtroEstado.value = estado
  router.replace({ query: estado === 'Todas' ? {} : { estado } })
}

const verDetalle = (id: number) => router.push(`/director/planificaciones/${id}`)

const nombreDocente = (p: PlanificacionAnualAPI): string => {
  const persona = p.persona_cargo_cursado?.persona
  if (!persona) return '—'
  return `${persona.nombre} ${persona.apellido}`
}

const nombreCurso = (p: PlanificacionAnualAPI): string => {
  return p.persona_cargo_cursado?.cursado?.curso?.nombre ?? '—'
}

const inicialesDocente = (p: PlanificacionAnualAPI): string => {
  const persona = p.persona_cargo_cursado?.persona
  if (!persona) return '?'
  return `${persona.nombre[0] ?? ''}${persona.apellido[0] ?? ''}`.toUpperCase()
}

const formatearFecha = (fecha: string) =>
  new Date(fecha).toLocaleDateString('es-AR', { year: 'numeric', month: 'short', day: 'numeric' })

onMounted(async () => {
  try {
    planificaciones.value = await getPlanificaciones()
  } catch (e) {
    error.value = 'No se pudieron cargar las planificaciones. Verificá la conexión con el servidor.'
    console.error(e)
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="filtros-bar">
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Todas' }"      @click="cambiarFiltro('Todas')">Todas</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Pendiente' }"  @click="cambiarFiltro('Pendiente')">Pendientes</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Aprobada' }"   @click="cambiarFiltro('Aprobada')">Aprobadas</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Corrección' }" @click="cambiarFiltro('Corrección')">En corrección</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Rechazada' }"  @click="cambiarFiltro('Rechazada')">Rechazadas</button>
  </div>

  <div v-if="cargando" class="estado-info">
    <i class="ti ti-loader-2 girando"></i> Cargando planificaciones...
  </div>

  <div v-else-if="error" class="estado-error">
    <i class="ti ti-alert-circle"></i> {{ error }}
  </div>

  <div v-else class="tabla-wrapper">
    <table class="tabla">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Docente</th>
          <th>Curso</th>
          <th>Fecha presentación</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="plan in planificacionesFiltradas" :key="plan.id">
          <td>{{ plan.id }}</td>
          <td>{{ plan.tipo_planificacion }}</td>
          <td>
            <div class="tabla-nombre">
              <div class="tabla-avatar">{{ inicialesDocente(plan) }}</div>
              {{ nombreDocente(plan) }}
            </div>
          </td>
          <td>{{ nombreCurso(plan) }}</td>
          <td>{{ formatearFecha(plan.fecha_presentacion) }}</td>
          <td>
            <span class="badge" :class="claseEstado(estadoActual(plan.estados_anuales ?? []))">
              {{ labelEstado(estadoActual(plan.estados_anuales ?? [])) }}
            </span>
          </td>
          <td>
            <button class="btn-tabla" @click="verDetalle(plan.id)">
              <i class="ti ti-eye"></i> Ver
            </button>
          </td>
        </tr>
        <tr v-if="!planificacionesFiltradas.length">
          <td colspan="7" class="fila-vacia">No hay planificaciones en este estado.</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.estado-info { display: flex; align-items: center; gap: 8px; color: #5a6a7a; font-size: 14px; padding: 2rem 0; }
.dark-mode .estado-info { color: #aabbcc; }
.estado-error { display: flex; align-items: center; gap: 8px; color: #c0392b; font-size: 14px; background: rgba(192,57,43,0.08); border: 1px solid rgba(192,57,43,0.2); border-radius: 10px; padding: 1rem 1.25rem; }
@keyframes girar { to { transform: rotate(360deg); } }
.girando { display: inline-block; animation: girar 0.9s linear infinite; }
.filtros-bar { display: flex; gap: 8px; margin-bottom: 1.25rem; flex-wrap: wrap; }
.filtro-btn { background: #ffffff; color: #5a6a7a; border: 1.5px solid rgba(0,0,0,0.1); border-radius: 999px; padding: 8px 16px; font-size: 13px; font-weight: 700; cursor: pointer; transition: background 0.15s, color 0.15s, border-color 0.15s; }
.dark-mode .filtro-btn { background: #1a1a1a; color: #aabbcc; border-color: #2c4f7c; }
.filtro-btn:hover { border-color: #2563eb; color: #2563eb; }
.filtro-btn.activo { background: #2563eb; color: #ffffff; border-color: #1e40af; }
.tabla-wrapper { border-radius: 16px; border: 1.5px solid rgba(0,0,0,0.08); overflow: hidden; }
.dark-mode .tabla-wrapper { border-color: #1e3a8a; }
.tabla { width: 100%; border-collapse: collapse; background: #ffffff; }
.dark-mode .tabla { background: #1a1a1a; }
.tabla thead { background: #2563eb; }
.tabla thead th { padding: 14px 20px; text-align: left; font-size: 13px; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 0.06em; }
.tabla tbody tr { border-bottom: 1px solid rgba(0,0,0,0.06); transition: background 0.15s; }
.tabla tbody tr:last-child { border-bottom: none; }
.tabla tbody tr:nth-child(even) { background: #f5f7fa; }
.dark-mode .tabla tbody tr:nth-child(even) { background: #111827; }
.tabla tbody tr:hover { background: rgba(37,99,235,0.06); }
.dark-mode .tabla tbody tr:hover { background: rgba(37,99,235,0.1); }
.tabla tbody td { padding: 14px 20px; font-size: 15px; color: #1a2a3a; }
.dark-mode .tabla tbody td { color: #e2e8f0; }
.tabla-nombre { display: flex; align-items: center; gap: 10px; }
.tabla-avatar { width: 34px; height: 34px; border-radius: 50%; background: rgba(37,99,235,0.12); border: 1.5px solid rgba(37,99,235,0.25); display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; color: #2563eb; flex-shrink: 0; }
.dark-mode .tabla-avatar { background: rgba(37,99,235,0.15); color: #60a5fa; }
.btn-tabla { display: inline-flex; align-items: center; gap: 5px; background: #2563eb; color: #ffffff; border: 2px solid #1e40af; border-radius: 999px; padding: 7px 16px; font-size: 13px; font-weight: 700; cursor: pointer; transition: background 0.2s, transform 0.15s, box-shadow 0.2s; }
.btn-tabla:hover { background: #1d4ed8; box-shadow: 0 4px 12px rgba(37,99,235,0.2); transform: translateY(-1px); }
.fila-vacia { text-align: center; color: #8a9aaa; font-style: italic; padding: 2rem; }
.badge { font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 999px; }
.badge-pendiente  { background: rgba(186,117,23,0.12); color: #854f0b; border: 1px solid rgba(186,117,23,0.25); }
.badge-aprobada   { background: rgba(29,158,117,0.12); color: #0f6e56; border: 1px solid rgba(29,158,117,0.25); }
.badge-correccion { background: rgba(237,28,36,0.12);  color: #a81018; border: 1px solid rgba(237,28,36,0.25); }
.badge-rechazada  { background: rgba(80,80,80,0.12);   color: #404040; border: 1px solid rgba(80,80,80,0.25); }
.dark-mode .badge-pendiente  { background: rgba(252,238,33,0.3);  color: #f4f421; border-color: #f4f421; }
.dark-mode .badge-aprobada   { background: rgba(57,181,74,0.3);   color: #00ff00; border-color: #00ff00; }
.dark-mode .badge-correccion { background: rgba(237,28,36,0.3);   color: #ed1c24; border-color: #ed1c24; }
.dark-mode .badge-rechazada  { background: rgba(150,150,150,0.2); color: #cccccc; border-color: #888888; }
</style>
