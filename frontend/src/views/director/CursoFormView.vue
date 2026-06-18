<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { agregarCurso } from '@/data/cursosMock'
import { docentesMock } from '@/data/docentesMock'

const router = useRouter()

const form = reactive({
  nombre: '',
  ciclo: 'Primario',
  turno: 'Mañana' as 'Mañana' | 'Tarde',
  docente: '',
  cantidadAlumnos: null as number | null,
})

const errores = ref<Record<string, string>>({})
const enviado = ref(false)

const validar = (): boolean => {
  errores.value = {}

  if (!form.nombre.trim()) errores.value.nombre = 'El nombre del curso es obligatorio.'
  if (!form.docente)       errores.value.docente = 'Seleccioná un docente a cargo.'

  if (form.cantidadAlumnos === null || form.cantidadAlumnos <= 0) {
    errores.value.cantidadAlumnos = 'Ingresá una cantidad válida de alumnos.'
  }

  return Object.keys(errores.value).length === 0
}

const guardar = () => {
  if (!validar()) return

  agregarCurso({
    nombre: form.nombre,
    ciclo: form.ciclo,
    turno: form.turno,
    docente: form.docente,
    cantidadAlumnos: form.cantidadAlumnos as number,
  })

  enviado.value = true
  setTimeout(() => router.push('/director/cursos'), 1200)
}

const cancelar = () => router.push('/director/cursos')
</script>

<template>
  <div class="page-wrapper">
    <button class="btn-volver" @click="cancelar">
      <i class="ti ti-arrow-left" aria-hidden="true"></i> Volver a Cursos
    </button>

    <div class="form-container">
      <h1 class="paso-titulo">Agregar nuevo curso</h1>
      <p class="paso-desc">Completá los datos del curso para registrarlo en el sistema.</p>

      <div v-if="enviado" class="exito-box">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        Curso agregado correctamente. Redirigiendo...
      </div>

      <form v-else @submit.prevent="guardar">
        <div class="form-fila">
          <div class="form-group">
            <label for="nombre">Nombre del curso</label>
            <input id="nombre" v-model="form.nombre" type="text" placeholder="Ej: 2° B" />
            <span v-if="errores.nombre" class="error-msg">{{ errores.nombre }}</span>
          </div>
          <div class="form-group">
            <label for="ciclo">Ciclo</label>
            <select id="ciclo" v-model="form.ciclo">
              <option value="Primario">Primario</option>
              <option value="Inicial">Inicial</option>
              <option value="Secundario">Secundario</option>
            </select>
          </div>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="turno">Turno</label>
            <select id="turno" v-model="form.turno">
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
            </select>
          </div>
          <div class="form-group">
            <label for="alumnos">Cantidad de alumnos</label>
            <input id="alumnos" v-model.number="form.cantidadAlumnos" type="number" min="1" placeholder="Ej: 25" />
            <span v-if="errores.cantidadAlumnos" class="error-msg">{{ errores.cantidadAlumnos }}</span>
          </div>
        </div>

        <div class="form-group">
          <label for="docente">Docente a cargo</label>
          <select id="docente" v-model="form.docente">
            <option value="" disabled>Seleccioná un docente</option>
            <option v-for="d in docentesMock" :key="d.id" :value="`${d.nombre} ${d.apellido}`">
              {{ d.nombre }} {{ d.apellido }}
            </option>
          </select>
          <span v-if="errores.docente" class="error-msg">{{ errores.docente }}</span>
        </div>

        <div class="form-nav">
          <button type="button" class="btn-nav btn-anterior" @click="cancelar">Cancelar</button>
          <button type="submit" class="btn-nav btn-submit">Guardar curso</button>
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
