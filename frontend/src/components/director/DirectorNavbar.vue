<script setup lang="ts">
import { RouterLink } from 'vue-router'

defineProps<{
  isDark: boolean
}>()

defineEmits<{
  (e: 'toggle-dark'): void
}>()
</script>

<template>
  <nav
    class="director-navbar"
    :class="{ 'dark-mode': isDark }"
  >
    <div class="navbar-brand">
      <span>Director</span>
    </div>

    <ul class="navbar-links">
      <li>
        <RouterLink to="/">
          <i class="pi pi-home"></i>
          Dashboard
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/docentes">
          <i class="pi pi-users"></i>
          Docentes
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/cursos">
          <i class="pi pi-book"></i>
          Cursos
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/planificaciones">
          <i class="pi pi-file"></i>
          Planificaciones
        </RouterLink>
      </li>

      <li class="toggle-wrap">
        <i class="pi pi-sun toggle-icon"></i>

        <button
          class="toggle-btn"
          @click="$emit('toggle-dark')"
        ></button>

        <i class="pi pi-moon toggle-icon"></i>
      </li>
    </ul>
  </nav>
</template>

<style scoped>
.director-navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;

  padding: 0.75rem 2rem;
  height: 68px;

  background-color: #eff2f4;

  border-bottom: 1px solid #e2e8f0;

  transition: 0.3s;
}

.director-navbar.dark-mode {
  background-color: #0f172a;
  border-bottom-color: rgba(255, 255, 255, 0.08);
}

.navbar-brand span {
  background: #1e3a8a;
  color: white;

  font-size: 18px;
  font-weight: 700;

  padding: 18px 26px;

  border-radius: 999px;
  border: 2px solid #2563eb;
}

.navbar-links {
  display: flex;
  align-items: center;
  gap: 8px;

  list-style: none;

  margin: 0;
  padding: 0;
}

.navbar-links a {
  display: inline-flex;
  align-items: center;
  gap: 6px;

  color: white;
  background: #2563eb;

  border: 2px solid #1e40af;
  border-radius: 999px;

  padding: 14px 18px;

  font-size: 15px;
  font-weight: 700;

  text-decoration: none;

  transition:
    background 0.2s,
    transform 0.15s,
    box-shadow 0.2s;
}

.navbar-links a:hover {
  background: #1d4ed8;

  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.2);

  transform: translateY(-2px);
}

.navbar-links a.router-link-active {
  background: #1e3a8a;
}

.dark-mode .navbar-links a {
  background: #1d4ed8;
}

.dark-mode .navbar-links a.router-link-active {
  background: #172554;
}

.toggle-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
}

.toggle-icon {
  color: #2563eb;
}

.dark-mode .toggle-icon {
  color: #60a5fa;
}

.toggle-btn {
  width: 48px;
  height: 26px;

  border-radius: 999px;

  border: 1.5px solid #2563eb;

  background: #f1f5f9;

  cursor: pointer;

  position: relative;
}

.toggle-btn::after {
  content: '';

  position: absolute;

  top: 2px;
  left: 2px;

  width: 18px;
  height: 18px;

  border-radius: 50%;

  background: white;

  transition: transform 0.25s;
}

.dark-mode .toggle-btn {
  background: #2563eb;
}

.dark-mode .toggle-btn::after {
  transform: translateX(22px);
}
</style>