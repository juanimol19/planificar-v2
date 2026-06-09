<template>
  <aside class="sidebar">
    <div class="logo">
      <h2>PlanificAR</h2>
      <span>Director</span>
    </div>

    <nav class="menu">
      <RouterLink to="/" class="menu-item">
        <i class="pi pi-home"></i>
        Dashboard
      </RouterLink>

      <RouterLink to="/docentes" class="menu-item">
        <i class="pi pi-users"></i>
        Docentes
      </RouterLink>

      <RouterLink to="/cursos" class="menu-item">
        <i class="pi pi-book"></i>
        Cursos
      </RouterLink>

      <RouterLink to="/planificaciones" class="menu-item">
        <i class="pi pi-file"></i>
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
  background-color: #334155;
  color: #60a5fa;
  font-weight: 600;
  border-radius: 8px;
  padding-left: 0.75rem;
}

.menu-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;

  text-decoration: none;
  color: white;
  padding: 0.8rem 0;
  transition: 0.2s;
}

.menu-item i {
  font-size: 1rem;
}
</style>