<script setup lang="ts">
import { ref } from 'vue'
import axios from 'axios'

// TODO: reemplazar por datos reales del usuario autenticado
const persona = ref({
  id: 1,
  nombres: 'Juan',
  apellidos: 'Pérez',
  dni: '12345678',
  email: 'juan.perez@email.com',
  telefono: '',
  direccion: '',
  fecha_nacimiento: '',
})

const form = ref({
  'e-mail': persona.value.email,
  telefono: persona.value.telefono,
  direccion: persona.value.direccion,
  fecha_nacimiento: persona.value.fecha_nacimiento,
})

const fotoPreview = ref<string | null>(localStorage.getItem('perfil_foto'))
const guardando = ref(false)
const exito = ref(false)
const error = ref<string | null>(null)

function handleFoto(e: Event) {
  const input = e.target as HTMLInputElement
  if (!input.files?.length) return
  const reader = new FileReader()
  reader.onload = () => {
    const resultado = reader.result as string
    fotoPreview.value = resultado
    localStorage.setItem('perfil_foto', resultado)
  }
  reader.readAsDataURL(input.files[0])
}

function iniciales() {
  return `${persona.value.nombres[0] ?? ''}${persona.value.apellidos[0] ?? ''}`.toUpperCase()
}

async function guardar() {
  guardando.value = true
  exito.value = false
  error.value = null
  try {
    await axios.put(`/api/personas/${persona.value.id}`, form.value)
    exito.value = true
  } catch {
    error.value = 'Ocurrió un error al guardar. Intentá de nuevo.'
  } finally {
    guardando.value = false
  }
}
</script>

<template>
  <div class="perfil-wrap">

    <!-- Avatar -->
    <div class="perfil-avatar-seccion">
      <div class="perfil-avatar">
        <img v-if="fotoPreview" :src="fotoPreview" alt="Foto de perfil" class="perfil-avatar-img" />
        <span v-else class="perfil-avatar-iniciales">{{ iniciales() }}</span>
      </div>
      <label class="perfil-btn-foto">
        <i class="ti ti-camera"></i>
        Cambiar foto
        <input type="file" accept="image/*" class="perfil-input-file" @change="handleFoto" />
      </label>
    </div>

    <!-- Datos de solo lectura -->
    <div class="perfil-card">
      <h3 class="perfil-seccion-titulo">
        <i class="ti ti-lock"></i>
        Datos personales
      </h3>
      <p class="perfil-seccion-desc">Estos datos son gestionados por el director y no pueden modificarse.</p>
      <div class="perfil-grid">
        <div class="perfil-campo">
          <label class="perfil-label">Nombres</label>
          <div class="perfil-valor-readonly">{{ persona.nombres }}</div>
        </div>
        <div class="perfil-campo">
          <label class="perfil-label">Apellidos</label>
          <div class="perfil-valor-readonly">{{ persona.apellidos }}</div>
        </div>
        <div class="perfil-campo">
          <label class="perfil-label">DNI</label>
          <div class="perfil-valor-readonly">{{ persona.dni }}</div>
        </div>
      </div>
    </div>

    <!-- Datos editables -->
    <div class="perfil-card">
      <h3 class="perfil-seccion-titulo">
        <i class="ti ti-edit"></i>
        Información de contacto
      </h3>
      <p class="perfil-seccion-desc">Podés actualizar estos datos en cualquier momento.</p>
      <div class="perfil-grid">
        <div class="perfil-campo">
          <label class="perfil-label">Email</label>
          <input
            v-model="form['e-mail']"
            type="email"
            class="perfil-input"
            placeholder="tu@email.com"
          />
        </div>
        <div class="perfil-campo">
          <label class="perfil-label">Teléfono</label>
          <input
            v-model="form.telefono"
            type="text"
            class="perfil-input"
            placeholder="Ej: 3624 123456"
          />
        </div>
        <div class="perfil-campo">
          <label class="perfil-label">Dirección</label>
          <input
            v-model="form.direccion"
            type="text"
            class="perfil-input"
            placeholder="Calle y número"
          />
        </div>
        <div class="perfil-campo">
          <label class="perfil-label">Fecha de nacimiento</label>
          <input
            v-model="form.fecha_nacimiento"
            type="date"
            class="perfil-input"
          />
        </div>
      </div>

      <!-- Feedback -->
      <p v-if="exito" class="perfil-msg-exito">
        <i class="ti ti-check"></i>
        Datos guardados correctamente.
      </p>
      <p v-if="error" class="perfil-msg-error">
        <i class="ti ti-alert-circle"></i>
        {{ error }}
      </p>

      <!-- Botón guardar -->
      <div class="perfil-acciones">
        <button class="perfil-btn-guardar" :disabled="guardando" @click="guardar">
          <i :class="guardando ? 'ti ti-loader-2' : 'ti ti-device-floppy'"></i>
          {{ guardando ? 'Guardando...' : 'Guardar cambios' }}
        </button>
      </div>
    </div>

  </div>
