<script setup lang="ts">
import { RouterLink } from 'vue-router'
</script>

<template>
  <nav class="director-navbar">
    <div class="navbar-brand">
      <span>Director</span>
    </div>

    <ul class="navbar-links">
      <li>
        <RouterLink to="/">
          Dashboard
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/docentes">
          Docentes
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/cursos">
          Cursos
        </RouterLink>
      </li>

      <li>
        <RouterLink to="/planificaciones">
          Planificaciones
        </RouterLink>
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

  background-color: #eff2f4;
  border-bottom: 1px solid #e2e8f0;
}

.navbar-brand span {
  background: #1e40af;
  color: white;

  font-size: 18px;
  font-weight: 700;

  padding: 18px 26px;

  border-radius: 999px;
  border: 2px solid #2563eb;
}

.navbar-links {
  display: flex;
  gap: 8px;

  list-style: none;

  margin: 0;
  padding: 0;
}

.navbar-links a {
  display: inline-flex;
  align-items: center;

  text-decoration: none;

  color: white;
  background: #2563eb;

  border: 2px solid #1e40af;
  border-radius: 999px;

  padding: 18px 20px;

  font-weight: 700;

  transition: 0.2s;
}

.navbar-links a:hover {
  background: #1d4ed8;
}

.navbar-links a.router-link-active {
  background: #1e3a8a;
}
</style>