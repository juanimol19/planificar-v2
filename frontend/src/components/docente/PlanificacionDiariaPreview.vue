<script setup lang="ts">
import { ref } from 'vue'
import apiClient from '@/api/axios'
import { useExportarPlanificacion } from '@/composables/useExportarPlanificacion'

const props = defineProps<{
  datos: {
    fecha_estimada: string
    fecha_desarrollada: string
    fecha_presentacion: string
    contenidos_especificos: string
    actividades: string
    tareas: string
  }
  planificacionId: number | null
}>()

const { exportarPDF, exportarWordDiaria } = useExportarPlanificacion()

const mostrarModalPresentar = ref(false)
const presentando = ref(false)
const presentada = ref(false)
const errorPresentar = ref<string | null>(null)

async function confirmarPresentar() {
  if (!props.planificacionId) return
  presentando.value = true
  errorPresentar.value = null
  try {
await apiClient.post('/estados-diaria', {
  estado: 'presentada',
  fecha: new Date().toISOString().split('T')[0],
  planificacion_diaria_id: props.planificacionId,
})
    presentada.value = true
    mostrarModalPresentar.value = false
  } catch {
    errorPresentar.value = 'Ocurrió un error al presentar. Intentá de nuevo.'
  } finally {
    presentando.value = false
  }
}
</script>

<template>
  <div class="diaria-preview-wrap">

    <div id="preview-diaria" class="diaria-preview-container">

      <!-- Header -->
      <div class="diaria-preview-header">
        <h2 class="diaria-preview-titulo">Planificación Diaria</h2>
        <div class="diaria-preview-subtitulo">Vista previa del documento</div>
      </div>

      <!-- Tabla -->
      <div class="diaria-preview-card">
<table class="diaria-preview-table">
  <tbody>
    <tr>
      <th>Fecha estimada</th>
      <td>{{ props.datos.fecha_estimada }}</td>
      <th>Fecha desarrollada</th>
      <td>{{ props.datos.fecha_desarrollada }}</td>
    </tr>
    <tr class="diaria-row-sep">
      <th>Fecha de presentación</th>
      <td colspan="3">{{ props.datos.fecha_presentacion }}</td>
    </tr>
    <tr class="diaria-row-sep">
      <th>Contenidos específicos</th>
      <td colspan="3" class="diaria-td-multiline">{{ props.datos.contenidos_especificos }}</td>
    </tr>
    <tr class="diaria-row-sep">
      <th>Actividades</th>
      <td colspan="3" class="diaria-td-multiline">{{ props.datos.actividades }}</td>
    </tr>
    <tr class="diaria-row-sep">
      <th>Tareas</th>
      <td colspan="3" class="diaria-td-multiline">{{ props.datos.tareas }}</td>
    </tr>
  </tbody>
</table>
      </div>

    </div>

    <!-- Botones de exportación -->
<div class="diaria-export-buttons">
  <button class="diaria-btn-export diaria-btn-pdf" @click="exportarPDF('preview-diaria', 'planificacion_diaria')">
    <i class="ti ti-file-type-pdf"></i>
    Descargar PDF
  </button>
  <button class="diaria-btn-export diaria-btn-word" @click="exportarWordDiaria(props.datos)">
    <i class="ti ti-file-type-docx"></i>
    Descargar Word
  </button>
  <button
    class="diaria-btn-export diaria-btn-presentar"
    :disabled="presentada"
    @click="mostrarModalPresentar = true"
  >
    <i :class="presentada ? 'ti ti-check' : 'ti ti-send'"></i>
    {{ presentada ? 'Presentada' : 'Presentar al director' }}
  </button>
</div>

<!-- Modal presentar -->
<div v-if="mostrarModalPresentar" class="diaria-modal-overlay">
  <div class="diaria-modal-presentar">
    <p class="diaria-modal-mensaje">
      ¿Subir planificación? <strong>Se enviará al director para su revisión.</strong>
    </p>
    <p v-if="errorPresentar" class="diaria-modal-error">{{ errorPresentar }}</p>
    <div class="diaria-modal-acciones">
      <button class="diaria-btn-modal diaria-btn-cancelar" @click="mostrarModalPresentar = false">
        Cancelar
      </button>
      <button class="diaria-btn-modal diaria-btn-confirmar" :disabled="presentando" @click="confirmarPresentar">
        <i class="ti ti-send"></i>
        {{ presentando ? 'Enviando...' : 'Confirmar' }}
      </button>
    </div>
  </div>
</div>

  </div>
</template>

<style>
/* ── Wrapper ── */
.diaria-preview-wrap {
  max-width: 900px;
  margin: 0 auto;
  padding: 1.5rem;
}

/* ── Header ── */
.diaria-preview-header {
  text-align: center;
  margin-bottom: 2rem;
  padding-bottom: 1.25rem;
  border-bottom: 2px solid #29ABE2;
}

.diaria-preview-titulo {
  font-size: 1.5rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: #1a2a3a;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 0.35rem;
}

.diaria-preview-subtitulo {
  font-size: 0.85rem;
  font-family: Arial, sans-serif;
  color: #5a6a7a;
}

