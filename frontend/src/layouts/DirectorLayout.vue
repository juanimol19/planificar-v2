<script setup lang="ts">
import DirectorNavbar from '@/components/director/DirectorNavbar.vue'
</script>

<template>
  <div class="director-layout">
    <DirectorNavbar />

    <main class="director-main">
      <RouterView />
    </main>
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