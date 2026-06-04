<script setup lang="ts">
import DirectorSidebar from '@/components/director/DirectorSidebar.vue'
import DirectorHeader from '@/components/director/DirectorHeader.vue'
</script>

<template>
  <div class="layout">

    <DirectorSidebar />

    <main class="content">
      <DirectorHeader />

      <RouterView />
    </main>

  </div>
</template>

<style scoped>
.layout {
  display: flex;
  min-height: 100vh;
}

.content {
  flex: 1;
  padding: 2rem;
  background: #f8fafc;
}
</style>