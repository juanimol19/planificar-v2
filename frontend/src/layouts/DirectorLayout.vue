<script setup lang="ts">
import { ref } from 'vue'

import DirectorNavbar from '@/components/director/DirectorNavbar.vue'
import DirectorFooter from '@/components/director/DirectorFooter.vue'

const isDark = ref(false)

const toggleDark = () => {
  isDark.value = !isDark.value
}
</script>

<template>
  <div
    class="director-layout"
    :class="{ 'dark-mode': isDark }"
  >
    <DirectorNavbar
      :is-dark="isDark"
      @toggle-dark="toggleDark"
    />

    <main class="director-main">
      <RouterView />
    </main>

    <DirectorFooter
      :is-dark="isDark"
    />
  </div>
</template>

<style scoped>
.director-layout {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background-color: #f5f7fa;
}

.director-main {
  flex: 1;
  padding: 2rem;
}
</style>