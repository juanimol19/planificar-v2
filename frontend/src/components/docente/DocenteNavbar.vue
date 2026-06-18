<script setup lang="ts">
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const props = defineProps<{ isDark: boolean; hayDatos: boolean }>()
const emit = defineEmits<{ (e: 'toggle-dark'): void; (e: 'resetear-datos'): void }>()

const router = useRouter()
const authStore = useAuthStore()

const menuAbierto = ref(false)
const menuRef = ref<HTMLElement | null>(null)

const mostrarModalNavbar = ref(false)
type AccionPendiente = { tipo: 'ruta'; valor: string } | { tipo: 'logout' }
const accionPendiente = ref<AccionPendiente | null>(null)

const iniciales = computed(() => {
  const nombre = authStore.user?.name ?? ''
  const partes = nombre.trim().split(' ').filter(Boolean)
  if (partes.length === 0) return ''
  if (partes.length === 1) return partes[0][0]?.toUpperCase() ?? ''
  return `${partes[0][0]}${partes[partes.length - 1][0]}`.toUpperCase()
})

const fotoUrl = computed(() => {
  const foto = authStore.user?.fotoUrl
  return typeof foto === 'string' ? foto : null
})

function toggleMenu() {
  menuAbierto.value = !menuAbierto.value
}

function navegarA(ruta: string) {
  menuAbierto.value = false
  if (props.hayDatos) {
    accionPendiente.value = { tipo: 'ruta', valor: ruta }
    mostrarModalNavbar.value = true
  } else {
    router.push(ruta)
  }
}

function solicitarCerrarSesion() {
  menuAbierto.value = false
  if (props.hayDatos) {
    accionPendiente.value = { tipo: 'logout' }
    mostrarModalNavbar.value = true
  } else {
    authStore.logout()
  }
}

function confirmarNavegacion() {
  mostrarModalNavbar.value = false
  if (!accionPendiente.value) return

  if (accionPendiente.value.tipo === 'ruta') {
    router.push(accionPendiente.value.valor)
  } else {
    authStore.logout()
  }

  emit('resetear-datos')
  accionPendiente.value = null
}

function cancelarNavegacion() {
  mostrarModalNavbar.value = false
  accionPendiente.value = null
}

function cerrarSiClickFuera(e: MouseEvent) {
  if (menuRef.value && !menuRef.value.contains(e.target as Node)) {
    menuAbierto.value = false
  }
}

onMounted(() => document.addEventListener('click', cerrarSiClickFuera))
onUnmounted(() => document.removeEventListener('click', cerrarSiClickFuera))
</script>

