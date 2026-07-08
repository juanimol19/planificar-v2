<script setup lang="ts">
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import {
  getPlanificacion,
  crearEstado,
  estadoActual,
  labelEstado,
  claseEstado,
  estadoFrontABack,
} from '@/services/planificacionService'
import type { PlanificacionAnualAPI, EstadoAnualAPI } from '@/types/planificacionAPI'

const route  = useRoute()
const router = useRouter()

const plan      = ref<PlanificacionAnualAPI | null>(null)
const cargando  = ref(true)
const error     = ref<string | null>(null)

const nuevoComentario    = ref('')
const mostrarConfirmacion = ref<string | null>(null)  // 'Aprobada' | 'Correccion' | 'Rechazada'
const enviandoEstado     = ref(false)
const errorEstado        = ref<string | null>(null)

const estadoActualPlan = computed(() =>
  plan.value ? estadoActual(plan.value.estados_anuales ?? []) : 'sin estado'
)

const labelEstadoActual = computed(() => labelEstado(estadoActualPlan.value))
const claseEstadoActual = computed(() => claseEstado(estadoActualPlan.value))

const historialOrdenado = computed(() =>
  [...(plan.value?.estados_anuales ?? [])].sort(
    (a, b) => new Date(a.created_at).getTime() - new Date(b.created_at).getTime()
  )
)

const textoConfirmacion: Record<string, string> = {
  Aprobada:   '¿Aprobar esta planificación? El docente verá que fue aceptada.',
  Correccion: '¿Pedir correcciones? Asegurate de haber dejado un comentario explicando qué corregir.',
  Rechazada:  '¿Rechazar esta planificación? Esta acción debería usarse solo en casos donde no corresponde una nueva versión.',
}

const formatearFecha = (fecha: string) =>
  new Date(fecha).toLocaleDateString('es-AR', { year: 'numeric', month: 'long', day: 'numeric' })

const nombreDocente = computed(() => {
  const p = plan.value?.persona_cargo_cursado?.persona_cargo?.persona
  return p ? `${p.nombres} ${p.apellidos}` : '—'
})

const nombreCurso = computed(() => {
  const curso = plan.value?.persona_cargo_cursado?.cursado?.curso
  return curso ? `${curso.grado} ${curso.seccion} - ${curso.turno}` : '—'
})

onMounted(async () => {
  const id = Number(route.params.id)
  try {
    plan.value = await getPlanificacion(id)
  } catch {
    error.value = 'No se pudo cargar la planificación.'
  } finally {
    cargando.value = false
  }
})

const pedirConfirmacion = (estadoFront: string) => {
  mostrarConfirmacion.value = estadoFront
  errorEstado.value = null
}

const confirmarCambioEstado = async () => {
  if (!plan.value || !mostrarConfirmacion.value) return
  enviandoEstado.value = true
  errorEstado.value = null
  try {
    const estadoBack = estadoFrontABack(mostrarConfirmacion.value)
    const payload: any = {
      estado: estadoBack,
      fecha: new Date().toISOString().slice(0, 10),
      planificacion_anual_id: plan.value.id,
    }
if (nuevoComentario.value.trim()) {
  payload.observaciones = nuevoComentario.value.trim()
}
    const nuevoEstadoObj = await crearEstado(payload)
    if (!plan.value.estados_anuales) plan.value.estados_anuales = []
    plan.value.estados_anuales.push(nuevoEstadoObj)
    if (nuevoComentario.value.trim()) nuevoComentario.value = ''
    mostrarConfirmacion.value = null
  } catch {
    errorEstado.value = 'Ocurrió un error al cambiar el estado. Intentá de nuevo.'
  } finally {
    enviandoEstado.value = false
  }
}

const volver = () => router.push('/director/planificaciones')
</script>

