<template>
  <aside class="sidebar">
    <div class="logo">
      <h2>PlanificAR</h2>
      <span>Director</span>
    </div>

    <nav class="menu">
      <RouterLink to="/" class="menu-item">
        Dashboard
      </RouterLink>

      <RouterLink to="/docentes" class="menu-item">
        Docentes
      </RouterLink>

      <RouterLink to="/cursos" class="menu-item">
        Cursos
      </RouterLink>

      <RouterLink to="/planificaciones" class="menu-item">
        Planificaciones
      </RouterLink>
    </nav>
  </aside>
</template>

<style scoped>
.sidebar {
  width: 260px;
  min-height: 100vh;
  background-color: #1e293b;
  color: white;
  padding: 1.5rem;
}

.logo {
  margin-bottom: 2rem;
}

.logo span {
  color: #94a3b8;
  font-size: 0.9rem;
}

.menu {
  display: flex;
  flex-direction: column;
}

.menu-item {
  text-decoration: none;
  color: white;
  padding: 0.8rem 0;
  transition: 0.2s;
}

.menu-item:hover {
  color: #60a5fa;
}

.router-link-active {
  font-weight: bold;
  color: #60a5fa;
}
</style>