<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { RouterLink, useRouter } from 'vue-router'
import { directorActual } from '@/data/directorMock'

defineProps<{ isDark: boolean }>()
defineEmits<{ (e: 'toggle-dark'): void }>()

const router = useRouter()
const menuAbierto = ref(false)
const menuRef = ref<HTMLElement | null>(null)

const iniciales = computed(() =>
  `${directorActual.nombre[0]}${directorActual.apellido[0]}`.toUpperCase()
)

const toggleMenu = () => { menuAbierto.value = !menuAbierto.value }

const irAPerfil = () => {
  menuAbierto.value = false
  router.push('/director/perfil')
}

const cerrarSesion = () => {
  menuAbierto.value = false
  // Acá iría la limpieza de token / store de auth cuando se conecte el back
  router.push('/login')
}

const cerrarSiClickFuera = (e: MouseEvent) => {
  if (menuRef.value && !menuRef.value.contains(e.target as Node)) {
    menuAbierto.value = false
  }
}

onMounted(() => document.addEventListener('click', cerrarSiClickFuera))
onUnmounted(() => document.removeEventListener('click', cerrarSiClickFuera))
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
      <li class="perfil-wrap" ref="menuRef">
        <button class="perfil-btn" @click.stop="toggleMenu">
          <div class="perfil-avatar">
            <img v-if="directorActual.fotoUrl" :src="directorActual.fotoUrl" alt="Foto de perfil" />
            <span v-else>{{ iniciales }}</span>
          </div>
          <i class="ti ti-chevron-down perfil-chevron" :class="{ rotada: menuAbierto }" aria-hidden="true"></i>
        </button>

        <div v-if="menuAbierto" class="perfil-dropdown">
          <div class="dropdown-header">
            <div class="perfil-avatar dropdown-avatar">
              <img v-if="directorActual.fotoUrl" :src="directorActual.fotoUrl" alt="Foto de perfil" />
              <span v-else>{{ iniciales }}</span>
            </div>
            <div>
              <p class="dropdown-nombre">{{ directorActual.nombre }} {{ directorActual.apellido }}</p>
              <p class="dropdown-email">{{ directorActual.email }}</p>
            </div>
          </div>
          <button class="dropdown-item" @click="irAPerfil">
            <i class="ti ti-user-circle" aria-hidden="true"></i> Mi perfil
          </button>
          <button class="dropdown-item dropdown-logout" @click="cerrarSesion">
            <i class="ti ti-logout" aria-hidden="true"></i> Cerrar sesión
          </button>
        </div>
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

/* ─── Perfil dropdown ────────────────────────────────────────────────────────── */

.perfil-wrap {
  position: relative;
  margin-left: 6px;
}

.perfil-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  border-radius: 999px;
}

.perfil-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: #2563eb;
  border: 2px solid #1e40af;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  font-weight: 700;
  color: #ffffff;
  overflow: hidden;
  flex-shrink: 0;
}

.perfil-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.perfil-chevron {
  font-size: 14px;
  color: #5a6a7a;
  transition: transform 0.2s;
}

.dark-mode .perfil-chevron {
  color: #aabbcc;
}

.perfil-chevron.rotada {
  transform: rotate(180deg);
}

.perfil-dropdown {
  position: absolute;
  top: calc(100% + 10px);
  right: 0;
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 16px;
  box-shadow: 0 12px 32px rgba(0, 0, 0, 0.15);
  width: 260px;
  padding: 0.75rem;
  z-index: 1100;
}

.dark-mode .perfil-dropdown {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.dropdown-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0.5rem 0.5rem 0.85rem 0.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  margin-bottom: 0.5rem;
}

.dark-mode .dropdown-header {
  border-bottom-color: rgba(255, 255, 255, 0.08);
}

.dropdown-avatar {
  width: 44px;
  height: 44px;
  font-size: 15px;
}

.dropdown-nombre {
  font-size: 14px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .dropdown-nombre {
  color: #ffffff;
}

.dropdown-email {
  font-size: 12px;
  color: #8a9aaa;
  word-break: break-all;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 10px;
  width: 100%;
  background: none;
  border: none;
  text-align: left;
  padding: 10px 12px;
  border-radius: 10px;
  font-size: 14px;
  font-weight: 600;
  color: #1a2a3a;
  cursor: pointer;
  transition: background 0.15s;
}

.dark-mode .dropdown-item {
  color: #e2e8f0;
}

.dropdown-item:hover {
  background: rgba(37, 99, 235, 0.08);
}

.dropdown-logout {
  color: #c0392b;
}

.dark-mode .dropdown-logout {
  color: #ff6b6b;
}

.dropdown-logout:hover {
  background: rgba(192, 57, 43, 0.08);
}
</style>
