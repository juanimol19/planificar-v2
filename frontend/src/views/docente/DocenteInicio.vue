<script setup lang="ts">
import { ref, computed } from 'vue'

import { useAuthStore } from '@/stores/auth'
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

type Tipo = 'anual' | 'diaria'
type Estado = 'borrador' | 'confirmada' | 'rechazada'

interface Planificacion {
  tipo: Tipo
  materia: string
  grado: string
  fecha: string
  estado: Estado
}

const planificaciones: Planificacion[] = [
  { tipo: 'anual',  materia: 'Matemáticas',        grado: '3° grado', fecha: '05 jun 2026', estado: 'confirmada' },
  { tipo: 'diaria', materia: 'Lengua y Literatura', grado: '4° grado', fecha: '03 jun 2026', estado: 'borrador'   },
  { tipo: 'anual',  materia: 'Ciencias Naturales',  grado: '2° grado', fecha: '01 jun 2026', estado: 'confirmada' },
  { tipo: 'diaria', materia: 'Educación Física',    grado: '5° grado', fecha: '28 may 2026', estado: 'borrador'   },
  { tipo: 'anual',  materia: 'Ciencias Sociales',   grado: '1° grado', fecha: '20 may 2026', estado: 'rechazada'  },
]
const etiquetaEstado: Record<Estado, string> = {
  borrador: 'Borrador',
  confirmada: 'Aceptado',
  rechazada: 'Rechazada',
}

const filtro = ref<'todas' | Tipo | Estado>('todas')

const planificacionesFiltradas = computed(() => {
  if (filtro.value === 'todas') return planificaciones
  return planificaciones.filter(p => p.tipo === filtro.value || p.estado === filtro.value)
})

const iconoPor = (tipo: Tipo) => tipo === 'anual' ? 'ti-calendar' : 'ti-file-text'
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
        v-for="f in ['todas', 'anual', 'diaria', 'borrador', 'confirmada', 'rechazada']"
        :key="f"
        class="filter-pill"
        :class="{ active: filtro === f }"
        @click="filtro = f as typeof filtro"
      >
        {{ f.charAt(0).toUpperCase() + f.slice(1) }}
      </button>
    </div>

    <div class="plan-list">
      <div
        v-for="(plan, index) in planificacionesFiltradas"
        :key="index"
        class="plan-card"
      >
        <div class="plan-icon">
          <i :class="`ti ${iconoPor(plan.tipo)}`" aria-hidden="true"></i>
        </div>
        <div class="plan-info">
          <p class="plan-title">{{ plan.materia }}</p>
          <p class="plan-meta">
            {{ plan.tipo.charAt(0).toUpperCase() + plan.tipo.slice(1) }} — {{ plan.grado }}
          </p>
        </div>
        <div class="plan-right">
          <span class="badge" :class="`badge-${plan.estado}`">
            {{ etiquetaEstado[plan.estado] }}
          </span>
          <span class="plan-date">{{ plan.fecha }}</span>
        </div>
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