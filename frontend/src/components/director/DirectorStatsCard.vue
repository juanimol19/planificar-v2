<script setup lang="ts">
import { useRouter } from 'vue-router'

const props = defineProps<{
  title: string
  value: number
  icon: string
  to?: string
  query?: Record<string, string>
}>()

const router = useRouter()

const irADestino = () => {
  if (!props.to) return
  router.push({ path: props.to, query: props.query })
}
</script>

<template>
  <button class="stats-card" :class="{ 'sin-link': !to }" @click="irADestino">
    <div class="card-icon">
      <i :class="`ti ${icon}`" aria-hidden="true"></i>
    </div>
    <div class="card-info">
      <p class="card-title">{{ title }}</p>
      <span class="card-value">{{ value }}</span>
    </div>
    <i v-if="to" class="ti ti-chevron-right card-arrow" aria-hidden="true"></i>
  </button>
</template>

<style scoped>
.stats-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 16px;
  padding: 28px 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  width: 100%;
  text-align: left;
  cursor: pointer;
  font-family: arial, sans-serif;
  transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
}

.stats-card.sin-link {
  cursor: default;
}

.stats-card:hover {
  border-color: #2563eb;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
  transform: translateY(-2px);
}

.stats-card.sin-link:hover {
  border-color: rgba(0, 0, 0, 0.08);
  box-shadow: none;
  transform: none;
}

.stats-card:active {
  transform: translateY(0px) scale(0.99);
  box-shadow: none;
}

.dark-mode .stats-card {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.dark-mode .stats-card:hover {
  border-color: #2563eb;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
}

.card-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #2563eb;
  font-size: 24px;
  flex-shrink: 0;
}

.dark-mode .card-icon {
  background: rgba(37, 99, 235, 0.08);
  border-color: rgba(29, 78, 216, 0.2);
  color: #60a5fa;
}

.card-info {
  display: flex;
  flex-direction: column;
  gap: 4px;
  flex: 1;
}

.card-title {
  font-size: 13px;
  font-weight: 700;
  color: #5a6a7a;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.dark-mode .card-title {
  color: #aabbcc;
}

.card-value {
  font-size: 32px;
  font-weight: 700;
  color: #1a2a3a;
  line-height: 1;
}

.dark-mode .card-value {
  color: #ffffff;
}

.card-arrow {
  font-size: 18px;
  color: #c0c8d0;
  flex-shrink: 0;
}

.dark-mode .card-arrow {
  color: #3a4a5a;
}
</style>
