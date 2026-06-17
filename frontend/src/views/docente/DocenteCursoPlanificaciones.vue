<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { planificaciones, etiquetaEstado } from '@/data/planificaciones'
import type { Tipo } from '@/data/planificaciones'

const route = useRoute()
const router = useRouter()

const cursoId = computed(() => Number(route.params.id))

const planificacionesCurso = computed(() =>
  planificaciones.filter(p => p.cursoId === cursoId.value)
)

const iconoPor = (tipo: Tipo) => tipo === 'anual' ? 'ti-calendar' : 'ti-file-text'

const volver = () => router.push({ name: 'docente-mis-cursos' })
</script>

<template>
  <div class="curso-plan-wrapper">

    <div class="curso-plan-header">
      <button class="btn-volver" @click="volver">
        <i class="ti ti-arrow-left" aria-hidden="true"></i> Volver
      </button>
      <span class="section-label">Planificaciones del curso</span>
    </div>

    <div class="plan-list" v-if="planificacionesCurso.length > 0">
      <div
        v-for="plan in planificacionesCurso"
        :key="plan.id"
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
        <i class="ti ti-arrow-right arrow" aria-hidden="true"></i>
      </div>
    </div>

    <div class="empty-state" v-else>
      <i class="ti ti-file-off" aria-hidden="true"></i>
      <p>Este curso no tiene planificaciones aún.</p>
    </div>

  </div>
</template>

<style>
.curso-plan-wrapper {
  width: 100%;
}

/* ─── Header ─────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .curso-plan-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 14px;
}

.curso-plan-wrapper .section-label {
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.dark-mode .curso-plan-wrapper .section-label {
  color: #4a6a8a;
}

/* ─── Botón volver ───────────────────────────────────────────────────────────── */

.curso-plan-wrapper .btn-volver {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #ffffff;
  border: 2px solid #29abe2;
  color: #29abe2;
  border-radius: 999px;
  padding: 8px 18px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
}

.curso-plan-wrapper .btn-volver:hover {
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.15);
  transform: translateY(-2px);
}

.curso-plan-wrapper .btn-volver:active {
  transform: translateY(0px) scale(0.99);
  box-shadow: none;
}

.dark-mode .curso-plan-wrapper .btn-volver {
  background: #0f1923;
  border-color: #1ab8f0;
  color: #1ab8f0;
}

.dark-mode .curso-plan-wrapper .btn-volver:hover {
  box-shadow: 0 4px 16px rgba(26, 184, 240, 0.15);
}

/* ─── Lista ──────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .plan-list {
  display: flex;
  flex-direction: column;
  gap: 14px;
}

.curso-plan-wrapper .plan-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 16px;
  padding: 22px 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
}

.curso-plan-wrapper .plan-card:hover {
  border-color: #29abe2;
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.15);
  transform: translateY(-2px);
}

.curso-plan-wrapper .plan-card:active {
  transform: translateY(0px) scale(0.99);
  box-shadow: none;
}

.dark-mode .curso-plan-wrapper .plan-card {
  background: #1a1a1a;
  border-color: #0071bc;
}

.dark-mode .curso-plan-wrapper .plan-card:hover {
  border-color: #1ab8f0;
  box-shadow: 0 4px 16px rgba(26, 184, 240, 0.15);
}

/* ─── Ícono ──────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .plan-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(51, 204, 255, 0.12);
  border: 1.5px solid rgba(41, 171, 226, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #29abe2;
  font-size: 24px;
  flex-shrink: 0;
}

.dark-mode .curso-plan-wrapper .plan-icon {
  background: rgba(26, 184, 240, 0.08);
  border-color: rgba(13, 159, 214, 0.2);
  color: #1ab8f0;
}

/* ─── Info ───────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .plan-info {
  flex: 1;
}

.curso-plan-wrapper .plan-title {
  font-size: 17px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 6px;
}

.dark-mode .curso-plan-wrapper .plan-title {
  color: #ffffff;
}

.curso-plan-wrapper .plan-meta {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .curso-plan-wrapper .plan-meta {
  color: #aabbcc;
}

.curso-plan-wrapper .plan-right {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
  gap: 10px;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
}

.curso-plan-wrapper .badge-borrador {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border: 1px solid rgba(186, 117, 23, 0.25);
}

.dark-mode .curso-plan-wrapper .badge-borrador {
  background: rgba(252, 238, 33, 0.3);
  color: #f4f421;
  border: 1px solid #f4f421;
}

.curso-plan-wrapper .badge-confirmada {
  background: rgba(29, 158, 117, 0.12);
  color: #0f6e56;
  border: 1px solid rgba(29, 158, 117, 0.25);
}

.dark-mode .curso-plan-wrapper .badge-confirmada {
  background: rgba(57, 181, 74, 0.3);
  color: #00ff00;
  border: 1px solid #00ff00;
}

.curso-plan-wrapper .badge-rechazada {
  background: rgba(237, 28, 36, 0.12);
  color: #a81018;
  border: 1px solid rgba(237, 28, 36, 0.25);
}

.dark-mode .curso-plan-wrapper .badge-rechazada {
  background: rgba(237, 28, 36, 0.3);
  color: #ed1c24;
  border: 1px solid #ed1c24;
}

/* ─── Fecha ──────────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .plan-date {
  font-size: 13px;
  color: #8a9aaa;
}

.dark-mode .curso-plan-wrapper .plan-date {
  color: #4a6a8a;
}

/* ─── Flecha animada ─────────────────────────────────────────────────────────── */

.curso-plan-wrapper .arrow {
  font-size: 20px;
  color: #29abe2;
  opacity: 0;
  transition: opacity 0.2s, transform 0.2s;
  margin-left: 4px;
  flex-shrink: 0;
}

.curso-plan-wrapper .plan-card:hover .arrow {
  opacity: 1;
  transform: translateX(4px);
}

/* ─── Empty state ────────────────────────────────────────────────────────────── */

.curso-plan-wrapper .empty-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
  padding: 60px 0;
  color: #8a9aaa;
}

.curso-plan-wrapper .empty-state i {
  font-size: 48px;
}

.curso-plan-wrapper .empty-state p {
  font-size: 15px;
  font-weight: 700;
}

.dark-mode .curso-plan-wrapper .empty-state {
  color: #4a6a8a;
}
</style>