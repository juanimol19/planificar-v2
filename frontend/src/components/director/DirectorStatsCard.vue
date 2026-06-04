<script setup lang="ts">
defineProps<{
  title: string
  value: number
  icon: string
}>()
</script>

<template>
  <div class="stats-card">
    <div class="stats-header">
      <i :class="icon"></i>
    </div>

    <h3>{{ title }}</h3>

    <span>{{ value }}</span>
  </div>
</template>

<style scoped>
.stats-card {
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  box-shadow: 0 2px 12px rgba(0,0,0,.08);
}

.stats-header {
  margin-bottom: 1rem;
}

.stats-header i {
  font-size: 1.5rem;
}

h3 {
  color: #64748b;
}

span {
  font-size: 2rem;
  font-weight: 700;
}
</style>