/* ── Card contenedor ── */
.diaria-preview-card {
  background-color: #f2efef;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
  margin-bottom: 2rem;
}

/* ── Tabla ── */
.diaria-preview-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
  font-family: Arial, sans-serif;
}

.diaria-preview-table th,
.diaria-preview-table td {
  border: 1px solid #d0d7de;
  padding: 0.85rem 1.1rem;
  text-align: left;
  vertical-align: top;
}

.diaria-preview-table th {
  background-color: #29ABE2;
  color: #ffffff;
  font-weight: bold;
  white-space: nowrap;
  width: 20%;
}

.diaria-preview-table td {
  background-color: #ffffff;
  color: #1a2a3a;
}

.diaria-td-multiline {
  white-space: pre-wrap;
  min-height: 80px;
}

/* ── Botones exportación ── */
.diaria-export-buttons {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
}

.diaria-btn-export {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.6rem 1.4rem;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.15s ease;
}

.diaria-btn-export:active {
  transform: scale(0.97);
}

.diaria-btn-pdf {
  background-color: #e53935;
  color: #ffffff;
}

.diaria-btn-pdf:hover {
  background-color: #c62828;
}

.diaria-btn-word {
  background-color: #2b579a;
  color: #ffffff;
}

.diaria-btn-word:hover {
  background-color: #1e3f6f;
}

/* ── Modo oscuro ── */
.dark-mode .diaria-preview-wrap .diaria-preview-titulo {
  color: #ffffff;
}

.dark-mode .diaria-preview-wrap .diaria-preview-subtitulo {
  color: #aabbcc;
}

.dark-mode .diaria-preview-wrap .diaria-preview-card {
  background-color: #1a1a1a;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
}

.dark-mode .diaria-preview-wrap .diaria-preview-table th {
  background-color: #33CCFF;
  color: #1a1a1a;
}

.dark-mode .diaria-preview-wrap .diaria-preview-table td {
  background-color: #232323;
  color: #ffffff;
  border-color: #2a2a2a;
}

.dark-mode .diaria-preview-wrap .diaria-preview-table th,
.dark-mode .diaria-preview-wrap .diaria-preview-table td {
  border-color: #2a2a2a;
}
/* ── Separación entre filas ── */
.diaria-row-sep td,
.diaria-row-sep th {
  padding-top: 1.1rem;
  padding-bottom: 1.1rem;
  border-top: 2px solid #d0d7de;
}

.dark-mode .diaria-preview-wrap .diaria-row-sep td,
.dark-mode .diaria-preview-wrap .diaria-row-sep th {
  border-top-color: #2a2a2a;
}

/* ── Botón presentar ── */
.diaria-btn-presentar {
  background-color: #29ABE2;
  color: #ffffff;
}

.diaria-btn-presentar:hover:not(:disabled) {
  background-color: #1a8fc1;
}

.diaria-btn-presentar:disabled {
  background-color: #a0d8ef;
  cursor: not-allowed;
  opacity: 0.8;
}

/* ── Modal overlay ── */
.diaria-modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

/* ── Modal box ── */
.diaria-modal-presentar {
  background: #ffffff;
  border-radius: 10px;
  padding: 2rem;
  max-width: 420px;
  width: 90%;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
}

.diaria-modal-mensaje {
  font-size: 1rem;
  font-family: Arial, sans-serif;
  color: #1a2a3a;
  margin-bottom: 1.25rem;
  line-height: 1.5;
}

.diaria-modal-error {
  font-size: 0.875rem;
  color: #c0392b;
  margin-bottom: 1rem;
  font-family: Arial, sans-serif;
}

.diaria-modal-acciones {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
}

.diaria-btn-modal {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.55rem 1.25rem;
  border-radius: 7px;
  border: none;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.15s ease;
}

.diaria-btn-modal:active {
  transform: scale(0.97);
}

.diaria-btn-cancelar {
  background-color: #e5e7eb;
  color: #1a2a3a;
}

.diaria-btn-cancelar:hover {
  background-color: #d1d5db;
}

.diaria-btn-confirmar {
  background-color: #29ABE2;
  color: #ffffff;
}

.diaria-btn-confirmar:hover:not(:disabled) {
  background-color: #1a8fc1;
}

.diaria-btn-confirmar:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* ── Modo oscuro ── */
.dark-mode .diaria-preview-wrap .diaria-btn-presentar:disabled {
  background-color: #1a5a7a;
}

.dark-mode .diaria-preview-wrap .diaria-modal-presentar {
  background-color: #1a1a1a;
}

.dark-mode .diaria-preview-wrap .diaria-modal-mensaje {
  color: #ffffff;
}

.dark-mode .diaria-preview-wrap .diaria-modal-mensaje strong {
  color: #aabbcc;
}

.dark-mode .diaria-preview-wrap .diaria-btn-cancelar {
  background-color: #2a2a2a;
  color: #aabbcc;
}

.dark-mode .diaria-preview-wrap .diaria-btn-cancelar:hover {
  background-color: #333333;
}
</style>