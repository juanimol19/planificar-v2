<script setup lang="ts">
import DirectorStatsCard from '@/components/director/DirectorStatsCard.vue'
</script>

<template>
  <div class="dashboard-wrapper">

    <div class="welcome-banner">
      <div class="welcome-text">
        <h1>Bienvenido Director</h1>
        <p>Panel de gestión académica y seguimiento institucional.</p>
      </div>
    </div>

    <div class="stats-grid">

      <DirectorStatsCard
        title="Docentes"
        :value="24"
        icon="pi pi-users"
      />

      <DirectorStatsCard
        title="Cursos"
        :value="12"
        icon="pi pi-book"
      />

      <DirectorStatsCard
        title="Pendientes"
        :value="8"
        icon="pi pi-clock"
      />

      <DirectorStatsCard
        title="Aprobadas"
        :value="35"
        icon="pi pi-check-circle"
      />

    </div>

  </div>
</template>

<style scoped>
.dashboard-wrapper {
  width: 100%;
}

.welcome-banner {
  background: #2563eb;
  border: 2px solid #1e40af;
  border-radius: 16px;

  padding: 1.5rem 2rem;

  margin-bottom: 2rem;
}

.welcome-text h1 {
  color: white;
  margin-bottom: 0.5rem;
}

.welcome-text p {
  color: rgba(255,255,255,0.85);
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));

  gap: 1.5rem;
}
</style>