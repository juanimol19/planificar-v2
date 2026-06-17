<script setup lang="ts">
import { computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { cursosMock } from '@/data/Director/cursosMock'

const route = useRoute()
const router = useRouter()

const cursoId = computed(() => Number(route.params.id))
const curso = computed(() => cursosMock.find(c => c.id === cursoId.value))

const verPlanificacion = (planId: number) => {
  router.push(`/director/planificaciones/${planId}`)
}

const volver = () => router.push('/director/cursos')
</script>

<template>
  <div class="page-wrapper">
    <button class="btn-volver" @click="volver">
      <i class="ti ti-arrow-left" aria-hidden="true"></i> Volver a Cursos
    </button>

    <div v-if="!curso" class="no-encontrado">
      <i class="ti ti-mood-confuzed" aria-hidden="true"></i>
      <p>No se encontró el curso solicitado.</p>
    </div>

    <template v-else>
      <div class="curso-header">
        <div class="curso-header-icon">
          <i class="ti ti-books" aria-hidden="true"></i>
        </div>
        <div>
          <h1 class="curso-titulo">{{ curso.nombre }}</h1>
          <p class="curso-subtitulo">{{ curso.ciclo }} — Turno {{ curso.turno }}</p>
        </div>
      </div>

      <div class="curso-datos-grid">
        <div class="dato-card">
          <i class="ti ti-user-check" aria-hidden="true"></i>
          <div>
            <span class="dato-label">Docente a cargo</span>
            <span class="dato-valor">{{ curso.docente }}</span>
          </div>
        </div>
        <div class="dato-card">
          <i class="ti ti-users" aria-hidden="true"></i>
          <div>
            <span class="dato-label">Alumnos</span>
            <span class="dato-valor">{{ curso.cantidadAlumnos }}</span>
          </div>
        </div>
        <div class="dato-card">
          <i class="ti ti-sun" aria-hidden="true"></i>
          <div>
            <span class="dato-label">Turno</span>
            <span class="dato-valor">{{ curso.turno }}</span>
          </div>
        </div>
      </div>

      <div class="curso-planificaciones">
        <h2 class="seccion-titulo"><i class="ti ti-clipboard-list" aria-hidden="true"></i> Planificaciones de este curso</h2>

        <div v-if="curso.planificaciones.length" class="plan-lista">
          <button
            v-for="plan in curso.planificaciones"
            :key="plan.id"
            class="plan-item"
            @click="verPlanificacion(plan.id)"
          >
            <span class="plan-titulo">{{ plan.titulo }}</span>
            <span class="badge" :class="{
              'badge-pendiente':  plan.estado === 'Pendiente',
              'badge-aprobada':   plan.estado === 'Aprobada',
              'badge-correccion': plan.estado === 'Correccion',
            }">
              {{ plan.estado === 'Correccion' ? 'Corrección' : plan.estado }}
            </span>
            <i class="ti ti-chevron-right plan-arrow" aria-hidden="true"></i>
          </button>
        </div>
        <p v-else class="plan-vacio">Este curso no tiene planificaciones registradas todavía.</p>
      </div>
    </template>
  </div>
</template>

<style scoped>
.page-wrapper {
  width: 100%;
  max-width: 820px;
}

.no-encontrado {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 3rem 0;
  color: #8a9aaa;
  font-size: 15px;
}

.no-encontrado i {
  font-size: 40px;
}

.curso-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 1.5rem;
}

.curso-header-icon {
  width: 56px;
  height: 56px;
  border-radius: 16px;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-size: 26px;
  flex-shrink: 0;
}

.dark-mode .curso-header-icon {
  background: rgba(37, 99, 235, 0.08);
  color: #60a5fa;
}

.curso-titulo {
  font-size: 22px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 2px;
}

.dark-mode .curso-titulo {
  color: #ffffff;
}

.curso-subtitulo {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .curso-subtitulo {
  color: #aabbcc;
}

.curso-datos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 14px;
  margin-bottom: 2rem;
}

.dato-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 14px;
  padding: 1.1rem 1.25rem;
  display: flex;
  align-items: center;
  gap: 12px;
}

.dark-mode .dato-card {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.dato-card i {
  font-size: 22px;
  color: #2563eb;
  flex-shrink: 0;
}

.dark-mode .dato-card i {
  color: #60a5fa;
}

.dato-card > div {
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.dato-label {
  font-size: 11.5px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.dato-valor {
  font-size: 15px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .dato-valor {
  color: #e2e8f0;
}

.seccion-titulo {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 16px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 1rem;
}

.dark-mode .seccion-titulo {
  color: #ffffff;
}

.plan-lista {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.plan-item {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 12px;
  padding: 14px 18px;
  cursor: pointer;
  text-align: left;
  font-family: arial, sans-serif;
  transition: border-color 0.15s, transform 0.15s, box-shadow 0.15s;
}

.dark-mode .plan-item {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.plan-item:hover {
  border-color: #2563eb;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
  transform: translateY(-1px);
}

.plan-titulo {
  flex: 1;
  font-size: 14.5px;
  font-weight: 600;
  color: #1a2a3a;
}

.dark-mode .plan-titulo {
  color: #e2e8f0;
}

.plan-arrow {
  font-size: 16px;
  color: #c0c8d0;
}

.plan-vacio {
  font-size: 13.5px;
  color: #8a9aaa;
  font-style: italic;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
  flex-shrink: 0;
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
</style>
