<script setup lang="ts">
import { ref } from 'vue'
import type { DatosAnual } from '@/types/planificacion'
import { useMaterias } from '@/composables/useMaterias'
import { usePeriodos } from '@/composables/usePeriodos'
import { MATERIAS_PREDEFINIDAS } from '@/utils/planificacionAnual'
import PeriodoCard from '@/components/docente/PeriodoCard.vue'

const props = defineProps<{
  form: DatosAnual
}>()

const { materiaActivaIdx, agregarMateria, eliminarMateria } = useMaterias(props.form.materias)
const { agregarPeriodo, eliminarPeriodo } = usePeriodos()

const mostrarSelectorMaterias = ref(false)

function agregarMateriaPersonalizada() {
  agregarMateria()
  mostrarSelectorMaterias.value = false
}

function agregarMateriaDesdeSelector(nombre: string) {
  agregarMateria(nombre)
  mostrarSelectorMaterias.value = false
}

function materiasDisponibles() {
  const nombresActuales = props.form.materias.map(m => m.nombre.toLowerCase())
  return MATERIAS_PREDEFINIDAS.filter(m => !nombresActuales.includes(m.toLowerCase()))
}
</script>

<template>
  <div class="paso2-wrap">
    <div class="materias-header">
      <h2 class="paso-titulo">Materias y períodos</h2>
      <button type="button" class="btn-agregar" @click="mostrarSelectorMaterias = true">
        + Agregar materia
      </button>
    </div>

    <div class="materias-tabs">
      <button
        v-for="(materia, idx) in form.materias"
        :key="idx"
        type="button"
        class="tab-btn"
        :class="{ activo: materiaActivaIdx === idx }"
        @click="materiaActivaIdx = idx"
      >
        {{ materia.nombre || `Materia ${idx + 1}` }}
        <span
          v-if="form.materias.length > 1"
          class="tab-eliminar"
          @click.stop="eliminarMateria(idx)"
        >×</span>
      </button>
    </div>

    <div v-if="form.materias[materiaActivaIdx]" class="materia-body">
      <div class="form-group">
        <label>Nombre de la materia</label>
        <input
          v-model="form.materias[materiaActivaIdx].nombre"
          placeholder="Ej: Matemática, Lengua, Ciencias Naturales..."
          required
        />
      </div>

      <div class="periodos-seccion">
        <div class="periodos-header">
          <h3>Períodos</h3>
          <button
            type="button"
            class="btn-agregar btn-sm"
            @click="agregarPeriodo(form.materias[materiaActivaIdx])"
          >
            + Período
          </button>
        </div>

        <PeriodoCard
          v-for="(periodo, pIdx) in form.materias[materiaActivaIdx].periodos"
          :key="pIdx"
          :periodo="periodo"
          :indice="pIdx"
          :mostrarEliminar="form.materias[materiaActivaIdx].periodos.length > 1"
          :nombreMateria="form.materias[materiaActivaIdx].nombre"
          @eliminar="eliminarPeriodo(form.materias[materiaActivaIdx], pIdx)"
        />
      </div>

      <div class="evaluacion-seccion">
        <h3>Evaluación</h3>
        <div class="form-fila">
          <div class="form-group">
            <label>Criterios de evaluación y acreditación</label>
            <textarea
              v-model="form.materias[materiaActivaIdx].criterios_evaluacion"
              rows="4"
              placeholder="Criterios para evaluar y acreditar..."
            />
          </div>
          <div class="form-group">
            <label>Instrumentos de evaluación</label>
            <textarea
              v-model="form.materias[materiaActivaIdx].instrumentos_evaluacion"
              rows="4"
              placeholder="Participación, exámenes, trabajos prácticos..."
            />
          </div>
        </div>
      </div>
    </div>

    <div v-if="mostrarSelectorMaterias" class="modal-overlay" @click.self="mostrarSelectorMaterias = false">
      <div class="modal">
        <h3 class="modal-titulo">Agregar materia</h3>

        <div class="modal-opciones-predefinidas">
          <p class="modal-subtitulo">Seleccioná una materia predefinida</p>
          <div class="materias-grid">
            <button
              v-for="nombre in materiasDisponibles()"
              :key="nombre"
              type="button"
              class="btn-materia-predefinida"
              @click="agregarMateriaDesdeSelector(nombre)"
            >
              {{ nombre }}
            </button>
            <p v-if="materiasDisponibles().length === 0" class="sin-materias">
              Ya agregaste todas las materias predefinidas.
            </p>
          </div>
        </div>

        <div class="modal-divisor">
          <span>o</span>
        </div>

        <div class="modal-opcion-personalizada">
          <p class="modal-subtitulo">Agregá una materia personalizada</p>
          <button
            type="button"
            class="btn-agregar btn-personalizada"
            @click="agregarMateriaPersonalizada"
          >
            + Materia en blanco
          </button>
        </div>

        <button
          type="button"
          class="modal-cerrar"
          @click="mostrarSelectorMaterias = false"
        >
          ✕
        </button>
      </div>
    </div>
  </div>
</template>

<style>
/* ─── Header ─────────────────────────────────────────────────────────────────── */

