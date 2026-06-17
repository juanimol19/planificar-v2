<script setup lang="ts">
import type { DatosDiaria } from '@/types/planificacion'

const props = defineProps<{
  form: DatosDiaria
}>()

const emit = defineEmits<{
  (e: 'submit', datos: DatosDiaria): void
}>()

function enviar() {
  emit('submit', { ...props.form })
}
</script>

<template>
  <div class="form-container">
    <h2 class="paso-titulo">Planificación Diaria</h2>

    <div class="form-group">
      <label>Fecha estimada</label>
      <input type="date" v-model="props.form.fecha_estimada" required />
    </div>

    <div class="form-group">
      <label>Fecha desarrollada</label>
      <input type="date" v-model="props.form.fecha_desarrollada" required />
    </div>

    <div class="form-group">
      <label>Fecha de presentación</label>
      <input type="date" v-model="props.form.fecha_presentacion" required />
    </div>

    <div class="form-group">
      <label>Contenidos específicos</label>
      <textarea v-model="props.form.contenidos_especificos" rows="4" required />
    </div>

    <div class="form-group">
      <label>Actividades</label>
      <textarea v-model="props.form.actividades" rows="4" required />
    </div>

    <div class="form-group">
      <label>Tareas</label>
      <textarea v-model="props.form.tareas" rows="4" required />
    </div>

    <div class="form-nav">
      <button type="button" class="btn-nav btn-submit" @click="enviar">
        Generar planificación
      </button>
    </div>
  </div>
</template>