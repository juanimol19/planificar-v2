<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { getPlanificaciones, estadoActual, labelEstado, claseEstado } from '@/services/planificacionService'
import type { PlanificacionAnualAPI } from '@/types/planificacionAPI'

const authStore = useAuthStore()
const nombreDocente = authStore.user?.name ?? ''

const iniciales = computed(() =>
  nombreDocente.split(' ').map(n => n[0]).join('').toUpperCase()
)

const fechaHoy = computed(() =>
  new Date().toLocaleDateString('es-AR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
)

const planificaciones = ref<PlanificacionAnualAPI[]>([])
const cargando = ref(true)
const error = ref<string | null>(null)
const filtro = ref<'todas' | 'presentada' | 'aprobada' | 'correccion' | 'rechazada'>('todas')

const planificacionesFiltradas = computed(() => {
  if (filtro.value === 'todas') return planificaciones.value
  return planificaciones.value.filter(p =>
    estadoActual(p.estados_anuales ?? []) === filtro.value
  )
})

const formatearFecha = (fecha: string) =>
  new Date(fecha).toLocaleDateString('es-AR', {
    day: '2-digit',
    month: 'short',
    year: 'numeric',
  })

const ultimaObservacion = (p: PlanificacionAnualAPI): string | null => {
  const estados = [...(p.estados_anuales ?? [])].sort(
    (a, b) => new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
  )
  return estados[0]?.observaciones ?? null
}

onMounted(async () => {
  try {
    planificaciones.value = await getPlanificaciones()
  } catch {
    error.value = 'No se pudieron cargar las planificaciones.'
  } finally {
    cargando.value = false
  }
})
</script>

<template>
  <div class="inicio-wrapper">

    <div class="welcome-banner">
      <div class="avatar">{{ iniciales }}</div>
      <div class="welcome-text">
        <h1>Bienvenido, Prof. {{ nombreDocente }}</h1>
        <p>{{ fechaHoy }} — Portal Docente</p>
      </div>
    </div>

    <div class="toolbar">
      <span class="section-label">Mis planificaciones</span>
      <button
        v-for="f in ['todas', 'presentada', 'aprobada', 'correccion', 'rechazada']"
        :key="f"
        class="filter-pill"
        :class="{ active: filtro === f }"
        @click="filtro = f as typeof filtro"
      >
        {{ f === 'todas' ? 'Todas' : labelEstado(f) }}
      </button>
    </div>

    <div v-if="cargando" class="estado-info">
      <i class="ti ti-loader-2 girando"></i> Cargando planificaciones...
    </div>

    <div v-else-if="error" class="estado-error">
      <i class="ti ti-alert-circle"></i> {{ error }}
    </div>

    <div v-else-if="planificaciones.length === 0" class="estado-info">
      <i class="ti ti-inbox"></i> Todavía no tenés planificaciones enviadas.
    </div>

    <div v-else class="plan-list">
      <div
        v-for="plan in planificacionesFiltradas"
        :key="plan.id"
        class="plan-card"
      >
        <div class="plan-icon">
          <i class="ti ti-calendar" aria-hidden="true"></i>
        </div>
        <div class="plan-info">
          <p class="plan-title">{{ plan.tipo_planificacion }}</p>
          <p class="plan-meta">
            Presentada el {{ formatearFecha(plan.fecha_presentacion) }}
          </p>
          <p v-if="ultimaObservacion(plan)" class="plan-observacion">
            <i class="ti ti-message-2"></i> {{ ultimaObservacion(plan) }}
          </p>
        </div>
        <div class="plan-right">
          <span class="badge" :class="claseEstado(estadoActual(plan.estados_anuales ?? []))">
            {{ labelEstado(estadoActual(plan.estados_anuales ?? [])) }}
          </span>
          <span class="plan-date">{{ formatearFecha(plan.fecha_presentacion) }}</span>
        </div>
      </div>

      <div v-if="planificacionesFiltradas.length === 0" class="estado-info">
        <i class="ti ti-filter-off"></i> No hay planificaciones con ese estado.
      </div>
    </div>

  </div>
</template>

<style>
.inicio-wrapper {
  width: 100%;
}

/* ─── Banner ─────────────────────────────────────────────────────────────────── */

.inicio-wrapper .welcome-banner {
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

.dark-mode .inicio-wrapper .welcome-banner {
  background: #0f1923;
  border-color: #1d4ed8;
}

.inicio-wrapper .avatar {
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

.inicio-wrapper .welcome-text h1 {
  font-size: 18px;
  font-weight: 700;
  color: #ffffff;
  margin-bottom: 2px;
}

.inicio-wrapper .welcome-text p {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.8);
}

/* ─── Toolbar ────────────────────────────────────────────────────────────────── */

.inicio-wrapper .toolbar {
  display: flex;
  align-items: center;
  gap: 8px;
  margin-bottom: 14px;
  flex-wrap: wrap;
}

.inicio-wrapper .section-label {
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  flex: 1;
}

.dark-mode .inicio-wrapper .section-label {
  color: #4a6a8a;
}

.inicio-wrapper .filter-pill {
  display: inline-flex;
  align-items: center;
  background: #ffffff;
  border: 2px solid #2563eb;
  color: #2563eb;
  border-radius: 999px;
  padding: 9px 20px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, opacity 0.2s;
}

.dark-mode .inicio-wrapper .filter-pill {
  background: #0f1923;
  border-color: #1d4ed8;
  color: #1d4ed8;
}

.inicio-wrapper .filter-pill.active {
  background: #2563eb;
  border-color: #1e40af;
  color: #ffffff;
}

.inicio-wrapper .filter-pill:hover {
  opacity: 0.85;
}

.inicio-wrapper .filter-pill:focus {
  outline: none;
}

/* ─── Tarjetas ───────────────────────────────────────────────────────────────── */

.inicio-wrapper .plan-list {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.inicio-wrapper .plan-card {
  background: #f2efef;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 16px;
  padding: 22px 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
}

.inicio-wrapper .plan-card:hover {
  border-color: #2563eb;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
  transform: translateY(-2px);
}

.inicio-wrapper .plan-card:active {
  transform: translateY(0px) scale(0.99);
  box-shadow: none;
}

.dark-mode .inicio-wrapper .plan-card {
  background: #1a1a1a;
  border-color: #0071bc;
}

.dark-mode .inicio-wrapper .plan-card:hover {
  border-color: #1d4ed8;
  box-shadow: 0 4px 16px rgba(29, 78, 216, 0.15);
}

.inicio-wrapper .plan-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(30, 64, 175, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-size: 24px;
  flex-shrink: 0;
}

.dark-mode .inicio-wrapper .plan-icon {
  background: rgba(29, 78, 216, 0.08);
  border-color: rgba(30, 64, 175, 0.2);
  color: #1d4ed8;
}

.inicio-wrapper .plan-info {
  flex: 1;
}

.inicio-wrapper .plan-title {
  font-size: 17px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 6px;
}

.dark-mode .inicio-wrapper .plan-title {
  color: #ffffff;
}

.inicio-wrapper .plan-meta {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .inicio-wrapper .plan-meta {
  color: #aabbcc;
}

.inicio-wrapper .plan-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.inicio-wrapper .badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
}

.inicio-wrapper .badge-borrador {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border: 1px solid rgba(186, 117, 23, 0.25);
}

.dark-mode .inicio-wrapper .badge-borrador {
  background: rgba(252, 238, 33, 0.3);
  color: #f4f421;
  border: 1px solid #f4f421;
}

.inicio-wrapper .badge-confirmada {
  background: rgba(29, 158, 117, 0.12);
  color: #0f6e56;
  border: 1px solid rgba(29, 158, 117, 0.25);
}

.dark-mode .inicio-wrapper .badge-confirmada {
  background: rgba(57, 181, 74, 0.3);
  color: #00ff00;
  border: 1px solid #00ff00;
}

.inicio-wrapper .badge-rechazada {
  background: rgba(237, 28, 36, 0.12);
  color: #a81018;
  border: 1px solid rgba(237, 28, 36, 0.25);
}

.dark-mode .inicio-wrapper .badge-rechazada {
  background: rgba(237, 28, 36, 0.3);
  color: #ed1c24;
  border: 1px solid #ed1c24;
}

/* ─── Fecha ──────────────────────────────────────────────────────────────────── */

.inicio-wrapper .plan-date {
  font-size: 13px;
  color: #8a9aaa;
}

.dark-mode .inicio-wrapper .plan-date {
  color: #4a6a8a;
}

/* ─── Flecha animada ─────────────────────────────────────────────────────────── */

.inicio-wrapper .arrow {
  font-size: 20px;
  color: #2563eb;
  opacity: 0;
  transition: opacity 0.2s, transform 0.2s;
  margin-left: 4px;
  flex-shrink: 0;
}

.inicio-wrapper .plan-card:hover .arrow {
  opacity: 1;
  transform: translateX(4px);
}
</style>