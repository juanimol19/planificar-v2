<script setup lang="ts">
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Button from 'primevue/button'

const cursos = [
  {
    id: 1,
    nombre: '1° A',
    turno: 'Mañana',
  },
  {
    id: 2,
    nombre: '2° B',
    turno: 'Tarde',
  },
  {
    id: 3,
    nombre: '3° A',
    turno: 'Mañana',
  },
]
</script>

<template>
  <DataTable
    :value="cursos"
    paginator
    :rows="5"
    stripedRows
  >
    <Column field="id" header="ID" />
    <Column field="nombre" header="Curso" />
    <Column field="turno" header="Turno" />

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