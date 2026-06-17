<script setup lang="ts">
defineProps<{ isDark: boolean }>()

const currentYear = new Date().getFullYear()
</script>

<template>
  <footer class="docente-footer" :class="{ 'dark-mode': isDark }">
    <span>© {{ currentYear }} Portal Docente — Todos los derechos reservados</span>
  </footer>
</template>

<style scoped>
.docente-footer {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem 2rem;
  background-color: #33ccff;
  border-top: 2px solid #29abe2;
  color: #ffffff;
  font-size: 0.85rem;
  font-weight: 700;
  transition: background-color 0.3s, border-color 0.3s;
}

.docente-footer.dark-mode {
  background-color: #0f1923;
  border-top-color: #1ab8f0;
  color: rgba(255, 255, 255, 0.6);
}
</style>