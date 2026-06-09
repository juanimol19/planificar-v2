<script setup lang="ts">
import Dialog from 'primevue/dialog'
import Button from 'primevue/button'

defineProps<{
  visible: boolean
}>()

const emit = defineEmits<{
  close: []
}>()
</script>

<template>
  <Dialog
    :visible="visible"
    modal
    header="Detalle de Planificación"
    :style="{ width: '50rem' }"
    @update:visible="emit('close')"
  >
    <div class="content">

      <h3>Planificación Anual</h3>

      <p>
        Aquí se mostrará la información completa de la planificación.
      </p>

      <div class="actions">
        <Button
          label="Aprobar"
          icon="pi pi-check"
          severity="success"
        />

        <Button
          label="Solicitar Corrección"
          icon="pi pi-pencil"
          severity="warning"
        />

        <Button
          label="Rechazar"
          icon="pi pi-times"
          severity="danger"
        />
      </div>

    </div>
  </Dialog>
</template>

<style scoped>
.content {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.actions {
  display: flex;
  gap: 1rem;
  margin-top: 1rem;
}
</style>