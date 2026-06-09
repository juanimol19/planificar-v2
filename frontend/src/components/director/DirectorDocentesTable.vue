<script setup lang="ts">
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'

const docentes = [
  {
    id: 1,
    nombre: 'Juan Pérez',
    email: 'juan@escuela.com',
  },
  {
    id: 2,
    nombre: 'María Gómez',
    email: 'maria@escuela.com',
  },
  {
    id: 3,
    nombre: 'Carlos López',
    email: 'carlos@escuela.com',
  },
]
</script>

<template>
  <DataTable
    :value="docentes"
    paginator
    :rows="5"
    stripedRows
  >
    <Column field="id" header="ID" />
    <Column field="nombre" header="Nombre" />
    <Column field="email" header="Email" />

    <Column header="Acciones">
      <template #body>
        <Button
          icon="pi pi-eye"
          label="Ver"
          size="small"
        />
      </template>
    </Column>
  </DataTable>
</template>