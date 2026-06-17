<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRouter } from 'vue-router'
import { directorActual } from '@/data/directorMock'

const router = useRouter()

const iniciales = computed(() =>
  `${directorActual.nombre[0]}${directorActual.apellido[0]}`.toUpperCase()
)

const fechaIngresoFormateada = computed(() =>
  new Date(directorActual.fechaIngreso).toLocaleDateString('es-AR', {
    year: 'numeric', month: 'long', day: 'numeric',
  })
)

const inputFoto = ref<HTMLInputElement | null>(null)
const modoEdicion = ref(false)
const mostrarConfirmLogout = ref(false)

const formEdicion = ref({
  telefono: directorActual.telefono,
  email: directorActual.email,
})

const abrirSelectorFoto = () => inputFoto.value?.click()

const onFotoSeleccionada = (e: Event) => {
  const input = e.target as HTMLInputElement
  const archivo = input.files?.[0]
  if (!archivo) return

  // Vista previa local (no se sube a ningún lado todavía, eso lo conecta el back)
  const url = URL.createObjectURL(archivo)
  directorActual.fotoUrl = url
}

const quitarFoto = () => {
  directorActual.fotoUrl = null
}

const activarEdicion = () => {
  formEdicion.value = { telefono: directorActual.telefono, email: directorActual.email }
  modoEdicion.value = true
}

const guardarEdicion = () => {
  directorActual.telefono = formEdicion.value.telefono
  directorActual.email = formEdicion.value.email
  modoEdicion.value = false
}

const cancelarEdicion = () => {
  modoEdicion.value = false
}

const confirmarLogout = () => {
  mostrarConfirmLogout.value = true
}

const cerrarSesion = () => {
  router.push('/login')
}
</script>

<template>
  <div class="page-wrapper">
    <div class="page-header">
      <div class="page-header-icon">
        <i class="ti ti-user-circle" aria-hidden="true"></i>
      </div>
      <div>
        <h1 class="page-title">Mi perfil</h1>
        <p class="page-subtitle">Tus datos personales y configuración de cuenta.</p>
      </div>
    </div>

    <div class="perfil-card">
      <div class="perfil-foto-bloque">
        <div class="perfil-foto">
          <img v-if="directorActual.fotoUrl" :src="directorActual.fotoUrl" alt="Foto de perfil" />
          <span v-else>{{ iniciales }}</span>
        </div>
        <input ref="inputFoto" type="file" accept="image/*" class="input-oculto" @change="onFotoSeleccionada" />
        <div class="foto-acciones">
          <button class="btn-foto" @click="abrirSelectorFoto">
            <i class="ti ti-camera" aria-hidden="true"></i> Cambiar foto
          </button>
          <button v-if="directorActual.fotoUrl" class="btn-foto btn-foto-quitar" @click="quitarFoto">
            <i class="ti ti-trash" aria-hidden="true"></i> Quitar
          </button>
        </div>
      </div>

      <div class="perfil-info">
        <h2 class="perfil-nombre">{{ directorActual.nombre }} {{ directorActual.apellido }}</h2>
        <p class="perfil-institucion">
          <i class="ti ti-building" aria-hidden="true"></i> {{ directorActual.institucion }}
        </p>

        <div class="perfil-datos">
          <div class="dato-row">
            <span class="dato-label"><i class="ti ti-id"></i> DNI</span>
            <span class="dato-valor">{{ directorActual.dni }}</span>
          </div>

          <template v-if="!modoEdicion">
            <div class="dato-row">
              <span class="dato-label"><i class="ti ti-mail"></i> Email</span>
              <span class="dato-valor">{{ directorActual.email }}</span>
            </div>
            <div class="dato-row">
              <span class="dato-label"><i class="ti ti-phone"></i> Teléfono</span>
              <span class="dato-valor">{{ directorActual.telefono }}</span>
            </div>
          </template>

          <template v-else>
            <div class="dato-row-editable">
              <span class="dato-label"><i class="ti ti-mail"></i> Email</span>
              <input v-model="formEdicion.email" type="email" class="input-edicion" />
            </div>
            <div class="dato-row-editable">
              <span class="dato-label"><i class="ti ti-phone"></i> Teléfono</span>
              <input v-model="formEdicion.telefono" type="text" class="input-edicion" />
            </div>
          </template>

          <div class="dato-row">
            <span class="dato-label"><i class="ti ti-calendar"></i> Ingreso</span>
            <span class="dato-valor">{{ fechaIngresoFormateada }}</span>
          </div>
        </div>

        <div class="perfil-acciones">
          <template v-if="!modoEdicion">
            <button class="btn-perfil btn-editar" @click="activarEdicion">
              <i class="ti ti-edit" aria-hidden="true"></i> Editar datos de contacto
            </button>
          </template>
          <template v-else>
            <button class="btn-perfil btn-guardar" @click="guardarEdicion">
              <i class="ti ti-check" aria-hidden="true"></i> Guardar cambios
            </button>
            <button class="btn-perfil btn-cancelar-edicion" @click="cancelarEdicion">
              Cancelar
            </button>
          </template>
        </div>
      </div>
    </div>

    <div class="logout-card">
      <div>
        <h3>Cerrar sesión</h3>
        <p>Vas a salir del portal y volver a la pantalla de inicio de sesión.</p>
      </div>
      <button class="btn-logout" @click="confirmarLogout">
        <i class="ti ti-logout" aria-hidden="true"></i> Cerrar sesión
      </button>
    </div>

    <!-- Modal de confirmación -->
    <div v-if="mostrarConfirmLogout" class="modal-overlay" @click.self="mostrarConfirmLogout = false">
      <div class="modal-confirm">
        <i class="ti ti-alert-triangle modal-confirm-icon" aria-hidden="true"></i>
        <h3>¿Cerrar sesión?</h3>
        <p>Tendrás que volver a iniciar sesión para acceder al portal.</p>
        <div class="modal-confirm-acciones">
          <button class="btn-perfil btn-cancelar-edicion" @click="mostrarConfirmLogout = false">Cancelar</button>
          <button class="btn-logout" @click="cerrarSesion">Sí, cerrar sesión</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper {
  width: 100%;
  max-width: 760px;
}

