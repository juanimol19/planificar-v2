<script setup lang="ts">
import Card from 'primevue/card'

defineProps<{
  title: string
  value: number
  icon: string
}>()
</script>

<template>
  <Card class="stats-card">
    <template #content>
      <div class="card-content">

        <div class="icon-container">
          <i :class="icon"></i>
        </div>

        <div class="info">
          <h3>{{ title }}</h3>
          <span>{{ value }}</span>
        </div>

      </div>
    </template>
  </Card>
</template>

<style scoped>
.stats-card {
  border-radius: 18px;
  transition:
    transform 0.2s ease,
    box-shadow 0.2s ease;
}

.stats-card:hover {
  transform: translateY(-4px);

  box-shadow:
    0 8px 24px rgba(37, 99, 235, 0.15);
}

.card-content {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.icon-container {
  width: 64px;
  height: 64px;

  border-radius: 16px;

  background: rgba(37, 99, 235, 0.1);

  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-container i {
  font-size: 2rem;
  color: #2563eb;
}

.info {
  display: flex;
  flex-direction: column;
}

.info h3 {
  margin: 0;

  font-size: 0.9rem;

  color: #64748b;
}

.info span {
  font-size: 2rem;
  font-weight: 700;

  color: #0f172a;
}
</style>