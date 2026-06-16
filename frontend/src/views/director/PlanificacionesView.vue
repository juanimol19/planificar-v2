<script setup lang="ts">
import DirectorPlanificacionesTable from '@/components/director/DirectorPlanificacionesTable.vue'
</script>

<template>
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-icon">
        <i class="ti ti-calendar" aria-hidden="true"></i>
      </div>
      <div>
        <h1 class="page-title">Planificaciones</h1>
        <p class="page-subtitle">Gestión y revisión de planificaciones enviadas por los docentes.</p>
      </div>
    </div>
    <DirectorPlanificacionesTable />
  </div>
</template>

<style scoped>
.page-wrapper {
  width: 100%;
}

.page-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 0.5rem;
}

.page-header-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-size: 24px;
  flex-shrink: 0;
}

.dark-mode .page-header-icon {
  background: rgba(37, 99, 235, 0.08);
  color: #60a5fa;
}

.page-title {
  font-size: 22px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 2px;
}

.dark-mode .page-title {
  color: #ffffff;
}

.page-subtitle {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .page-subtitle {
  color: #aabbcc;
}
</style>
