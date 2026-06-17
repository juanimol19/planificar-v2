<script setup lang="ts">
import { ref } from 'vue'
import DocenteNavbar from '@/components/docente/DocenteNavbar.vue'
import DocenteFooter from '@/components/docente/DocenteFooter.vue'

const isDark = ref(false)
const hayDatos = ref(false)

const toggleDark = () => { isDark.value = !isDark.value }
const actualizarHayDatos = (valor: boolean) => { hayDatos.value = valor }
</script>

<template>
  <div class="docente-layout" :class="{ 'dark-mode': isDark }">
<DocenteNavbar
  :is-dark="isDark"
  :hay-datos="hayDatos"
  @toggle-dark="toggleDark"
  @resetear-datos="hayDatos = false"
/>
    <main class="docente-main">
      <RouterView @hay-datos="actualizarHayDatos" />
    </main>
    <DocenteFooter :is-dark="isDark" />
  </div>
</template>

<style scoped>
.docente-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #f5f7fa;
  transition: background-color 0.3s;
}

.docente-layout.dark-mode {
  background-color: #0a1520;
}

.docente-main {
  flex: 1;
  padding: 2rem;
}
</style>