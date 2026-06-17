<script setup lang="ts">
import type { DatosAnual } from '@/types/planificacion'

defineProps<{
  form: DatosAnual
}>()

const GRADOS = ['1°', '2°', '3°', '4°', '5°', '6°', '7°']
const CICLOS = ['Primer Ciclo', 'Segundo Ciclo', 'Tercer Ciclo']
</script>

<template>
  <div class="paso1-wrap">
    <h2 class="paso-titulo">Datos generales</h2>

    <div class="form-fila">
      <div class="form-group">
        <label>Grado</label>
        <div class="select-wrapper">
          <select v-model="form.grado" required>
            <option value="" disabled>Seleccioná un grado</option>
            <option v-for="grado in GRADOS" :key="grado" :value="grado">{{ grado }}</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Ciclo</label>
        <div class="select-wrapper">
          <select v-model="form.ciclo" required>
            <option value="" disabled>Seleccioná un ciclo</option>
            <option v-for="ciclo in CICLOS" :key="ciclo" :value="ciclo">{{ ciclo }}</option>
          </select>
        </div>
      </div>

      <div class="form-group">
        <label>Año</label>
        <input v-model="form.anio" type="number" placeholder="2026" required />
      </div>
    </div>

    <div class="form-group">
      <label>Fecha de presentación</label>
      <input type="date" v-model="form.fecha_presentacion" required />
    </div>

    <div class="form-group">
      <label>Diagnóstico</label>
      <textarea v-model="form.diagnostico" rows="4" placeholder="Descripción del diagnóstico inicial..." />
    </div>

    <div class="form-group">
      <label>Bibliografía</label>
      <textarea v-model="form.bibliografia" rows="3" placeholder="Libros, recursos, materiales de referencia..." />
    </div>
  </div>
</template>

<style>
/* ─── Select wrapper ─────────────────────────────────────────────────────────── */

.paso1-wrap .select-wrapper {
  position: relative;
}

.paso1-wrap .select-wrapper::after {
  content: '▼';
  font-size: 0.65rem;
  color: #29abe2;
  position: absolute;
  right: 0.85rem;
  top: 50%;
  transform: translateY(-50%);
  pointer-events: none;
}

.paso1-wrap .select-wrapper select {
  width: 100%;
  appearance: none;
  -webkit-appearance: none;
  padding: 0.55rem 2.25rem 0.55rem 0.75rem;
  border: 1.5px solid #ccc;
  border-radius: 8px;
  font-size: 0.95rem;
  color: #1a2a3a;
  background-color: #ffffff;
  cursor: pointer;
  transition: border-color 0.2s ease, background-color 0.2s, color 0.2s;
}

.paso1-wrap .select-wrapper select:focus {
  outline: none;
  border-color: #29abe2;
}

.paso1-wrap .select-wrapper select option:checked {
  background-color: #29abe2;
  color: white;
}

/* ─── Modo oscuro ────────────────────────────────────────────────────────────── */

.dark-mode .paso1-wrap .select-wrapper::after {
  color: #1ab8f0;
}

.dark-mode .paso1-wrap .select-wrapper select {
  border-color: #2a3a4a;
  background-color: #0f1923;
  color: #ffffff;
}

.dark-mode .paso1-wrap .select-wrapper select:focus {
  border-color: #1ab8f0;
}

.dark-mode .paso1-wrap .select-wrapper select option:checked {
  background-color: #1ab8f0;
  color: #ffffff;
}
</style>