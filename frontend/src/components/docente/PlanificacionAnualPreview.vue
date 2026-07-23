<script setup lang="ts">
import { ref } from 'vue'
import apiClient from '@/api/axios'
import type { DatosAnual } from '@/types/planificacion'
import { useExportarPlanificacion } from '@/composables/useExportarPlanificacion'

const props = withDefaults(defineProps<{
  datos: DatosAnual
  planificacionId: number | null
  soloLectura?: boolean
}>(), {
  soloLectura: false,
})

const { exportarPDF, exportarWordAnual } = useExportarPlanificacion()

const mostrarModalPresentar = ref(false)
const presentando = ref(false)
const presentada = ref(false)
const errorPresentar = ref<string | null>(null)

async function confirmarPresentar() {
  if (!props.planificacionId) return
  presentando.value = true
  errorPresentar.value = null
  try {
    await apiClient.post('/estados-anual', {
      estado: 'presentada',
      fecha: new Date().toISOString().split('T')[0],
      planificacion_anual_id: props.planificacionId,
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
  <div class="anual-preview-wrap">

    <div id="preview-anual" class="anual-preview-container">

      <!-- Header -->
      <div class="anual-preview-header">
        <h2 class="anual-preview-titulo">Planificación Anual</h2>
        <div class="anual-preview-meta">
          <span><strong>Grado:</strong> {{ props.datos.grado }}</span>
          <span><strong>Ciclo:</strong> {{ props.datos.ciclo }}</span>
          <span><strong>Año:</strong> {{ props.datos.anio }}</span>
          <span><strong>Fecha de presentación:</strong> {{ props.datos.fecha_presentacion }}</span>
        </div>
      </div>

      <!-- Diagnóstico y Bibliografía -->
      <div class="anual-preview-card anual-mb">
        <table class="anual-preview-table">
          <tbody>
            <tr>
              <th>Diagnóstico</th>
              <td class="anual-td-multiline">{{ props.datos.diagnostico }}</td>
            </tr>
            <tr class="anual-row-sep">
              <th>Bibliografía</th>
              <td class="anual-td-multiline">{{ props.datos.bibliografia }}</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Una sección por materia -->
      <div
        v-for="(materia, mIdx) in props.datos.materias"
        :key="mIdx"
        class="anual-materia-seccion"
      >
        <div class="anual-preview-card">
          <table class="anual-preview-table">
            <thead>
              <tr>
                <th colspan="5" class="anual-th-materia">{{ materia.nombre }}</th>
              </tr>
              <tr>
                <th class="anual-col-mes">Mes</th>
                <th class="anual-col-eje">Eje</th>
                <th>Saberes a desarrollar</th>
                <th>Consideraciones didácticas</th>
                <th>Aprendizajes esperados</th>
              </tr>
            </thead>
            <tbody>
              <tr
                v-for="(periodo, pIdx) in materia.periodos"
                :key="pIdx"
                class="anual-row-sep"
              >
                <td class="anual-td-mes">{{ periodo.nombre }}</td>
                <td class="anual-td-eje anual-td-multiline">{{ periodo.eje }}</td>
                <td class="anual-td-multiline">{{ periodo.saberes }}</td>
                <td class="anual-td-multiline">{{ periodo.consideraciones_didacticas }}</td>
                <td class="anual-td-multiline">{{ periodo.aprendizajes_esperados }}</td>
              </tr>

              <!-- Evaluación -->
              <tr class="anual-eval-header-row">
                <th colspan="3" class="anual-th-eval">Criterios de evaluación y acreditación</th>
                <th colspan="2" class="anual-th-eval">Instrumentos de evaluación</th>
              </tr>
              <tr>
                <td colspan="3" class="anual-td-multiline anual-td-eval">{{ materia.criterios_evaluacion }}</td>
                <td colspan="2" class="anual-td-multiline anual-td-eval">{{ materia.instrumentos_evaluacion }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <!-- Saberes transversales -->
      <div v-if="props.datos.saberes_transversales" class="anual-materia-seccion">
        <div class="anual-preview-card">
          <table class="anual-preview-table">
            <thead>
              <tr>
                <th class="anual-th-materia">Saberes Transversales — Ética y Ciudadana</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td class="anual-td-multiline anual-td-eval">{{ props.datos.saberes_transversales }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <!-- Botones de exportación -->
    <div class="anual-export-buttons">
      <button class="anual-btn-export anual-btn-pdf" @click="exportarPDF('preview-anual', 'planificacion_anual')">
        <i class="ti ti-file-type-pdf"></i>
        Descargar PDF
      </button>
      <button class="anual-btn-export anual-btn-word" @click="exportarWordAnual(props.datos)">
        <i class="ti ti-file-type-docx"></i>
        Descargar Word
      </button>
      <button
        v-if="!props.soloLectura"
        class="anual-btn-export anual-btn-presentar"
        :disabled="presentada"
        @click="mostrarModalPresentar = true"
      >
        <i :class="presentada ? 'ti ti-check' : 'ti ti-send'"></i>
        {{ presentada ? 'Presentada' : 'Presentar al director' }}
      </button>
    </div>

    <!-- Modal presentar -->
    <div v-if="!props.soloLectura && mostrarModalPresentar" class="anual-modal-overlay">
      <div class="anual-modal-presentar">
        <p class="anual-modal-mensaje">
          ¿Subir planificación? <strong>Se enviará al director para su revisión.</strong>
        </p>
        <p v-if="errorPresentar" class="anual-modal-error">{{ errorPresentar }}</p>
        <div class="anual-modal-acciones">
          <button class="anual-btn-modal anual-btn-cancelar" @click="mostrarModalPresentar = false">
            Cancelar
          </button>
          <button class="anual-btn-modal anual-btn-confirmar" :disabled="presentando" @click="confirmarPresentar">
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
.anual-preview-wrap {
  max-width: 1000px;
  margin: 0 auto;
  padding: 1.5rem;
}

/* ── Header ── */
.anual-preview-header {
  text-align: center;
  margin-bottom: 2rem;
  padding-bottom: 1.25rem;
  border-bottom: 2px solid #29ABE2;
}

.anual-preview-titulo {
  font-size: 1.5rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: #1a2a3a;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  margin-bottom: 0.5rem;
}

.anual-preview-meta {
  display: flex;
  justify-content: center;
  flex-wrap: wrap;
  gap: 1.5rem;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  color: #5a6a7a;
}

.anual-preview-meta strong {
  color: #1a2a3a;
}

/* ── Card contenedor ── */
.anual-preview-card {
  background-color: #f2efef;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
}

.anual-mb {
  margin-bottom: 1.5rem;
}

/* ── Sección por materia ── */
.anual-materia-seccion {
  margin-bottom: 2rem;
}

/* ── Tabla ── */
.anual-preview-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.875rem;
  font-family: Arial, sans-serif;
}

.anual-preview-table th,
.anual-preview-table td {
  border: 1px solid #d0d7de;
  padding: 0.9rem 1.1rem;
  text-align: left;
  vertical-align: top;
}

.anual-preview-table th {
  background-color: #29ABE2;
  color: #ffffff;
  font-weight: bold;
}

.anual-preview-table td {
  background-color: #ffffff;
  color: #1a2a3a;
}

/* Separación entre filas de períodos */
.anual-row-sep td,
.anual-row-sep th {
  padding-top: 1.1rem;
  padding-bottom: 1.1rem;
  border-top: 2px solid #d0d7de;
}

.anual-th-materia {
  font-size: 1rem;
  text-align: center;
  letter-spacing: 0.04em;
  text-transform: uppercase;
  background-color: #1a8fc1 !important;
}

.anual-th-eval {
  font-size: 0.8rem;
  background-color: #29ABE2 !important;
}

.anual-eval-header-row th {
  border-top: 2px solid #29ABE2;
}

.anual-col-mes { width: 10%; white-space: nowrap; }
.anual-col-eje { width: 15%; }

.anual-td-mes { font-weight: bold; white-space: pre-wrap; }
.anual-td-eje { font-style: italic; }
.anual-td-multiline { white-space: pre-wrap; min-height: 60px; }
.anual-td-eval { min-height: 70px; }

/* ── Botones exportación ── */
.anual-export-buttons {
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  margin-top: 1.5rem;
}

.anual-btn-export {
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

.anual-btn-export:active {
  transform: scale(0.97);
}

.anual-btn-pdf {
  background-color: #e53935;
  color: #ffffff;
}

.anual-btn-pdf:hover {
  background-color: #c62828;
}

.anual-btn-word {
  background-color: #2b579a;
  color: #ffffff;
}

.anual-btn-word:hover {
  background-color: #1e3f6f;
}

/* ── Modo oscuro ── */
.dark-mode .anual-preview-wrap .anual-preview-titulo {
  color: #ffffff;
}

.dark-mode .anual-preview-wrap .anual-preview-meta {
  color: #aabbcc;
}

.dark-mode .anual-preview-wrap .anual-preview-meta strong {
  color: #ffffff;
}

.dark-mode .anual-preview-wrap .anual-preview-card {
  background-color: #1a1a1a;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
}

.dark-mode .anual-preview-wrap .anual-preview-table th {
  background-color: #33CCFF;
  color: #1a1a1a;
}

.dark-mode .anual-preview-wrap .anual-th-materia {
  background-color: #29ABE2 !important;
  color: #1a1a1a !important;
}

.dark-mode .anual-preview-wrap .anual-preview-table td {
  background-color: #232323;
  color: #ffffff;
}

.dark-mode .anual-preview-wrap .anual-preview-table th,
.dark-mode .anual-preview-wrap .anual-preview-table td {
  border-color: #2a2a2a;
}

.dark-mode .anual-preview-wrap .anual-row-sep td,
.dark-mode .anual-preview-wrap .anual-row-sep th {
  border-top-color: #2a2a2a;
}

.dark-mode .anual-preview-wrap .anual-eval-header-row th {
  border-top-color: #33CCFF;
}

/* ── Botón presentar ── */
.anual-btn-presentar {
  background-color: #29ABE2;
  color: #ffffff;
}

.anual-btn-presentar:hover:not(:disabled) {
  background-color: #1a8fc1;
}

.anual-btn-presentar:disabled {
  background-color: #a0d8ef;
  cursor: not-allowed;
  opacity: 0.8;
}

/* ── Modal overlay ── */
.anual-modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

/* ── Modal box ── */
.anual-modal-presentar {
  background: #ffffff;
  border-radius: 10px;
  padding: 2rem;
  max-width: 420px;
  width: 90%;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
}

.anual-modal-mensaje {
  font-size: 1rem;
  font-family: Arial, sans-serif;
  color: #1a2a3a;
  margin-bottom: 1.25rem;
  line-height: 1.5;
}

.anual-modal-error {
  font-size: 0.875rem;
  color: #c0392b;
  margin-bottom: 1rem;
  font-family: Arial, sans-serif;
}

.anual-modal-acciones {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
}

.anual-btn-modal {
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

.anual-btn-modal:active {
  transform: scale(0.97);
}

.anual-btn-cancelar {
  background-color: #e5e7eb;
  color: #1a2a3a;
}

.anual-btn-cancelar:hover {
  background-color: #d1d5db;
}

.anual-btn-confirmar {
  background-color: #29ABE2;
  color: #ffffff;
}

.anual-btn-confirmar:hover:not(:disabled) {
  background-color: #1a8fc1;
}

.anual-btn-confirmar:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* ── Modo oscuro ── */
.dark-mode .anual-preview-wrap .anual-btn-presentar:disabled {
  background-color: #1a5a7a;
}

.dark-mode .anual-preview-wrap .anual-modal-presentar {
  background-color: #1a1a1a;
}

.dark-mode .anual-preview-wrap .anual-modal-mensaje {
  color: #ffffff;
}

.dark-mode .anual-preview-wrap .anual-modal-mensaje strong {
  color: #aabbcc;
}

.dark-mode .anual-preview-wrap .anual-btn-cancelar {
  background-color: #2a2a2a;
  color: #aabbcc;
}

.dark-mode .anual-preview-wrap .anual-btn-cancelar:hover {
  background-color: #333333;
}
</style>