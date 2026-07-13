<script setup lang="ts">
import { reactive, ref, computed, watch } from 'vue'
import { useRouter } from 'vue-router'
import { crearCurso } from '@/services/cursoService'

const router = useRouter()

const form = reactive({
  ciclo: 'Primer Ciclo' as 'Primer Ciclo' | 'Segundo Ciclo',
  grado: '',
  seccion: '',
  turno: 'Mañana' as 'Mañana' | 'Tarde' | 'Noche',
})

const errores = ref<Record<string, string>>({})
const enviado = ref(false)
const enviando = ref(false)
const errorServidor = ref('')

const gradosPorCiclo: Record<string, string[]> = {
  'Primer Ciclo': ['1°', '2°', '3°'],
  'Segundo Ciclo': ['4°', '5°', '6°', '7°'],
}

const opcionesGrado = computed(() => gradosPorCiclo[form.ciclo] ?? [])
const opcionesSeccion = ['A', 'B', 'C', 'D', 'E', 'F']

watch(() => form.ciclo, () => {
  form.grado = ''
})

const validar = (): boolean => {
  errores.value = {}

  if (!form.grado)   errores.value.grado = 'Seleccioná un grado.'
  if (!form.seccion) errores.value.seccion = 'Seleccioná una sección.'

  return Object.keys(errores.value).length === 0
}

const guardar = async () => {
  errorServidor.value = ''
  if (!validar()) return

  enviando.value = true
  try {
    await crearCurso({
      ciclo: form.ciclo,
      grado: form.grado,
      seccion: form.seccion,
      turno: form.turno,
    })

    enviado.value = true
    setTimeout(() => router.push('/director/cursos'), 1200)
  } catch (error) {
    errorServidor.value = 'No se pudo crear el curso. Intentá nuevamente.'
    console.error(error)
  } finally {
    enviando.value = false
  }
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
            <label for="ciclo">Ciclo</label>
            <select id="ciclo" v-model="form.ciclo">
              <option value="Primer Ciclo">Primer Ciclo</option>
              <option value="Segundo Ciclo">Segundo Ciclo</option>
            </select>
          </div>
          <div class="form-group">
            <label for="grado">Grado</label>
            <select id="grado" v-model="form.grado">
              <option value="" disabled>Seleccioná un grado</option>
              <option v-for="g in opcionesGrado" :key="g" :value="g">{{ g }}</option>
            </select>
            <span v-if="errores.grado" class="error-msg">{{ errores.grado }}</span>
          </div>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="seccion">Sección</label>
            <select id="seccion" v-model="form.seccion">
              <option value="" disabled>Seleccioná una sección</option>
              <option v-for="s in opcionesSeccion" :key="s" :value="s">{{ s }}</option>
            </select>
            <span v-if="errores.seccion" class="error-msg">{{ errores.seccion }}</span>
          </div>
          <div class="form-group">
            <label for="turno">Turno</label>
            <select id="turno" v-model="form.turno">
              <option value="Mañana">Mañana</option>
              <option value="Tarde">Tarde</option>
              <option value="Noche">Noche</option>
            </select>
          </div>
        </div>

        <div v-if="errorServidor" class="error-msg">{{ errorServidor }}</div>

        <div class="form-nav">
          <button type="button" class="btn-nav btn-anterior" @click="cancelar" :disabled="enviando">
            Cancelar
          </button>
          <button type="submit" class="btn-nav btn-submit" :disabled="enviando">
            {{ enviando ? 'Guardando...' : 'Guardar curso' }}
          </button>
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
