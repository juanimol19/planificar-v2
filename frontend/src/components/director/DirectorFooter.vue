<script setup lang="ts">
defineProps<{ isDark: boolean }>()

const currentYear = new Date().getFullYear()
</script>

<template>
  <footer class="director-footer" :class="{ 'dark-mode': isDark }">
    <span>© {{ currentYear }} Portal Director — Todos los derechos reservados</span>
  </footer>
</template>

<style scoped>
.director-footer {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem 2rem;
  background-color: #2563eb;
  border-top: 2px solid #1e40af;
  color: #ffffff;
  font-size: 0.85rem;
  font-weight: 700;
  transition: background-color 0.3s, border-color 0.3s;
}

.director-footer.dark-mode {
  background-color: #0f1923;
  border-top-color: #2563eb;
  color: rgba(255, 255, 255, 0.6);
}
</style>
