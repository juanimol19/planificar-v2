<script setup lang="ts">
import { RouterLink } from 'vue-router'

defineProps<{ isDark: boolean }>()
defineEmits<{ (e: 'toggle-dark'): void }>()
</script>

<template>
  <nav class="director-navbar" :class="{ 'dark-mode': isDark }">
    <div class="navbar-brand">
      <span>Director</span>
    </div>
    <ul class="navbar-links">
      <li>
        <RouterLink to="/director/inicio">
          <i class="ti ti-home" aria-hidden="true"></i> Inicio
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/director/docentes">
          <i class="ti ti-users" aria-hidden="true"></i> Docentes
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/director/cursos">
          <i class="ti ti-books" aria-hidden="true"></i> Cursos
        </RouterLink>
      </li>
      <li>
        <RouterLink to="/director/planificaciones">
          <i class="ti ti-calendar" aria-hidden="true"></i> Planificaciones
        </RouterLink>
      </li>
      <li class="toggle-wrap">
        <i class="ti ti-sun toggle-icon" aria-hidden="true"></i>
        <button class="toggle-btn" @click="$emit('toggle-dark')" aria-label="Cambiar modo claro/oscuro"></button>
        <i class="ti ti-moon toggle-icon" aria-hidden="true"></i>
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
  border-bottom: 0.5px solid rgba(177, 149, 149, 0.08);
  transition: background-color 0.3s, border-color 0.3s;
}

.director-navbar.dark-mode {
  background-color: #0f1923;
  border-bottom-color: rgba(255, 255, 255, 0.08);
}

.navbar-brand span {
  background: #2563eb;
  color: #ffffff;
  font-size: 18px;
  font-weight: 700;
  padding: 18px 26px;
  border-radius: 999px;
  border: 2px solid #1e40af;
  cursor: default;
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
  color: #ffffff;
  background: #2563eb;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 18px 20px;
  font-size: 16px;
  font-weight: 700;
  text-decoration: none;
  transition: background 0.2s, opacity 0.2s, transform 0.15s, box-shadow 0.2s;
}

.navbar-links a:hover {
  background: #1d4ed8;
  opacity: 0.88;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
  transform: translateY(-2px);
}

.navbar-links a:active {
  transform: translateY(0px) scale(0.97);
  box-shadow: none;
  opacity: 0.75;
}

.navbar-links a.router-link-active {
  background: #1e3a8a;
  opacity: 1;
}

.dark-mode .navbar-links a {
  background: #1d4ed8;
  border-color: #1e40af;
}

.dark-mode .navbar-links a:hover {
  background: #1e40af;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
}

.dark-mode .navbar-links a.router-link-active {
  background: #172554;
}

.toggle-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-left: 4px;
}

.toggle-icon {
  font-size: 17px;
  color: #2563eb;
  display: flex;
  align-items: center;
}

.dark-mode .toggle-icon {
  color: #60a5fa;
}

.toggle-btn {
  width: 48px;
  height: 26px;
  border-radius: 999px;
  background: #f0f0f0;
  border: 1.5px solid #2563eb;
  cursor: pointer;
  position: relative;
  transition: background 0.3s, border-color 0.3s;
  flex-shrink: 0;
}

.toggle-btn::after {
  content: '';
  position: absolute;
  top: 2px;
  left: 2px;
  width: 18px;
  height: 18px;
  border-radius: 50%;
  background: #ffffff;
  transition: transform 0.25s, background 0.3s;
}

.dark-mode .toggle-btn {
  background: #2563eb;
  border-color: #1e40af;
}

.dark-mode .toggle-btn::after {
  transform: translateX(22px);
  background: #0f1923;
}
</style>
