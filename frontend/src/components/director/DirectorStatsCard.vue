<script setup lang="ts">
import Card from 'primevue/card'

defineProps<{
  title: string
  value: number
  icon: string
}>()
</script>

<template>
  <Card>
    <template #content>
      <div class="card-content">
        <i :class="icon"></i>

        <div>
          <h3>{{ title }}</h3>
          <span>{{ value }}</span>
        </div>
      </div>
    </template>
  </Card>
</template>

<style scoped>
.card-content {
  display: flex;
  align-items: center;
  gap: 1rem;
}

i {
  font-size: 2.5rem;
}

h3 {
  margin: 0;
  color: #64748b;
  font-size: .9rem;
}

span {
  font-size: 2.2rem;
  font-weight: 700;
}
</style>