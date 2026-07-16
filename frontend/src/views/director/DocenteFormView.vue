<script setup lang="ts">
import { reactive, ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { crearDocente, type CrearDocentePayload } from '@/services/docenteService'
import { getCargos, type CargoAPI } from '@/services/cargoService'
import { getSitRevistas, type SitRevistaAPI } from '@/services/sitRevistaService'
import { getCursosSinAsignar, type CursoSinAsignarAPI } from '@/services/cursoService'

const router = useRouter()

const form = reactive({
  // Datos de acceso
  name: '',
  email: '',
  password: '',
  password_confirmation: '',

  // Datos personales
  apellidos: '',
  nombres: '',
  dni: '',
  telefono: '',
  direccion: '',
  fecha_nacimiento: '',

  // Cargo y situación de revista
  cargos_id: null as number | null,
  sit_revista_id: null as number | null,

  // Asignación de curso
  cursos_id: null as number | null,
  anio_lectivo: '',
  fecha_inicio: '',
  fecha_fin: '',
})

const cargos = ref<CargoAPI[]>([])
const sitRevistas = ref<SitRevistaAPI[]>([])
const cursosSinAsignar = ref<CursoSinAsignarAPI[]>([])

const cargandoOpciones = ref(true)
const errorOpciones = ref('')

const errores = ref<Record<string, string>>({})
const enviado = ref(false)
const cargando = ref(false)
const errorServidor = ref('')

const cargarOpciones = async () => {
  cargandoOpciones.value = true
  errorOpciones.value = ''
  try {
    const [cargosData, sitRevistasData, cursosData] = await Promise.all([
      getCargos(),
      getSitRevistas(),
      getCursosSinAsignar(),
    ])
    cargos.value = cargosData
    sitRevistas.value = sitRevistasData
    cursosSinAsignar.value = cursosData
  } catch {
    errorOpciones.value = 'No se pudieron cargar las opciones del formulario. Reintentá recargando la página.'
  } finally {
    cargandoOpciones.value = false
  }
}

onMounted(cargarOpciones)

const cursoSeleccionadoLabel = computed(() => {
  const curso = cursosSinAsignar.value.find(c => c.id === form.cursos_id)
  if (!curso) return ''
  return `${curso.grado} ${curso.seccion} - ${curso.turno}`
})

const validar = (): boolean => {
  errores.value = {}

  if (!form.name.trim()) errores.value.name = 'El nombre es obligatorio.'

  if (!form.email.trim()) {
    errores.value.email = 'El email es obligatorio.'
  } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(form.email.trim())) {
    errores.value.email = 'El email no tiene un formato válido.'
  }

  if (!form.password) {
    errores.value.password = 'La contraseña es obligatoria.'
  } else if (form.password.length < 6) {
    errores.value.password = 'La contraseña debe tener al menos 6 caracteres.'
  }

  if (!form.password_confirmation) {
    errores.value.password_confirmation = 'Confirmá la contraseña.'
  } else if (form.password !== form.password_confirmation) {
    errores.value.password_confirmation = 'Las contraseñas no coinciden.'
  }

  if (!form.apellidos.trim()) errores.value.apellidos = 'Los apellidos son obligatorios.'
  if (!form.nombres.trim()) errores.value.nombres = 'Los nombres son obligatorios.'
  if (!form.telefono.trim()) errores.value.telefono = 'El teléfono es obligatorio.'
  if (!form.direccion.trim()) errores.value.direccion = 'La dirección es obligatoria.'

  if (!form.cargos_id) errores.value.cargos_id = 'Seleccioná un cargo.'
  if (!form.sit_revista_id) errores.value.sit_revista_id = 'Seleccioná una situación de revista.'

  if (!form.cursos_id) errores.value.cursos_id = 'Seleccioná un curso.'
  if (!form.anio_lectivo.trim()) errores.value.anio_lectivo = 'El año lectivo es obligatorio.'
  if (!form.fecha_inicio) errores.value.fecha_inicio = 'La fecha de inicio es obligatoria.'
  if (!form.fecha_fin) {
    errores.value.fecha_fin = 'La fecha de fin es obligatoria.'
  } else if (form.fecha_inicio && form.fecha_fin < form.fecha_inicio) {
    errores.value.fecha_fin = 'La fecha de fin no puede ser anterior a la de inicio.'
  }

  return Object.keys(errores.value).length === 0
}

