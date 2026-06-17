<script setup lang="ts">
import type { DatosAnual } from '@/types/planificacion'
import { materiaVacia } from '@/utils/planificacionAnual'
import PasosIndicador from '@/components/docente/pasos/PasosIndicador.vue'
import FormPaso1Encabezado from '@/components/docente/pasos/FormPaso1Encabezado.vue'
import FormPaso2Materias from '@/components/docente/pasos/FormPaso2Materias.vue'
import FormPaso3Transversales from '@/components/docente/pasos/FormPaso3Transversales.vue'

const LABELS_PASOS = ['Encabezado', 'Materias', 'Transversales']

const props = defineProps<{
  form: DatosAnual
  paso: 1 | 2 | 3
}>()

const emit = defineEmits<{
  (e: 'submit', datos: DatosAnual): void
  (e: 'update:paso', paso: 1 | 2 | 3): void
}>()

function siguientePaso() {
  if (props.paso < 3) emit('update:paso', (props.paso + 1) as 1 | 2 | 3)
}

function anteriorPaso() {
  if (props.paso > 1) emit('update:paso', (props.paso - 1) as 1 | 2 | 3)
}

function enviar() {
  emit('submit', JSON.parse(JSON.stringify(props.form)))
}
</script>

<template>
  <div class="form-container">
    <PasosIndicador :paso="props.paso" :labels="LABELS_PASOS" />

    <FormPaso1Encabezado v-if="props.paso === 1" :form="props.form" />
    <FormPaso2Materias   v-if="props.paso === 2" :form="props.form" />
    <FormPaso3Transversales v-if="props.paso === 3" :form="props.form" />

    <div class="form-nav">
      <button
        v-if="props.paso > 1"
        type="button"
        class="btn-nav btn-anterior"
        @click="anteriorPaso"
      >
        ← Anterior
      </button>

      <button
        v-if="props.paso < 3"
        type="button"
        class="btn-nav btn-siguiente"
        @click="siguientePaso"
      >
        Siguiente →
      </button>

      <button
        v-if="props.paso === 3"
        type="button"
        class="btn-nav btn-submit"
        @click="enviar"
      >
        Previsualizar planificación
      </button>
    </div>
  </div>
</template>