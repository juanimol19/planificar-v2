<script setup lang="ts">
import { ref, reactive } from 'vue'
import PlanificacionSelector from '@/components/docente/PlanificacionesSelector.vue'
import FormPlanificacionesDiaria from '@/components/docente/FormPlanificacionesDiaria.vue'
import FormPlanificacionesAnual from '@/components/docente/FormPlanificacionesAnual.vue'
import PlanificacionDiariaPreview from '@/components/docente/PlanificacionDiariaPreview.vue'
import PlanificacionAnualPreview from '@/components/docente/PlanificacionAnualPreview.vue'
import type { DatosAnual, DatosDiaria } from '@/types/planificacionAPI'
import { materiaVacia } from '@/utils/planificacionAnual'
import { crearPlanificacion } from '@/services/planificacionService'

type TipoPlanificacion = 'diaria' | 'anual'

const emit = defineEmits<{ (e: 'hay-datos', valor: boolean): void }>()

const tipoSeleccionado  = ref<TipoPlanificacion | null>(null)
const datosFormulario   = ref<DatosAnual | DatosDiaria | null>(null)
const mostrarModalVolver = ref(false)
const pasoAnual         = ref<1 | 2 | 3>(1)
const planificacionId   = ref<number | null>(null)
const enviandoPlan      = ref(false)
const errorEnvio        = ref<string | null>(null)

const datosAnual = reactive<DatosAnual>({
  fecha_presentacion: '',
  diagnostico: '',
  bibliografia: '',
  grado: '',
  ciclo: '',
  anio: new Date().getFullYear().toString(),
  materias: [materiaVacia()],
  saberes_transversales: '',
})

const datosDiaria = reactive<DatosDiaria>({
  fecha_estimada: '',
  fecha_desarrollada: '',
  fecha_presentacion: '',
  contenidos_especificos: '',
  actividades: '',
  tareas: '',
})

function seleccionar(tipo: TipoPlanificacion) {
  tipoSeleccionado.value = tipo
  emit('hay-datos', true)
}

function resetearAnual() {
  Object.assign(datosAnual, {
    fecha_presentacion: '',
    diagnostico: '',
    bibliografia: '',
    grado: '',
    ciclo: '',
    anio: new Date().getFullYear().toString(),
    materias: [materiaVacia()],
    saberes_transversales: '',
  })
  pasoAnual.value = 1
}

function resetearDiaria() {
  Object.assign(datosDiaria, {
    fecha_estimada: '',
    fecha_desarrollada: '',
    fecha_presentacion: '',
    contenidos_especificos: '',
    actividades: '',
    tareas: '',
  })
}

function volver() {
  tipoSeleccionado.value = null
  datosFormulario.value  = null
  planificacionId.value  = null
  errorEnvio.value       = null
  resetearAnual()
  resetearDiaria()
  emit('hay-datos', false)
}

function volverAlFormulario() {
  datosFormulario.value = null
}

function handleVolverClick() {
  if (datosFormulario.value) {
    volverAlFormulario()
  } else {
    mostrarModalVolver.value = true
  }
}

function confirmarVolver() {
  mostrarModalVolver.value = false
  volver()
}

function cancelarVolver() {
  mostrarModalVolver.value = false
}

/**
 * Cuando el docente termina el formulario anual:
 * 1. Se hace POST /api/planificacion-anual al back con los datos
 * 2. Se guarda el id real que devuelve
 * 3. Se muestra el preview con ese id
 */
async function handleSubmit(datos: DatosAnual | DatosDiaria) {
  errorEnvio.value = null

  if (tipoSeleccionado.value === 'anual') {
    const d = datos as DatosAnual

    // Construimos el payload que espera el back
    // Nota: areas_id y persona_cargo_cursado_id deberán venir del perfil del
    // docente logueado cuando se conecte el auth real. Por ahora usamos 1
    // como placeholder — reemplazá con los valores reales del store de auth.
    enviandoPlan.value = true
    try {
      const planCreada = await crearPlanificacion({
        fecha_presentacion:     d.fecha_presentacion,
        aprendizajes_esperados: d.materias.map(m =>
          m.periodos.map(p => p.aprendizajes_esperados).join(' | ')
        ).join(' // '),
        saberes: d.materias.map(m =>
          m.periodos.map(p => p.saberes).join(' | ')
        ).join(' // '),
        criterios: d.materias.map(m => m.criterios_evaluacion).join(' // '),
        bibliografia:     d.bibliografia,
        diagnostico:      d.diagnostico,
        areas_id:         1,   // TODO: traer del perfil del docente logueado
        persona_cargo_cursado_id: 1,  // TODO: traer del perfil del docente logueado
        tipo_planificacion: 'Anual',
      })
      planificacionId.value = planCreada.id
      datosFormulario.value = datos
    } catch (e) {
      errorEnvio.value = 'Ocurrió un error al guardar la planificación. Verificá tu conexión e intentá de nuevo.'
      console.error(e)
    } finally {
      enviandoPlan.value = false
    }
  } else {
    // Para diaria no hay endpoint todavía — mostramos preview directo
    datosFormulario.value = datos
    planificacionId.value = null
  }
}
</script>

