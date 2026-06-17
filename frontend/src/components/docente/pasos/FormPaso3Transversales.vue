<script setup lang="ts">
import type { DatosAnual } from '@/types/planificacion'

defineProps<{
  form: DatosAnual
}>()
</script>

<template>
  <div>
    <h2 class="paso-titulo">Saberes transversales</h2>
    <p class="paso-desc">
      Completá los saberes que atraviesan todas las materias: Educación para la Paz,
      Educación Ambiental, ESI, Educación Vial, Valores, Derechos Humanos, etc.
    </p>
    <div class="form-group">
      <label>Saberes transversales</label>
      <textarea
        v-model="form.saberes_transversales"
        rows="10"
        placeholder="Describí los saberes transversales que se trabajarán durante el año..."
      />
    </div>
  </div>
</template>