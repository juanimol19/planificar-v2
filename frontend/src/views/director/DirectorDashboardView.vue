<script setup lang="ts">
import { computed } from 'vue'
import DirectorStatsCard from '@/components/director/DirectorStatsCard.vue'

const nombreDirector = 'Carlos Rodríguez'

const iniciales = computed(() =>
  nombreDirector.split(' ').map(n => n[0]).join('').toUpperCase()
)

const fechaHoy = computed(() =>
  new Date().toLocaleDateString('es-AR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  })
)
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

    <div class="stats-grid">
      <DirectorStatsCard title="Docentes"  :value="24" icon="ti-users"        to="/director/docentes" />
      <DirectorStatsCard title="Cursos"    :value="12" icon="ti-books"        to="/director/cursos" />
      <DirectorStatsCard title="Pendientes" :value="8" icon="ti-clock"        to="/director/planificaciones" :query="{ estado: 'Pendiente' }" />
      <DirectorStatsCard title="Aprobadas" :value="35" icon="ti-circle-check" to="/director/planificaciones" :query="{ estado: 'Aprobada' }" />
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

/* ─── Stats grid ─────────────────────────────────────────────────────────────── */

.dashboard-wrapper .stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
  gap: 14px;
}
</style>