const guardar = async () => {
  if (!validar()) return

  cargando.value = true
  errorServidor.value = ''

  try {
    const payload: CrearDocentePayload = {
      name: form.name,
      email: form.email,
      password: form.password,
      password_confirmation: form.password_confirmation,
      apellidos: form.apellidos,
      nombres: form.nombres,
      dni: form.dni.trim() || null,
      telefono: form.telefono,
      direccion: form.direccion,
      fecha_nacimiento: form.fecha_nacimiento || null,
      cargos_id: form.cargos_id!,
      sit_revista_id: form.sit_revista_id!,
      cursos_id: form.cursos_id!,
      anio_lectivo: form.anio_lectivo,
      fecha_inicio: form.fecha_inicio,
      fecha_fin: form.fecha_fin,
    }

    await crearDocente(payload)
    enviado.value = true
    setTimeout(() => router.push('/director/docentes'), 1200)
  } catch (error: any) {
    const data = error.response?.data
    if (data?.errors) {
      for (const [campo, mensajes] of Object.entries(data.errors)) {
        errores.value[campo] = (mensajes as string[])[0]
      }
    } else {
      errorServidor.value = data?.message ?? data?.mensaje ?? 'Ocurrió un error al registrar el docente.'
    }
  } finally {
    cargando.value = false
  }
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
      <p class="paso-desc">Registrá los datos del docente, su cargo y el curso que va a dictar.</p>

      <div v-if="enviado" class="exito-box">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        Docente registrado correctamente. Redirigiendo...
      </div>

      <div v-if="errorServidor" class="error-box">
        <i class="ti ti-alert-circle" aria-hidden="true"></i>
        {{ errorServidor }}
      </div>

      <div v-if="errorOpciones" class="error-box">
        <i class="ti ti-alert-circle" aria-hidden="true"></i>
        {{ errorOpciones }}
      </div>

      <div v-if="cargandoOpciones && !errorOpciones" class="cargando-box">
        <i class="ti ti-loader-2" aria-hidden="true"></i> Cargando opciones...
      </div>

      <form v-if="!enviado && !cargandoOpciones && !errorOpciones" @submit.prevent="guardar">

        <!-- Datos de acceso -->
        <h2 class="subtitulo-seccion">Datos de acceso</h2>

        <div class="form-group">
          <label for="name">Nombre completo</label>
          <input id="name" v-model="form.name" type="text" placeholder="Ej: Juan Pérez" />
          <span v-if="errores.name" class="error-msg">{{ errores.name }}</span>
        </div>

        <div class="form-group">
          <label for="email">Email</label>
          <input id="email" v-model="form.email" type="email" placeholder="Ej: juan@escuela.com" />
          <span v-if="errores.email" class="error-msg">{{ errores.email }}</span>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input id="password" v-model="form.password" type="password" placeholder="Mínimo 6 caracteres" />
            <span v-if="errores.password" class="error-msg">{{ errores.password }}</span>
          </div>
          <div class="form-group">
            <label for="password_confirmation">Confirmar contraseña</label>
            <input id="password_confirmation" v-model="form.password_confirmation" type="password" placeholder="Repetí la contraseña" />
            <span v-if="errores.password_confirmation" class="error-msg">{{ errores.password_confirmation }}</span>
          </div>
        </div>

        <!-- Datos personales -->
        <h2 class="subtitulo-seccion">Datos personales</h2>

        <div class="form-fila">
          <div class="form-group">
            <label for="apellidos">Apellidos</label>
            <input id="apellidos" v-model="form.apellidos" type="text" placeholder="Ej: Pérez" />
            <span v-if="errores.apellidos" class="error-msg">{{ errores.apellidos }}</span>
          </div>
          <div class="form-group">
            <label for="nombres">Nombres</label>
            <input id="nombres" v-model="form.nombres" type="text" placeholder="Ej: Juan" />
            <span v-if="errores.nombres" class="error-msg">{{ errores.nombres }}</span>
          </div>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="dni">DNI (opcional)</label>
            <input id="dni" v-model="form.dni" type="text" placeholder="Ej: 30123456" />
            <span v-if="errores.dni" class="error-msg">{{ errores.dni }}</span>
          </div>
          <div class="form-group">
            <label for="telefono">Teléfono</label>
            <input id="telefono" v-model="form.telefono" type="text" placeholder="Ej: 3624123456" />
            <span v-if="errores.telefono" class="error-msg">{{ errores.telefono }}</span>
          </div>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="direccion">Dirección</label>
            <input id="direccion" v-model="form.direccion" type="text" placeholder="Ej: Av. Siempre Viva 123" />
            <span v-if="errores.direccion" class="error-msg">{{ errores.direccion }}</span>
          </div>
          <div class="form-group">
            <label for="fecha_nacimiento">Fecha de nacimiento (opcional)</label>
            <input id="fecha_nacimiento" v-model="form.fecha_nacimiento" type="date" />
            <span v-if="errores.fecha_nacimiento" class="error-msg">{{ errores.fecha_nacimiento }}</span>
          </div>
        </div>

        <!-- Cargo y situación de revista -->
        <h2 class="subtitulo-seccion">Cargo y situación de revista</h2>

        <div class="form-fila">
          <div class="form-group">
            <label for="cargos_id">Cargo</label>
            <select id="cargos_id" v-model="form.cargos_id">
              <option :value="null" disabled>Seleccioná un cargo</option>
              <option v-for="c in cargos" :key="c.id" :value="c.id">{{ c.cargo }}</option>
            </select>
            <span v-if="errores.cargos_id" class="error-msg">{{ errores.cargos_id }}</span>
          </div>
          <div class="form-group">
            <label for="sit_revista_id">Situación de revista</label>
            <select id="sit_revista_id" v-model="form.sit_revista_id">
              <option :value="null" disabled>Seleccioná una situación</option>
              <option v-for="s in sitRevistas" :key="s.id" :value="s.id">{{ s.revista }}</option>
            </select>
            <span v-if="errores.sit_revista_id" class="error-msg">{{ errores.sit_revista_id }}</span>
          </div>
        </div>

        <!-- Asignación de curso -->
        <h2 class="subtitulo-seccion">Asignación de curso</h2>

        <div class="form-group" v-if="cursosSinAsignar.length === 0">
          <div class="error-box">
            <i class="ti ti-alert-circle" aria-hidden="true"></i>
            No hay cursos sin asignar disponibles. Creá un curso primero.
          </div>
        </div>

        <div class="form-group" v-else>
          <label for="cursos_id">Curso</label>
          <select id="cursos_id" v-model="form.cursos_id">
            <option :value="null" disabled>Seleccioná un curso</option>
            <option v-for="c in cursosSinAsignar" :key="c.id" :value="c.id">
              {{ c.grado }} {{ c.seccion }} - {{ c.turno }}
            </option>
          </select>
          <span v-if="errores.cursos_id" class="error-msg">{{ errores.cursos_id }}</span>
        </div>

        <div class="form-group">
          <label for="anio_lectivo">Año lectivo</label>
          <input id="anio_lectivo" v-model="form.anio_lectivo" type="text" placeholder="Ej: 2026" />
          <span v-if="errores.anio_lectivo" class="error-msg">{{ errores.anio_lectivo }}</span>
        </div>

        <div class="form-fila">
          <div class="form-group">
            <label for="fecha_inicio">Fecha de inicio</label>
            <input id="fecha_inicio" v-model="form.fecha_inicio" type="date" />
            <span v-if="errores.fecha_inicio" class="error-msg">{{ errores.fecha_inicio }}</span>
          </div>
          <div class="form-group">
            <label for="fecha_fin">Fecha de fin</label>
            <input id="fecha_fin" v-model="form.fecha_fin" type="date" />
            <span v-if="errores.fecha_fin" class="error-msg">{{ errores.fecha_fin }}</span>
          </div>
        </div>

        <div class="form-nav">
          <button type="button" class="btn-nav btn-anterior" @click="cancelar" :disabled="cargando">
            Cancelar
          </button>
          <button type="submit" class="btn-nav btn-submit" :disabled="cargando">
            <i v-if="cargando" class="ti ti-loader-2" aria-hidden="true"></i>
            {{ cargando ? 'Registrando...' : 'Registrar docente' }}
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
