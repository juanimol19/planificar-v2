<script setup lang="ts">
type TipoPlanificacion = 'diaria' | 'anual'

const emit = defineEmits<{
  (e: 'seleccionar', tipo: TipoPlanificacion): void
}>()
</script>

<template>
  <div class="selector-wrap">
    <div class="selector-welcome">
      <p class="selector-saludo">Buenos días!</p>
      <h2 class="selector-nombre">Hola, <span>Juan Pérez</span> </h2>
    </div>

    <p class="selector-instruccion">Seleccioná el tipo de planificación que querés crear:</p>

    <div class="selector-cards">
      <div class="sel-card" @click="emit('seleccionar', 'diaria')">
        <div class="sel-card-header">
          <p class="sel-card-title">
            <i class="ti ti-notes" aria-hidden="true"></i>
            Planificación Diaria
          </p>
          <p class="sel-card-desc">Organizá las actividades, contenidos y tareas de una clase específica.</p>
        </div>

        <div class="mini-diaria">
          <div class="mini-row"><div class="mini-dot"></div><div class="mini-bar" style="width: 70%;"></div></div>
          <div class="mini-row"><div class="mini-dot"></div><div class="mini-bar" style="width: 55%;"></div></div>
          <div class="mini-row"><div class="mini-dot"></div><div class="mini-bar" style="width: 80%;"></div></div>
        </div>

        <div class="sel-card-action">
          <i class="ti ti-arrow-right"></i> Crear planificación diaria
        </div>
      </div>

      <div class="sel-card" @click="emit('seleccionar', 'anual')">
        <div class="sel-card-header">
          <p class="sel-card-title">
            <i class="ti ti-calendar-event" aria-hidden="true"></i>
            Planificación Anual
          </p>
          <p class="sel-card-desc">Definí los aprendizajes, saberes, criterios y bibliografía del año.</p>
        </div>

        <div class="mini-anual">
          <div class="mini-cell"></div>
          <div class="mini-cell"></div>
          <div class="mini-cell"></div>
          <div class="mini-cell"></div>
          <div class="mini-cell mini-cell--wide"></div>
        </div>

        <div class="sel-card-action">
          <i class="ti ti-arrow-right"></i> Crear planificación anual
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.selector-wrap {
  width: 100%;
  font-family: Arial, sans-serif;
}

/* ─── Bienvenida ─────────────────────────────────────────────────────────────── */

.selector-wrap .selector-welcome {
  margin-bottom: 1.25rem;
}

.selector-wrap .selector-saludo {
  margin: 0;
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.dark-mode .selector-wrap .selector-saludo {
  color: #4a6a8a;
}

.selector-wrap .selector-nombre {
  margin: 4px 0 0;
  font-size: 22px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .selector-wrap .selector-nombre {
  color: #ffffff;
}

.selector-wrap .selector-nombre span {
  color: #29abe2;
}

.selector-wrap .selector-instruccion {
  font-size: 14px;
  color: #5a6a7a;
  margin: 0 0 1.25rem;
}

.dark-mode .selector-wrap .selector-instruccion {
  color: #aabbcc;
}

/* ─── Cards ──────────────────────────────────────────────────────────────────── */

.selector-wrap .selector-cards {
  display: flex;
  gap: 1.5rem;
}

.selector-wrap .sel-card {
  flex: 1;
  border: 1.5px solid #29abe2;
  border-radius: 14px;
  background: #f2efef;
  padding: 1.5rem;
  cursor: pointer;
  transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.dark-mode .selector-wrap .sel-card {
  background: #1a1a1a;
  border-color: #0071bc;
}

.selector-wrap .sel-card:hover {
  border-color: #33ccff;
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.15);
  transform: scale(1.02);
}

.dark-mode .selector-wrap .sel-card:hover {
  border-color: #1ab8f0;
  box-shadow: 0 4px 16px rgba(26, 184, 240, 0.15);
}

.selector-wrap .sel-card:active {
  transform: scale(0.99);
  box-shadow: none;
}

/* ─── Encabezado de card ─────────────────────────────────────────────────────── */

.selector-wrap .sel-card-title {
  margin: 0;
  font-size: 16px;
  font-weight: 700;
  color: #1a2a3a;
  display: flex;
  align-items: center;
  gap: 8px;
}

.dark-mode .selector-wrap .sel-card-title {
  color: #ffffff;
}

.selector-wrap .sel-card-title i {
  font-size: 18px;
  color: #29abe2;
}

.dark-mode .selector-wrap .sel-card-title i {
  color: #1ab8f0;
}

.selector-wrap .sel-card-desc {
  margin: 6px 0 0;
  font-size: 13px;
  color: #5a6a7a;
  line-height: 1.5;
}

.dark-mode .selector-wrap .sel-card-desc {
  color: #aabbcc;
}

/* ─── Acción ─────────────────────────────────────────────────────────────────── */

.selector-wrap .sel-card-action {
  margin-top: auto;
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  font-weight: 700;
  color: #29abe2;
}

.dark-mode .selector-wrap .sel-card-action {
  color: #1ab8f0;
}

.selector-wrap .sel-card-action i {
  font-size: 16px;
}

/* ─── Mini modelo Diaria ─────────────────────────────────────────────────────── */

.selector-wrap .mini-diaria {
  display: flex;
  flex-direction: column;
  gap: 7px;
}

.selector-wrap .mini-row {
  display: flex;
  align-items: center;
  gap: 8px;
  background: rgba(51, 204, 255, 0.1);
  border: 0.5px solid #29abe2;
  border-radius: 8px;
  padding: 7px 10px;
}

.dark-mode .selector-wrap .mini-row {
  background: rgba(26, 184, 240, 0.08);
  border-color: #0d9fd6;
}

.selector-wrap .mini-dot {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background: #f2efef;
  border: 1.5px solid #29abe2;
  flex-shrink: 0;
}

.dark-mode .selector-wrap .mini-dot {
  background: #1a1a1a;
  border-color: #1ab8f0;
}

.selector-wrap .mini-bar {
  height: 7px;
  border-radius: 4px;
  background: #29abe2;
  opacity: 0.5;
}

/* ─── Mini modelo Anual ──────────────────────────────────────────────────────── */

.selector-wrap .mini-anual {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 7px;
}

.selector-wrap .mini-cell {
  background: rgba(51, 204, 255, 0.1);
  border: 0.5px solid #29abe2;
  border-radius: 8px;
  height: 38px;
}

.dark-mode .selector-wrap .mini-cell {
  background: rgba(26, 184, 240, 0.08);
  border-color: #0d9fd6;
}

.selector-wrap .mini-cell--wide {
  grid-column: span 2;
  height: 28px;
}
</style>