.paso2-wrap .materias-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

/* ─── Tabs ───────────────────────────────────────────────────────────────────── */

.paso2-wrap .materias-tabs {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1.5rem;
}

.paso2-wrap .tab-btn {
  padding: 0.5rem 1rem;
  border: 2px solid #29abe2;
  border-radius: 8px;
  background-color: #ffffff;
  color: #29abe2;
  font-size: 0.875rem;
  font-weight: 600;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: all 0.2s;
}

.paso2-wrap .tab-btn.activo {
  background-color: #29abe2;
  color: #ffffff;
}

.dark-mode .paso2-wrap .tab-btn {
  background-color: #0f1923;
  border-color: #1ab8f0;
  color: #1ab8f0;
}

.dark-mode .paso2-wrap .tab-btn.activo {
  background-color: #1ab8f0;
  color: #ffffff;
}

.paso2-wrap .tab-eliminar {
  font-size: 1rem;
  opacity: 0.7;
  line-height: 1;
}

.paso2-wrap .tab-eliminar:hover {
  opacity: 1;
}

/* ─── Períodos ───────────────────────────────────────────────────────────────── */

.paso2-wrap .periodos-seccion {
  margin-bottom: 1.5rem;
}

.paso2-wrap .periodos-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
}

.paso2-wrap .periodos-header h3,
.paso2-wrap .evaluacion-seccion h3 {
  font-size: 1rem;
  color: #29abe2;
  font-weight: 700;
}

.dark-mode .paso2-wrap .periodos-header h3,
.dark-mode .paso2-wrap .evaluacion-seccion h3 {
  color: #1ab8f0;
}

/* ─── Evaluación ─────────────────────────────────────────────────────────────── */

.paso2-wrap .evaluacion-seccion {
  margin-top: 1.5rem;
  padding-top: 1.25rem;
  border-top: 1px solid #dde3ec;
}

.dark-mode .paso2-wrap .evaluacion-seccion {
  border-top-color: #1e2e3e;
}

/* ─── Modal ──────────────────────────────────────────────────────────────────── */

.paso2-wrap .modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 100;
}

.paso2-wrap .modal {
  background: #ffffff;
  border-radius: 12px;
  padding: 2rem;
  max-width: 480px;
  width: 90%;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
  position: relative;
}

.dark-mode .paso2-wrap .modal {
  background: #1a1a1a;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
}

.paso2-wrap .modal-titulo {
  font-size: 1.1rem;
  font-weight: 700;
  color: #29abe2;
  margin-bottom: 1.25rem;
}

.dark-mode .paso2-wrap .modal-titulo {
  color: #1ab8f0;
}

.paso2-wrap .modal-subtitulo {
  font-size: 0.85rem;
  color: #5a6a7a;
  margin-bottom: 0.75rem;
}

.dark-mode .paso2-wrap .modal-subtitulo {
  color: #aabbcc;
}

/* ─── Materias grid ──────────────────────────────────────────────────────────── */

.paso2-wrap .materias-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
}

.paso2-wrap .btn-materia-predefinida {
  padding: 0.45rem 0.9rem;
  border: 2px solid #29abe2;
  border-radius: 20px;
  background-color: #ffffff;
  color: #29abe2;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
}

.paso2-wrap .btn-materia-predefinida:hover {
  background-color: #29abe2;
  color: #ffffff;
}

.dark-mode .paso2-wrap .btn-materia-predefinida {
  background-color: #0f1923;
  border-color: #1ab8f0;
  color: #1ab8f0;
}

.dark-mode .paso2-wrap .btn-materia-predefinida:hover {
  background-color: #1ab8f0;
  color: #ffffff;
}

.paso2-wrap .sin-materias {
  font-size: 0.85rem;
  color: #aabbcc;
  font-style: italic;
}

/* ─── Divisor modal ──────────────────────────────────────────────────────────── */

.paso2-wrap .modal-divisor {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin: 1.25rem 0;
  color: #aabbcc;
  font-size: 0.85rem;
}

.paso2-wrap .modal-divisor::before,
.paso2-wrap .modal-divisor::after {
  content: '';
  flex: 1;
  height: 1px;
  background-color: #dde3ec;
}

.dark-mode .paso2-wrap .modal-divisor::before,
.dark-mode .paso2-wrap .modal-divisor::after {
  background-color: #1e2e3e;
}

/* ─── Opción personalizada ───────────────────────────────────────────────────── */

.paso2-wrap .modal-opcion-personalizada {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.paso2-wrap .btn-personalizada {
  font-size: 0.875rem;
}

/* ─── Cerrar modal ───────────────────────────────────────────────────────────── */

.paso2-wrap .modal-cerrar {
  position: absolute;
  top: 1rem;
  right: 1rem;
  background: none;
  border: none;
  font-size: 1rem;
  color: #5a6a7a;
  cursor: pointer;
  line-height: 1;
}

.paso2-wrap .modal-cerrar:hover {
  color: #1a2a3a;
}

.dark-mode .paso2-wrap .modal-cerrar {
  color: #aabbcc;
}

.dark-mode .paso2-wrap .modal-cerrar:hover {
  color: #ffffff;
}
</style>