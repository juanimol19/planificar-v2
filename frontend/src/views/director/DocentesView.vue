<script setup lang="ts">
import DirectorDocentesTable from '@/components/director/DirectorDocentesTable.vue'
</script>

<template>
  <div class="page-header">
    <h1>Docentes</h1>

    <p>
      Gestión de docentes registrados en el sistema.
    </p>

    <DirectorDocentesTable />
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