<template>
  <nav class="docente-navbar" :class="{ 'dark-mode': isDark }">
    <div class="navbar-brand">
      <span>Docente</span>
    </div>
    <ul class="navbar-links">
      <li>
        <a @click.prevent="navegarA('/docente/inicio')">
          <i class="ti ti-home" aria-hidden="true"></i> Inicio
        </a>
      </li>
      <li>
        <a @click.prevent="navegarA('/docente/mis-cursos')">
          <i class="ti ti-books" aria-hidden="true"></i> Mis cursos
        </a>
      </li>
      <li>
        <a @click.prevent="navegarA('/docente/planificaciones')">
          <i class="ti ti-calendar" aria-hidden="true"></i> Planificaciones
        </a>
      </li>
      <li class="toggle-wrap">
        <i class="ti ti-sun toggle-icon" aria-hidden="true"></i>
        <button class="toggle-btn" @click="$emit('toggle-dark')" aria-label="Cambiar modo claro/oscuro"></button>
        <i class="ti ti-moon toggle-icon" aria-hidden="true"></i>
      </li>
      <li class="perfil-wrap" ref="menuRef">
        <button class="perfil-btn" @click.stop="toggleMenu">
          <div class="perfil-avatar">
            <img v-if="fotoUrl" :src="fotoUrl" alt="Foto de perfil" />
            <span v-else>{{ iniciales }}</span>
          </div>
          <i class="ti ti-chevron-down perfil-chevron" :class="{ rotada: menuAbierto }" aria-hidden="true"></i>
        </button>

        <div v-if="menuAbierto" class="perfil-dropdown">
          <div class="dropdown-header">
            <div class="perfil-avatar dropdown-avatar">
              <img v-if="fotoUrl" :src="fotoUrl" alt="Foto de perfil" />
              <span v-else>{{ iniciales }}</span>
            </div>
            <div>
              <p class="dropdown-nombre">{{ authStore.user?.name }}</p>
              <p class="dropdown-email">{{ authStore.user?.email }}</p>
            </div>
          </div>
          <button class="dropdown-item" @click="navegarA('/docente/mi-perfil')">
            <i class="ti ti-user-circle" aria-hidden="true"></i> Mi perfil
          </button>
          <button class="dropdown-item dropdown-logout" @click="solicitarCerrarSesion">
            <i class="ti ti-logout" aria-hidden="true"></i> Cerrar sesión
          </button>
        </div>
      </li>
    </ul>

    <!-- Modal de advertencia -->
    <div v-if="mostrarModalNavbar" class="navbar-modal-overlay">
      <div class="navbar-modal">
        <p class="navbar-modal-mensaje">
          <template v-if="accionPendiente?.tipo === 'logout'">
            ¿Cerrar sesión? <strong>Se perderá toda la información ingresada.</strong>
          </template>
          <template v-else>
            ¿Salir de la planificación? <strong>Se perderá toda la información ingresada.</strong>
          </template>
        </p>
        <div class="navbar-modal-acciones">
          <button class="btn-navbar-modal btn-navbar-cancelar" @click="cancelarNavegacion">
            Cancelar
          </button>
          <button class="btn-navbar-modal btn-navbar-confirmar" @click="confirmarNavegacion">
            <i class="ti ti-arrow-right"></i>
            Salir de todas formas
          </button>
        </div>
      </div>
    </div>
  </nav>
</template>

<style>
/* ── Navbar base ── */
.docente-navbar {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 2rem;
  height: 90px;
  background-color: #eff2f4;
  border-bottom: 0.5px solid rgba(177, 149, 149, 0.08);
  transition: background-color 0.3s, border-color 0.3s;
  position: relative;
}

.docente-navbar.dark-mode {
  background-color: #0f1923;
  border-bottom-color: rgba(255, 255, 255, 0.08);
}

/* ── Brand ── */
.docente-navbar .navbar-brand span {
  background: #2563eb;
  color: #ffffff;
  font-size: 18px;
  font-weight: 700;
  padding: 18px 26px;
  border-radius: 999px;
  border: 2px solid #1e40af;
  cursor: default;
}

/* ── Links ── */
.docente-navbar .navbar-links {
  display: flex;
  align-items: center;
  gap: 8px;
  list-style: none;
  margin: 0;
  padding: 0;
}

.docente-navbar .navbar-links a {
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
  cursor: pointer;
  transition: background 0.2s, opacity 0.2s, transform 0.15s, box-shadow 0.2s;
}

.docente-navbar .navbar-links a:hover {
  background: #1d4ed8;
  opacity: 0.88;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
  transform: translateY(-2px);
}

.docente-navbar .navbar-links a:active {
  transform: translateY(0px) scale(0.97);
  box-shadow: none;
  opacity: 0.75;
}

.docente-navbar .navbar-links a.router-link-active {
  background: #1e3a8a;
  opacity: 1;
}

/* ── Dark mode links ── */
.dark-mode .docente-navbar .navbar-links a {
  background: #1d4ed8;
  border-color: #1e40af;
}

.dark-mode .docente-navbar .navbar-links a:hover {
  background: #1e40af;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.15);
}

.dark-mode .docente-navbar .navbar-links a.router-link-active {
  background: #172554;
}

/* ── Toggle ── */
.docente-navbar .toggle-wrap {
  display: flex;
  align-items: center;
  gap: 6px;
  margin-left: 4px;
}

.docente-navbar .toggle-icon {
  font-size: 17px;
  color: #2563eb;
  display: flex;
  align-items: center;
}

.dark-mode .docente-navbar .toggle-icon {
  color: #60a5fa;
}