<template>
  <div class="planificaciones-wrap">

    <div v-if="tipoSeleccionado === null">
      <PlanificacionSelector @seleccionar="seleccionar" />
    </div>

    <div v-else>
      <button class="btn-volver" @click="handleVolverClick">
        <i class="ti ti-arrow-left"></i>
        Volver a Inicio
      </button>

      <!-- Error al guardar -->
      <div v-if="errorEnvio" class="error-envio">
        <i class="ti ti-alert-circle"></i> {{ errorEnvio }}
      </div>

      <!-- Loader mientras se guarda -->
      <div v-if="enviandoPlan" class="guardando-info">
        <i class="ti ti-loader-2 girando"></i> Guardando planificación...
      </div>

      <template v-if="!enviandoPlan">
        <FormPlanificacionesDiaria
          v-if="tipoSeleccionado === 'diaria' && !datosFormulario"
          :form="datosDiaria"
          @submit="handleSubmit"
        />

        <FormPlanificacionesAnual
          v-if="tipoSeleccionado === 'anual' && !datosFormulario"
          :form="datosAnual"
          :paso="pasoAnual"
          @update:paso="pasoAnual = $event"
          @submit="handleSubmit"
        />

        <PlanificacionDiariaPreview
          v-if="tipoSeleccionado === 'diaria' && datosFormulario"
          :datos="(datosFormulario as DatosDiaria)"
          :planificacion-id="planificacionId"
        />

        <PlanificacionAnualPreview
          v-if="tipoSeleccionado === 'anual' && datosFormulario"
          :datos="(datosFormulario as DatosAnual)"
          :planificacion-id="planificacionId"
        />
      </template>

      <!-- Modal confirmación volver -->
      <div v-if="mostrarModalVolver" class="modal-overlay">
        <div class="modal-volver">
          <p class="modal-volver-mensaje">
            ¿Volver a inicio? <strong>Se perderá toda la información ingresada.</strong>
          </p>
          <div class="modal-volver-acciones">
            <button class="btn-modal-volver btn-modal-cancelar" @click="cancelarVolver">Cancelar</button>
            <button class="btn-modal-volver btn-modal-confirmar" @click="confirmarVolver">
              <i class="ti ti-arrow-left"></i> Volver a inicio
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.planificaciones-wrap .btn-volver {
  display: inline-flex; align-items: center; gap: 0.4rem;
  background: none; border: 1.5px solid #29ABE2; color: #29ABE2;
  border-radius: 8px; padding: 0.45rem 1rem; font-size: 0.9rem;
  font-family: Arial, sans-serif; font-weight: bold; cursor: pointer;
  margin-bottom: 1.5rem; transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease;
}
.planificaciones-wrap .btn-volver:active { transform: scale(0.97); }
.planificaciones-wrap .btn-volver:hover { background-color: #29ABE2; color: #ffffff; }

.planificaciones-wrap .error-envio {
  display: flex; align-items: center; gap: 8px;
  color: #c0392b; background: rgba(192,57,43,0.08);
  border: 1px solid rgba(192,57,43,0.2); border-radius: 10px;
  padding: 0.75rem 1rem; font-size: 14px; margin-bottom: 1rem;
}

.planificaciones-wrap .guardando-info {
  display: flex; align-items: center; gap: 8px;
  color: #5a6a7a; font-size: 14px; padding: 1rem 0;
}

@keyframes girar { to { transform: rotate(360deg); } }
.girando { display: inline-block; animation: girar 0.9s linear infinite; }

.planificaciones-wrap .modal-overlay {
  position: fixed; inset: 0; background-color: rgba(0,0,0,0.45);
  display: flex; align-items: center; justify-content: center; z-index: 100;
}
.planificaciones-wrap .modal-volver {
  background: #ffffff; border-radius: 10px; padding: 2rem;
  max-width: 420px; width: 90%; box-shadow: 0 8px 32px rgba(0,0,0,0.18);
}
.planificaciones-wrap .modal-volver-mensaje { font-size: 1rem; color: #1a2a3a; margin-bottom: 1.5rem; line-height: 1.5; font-family: Arial, sans-serif; }
.planificaciones-wrap .modal-volver-acciones { display: flex; justify-content: flex-end; gap: 0.75rem; }
.planificaciones-wrap .btn-modal-volver { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.55rem 1.25rem; border-radius: 7px; border: none; font-size: 0.9rem; font-family: Arial, sans-serif; font-weight: bold; cursor: pointer; transition: background-color 0.2s ease; }
.planificaciones-wrap .btn-modal-cancelar { background-color: #e5e7eb; color: #1a2a3a; }
.planificaciones-wrap .btn-modal-cancelar:hover { background-color: #d1d5db; }
.planificaciones-wrap .btn-modal-confirmar { background-color: #c0392b; color: #ffffff; }
.planificaciones-wrap .btn-modal-confirmar:hover { background-color: #a93226; }

.dark-mode .planificaciones-wrap .btn-volver { border-color: #33CCFF; color: #33CCFF; }
.dark-mode .planificaciones-wrap .btn-volver:hover { background-color: #33CCFF; color: #1a1a1a; }
.dark-mode .planificaciones-wrap .modal-volver { background-color: #1a1a1a; }
.dark-mode .planificaciones-wrap .modal-volver-mensaje { color: #ffffff; }
.dark-mode .planificaciones-wrap .btn-modal-cancelar { background-color: #2a2a2a; color: #aabbcc; }
.dark-mode .planificaciones-wrap .btn-modal-cancelar:hover { background-color: #333333; }
</style>
