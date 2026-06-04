<script setup lang="ts">
const currentDate = new Date().toLocaleDateString('es-AR', {
  weekday: 'long',
  day: 'numeric',
  month: 'long',
  year: 'numeric',
})
</script>

<template>
  <header class="header">
    <div>
      <h2>Dashboard Director</h2>
      <p>{{ currentDate }}</p>
    </div>

    <div class="user-section">
      <i class="pi pi-user"></i>
      <span>Director</span>
    </div>
  </header>
</template>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
}

.header h2 {
  margin: 0;
}

.header p {
  color: #64748b;
  margin-top: .25rem;
}

.user-section {
  display: flex;
  align-items: center;
  gap: .75rem;
  background: white;
  padding: .75rem 1rem;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0,0,0,.08);
}

.user-section i {
  font-size: 1.2rem;
}
</style>