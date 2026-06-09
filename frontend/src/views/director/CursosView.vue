<script setup lang="ts">
import DirectorCursosTable from '@/components/director/DirectorCursosTable.vue'
</script>

<template>
  <div class="page-header">
    <h1>Cursos</h1>

    <p>
      Gestión de cursos registrados en el sistema.
    </p>

    <DirectorCursosTable />
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