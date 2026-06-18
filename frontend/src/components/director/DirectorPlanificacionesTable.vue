<script setup lang="ts">
import { computed, ref, watch } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { planificacionesMock } from '@/data/planificacionesMock'
import type { EstadoPlanificacion } from '@/types/Planificacion'

const route = useRoute()
const router = useRouter()

const filtroEstado = ref<EstadoPlanificacion | 'Todas'>(
  (route.query.estado as EstadoPlanificacion) || 'Todas'
)

watch(() => route.query.estado, (nuevo) => {
  filtroEstado.value = (nuevo as EstadoPlanificacion) || 'Todas'
})

const planificacionesFiltradas = computed(() => {
  if (filtroEstado.value === 'Todas') return planificacionesMock
  return planificacionesMock.filter(p => p.estado === filtroEstado.value)
})

const cambiarFiltro = (estado: EstadoPlanificacion | 'Todas') => {
  filtroEstado.value = estado
  router.replace({ query: estado === 'Todas' ? {} : { estado } })
}

const verDetalle = (id: number) => router.push(`/director/planificaciones/${id}`)

const formatearFecha = (fecha: string) =>
  new Date(fecha).toLocaleDateString('es-AR', { year: 'numeric', month: 'short', day: 'numeric' })
</script>

<template>
  <div class="filtros-bar">
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Todas' }" @click="cambiarFiltro('Todas')">Todas</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Pendiente' }" @click="cambiarFiltro('Pendiente')">Pendientes</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Aprobada' }" @click="cambiarFiltro('Aprobada')">Aprobadas</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Correccion' }" @click="cambiarFiltro('Correccion')">En corrección</button>
    <button class="filtro-btn" :class="{ activo: filtroEstado === 'Rechazada' }" @click="cambiarFiltro('Rechazada')">Rechazadas</button>
  </div>

  <div class="tabla-wrapper">
    <table class="tabla">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Docente</th>
          <th>Curso</th>
          <th>Envío</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="plan in planificacionesFiltradas" :key="plan.id">
          <td>{{ plan.id }}</td>
          <td>{{ plan.titulo }}</td>
          <td>
            <div class="tabla-nombre">
              <div class="tabla-avatar">{{ plan.docente.split(' ').map(n => n[0]).join('') }}</div>
              {{ plan.docente }}
            </div>
          </td>
          <td>{{ plan.curso }}</td>
          <td>{{ formatearFecha(plan.fechaEnvio) }}</td>
          <td>
            <span class="badge" :class="{
              'badge-pendiente':  plan.estado === 'Pendiente',
              'badge-aprobada':   plan.estado === 'Aprobada',
              'badge-correccion': plan.estado === 'Correccion',
              'badge-rechazada':  plan.estado === 'Rechazada',
            }">
              {{ plan.estado === 'Correccion' ? 'Corrección' : plan.estado }}
            </span>
          </td>
          <td>
            <button class="btn-tabla" @click="verDetalle(plan.id)">
              <i class="ti ti-eye" aria-hidden="true"></i> Ver
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
/* ─── Filtros ────────────────────────────────────────────────────────────────── */

.filtros-bar {
  display: flex;
  gap: 8px;
  margin-bottom: 1.25rem;
  flex-wrap: wrap;
}

.filtro-btn {
  background: #ffffff;
  color: #5a6a7a;
  border: 1.5px solid rgba(0, 0, 0, 0.1);
  border-radius: 999px;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.15s, color 0.15s, border-color 0.15s;
}

.dark-mode .filtro-btn {
  background: #1a1a1a;
  color: #aabbcc;
  border-color: #2c4f7c;
}

.filtro-btn:hover {
  border-color: #2563eb;
  color: #2563eb;
}

.filtro-btn.activo {
  background: #2563eb;
  color: #ffffff;
  border-color: #1e40af;
}

.dark-mode .filtro-btn.activo {
  background: #1d4ed8;
}

/* ─── Tabla ──────────────────────────────────────────────────────────────────── */

.tabla-wrapper {
  border-radius: 16px;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.dark-mode .tabla-wrapper {
  border-color: #1e3a8a;
}

.tabla {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
}

.dark-mode .tabla {
  background: #1a1a1a;
}

.tabla thead {
  background: #2563eb;
}

.tabla thead th {
  padding: 14px 20px;
  text-align: left;
  font-size: 13px;
  font-weight: 700;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.tabla tbody tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  transition: background 0.15s;
}

.tabla tbody tr:last-child {
  border-bottom: none;
}

.tabla tbody tr:nth-child(even) {
  background: #f5f7fa;
}

.dark-mode .tabla tbody tr:nth-child(even) {
  background: #111827;
}

.tabla tbody tr:hover {
  background: rgba(37, 99, 235, 0.06);
}

.dark-mode .tabla tbody tr:hover {
  background: rgba(37, 99, 235, 0.1);
}

.tabla tbody td {
  padding: 14px 20px;
  font-size: 15px;
  color: #1a2a3a;
}

.dark-mode .tabla tbody td {
  color: #e2e8f0;
}

.tabla-nombre {
  display: flex;
  align-items: center;
  gap: 10px;
}

.tabla-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
  color: #2563eb;
  flex-shrink: 0;
}

.dark-mode .tabla-avatar {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.btn-tabla {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: #2563eb;
  color: #ffffff;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 7px 16px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}

.btn-tabla:hover {
  background: #1d4ed8;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
  transform: translateY(-1px);
}

.btn-tabla:active {
  transform: translateY(0);
  box-shadow: none;
}

.fila-vacia {
  text-align: center;
  color: #8a9aaa;
  font-style: italic;
  padding: 2rem;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
}

.badge-pendiente {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border: 1px solid rgba(186, 117, 23, 0.25);
}

.dark-mode .badge-pendiente {
  background: rgba(252, 238, 33, 0.3);
  color: #f4f421;
  border: 1px solid #f4f421;
}

.badge-aprobada {
  background: rgba(29, 158, 117, 0.12);
  color: #0f6e56;
  border: 1px solid rgba(29, 158, 117, 0.25);
}

.dark-mode .badge-aprobada {
  background: rgba(57, 181, 74, 0.3);
  color: #00ff00;
  border: 1px solid #00ff00;
}

.badge-correccion {
  background: rgba(237, 28, 36, 0.12);
  color: #a81018;
  border: 1px solid rgba(237, 28, 36, 0.25);
}

.dark-mode .badge-correccion {
  background: rgba(237, 28, 36, 0.3);
  color: #ed1c24;
  border: 1px solid #ed1c24;
}

.badge-rechazada {
  background: rgba(80, 80, 80, 0.12);
  color: #404040;
  border: 1px solid rgba(80, 80, 80, 0.25);
}

.dark-mode .badge-rechazada {
  background: rgba(150, 150, 150, 0.2);
  color: #cccccc;
  border: 1px solid #888888;
}
</style>