</template>

<style>
/* ── Wrapper ── */
.perfil-wrap {
  max-width: 700px;
  margin: 0 auto;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

/* ── Avatar ── */
.perfil-avatar-seccion {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 1rem;
}

.perfil-avatar {
  width: 100px;
  height: 100px;
  border-radius: 50%;
  background-color: #29ABE2;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border: 3px solid #33CCFF;
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.25);
}

.perfil-avatar-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.perfil-avatar-iniciales {
  font-size: 2rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: #ffffff;
}

.perfil-btn-foto {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.45rem 1rem;
  border: 1.5px solid #29ABE2;
  border-radius: 8px;
  color: #29ABE2;
  font-size: 0.875rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s ease, color 0.2s ease;
}

.perfil-btn-foto:hover {
  background-color: #29ABE2;
  color: #ffffff;
}

.perfil-input-file {
  display: none;
}

/* ── Card ── */
.perfil-card {
  background-color: #f2efef;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.07);
}

/* ── Sección título ── */
.perfil-seccion-titulo {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: #1a2a3a;
  margin-bottom: 0.35rem;
}

.perfil-seccion-desc {
  font-size: 0.825rem;
  font-family: Arial, sans-serif;
  color: #5a6a7a;
  margin-bottom: 1.25rem;
}

/* ── Grid campos ── */
.perfil-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem 1.5rem;
}

.perfil-campo {
  display: flex;
  flex-direction: column;
  gap: 0.35rem;
}

.perfil-label {
  font-size: 0.8rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  color: #5a6a7a;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

/* ── Solo lectura ── */
.perfil-valor-readonly {
  padding: 0.55rem 0.85rem;
  background-color: #e8e5e5;
  border-radius: 7px;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  color: #5a6a7a;
  border: 1px solid #d0cece;
}

/* ── Inputs editables ── */
.perfil-input {
  padding: 0.55rem 0.85rem;
  background-color: #ffffff;
  border: 1px solid #d0cece;
  border-radius: 7px;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  color: #1a2a3a;
  transition: border-color 0.2s ease;
  outline: none;
}

.perfil-input:focus {
  border-color: #29ABE2;
}

/* ── Feedback ── */
.perfil-msg-exito {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  margin-top: 1rem;
  font-size: 0.875rem;
  font-family: Arial, sans-serif;
  color: #27ae60;
}

.perfil-msg-error {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  margin-top: 1rem;
  font-size: 0.875rem;
  font-family: Arial, sans-serif;
  color: #c0392b;
}

/* ── Botón guardar ── */
.perfil-acciones {
  display: flex;
  justify-content: flex-end;
  margin-top: 1.25rem;
}

.perfil-btn-guardar {
  display: inline-flex;
  align-items: center;
  gap: 0.4rem;
  padding: 0.6rem 1.4rem;
  background-color: #29ABE2;
  color: #ffffff;
  border: none;
  border-radius: 8px;
  font-size: 0.9rem;
  font-family: Arial, sans-serif;
  font-weight: bold;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.15s ease;
}

.perfil-btn-guardar:hover:not(:disabled) {
  background-color: #1a8fc1;
}

.perfil-btn-guardar:active:not(:disabled) {
  transform: scale(0.97);
}

.perfil-btn-guardar:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

/* ── Modo oscuro ── */
.dark-mode .perfil-wrap .perfil-card {
  background-color: #1a1a1a;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.3);
}

.dark-mode .perfil-wrap .perfil-seccion-titulo {
  color: #ffffff;
}

.dark-mode .perfil-wrap .perfil-seccion-desc {
  color: #aabbcc;
}

.dark-mode .perfil-wrap .perfil-label {
  color: #aabbcc;
}

.dark-mode .perfil-wrap .perfil-valor-readonly {
  background-color: #2a2a2a;
  color: #aabbcc;
  border-color: #333333;
}

.dark-mode .perfil-wrap .perfil-input {
  background-color: #232323;
  border-color: #333333;
  color: #ffffff;
}

.dark-mode .perfil-wrap .perfil-input:focus {
  border-color: #33CCFF;
}

.dark-mode .perfil-wrap .perfil-btn-foto {
  border-color: #33CCFF;
  color: #33CCFF;
}

.dark-mode .perfil-wrap .perfil-btn-foto:hover {
  background-color: #33CCFF;
  color: #1a1a1a;
}
</style>