.page-header {
  display: flex;
  align-items: center;
  gap: 16px;
  margin-bottom: 1.5rem;
}

.page-header-icon {
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

.dark-mode .page-header-icon {
  background: rgba(37, 99, 235, 0.08);
  color: #60a5fa;
}

.page-title {
  font-size: 22px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 2px;
}

.dark-mode .page-title {
  color: #ffffff;
}

.page-subtitle {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .page-subtitle {
  color: #aabbcc;
}

/* ─── Perfil card ────────────────────────────────────────────────────────────── */

.perfil-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 20px;
  padding: 2rem;
  display: flex;
  gap: 2rem;
  margin-bottom: 1.5rem;
}

.dark-mode .perfil-card {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.perfil-foto-bloque {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 14px;
  flex-shrink: 0;
}

.perfil-foto {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: #2563eb;
  border: 3px solid #1e40af;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 36px;
  font-weight: 700;
  color: #ffffff;
  overflow: hidden;
}

.perfil-foto img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.input-oculto {
  display: none;
}

.foto-acciones {
  display: flex;
  flex-direction: column;
  gap: 6px;
  width: 100%;
}

.btn-foto {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  background: rgba(37, 99, 235, 0.1);
  color: #1e40af;
  border: 1.5px solid rgba(37, 99, 235, 0.3);
  border-radius: 999px;
  padding: 7px 14px;
  font-size: 12.5px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s;
}

.dark-mode .btn-foto {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.btn-foto:hover {
  background: rgba(37, 99, 235, 0.2);
}

.btn-foto-quitar {
  background: rgba(192, 57, 43, 0.08);
  color: #c0392b;
  border-color: rgba(192, 57, 43, 0.25);
}

.dark-mode .btn-foto-quitar {
  color: #ff6b6b;
}

.btn-foto-quitar:hover {
  background: rgba(192, 57, 43, 0.15);
}

.perfil-info {
  flex: 1;
  min-width: 0;
}

.perfil-nombre {
  font-size: 20px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 4px;
}

.dark-mode .perfil-nombre {
  color: #ffffff;
}

.perfil-institucion {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13px;
  color: #5a6a7a;
  margin-bottom: 1.25rem;
}

.dark-mode .perfil-institucion {
  color: #aabbcc;
}

.perfil-datos {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 1.5rem;
}

.dato-row, .dato-row-editable {
  display: flex;
  align-items: center;
  gap: 10px;
}

.dato-label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  min-width: 110px;
  flex-shrink: 0;
}

.dark-mode .dato-label {
  color: #6b7c8c;
}

.dato-valor {
  font-size: 14.5px;
  font-weight: 600;
  color: #1a2a3a;
}

.dark-mode .dato-valor {
  color: #e2e8f0;
}

.input-edicion {
  flex: 1;
  padding: 0.45rem 0.7rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
  font-family: arial, sans-serif;
  max-width: 280px;
}

.dark-mode .input-edicion {
  background: #111827;
  border-color: #2c4f7c;
  color: #e2e8f0;
}

.perfil-acciones {
  display: flex;
  gap: 10px;
}

.btn-perfil {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border-radius: 999px;
  padding: 9px 18px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  border: 2px solid transparent;
  transition: background 0.2s, transform 0.15s;
}

.btn-editar {
  background: #2563eb;
  color: #ffffff;
  border-color: #1e40af;
}

.btn-editar:hover {
  background: #1d4ed8;
  transform: translateY(-1px);
}

.btn-guardar {
  background: #1d9e75;
  color: #ffffff;
  border-color: #0f6e56;
}

.btn-guardar:hover {
  background: #168a64;
}

.btn-cancelar-edicion {
  background: #f5f7fa;
  color: #5a6a7a;
  border-color: rgba(0,0,0,0.1);
}

.btn-cancelar-edicion:hover {
  background: #e2e8f0;
}

.dark-mode .btn-cancelar-edicion {
  background: #111827;
  color: #aabbcc;
}

/* ─── Logout card ────────────────────────────────────────────────────────────── */

.logout-card {
  background: rgba(192, 57, 43, 0.06);
  border: 1.5px solid rgba(192, 57, 43, 0.2);
  border-radius: 16px;
  padding: 1.25rem 1.5rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  flex-wrap: wrap;
}

.dark-mode .logout-card {
  background: rgba(192, 57, 43, 0.1);
  border-color: rgba(255, 107, 107, 0.25);
}

.logout-card h3 {
  font-size: 15px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 2px;
}

.dark-mode .logout-card h3 {
  color: #ffffff;
}

.logout-card p {
  font-size: 13px;
  color: #5a6a7a;
}

.dark-mode .logout-card p {
  color: #aabbcc;
}

.btn-logout {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #c0392b;
  color: #ffffff;
  border: 2px solid #962d22;
  border-radius: 999px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s;
  flex-shrink: 0;
}

.btn-logout:hover {
  background: #a93226;
  transform: translateY(-1px);
}

/* ─── Modal confirmación ─────────────────────────────────────────────────────── */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
  padding: 1rem;
}

.modal-confirm {
  background: #ffffff;
  border-radius: 20px;
  width: 100%;
  max-width: 380px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.dark-mode .modal-confirm {
  background: #1a1a1a;
}

.modal-confirm-icon {
  font-size: 40px;
  color: #c0392b;
  margin-bottom: 12px;
}

.modal-confirm h3 {
  font-size: 17px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 8px;
}

.dark-mode .modal-confirm h3 {
  color: #ffffff;
}

.modal-confirm p {
  font-size: 13.5px;
  color: #5a6a7a;
  margin-bottom: 1.5rem;
}

.dark-mode .modal-confirm p {
  color: #aabbcc;
}

.modal-confirm-acciones {
  display: flex;
  gap: 10px;
  justify-content: center;
}
</style>
