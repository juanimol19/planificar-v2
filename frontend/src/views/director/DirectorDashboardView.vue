<script setup lang="ts">
import DirectorStatsCard from '@/components/director/DirectorStatsCard.vue'
</script>

<template>
  <div>
    <div class="dashboard-header">
  <h1>Dashboard</h1>
  <p>Resumen general de la actividad académica.</p>
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
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  margin-top: 2rem;
}
</style>