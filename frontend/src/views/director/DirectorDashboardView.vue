<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import {
  getPlanificaciones,
  estadoActual,
  labelEstado,
} from '@/services/planificacionService'
import type { PlanificacionAnualAPI } from '@/types/planificacionAPI'

const authStore = useAuthStore()
const cargando = ref(true)
const planificaciones = ref<PlanificacionAnualAPI[]>([])

const nombreDirector = computed(() => authStore.user?.name ?? 'Director/a')

const iniciales = computed(() =>
  nombreDirector.value
    .split(' ')
    .map((n) => n[0])
    .join('')
    .toUpperCase(),
)

const fechaHoy = computed(() =>
  new Date().toLocaleDateString('es-AR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  }),
)

// ─── Helpers de datos derivados ───────────────────────────────────────────────

function nombreDocente(p: PlanificacionAnualAPI): string {
  const persona = p.persona_cargo_cursado?.persona_cargo?.persona
  if (!persona) return 'Docente sin datos'
  return `${persona.nombres} ${persona.apellidos}`
}

function nombreCurso(p: PlanificacionAnualAPI): string {
  const curso = p.persona_cargo_cursado?.cursado?.curso
  if (!curso) return 'Curso sin datos'
  return `${curso.grado} ${curso.seccion} - ${curso.turno}`
}

function fechaCorta(fecha: string): string {
  if (!fecha) return '—'
  return new Date(fecha).toLocaleDateString('es-AR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  })
}

// ─── Listas derivadas ──────────────────────────────────────────────────────────

const pendientes = computed(() =>
  planificaciones.value
    .filter((p) => labelEstado(estadoActual(p.estados_anuales ?? [])) === 'Pendiente')
    .sort((a, b) => new Date(a.fecha_presentacion).getTime() - new Date(b.fecha_presentacion).getTime()),
)

const aprobadasRecientes = computed(() =>
  planificaciones.value
    .filter((p) => labelEstado(estadoActual(p.estados_anuales ?? [])) === 'Aprobada')
    .sort((a, b) => new Date(b.fecha_presentacion).getTime() - new Date(a.fecha_presentacion).getTime())
    .slice(0, 5),
)

onMounted(async () => {
  try {
    planificaciones.value = await getPlanificaciones()
  } catch (error) {
    console.error('Error al cargar planificaciones para el inicio del director:', error)
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="dashboard-wrapper">

    <div class="welcome-banner">
      <div class="avatar">{{ iniciales }}</div>
      <div class="welcome-text">
        <h1>Bienvenido, Dir. {{ nombreDirector }}</h1>
        <p>{{ fechaHoy }} — Portal Director</p>
      </div>
    </div>

    <div class="mesa-entradas">

      <!-- ─── Pendientes de revisión ─────────────────────────────────────── -->
      <section class="registro-seccion">
        <div class="registro-header">
          <h2>Planificaciones a revisar</h2>
          <div v-if="!cargando" class="sello" :class="{ 'sello-vacio': pendientes.length === 0 }">
            <span class="sello-numero">{{ pendientes.length }}</span>
            <span class="sello-texto">{{ pendientes.length === 1 ? 'PENDIENTE' : 'PENDIENTES' }}</span>
          </div>
        </div>

        <p v-if="cargando" class="registro-estado">Cargando planificaciones…</p>

        <p v-else-if="pendientes.length === 0" class="registro-vacio">
          Todo al día. No hay planificaciones esperando revisión.
        </p>

        <ul v-else class="registro-lista">
          <li v-for="p in pendientes" :key="p.id">
            <RouterLink
              :to="{ name: 'director-planificacion-detalle', params: { id: p.id } }"
              class="registro-item registro-item--pendiente"
            >
              <span class="registro-fecha">{{ fechaCorta(p.fecha_presentacion) }}</span>
              <span class="registro-info">
                <strong>{{ nombreDocente(p) }}</strong>
                <span class="registro-curso">{{ nombreCurso(p) }}</span>
              </span>
              <i class="ti ti-chevron-right registro-flecha" aria-hidden="true"></i>
            </RouterLink>
          </li>
        </ul>
      </section>

      <!-- ─── Aprobadas recientes ────────────────────────────────────────── -->
      <section class="registro-seccion">
        <div class="registro-header">
          <h2>Aprobadas recientes</h2>
        </div>

        <p v-if="cargando" class="registro-estado">Cargando planificaciones…</p>

        <p v-else-if="aprobadasRecientes.length === 0" class="registro-vacio">
          Todavía no hay planificaciones aprobadas.
        </p>

        <ul v-else class="registro-lista">
          <li v-for="p in aprobadasRecientes" :key="p.id">
            <RouterLink
              :to="{ name: 'director-planificacion-detalle', params: { id: p.id } }"
              class="registro-item registro-item--aprobada"
            >
              <span class="registro-fecha">{{ fechaCorta(p.fecha_presentacion) }}</span>
              <span class="registro-info">
                <strong>{{ nombreDocente(p) }}</strong>
                <span class="registro-curso">{{ nombreCurso(p) }}</span>
              </span>
              <i class="ti ti-chevron-right registro-flecha" aria-hidden="true"></i>
            </RouterLink>
          </li>
        </ul>
      </section>

    </div>
  </div>
</template>

<style>
.dashboard-wrapper {
  width: 100%;
}

/* ─── Banner ─────────────────────────────────────────────────────────────────── */

.dashboard-wrapper .welcome-banner {
  background: #2563eb;
  border: 2px solid #1e40af;
  border-radius: 16px;
  padding: 1.5rem 2rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1.5rem;
  transition: background 0.3s, border-color 0.3s;
}

.dark-mode .dashboard-wrapper .welcome-banner {
  background: #0f1923;
  border-color: #2563eb;
}

.dashboard-wrapper .avatar {
  width: 52px;
  height: 52px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.2);
  border: 2px solid rgba(255, 255, 255, 0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  font-weight: 700;
  color: #ffffff;
  flex-shrink: 0;
}

.dashboard-wrapper .welcome-text h1 {
  font-size: 18px;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 2px;
}

.dashboard-wrapper .welcome-text p {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.8);
}

/* ─── Mesa de entradas ───────────────────────────────────────────────────────── */

.dashboard-wrapper .mesa-entradas {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1.25rem;
}

@media (max-width: 900px) {
  .dashboard-wrapper .mesa-entradas {
    grid-template-columns: 1fr;
  }
}

.dashboard-wrapper .registro-seccion {
  background: #faf8f3;
  border: 1px solid #e5e0d4;
  border-radius: 12px;
  padding: 1.25rem 1.5rem 1.5rem;
  transition: background 0.3s, border-color 0.3s;
}

.dark-mode .dashboard-wrapper .registro-seccion {
  background: #0f1923;
  border-color: #1e2b3a;
}

.dashboard-wrapper .registro-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 2px solid #1e40af;
}

.dashboard-wrapper .registro-header h2 {
  font-size: 15px;
  font-weight: 700;
  letter-spacing: 0.02em;
  color: #12233d;
  text-transform: uppercase;
}

.dark-mode .dashboard-wrapper .registro-header h2 {
  color: #e5e7eb;
}

/* ─── Sello de pendientes ────────────────────────────────────────────────────── */

.dashboard-wrapper .sello {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 68px;
  height: 68px;
  border-radius: 50%;
  border: 2.5px solid #b91c1c;
  color: #b91c1c;
  transform: rotate(-8deg);
  flex-shrink: 0;
}

.dashboard-wrapper .sello.sello-vacio {
  border-color: #15803d;
  color: #15803d;
}

.dashboard-wrapper .sello-numero {
  font-size: 20px;
  font-weight: 700;
  line-height: 1;
}

.dashboard-wrapper .sello-texto {
  font-size: 8px;
  font-weight: 700;
  letter-spacing: 0.04em;
}

/* ─── Lista de registro ───────────────────────────────────────────────────────── */

.dashboard-wrapper .registro-estado,
.dashboard-wrapper .registro-vacio {
  font-size: 13px;
  color: #6b7280;
  padding: 0.5rem 0;
}

.dark-mode .dashboard-wrapper .registro-estado,
.dark-mode .dashboard-wrapper .registro-vacio {
  color: #9ca3af;
}

.dashboard-wrapper .registro-lista {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.dashboard-wrapper .registro-item {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  padding: 0.6rem 0.75rem;
  border-radius: 8px;
  border-left: 3px solid transparent;
  background: #ffffff;
  text-decoration: none;
  transition: background 0.15s, border-color 0.15s;
}

.dark-mode .dashboard-wrapper .registro-item {
  background: #16212e;
}

.dashboard-wrapper .registro-item:hover {
  background: #f0eee6;
}

.dark-mode .dashboard-wrapper .registro-item:hover {
  background: #1c2a3a;
}

.dashboard-wrapper .registro-item--pendiente {
  border-left-color: #b91c1c;
}

.dashboard-wrapper .registro-item--aprobada {
  border-left-color: #15803d;
}

.dashboard-wrapper .registro-fecha {
  font-family: 'Courier New', monospace;
  font-size: 12px;
  font-weight: 700;
  color: #4b5563;
  white-space: nowrap;
}

.dark-mode .dashboard-wrapper .registro-fecha {
  color: #9ca3af;
}

.dashboard-wrapper .registro-info {
  display: flex;
  flex-direction: column;
  flex: 1;
  min-width: 0;
}

.dashboard-wrapper .registro-info strong {
  font-size: 13px;
  color: #12233d;
}

.dark-mode .dashboard-wrapper .registro-info strong {
  color: #e5e7eb;
}

.dashboard-wrapper .registro-curso {
  font-size: 12px;
  color: #6b7280;
}

.dark-mode .dashboard-wrapper .registro-curso {
  color: #9ca3af;
}

.dashboard-wrapper .registro-flecha {
  color: #9ca3af;
  flex-shrink: 0;
}
</style>