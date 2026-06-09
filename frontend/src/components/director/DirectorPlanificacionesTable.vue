<script setup lang="ts">
import DataTable from 'primevue/datatable'
import Column from 'primevue/column'
import Tag from 'primevue/tag'
import Button from 'primevue/button'

import type { Planificacion } from '@/types/Planificacion'

import { ref } from 'vue'
import DirectorPlanificacionDialog from './DirectorPlanificacionDialog.vue'

const showDialog = ref(false)

const planificaciones: Planificacion[] = [
  {
    id: 1,
    docente: 'Juan Pérez',
    curso: '5° A',
    estado: 'Pendiente',
  },
  {
    id: 2,
    docente: 'María Gómez',
    curso: '4° B',
    estado: 'Aprobada',
  },
  {
    id: 3,
    docente: 'Carlos López',
    curso: '6° A',
    estado: 'Correccion',
  },
]
</script>

<template>
  <DataTable
    :value="planificaciones"
    stripedRows
    paginator
    :rows="5"
  >
    <Column field="id" header="ID" />

    <Column field="docente" header="Docente" />

    <Column field="curso" header="Curso" />

    <Column header="Estado">
      <template #body="{ data }">
        <Tag
          :value="data.estado"
          :severity="
            data.estado === 'Aprobada'
              ? 'success'
              : data.estado === 'Pendiente'
                ? 'warning'
                : 'info'
          "
        />
      </template>
    </Column>

    <Column header="Acciones">
      <template #body>
        <Button
          label="Ver"
          icon="pi pi-eye"
          size="small"
          @click="showDialog = true"
        />

        <DirectorPlanificacionDialog
        :visible="showDialog"
        @close="showDialog = false"
        />
      </template>
    </Column>
  </DataTable>
</template>