<script setup lang="ts">
defineProps<{
  paso: number
  labels: string[]
}>()
</script>

<template>
  <div class="pasos-indicador">
    <div
      v-for="(label, idx) in labels"
      :key="idx"
      class="paso-item"
      :class="{ activo: paso === idx + 1, completado: paso > idx + 1 }"
    >
      <div class="paso-circulo">{{ idx + 1 }}</div>
      <span class="paso-label">{{ label }}</span>
    </div>
  </div>
</template>

<style>
.pasos-indicador {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-bottom: 2rem;
}

.pasos-indicador .paso-item {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 0.4rem;
  opacity: 0.4;
  transition: opacity 0.2s;
}

.pasos-indicador .paso-item.activo,
.pasos-indicador .paso-item.completado {
  opacity: 1;
}

.pasos-indicador .paso-circulo {
  width: 2rem;
  height: 2rem;
  border-radius: 50%;
  background-color: #ccc;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 0.9rem;
}

.pasos-indicador .paso-item.activo .paso-circulo {
  background-color: #29abe2;
}

.pasos-indicador .paso-item.completado .paso-circulo {
  background-color: #2e7d32;
}

.pasos-indicador .paso-label {
  font-size: 0.8rem;
  color: #5a6a7a;
  font-weight: 500;
}

/* ─── Modo oscuro ────────────────────────────────────────────────────────────── */

.dark-mode .pasos-indicador .paso-circulo {
  background-color: #2a3a4a;
}

.dark-mode .pasos-indicador .paso-item.activo .paso-circulo {
  background-color: #1ab8f0;
}

.dark-mode .pasos-indicador .paso-item.completado .paso-circulo {
  background-color: #39b54a;
}

.dark-mode .pasos-indicador .paso-label {
  color: #aabbcc;
}
</style>