<template>
  <div class="page-wrapper">
    <button class="btn-volver" @click="volver">
      <i class="ti ti-arrow-left"></i> Volver a Planificaciones
    </button>

    <div v-if="cargando" class="estado-info">
      <i class="ti ti-loader-2 girando"></i> Cargando planificación...
    </div>

    <div v-else-if="error" class="estado-error">
      <i class="ti ti-alert-circle"></i> {{ error }}
    </div>

    <template v-else-if="plan">
      <!-- Header -->
      <div class="plan-header">
        <div>
          <h1 class="plan-titulo">{{ plan.tipo_planificacion }} — {{ nombreCurso }}</h1>
          <p class="plan-meta">
            <i class="ti ti-user"></i> {{ nombreDocente }}
            <span class="meta-sep">·</span>
            <i class="ti ti-calendar"></i> Presentada el {{ formatearFecha(plan.fecha_presentacion) }}
          </p>
        </div>
        <span class="badge badge-grande" :class="claseEstadoActual">
          {{ labelEstadoActual }}
        </span>
      </div>

      <!-- Contenido pedagógico -->
      <div class="contenido-grid">
        <div class="contenido-card">
          <h3><i class="ti ti-target"></i> Aprendizajes esperados</h3>
          <p>{{ plan.aprendizajes_esperados }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-book-2"></i> Saberes</h3>
          <p>{{ plan.saberes }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-clipboard-check"></i> Criterios de evaluación</h3>
          <p>{{ plan.criterios }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-books"></i> Bibliografía</h3>
          <p>{{ plan.bibliografia }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-stethoscope"></i> Diagnóstico</h3>
          <p>{{ plan.diagnostico }}</p>
        </div>
      </div>

      <!-- Acciones de revisión -->
      <div class="acciones-revision">
        <h2 class="seccion-titulo"><i class="ti ti-gavel"></i> Revisión</h2>
        <div class="botones-revision">
          <button class="btn-revision btn-aprobar"    @click="pedirConfirmacion('Aprobada')">
            <i class="ti ti-circle-check"></i> Aprobar
          </button>
          <button class="btn-revision btn-correccion" @click="pedirConfirmacion('Correccion')">
            <i class="ti ti-pencil"></i> Pedir corrección
          </button>
          <button class="btn-revision btn-rechazar"   @click="pedirConfirmacion('Rechazada')">
            <i class="ti ti-circle-x"></i> Rechazar
          </button>
        </div>
      </div>

      <!-- Comentarios / correcciones -->
      <div class="comentarios-section">
        <h2 class="seccion-titulo"><i class="ti ti-message-2"></i> Agregar comentario / corrección</h2>
        <p class="comentario-ayuda">El comentario se enviará junto con el cambio de estado al hacer clic en Aprobar, Pedir corrección o Rechazar.</p>
        <div class="nuevo-comentario">
          <textarea
            v-model="nuevoComentario"
            placeholder="Escribí una observación o corrección para el docente..."
            rows="3"
          ></textarea>
        </div>
      </div>

      <!-- Historial de estados -->
      <div class="historial-section">
        <h2 class="seccion-titulo"><i class="ti ti-history"></i> Historial</h2>
        <div v-if="historialOrdenado.length" class="historial-lista">
          <div v-for="(h, idx) in historialOrdenado" :key="idx" class="historial-item">
            <div class="historial-punto"></div>
            <div class="historial-info">
              <div class="historial-cabecera">
                <span class="badge badge-chica" :class="claseEstado(h.estado)">
                  {{ labelEstado(h.estado) }}
                </span>
                <span class="historial-fecha">{{ formatearFecha(h.fecha) }}</span>
              </div>
<p v-if="h.observaciones" class="historial-comentario">
  "{{ h.observaciones }}"
</p>

            </div>
          </div>
        </div>
        <p v-else class="sin-historial">Todavía no hay cambios de estado registrados.</p>
      </div>
    </template>

    <!-- Modal confirmación -->
    <div v-if="mostrarConfirmacion" class="modal-overlay" @click.self="mostrarConfirmacion = null">
      <div class="modal-confirm">
        <i class="ti ti-help-circle modal-confirm-icon"></i>
        <h3>Confirmar acción</h3>
        <p>{{ textoConfirmacion[mostrarConfirmacion] }}</p>
        <p v-if="errorEstado" class="modal-error">{{ errorEstado }}</p>
        <div class="modal-confirm-acciones">
          <button class="btn-cancelar-modal" :disabled="enviandoEstado" @click="mostrarConfirmacion = null">Cancelar</button>
          <button class="btn-confirmar-modal" :disabled="enviandoEstado" @click="confirmarCambioEstado">
            <i v-if="enviandoEstado" class="ti ti-loader-2 girando"></i>
            {{ enviandoEstado ? 'Enviando...' : 'Confirmar' }}
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper { width: 100%; max-width: 820px; }
.estado-info { display: flex; align-items: center; gap: 8px; color: #5a6a7a; font-size: 14px; padding: 2rem 0; }
.estado-error { display: flex; align-items: center; gap: 8px; color: #c0392b; font-size: 14px; background: rgba(192,57,43,0.08); border: 1px solid rgba(192,57,43,0.2); border-radius: 10px; padding: 1rem 1.25rem; }
@keyframes girar { to { transform: rotate(360deg); } }
.girando { display: inline-block; animation: girar 0.9s linear infinite; }
.plan-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; margin-bottom: 1.25rem; flex-wrap: wrap; }
.plan-titulo { font-size: 22px; font-weight: 700; color: #1a2a3a; margin-bottom: 6px; }
.dark-mode .plan-titulo { color: #ffffff; }
.plan-meta { display: flex; align-items: center; gap: 6px; font-size: 13.5px; color: #5a6a7a; flex-wrap: wrap; }
.dark-mode .plan-meta { color: #aabbcc; }
.meta-sep { margin: 0 2px; color: #c0c8d0; }
.contenido-grid { display: flex; flex-direction: column; gap: 12px; margin-bottom: 2rem; }
.contenido-card { background: #ffffff; border: 1.5px solid rgba(0,0,0,0.08); border-radius: 14px; padding: 1.25rem 1.5rem; }
.dark-mode .contenido-card { background: #1a1a1a; border-color: #1e3a8a; }
.contenido-card h3 { display: flex; align-items: center; gap: 8px; font-size: 14px; font-weight: 700; color: #2563eb; margin-bottom: 8px; }
.dark-mode .contenido-card h3 { color: #60a5fa; }
.contenido-card p { font-size: 14.5px; line-height: 1.55; color: #3a4a5a; white-space: pre-wrap; }
.dark-mode .contenido-card p { color: #cdd9e5; }
.seccion-titulo { display: flex; align-items: center; gap: 8px; font-size: 16px; font-weight: 700; color: #1a2a3a; margin-bottom: 1rem; }
.dark-mode .seccion-titulo { color: #ffffff; }
.acciones-revision, .comentarios-section, .historial-section { margin-bottom: 2rem; }
.botones-revision { display: flex; gap: 10px; flex-wrap: wrap; }
.btn-revision { display: inline-flex; align-items: center; gap: 7px; border-radius: 999px; padding: 11px 22px; font-size: 14px; font-weight: 700; cursor: pointer; border: 2px solid transparent; transition: background 0.2s, transform 0.15s, box-shadow 0.2s; }
.btn-revision:hover { transform: translateY(-1px); }
.btn-aprobar   { background: #1d9e75; color: #ffffff; border-color: #0f6e56; }
.btn-aprobar:hover { background: #168a64; box-shadow: 0 4px 14px rgba(29,158,117,0.25); }
.btn-correccion { background: rgba(186,117,23,0.12); color: #854f0b; border-color: rgba(186,117,23,0.4); }
.btn-correccion:hover { background: rgba(186,117,23,0.22); }
.btn-rechazar  { background: #ffffff; color: #c0392b; border-color: rgba(192,57,43,0.4); }
.dark-mode .btn-rechazar { background: #1a1a1a; }
.btn-rechazar:hover { background: rgba(192,57,43,0.08); }
.comentario-ayuda { font-size: 13px; color: #8a9aaa; margin-bottom: 10px; font-style: italic; }
.nuevo-comentario textarea { width: 100%; padding: 0.7rem 0.85rem; border: 1px solid #ccc; border-radius: 10px; font-size: 14px; font-family: arial, sans-serif; resize: vertical; box-sizing: border-box; }
.nuevo-comentario textarea:focus { outline: none; border-color: #2563eb; }
.dark-mode .nuevo-comentario textarea { background: #111827; border-color: #2c4f7c; color: #e2e8f0; }
.historial-lista { display: flex; flex-direction: column; }
.historial-item { display: flex; gap: 14px; padding-bottom: 1.1rem; position: relative; }
.historial-item:not(:last-child)::before { content: ''; position: absolute; left: 5px; top: 14px; bottom: 0; width: 2px; background: rgba(37,99,235,0.2); }
.historial-punto { width: 12px; height: 12px; border-radius: 50%; background: #2563eb; border: 2px solid #ffffff; box-shadow: 0 0 0 2px #2563eb; flex-shrink: 0; margin-top: 4px; }
.dark-mode .historial-punto { border-color: #1a1a1a; }
.historial-info { flex: 1; }
.historial-cabecera { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
.historial-fecha { font-size: 12.5px; color: #8a9aaa; font-weight: 600; }
.historial-comentario { font-size: 13.5px; color: #3a4a5a; font-style: italic; margin-top: 4px; }
.dark-mode .historial-comentario { color: #cdd9e5; }
.sin-historial { font-size: 13.5px; color: #8a9aaa; font-style: italic; }
.badge { font-size: 12px; font-weight: 700; padding: 5px 14px; border-radius: 999px; display: inline-block; }
.badge-grande { font-size: 13.5px; padding: 8px 18px; }
.badge-chica  { font-size: 11px; padding: 4px 11px; }
.badge-pendiente  { background: rgba(186,117,23,0.12); color: #854f0b; border: 1px solid rgba(186,117,23,0.25); }
.badge-aprobada   { background: rgba(29,158,117,0.12); color: #0f6e56; border: 1px solid rgba(29,158,117,0.25); }
.badge-correccion { background: rgba(237,28,36,0.12);  color: #a81018; border: 1px solid rgba(237,28,36,0.25); }
.badge-rechazada  { background: rgba(80,80,80,0.12);   color: #404040; border: 1px solid rgba(80,80,80,0.25); }
.dark-mode .badge-pendiente  { background: rgba(252,238,33,0.3);  color: #f4f421; border-color: #f4f421; }
.dark-mode .badge-aprobada   { background: rgba(57,181,74,0.3);   color: #00ff00; border-color: #00ff00; }
.dark-mode .badge-correccion { background: rgba(237,28,36,0.3);   color: #ed1c24; border-color: #ed1c24; }
.dark-mode .badge-rechazada  { background: rgba(150,150,150,0.2); color: #cccccc; border-color: #888888; }
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.45); display: flex; align-items: center; justify-content: center; z-index: 1000; padding: 1rem; }
.modal-confirm { background: #ffffff; border-radius: 20px; width: 100%; max-width: 400px; padding: 2rem; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.2); }
.dark-mode .modal-confirm { background: #1a1a1a; }
.modal-confirm-icon { font-size: 38px; color: #2563eb; margin-bottom: 12px; }
.modal-confirm h3 { font-size: 17px; font-weight: 700; color: #1a2a3a; margin-bottom: 8px; }
.dark-mode .modal-confirm h3 { color: #ffffff; }
.modal-confirm p { font-size: 13.5px; color: #5a6a7a; margin-bottom: 1.5rem; line-height: 1.5; }
.dark-mode .modal-confirm p { color: #aabbcc; }
.modal-error { color: #c0392b !important; }
.modal-confirm-acciones { display: flex; gap: 10px; justify-content: center; }
.btn-cancelar-modal { background: #f5f7fa; color: #5a6a7a; border: 1.5px solid rgba(0,0,0,0.1); border-radius: 999px; padding: 9px 18px; font-size: 13.5px; font-weight: 700; cursor: pointer; }
.dark-mode .btn-cancelar-modal { background: #111827; color: #aabbcc; }
.btn-confirmar-modal { display: inline-flex; align-items: center; gap: 6px; background: #2563eb; color: #ffffff; border: 2px solid #1e40af; border-radius: 999px; padding: 9px 18px; font-size: 13.5px; font-weight: 700; cursor: pointer; }
.btn-confirmar-modal:hover { background: #1d4ed8; }
.btn-confirmar-modal:disabled, .btn-cancelar-modal:disabled { opacity: 0.5; cursor: not-allowed; }
</style>
