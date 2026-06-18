<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { agregarDocente } from '@/data/docentesMock'

const router = useRouter()

const form = reactive({
  nombre: '',
  apellido: '',
  dni: '',
  email: '',
  telefono: '',
  grado: '',
  fechaIngreso: '',
  estado: 'Activo' as 'Activo' | 'Inactivo',
})

const errores = ref<Record<string, string>>({})
const enviado = ref(false)

const grados = [
  '1° A', '1° B', '2° A', '2° B', '3° A', '3° B',
  '4° A', '4° B', '5° A', '5° B', '6° A', '6° B',
]

const validar = (): boolean => {
  errores.value = {}

  if (!form.nombre.trim())   errores.value.nombre = 'El nombre es obligatorio.'
  if (!form.apellido.trim()) errores.value.apellido = 'El apellido es obligatorio.'

  if (!form.dni.trim()) {
    errores.value.dni = 'El DNI es obligatorio.'
  } else if (!/^\d{7,8}$/.test(form.dni.trim())) {
    errores.value.dni = 'El DNI debe tener 7 u 8 números.'
  }

  if (!form.email.trim()) {
    errores.value.email = 'El email es obligatorio.'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.trim())) {
    errores.value.email = 'El email no tiene un formato válido.'
  }

  if (!form.telefono.trim()) errores.value.telefono = 'El teléfono es obligatorio.'
  if (!form.grado)           errores.value.grado = 'Seleccioná un grado.'
  if (!form.fechaIngreso)    errores.value.fechaIngreso = 'La fecha de ingreso es obligatoria.'

  return Object.keys(errores.value).length === 0
}

const guardar = () => {
  if (!validar()) return

  agregarDocente({ ...form })
  enviado.value = true

  setTimeout(() => {
    router.push('/director/docentes')
  }, 1200)
}

const cancelar = () => {
  router.push('/director/docentes')
}
</script>

<template>
  <div class="page-wrapper">
    <button class="btn-volver" @click="cancelar">
      <i class="ti ti-arrow-left" aria-hidden="true"></i> Volver a Docentes
    </button>

    <div class="form-container">
      <h1 class="paso-titulo">Agregar nuevo docente</h1>
      <p class="paso-desc">Completá los datos del docente para registrarlo en el sistema.</p>

      <div v-if="enviado" class="exito-box">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        Docente agregado correctamente. Redirigiendo...
      </div>

      <form v-else @submit.prevent="guardar">
        <div class="form-fila">
          <div class="form-group">
            <label for="nombre">Nombre</label>
            <input id="nombre" v-model="form.nombre" type="text" placeholder="Ej: Juan" />
            <span v-if="errores.nombre" class="error-msg">{{ errores.nombre }}</span>
          </div>
          <div class="form-group">
            <label for="apellido">Apellido</label>
            <input id="apellido" v-model="form.apellido" type="text" placeholder="Ej: Pérez" />
            <span v-if="errores.apellido" class="error-msg">{{ errores.apellido }}</span>
          </div>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="dni">DNI</label>
            <input id="dni" v-model="form.dni" type="text" placeholder="Ej: 28456789" maxlength="8" />
            <span v-if="errores.dni" class="error-msg">{{ errores.dni }}</span>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input id="telefono" v-model="form.telefono" type="text" placeholder="Ej: 3624-112233" />
            <span v-if="errores.telefono" class="error-msg">{{ errores.telefono }}</span>
          </div>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" v-model="form.email" type="email" placeholder="Ej: juan@escuela.com" />
          <span v-if="errores.email" class="error-msg">{{ errores.email }}</span>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="grado">Grado a cargo</label>
            <select id="grado" v-model="form.grado">
              <option value="" disabled>Seleccioná un grado</option>
              <option v-for="g in grados" :key="g" :value="g">{{ g }}</option>
            </select>
            <span v-if="errores.grado" class="error-msg">{{ errores.grado }}</span>
          </div>
          <div class="form-group">
            <label for="fechaIngreso">Fecha de ingreso</label>
            <input id="fechaIngreso" v-model="form.fechaIngreso" type="date" />
            <span v-if="errores.fechaIngreso" class="error-msg">{{ errores.fechaIngreso }}</span>
          </div>
        </div>

        <div class="form-group">
          <label for="estado">Estado</label>
          <select id="estado" v-model="form.estado">
            <option value="Activo">Activo</option>
            <option value="Inactivo">Inactivo</option>
          </select>
        </div>

        <div class="form-nav">
          <button type="button" class="btn-nav btn-anterior" @click="cancelar">Cancelar</button>
          <button type="submit" class="btn-nav btn-submit">Guardar docente</button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper {
  width: 100%;
}

.form-group select {
  padding: 0.6rem 0.75rem;
  border: 1px solid var(--color-border);
  border-radius: 8px;
  font-size: 0.95rem;
  font-family: arial, sans-serif;
  background: #ffffff;
  color: var(--color-text);
}

.form-group select:focus {
  outline: none;
  border-color: var(--color-primary);
}

.error-msg {
  font-size: 0.8rem;
  color: #c0392b;
  font-weight: 600;
}

.exito-box {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(29, 158, 117, 0.12);
  border: 1.5px solid rgba(29, 158, 117, 0.3);
  color: #0f6e56;
  border-radius: 12px;
  padding: 1rem 1.25rem;
  font-weight: 600;
  font-size: 0.95rem;
}

.dark-mode .form-container {
  color: #e2e8f0;
}

.dark-mode .paso-titulo {
  color: #60a5fa;
}

.dark-mode .form-group label {
  color: #e2e8f0;
}

.dark-mode .form-group input,
.dark-mode .form-group select {
  background: #111827;
  border-color: #2c4f7c;
  color: #e2e8f0;
}

.dark-mode .btn-anterior {
  background-color: #1a1a1a;
  color: #e2e8f0;
}
</style>
