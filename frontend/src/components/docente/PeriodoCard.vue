<script setup lang="ts">
import { ref, computed } from 'vue'
import type { Periodo } from '@/types/planificacion'
import { sugerenciaEje } from '@/utils/planificacionAnual'

const props = defineProps<{
  periodo: Periodo
  indice: number
  mostrarEliminar: boolean
  nombreMateria: string
}>()

const emit = defineEmits<{
  (e: 'eliminar'): void
}>()

const placeholderEje = computed(() => sugerenciaEje(props.nombreMateria))
const confirmando = ref(false)
const eliminando = ref(false)

function confirmarEliminar() {
  eliminando.value = true
  setTimeout(() => {
    emit('eliminar')
  }, 350)
}
</script>

<template>
  <div class="periodo-card" :class="{ 'periodo-salida': eliminando }">
    <div class="periodo-card-header">
      <span class="periodo-num">Período {{ indice + 1 }}</span>

      <div v-if="mostrarEliminar" class="eliminar-wrap">
        <div v-if="!confirmando" class="btn-eliminar-periodo" @click="confirmando = true">
          <i class="ti ti-trash"></i>
          <span>Eliminar</span>
        </div>
        <div v-else class="confirmar-eliminar">
          <span class="confirmar-texto">¿Eliminar período?</span>
          <button type="button" class="confirmar-si" @click="confirmarEliminar">Sí</button>
          <button type="button" class="confirmar-no" @click="confirmando = false">No</button>
        </div>
      </div>
    </div>

    <div class="form-fila">
      <div class="form-group">
        <label>Meses / Período</label>
        <input v-model="periodo.nombre" placeholder="Ej: Marzo - Abril" />
      </div>
      <div class="form-group">
        <label>Eje</label>
        <input v-model="periodo.eje" :placeholder="placeholderEje" />
      </div>
    </div>

    <div class="form-group">
      <label>Saberes a desarrollar</label>
      <textarea
        v-model="periodo.saberes"
        rows="4"
        placeholder="Listá los temas y contenidos del período..."
      />
    </div>

    <div class="form-fila">
      <div class="form-group">
        <label>Consideraciones didácticas</label>
        <textarea
          v-model="periodo.consideraciones_didacticas"
          rows="4"
          placeholder="Estrategias y metodología de enseñanza..."
        />
      </div>
      <div class="form-group">
        <label>Aprendizajes esperados</label>
        <textarea
          v-model="periodo.aprendizajes_esperados"
          rows="4"
          placeholder="Objetivos y logros esperados en este período..."
        />
      </div>
    </div>
  </div>
</template>

<style>
/* ─── Card ───────────────────────────────────────────────────────────────────── */

.periodo-card {
  border: 1px solid #dde3ec;
  border-radius: 10px;
  padding: 1.25rem;
  margin-bottom: 1rem;
  background-color: #f7f9fc;
  overflow: hidden;
  transition: background-color 0.2s, border-color 0.2s,
              opacity 0.35s ease, transform 0.35s ease,
              max-height 0.35s ease, padding 0.35s ease,
              margin 0.35s ease;
  max-height: 1000px;
}

.dark-mode .periodo-card {
  background-color: #0f1923;
  border-color: #1e2e3e;
}

/* ─── Animación de salida ────────────────────────────────────────────────────── */

.periodo-card.periodo-salida {
  opacity: 0;
  transform: translateY(-8px) scale(0.98);
  max-height: 0;
  padding-top: 0;
  padding-bottom: 0;
  margin-bottom: 0;
  pointer-events: none;
}

/* ─── Header ─────────────────────────────────────────────────────────────────── */

.periodo-card .periodo-card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
}

.periodo-card .periodo-num {
  font-size: 0.875rem;
  font-weight: 700;
  color: #29abe2;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

.dark-mode .periodo-card .periodo-num {
  color: #1ab8f0;
}

/* ─── Botón eliminar ─────────────────────────────────────────────────────────── */

.periodo-card .eliminar-wrap {
  display: flex;
  align-items: center;
}

.periodo-card .btn-eliminar-periodo {
  display: flex;
  align-items: center;
  gap: 5px;
  color: #c0392b;
  font-size: 0.875rem;
  cursor: pointer;
  padding: 4px 8px;
  border-radius: 6px;
  transition: background-color 0.2s;
  user-select: none;
  text-decoration: none;
}

.periodo-card .btn-eliminar-periodo:hover {
  background-color: rgba(192, 57, 43, 0.08);
  text-decoration: none;
}

.periodo-card .btn-eliminar-periodo i {
  font-size: 1.05rem;
}

.dark-mode .periodo-card .btn-eliminar-periodo {
  color: #e74c3c;
}

.dark-mode .periodo-card .btn-eliminar-periodo:hover {
  background-color: rgba(231, 76, 60, 0.1);
}

/* ─── Confirmación inline ────────────────────────────────────────────────────── */

.periodo-card .confirmar-eliminar {
  display: flex;
  align-items: center;
  gap: 8px;
  animation: fadeIn 0.15s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateX(4px); }
  to   { opacity: 1; transform: translateX(0); }
}

.periodo-card .confirmar-texto {
  font-size: 0.875rem;
  color: #c0392b;
  font-weight: 600;
}

.dark-mode .periodo-card .confirmar-texto {
  color: #e74c3c;
}

.periodo-card .confirmar-si,
.periodo-card .confirmar-no {
  padding: 3px 10px;
  border-radius: 6px;
  font-size: 0.825rem;
  font-weight: 700;
  cursor: pointer;
  border: none;
  transition: background-color 0.2s;
}

.periodo-card .confirmar-si {
  background-color: #c0392b;
  color: #ffffff;
}

.periodo-card .confirmar-si:hover {
  background-color: #a93226;
}

.periodo-card .confirmar-no {
  background-color: #f0f0f0;
  color: #1a2a3a;
}

.periodo-card .confirmar-no:hover {
  background-color: #e0e0e0;
}

.dark-mode .periodo-card .confirmar-si {
  background-color: #e74c3c;
}

.dark-mode .periodo-card .confirmar-si:hover {
  background-color: #c0392b;
}

.dark-mode .periodo-card .confirmar-no {
  background-color: #1e2e3e;
  color: #aabbcc;
}

.dark-mode .periodo-card .confirmar-no:hover {
  background-color: #243444;
}
</style>