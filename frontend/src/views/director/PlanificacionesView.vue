<script setup lang="ts">
import DirectorPlanificacionesTable from '@/components/director/DirectorPlanificacionesTable.vue'
</script>

<template>
  <div class="page-header">
    <h1>Planificaciones</h1>

    <p>
      Gestión de planificaciones enviadas por los docentes.
    </p>

    <DirectorPlanificacionesTable />
  </div>
</template>

<style scoped>  

.page-header {
  margin-bottom: 1.5rem;
}

.page-header h1 {
  margin-bottom: .5rem;
}

.page-header p {
  color: #64748b;
}

</style>