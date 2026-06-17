<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps<{ isDark: boolean; hayDatos: boolean }>()
const emit = defineEmits<{ (e: 'toggle-dark'): void; (e: 'resetear-datos'): void }>()

const router = useRouter()
const mostrarModalNavbar = ref(false)
const rutaPendiente = ref<string | null>(null)

function navegarA(ruta: string) {
  if (props.hayDatos) {
    rutaPendiente.value = ruta
    mostrarModalNavbar.value = true
  } else {
    router.push(ruta)
  }
}

function confirmarNavegacion() {
  mostrarModalNavbar.value = false
  if (rutaPendiente.value) {
    router.push(rutaPendiente.value)
    rutaPendiente.value = null
    emit('resetear-datos')
  }
}

function cancelarNavegacion() {
  mostrarModalNavbar.value = false
  rutaPendiente.value = null
}
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
      <li>
        <a @click.prevent="navegarA('/docente/mi-perfil')">
          <i class="ti ti-user" aria-hidden="true"></i> Mi perfil
        </a>
      </li>
      <li class="toggle-wrap">
        <i class="ti ti-sun toggle-icon" aria-hidden="true"></i>
        <button class="toggle-btn" @click="$emit('toggle-dark')" aria-label="Cambiar modo claro/oscuro"></button>
        <i class="ti ti-moon toggle-icon" aria-hidden="true"></i>
      </li>
    </ul>

    <!-- Modal de advertencia -->
    <div v-if="mostrarModalNavbar" class="navbar-modal-overlay">
      <div class="navbar-modal">
        <p class="navbar-modal-mensaje">
          ¿Salir de la planificación? <strong>Se perderá toda la información ingresada.</strong>
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
  height: 68px;
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
  background: #33ccff;
  color: #ffffff;
  font-size: 18px;
  font-weight: 700;
  padding: 18px 26px;
  border-radius: 999px;
  border: 2px solid #29abe2;
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
  background: #33ccff;
  border: 2px solid #29abe2;
  border-radius: 999px;
  padding: 18px 20px;
  font-size: 16px;
  font-weight: 700;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.2s, opacity 0.2s, transform 0.15s, box-shadow 0.2s;
}

.docente-navbar .navbar-links a:hover {
  background: #1ab8f0;
  opacity: 0.88;
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.15);
  transform: translateY(-2px);
}

.docente-navbar .navbar-links a:active {
  transform: translateY(0px) scale(0.97);
  box-shadow: none;
  opacity: 0.75;
}

.docente-navbar .navbar-links a.router-link-active {
  background: #29abe2;
  opacity: 1;
}

/* ── Dark mode links ── */
.dark-mode .docente-navbar .navbar-links a {
  background: #1ab8f0;
  border-color: #0d9fd6;
}

.dark-mode .docente-navbar .navbar-links a:hover {
  background: #0d9fd6;
  box-shadow: 0 4px 16px rgba(26, 184, 240, 0.15);
}

.dark-mode .docente-navbar .navbar-links a.router-link-active {
  background: #0d9fd6;
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
  color: #29abe2;
  display: flex;
  align-items: center;
}

.dark-mode .docente-navbar .toggle-icon {
  color: #1ab8f0;
}

.docente-navbar .toggle-btn {
  width: 48px;
  height: 26px;
  border-radius: 999px;
  background: #f0f0f0;
  border: 1.5px solid #29abe2;
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
  background: #1ab8f0;
  border-color: #0d9fd6;
}

.dark-mode .docente-navbar .toggle-btn::after {
  transform: translateX(22px);
  background: #0f1923;
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