.docente-navbar .toggle-btn {
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

.docente-navbar .toggle-btn::after {
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

.dark-mode .docente-navbar .toggle-btn {
  background: #2563eb;
  border-color: #1e40af;
}

.dark-mode .docente-navbar .toggle-btn::after {
  transform: translateX(22px);
  background: #0f1923;
}

/* ── Perfil dropdown ── */
.docente-navbar .perfil-wrap {
  position: relative;
  margin-left: 6px;
}

.docente-navbar .perfil-btn {
  display: flex;
  align-items: center;
  gap: 6px;
  background: none;
  border: none;
  cursor: pointer;
  padding: 4px;
  border-radius: 999px;
}

.docente-navbar .perfil-avatar {
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

.docente-navbar .perfil-avatar img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.docente-navbar .perfil-chevron {
  font-size: 14px;
  color: #5a6a7a;
  transition: transform 0.2s;
}

.dark-mode .docente-navbar .perfil-chevron {
  color: #aabbcc;
}

.docente-navbar .perfil-chevron.rotada {
  transform: rotate(180deg);
}

.docente-navbar .perfil-dropdown {
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

.dark-mode .docente-navbar .perfil-dropdown {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.docente-navbar .dropdown-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 0.5rem 0.5rem 0.85rem 0.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
  margin-bottom: 0.5rem;
}

.dark-mode .docente-navbar .dropdown-header {
  border-bottom-color: rgba(255, 255, 255, 0.08);
}

.docente-navbar .dropdown-avatar {
  width: 44px;
  height: 44px;
  font-size: 15px;
}

.docente-navbar .dropdown-nombre {
  font-size: 14px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .docente-navbar .dropdown-nombre {
  color: #ffffff;
}

.docente-navbar .dropdown-email {
  font-size: 12px;
  color: #8a9aaa;
  word-break: break-all;
}

.docente-navbar .dropdown-item {
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

.dark-mode .docente-navbar .dropdown-item {
  color: #e2e8f0;
}

.docente-navbar .dropdown-item:hover {
  background: rgba(37, 99, 235, 0.08);
}

.docente-navbar .dropdown-logout {
  color: #c0392b;
}

.dark-mode .docente-navbar .dropdown-logout {
  color: #ff6b6b;
}

.docente-navbar .dropdown-logout:hover {
  background: rgba(192, 57, 43, 0.08);
}

/* ── Modal overlay ── */
.docente-navbar .navbar-modal-overlay {
  position: fixed;
  inset: 0;
  background-color: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 200;
}

/* ── Modal box ── */
.docente-navbar .navbar-modal {
  background: #ffffff;
  border-radius: 10px;
  padding: 2rem;
  max-width: 420px;
  width: 90%;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
}

.docente-navbar .navbar-modal-mensaje {
  font-size: 1rem;
  color: #1a2a3a;
  margin-bottom: 1.5rem;
  line-height: 1.5;
  font-family: Arial, sans-serif;
}

.docente-navbar .navbar-modal-acciones {
  display: flex;
  justify-content: flex-end;
  gap: 0.75rem;
}

.docente-navbar .btn-navbar-modal {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.55rem 1.25rem;
  border-radius: 7px;
  border: none;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.15s ease;
}

.docente-navbar .btn-navbar-modal:active {
  transform: scale(0.97);
}

.docente-navbar .btn-navbar-cancelar {
  background-color: #e5e7eb;
  color: #1a2a3a;
}

.docente-navbar .btn-navbar-cancelar:hover {
  background-color: #d1d5db;
}

.docente-navbar .btn-navbar-confirmar {
  background-color: #c0392b;
  color: #ffffff;
}

.docente-navbar .btn-navbar-confirmar:hover {
  background-color: #a93226;
}

/* ── Modal dark mode ── */
.dark-mode .docente-navbar .navbar-modal {
  background-color: #1a1a1a;
  box-shadow: 0 8px 32px rgba(0, 0, 0, 0.5);
}

.dark-mode .docente-navbar .navbar-modal-mensaje {
  color: #ffffff;
}

.dark-mode .docente-navbar .navbar-modal-mensaje strong {
  color: #aabbcc;
}

.dark-mode .docente-navbar .btn-navbar-cancelar {
  background-color: #2a2a2a;
  color: #aabbcc;
}

.dark-mode .docente-navbar .btn-navbar-cancelar:hover {
  background-color: #333333;
}
</style>