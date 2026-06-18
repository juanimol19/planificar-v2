<script setup lang="ts">
import { computed, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { planificacionesMock } from '@/data/planificacionesMock'
import { directorActual } from '@/data/directorMock'
import type { EstadoPlanificacion } from '@/types/Planificacion'

const route = useRoute()
const router = useRouter()

const planId = computed(() => Number(route.params.id))
const plan = computed(() => planificacionesMock.find(p => p.id === planId.value))

const nuevoComentario = ref('')
const mostrarConfirmacion = ref<EstadoPlanificacion | null>(null)

const formatearFecha = (fecha: string) =>
  new Date(fecha).toLocaleDateString('es-AR', { year: 'numeric', month: 'long', day: 'numeric' })

let nextComentarioId = 100

const agregarComentario = () => {
  if (!plan.value || !nuevoComentario.value.trim()) return

  plan.value.comentarios.push({
    id: nextComentarioId++,
    autor: `Dir. ${directorActual.nombre} ${directorActual.apellido}`,
    texto: nuevoComentario.value.trim(),
    fecha: new Date().toISOString().slice(0, 10),
  })

  nuevoComentario.value = ''
}

const notasPorEstado: Record<EstadoPlanificacion, string> = {
  Pendiente: 'Vuelta a estado pendiente.',
  Aprobada: 'Aprobada por el director.',
  Correccion: 'Se solicitaron correcciones al docente.',
  Rechazada: 'Planificación rechazada.',
}

const pedirConfirmacion = (estado: EstadoPlanificacion) => {
  mostrarConfirmacion.value = estado
}

const confirmarCambioEstado = () => {
  if (!plan.value || !mostrarConfirmacion.value) return

  const nuevoEstado = mostrarConfirmacion.value
  plan.value.estado = nuevoEstado
  plan.value.historial.push({
    version: plan.value.historial.length,
    fecha: new Date().toISOString().slice(0, 10),
    estado: nuevoEstado,
    nota: notasPorEstado[nuevoEstado],
  })

  mostrarConfirmacion.value = null
}

const volver = () => router.push('/director/planificaciones')

const textoConfirmacion: Record<EstadoPlanificacion, string> = {
  Pendiente: '¿Volver a marcar esta planificación como pendiente?',
  Aprobada: '¿Aprobar esta planificación? El docente verá que fue aceptada.',
  Correccion: '¿Pedir correcciones? Asegurate de haber dejado un comentario explicando qué corregir.',
  Rechazada: '¿Rechazar esta planificación? Esta acción debería usarse solo en casos donde no corresponde una nueva versión.',
}
</script>

<template>
  <div class="page-wrapper">
    <button class="btn-volver" @click="volver">
      <i class="ti ti-arrow-left" aria-hidden="true"></i> Volver a Planificaciones
    </button>

    <div v-if="!plan" class="no-encontrado">
      <i class="ti ti-mood-confuzed" aria-hidden="true"></i>
      <p>No se encontró la planificación solicitada.</p>
    </div>

    <template v-else>
      <div class="plan-header">
        <div>
          <h1 class="plan-titulo">{{ plan.titulo }}</h1>
          <p class="plan-meta">
            <i class="ti ti-user" aria-hidden="true"></i> {{ plan.docente }}
            <span class="meta-sep">·</span>
            <i class="ti ti-school" aria-hidden="true"></i> {{ plan.curso }}
            <span class="meta-sep">·</span>
            <i class="ti ti-calendar" aria-hidden="true"></i> Enviada el {{ formatearFecha(plan.fechaEnvio) }}
          </p>
        </div>
        <span class="badge badge-grande" :class="{
          'badge-pendiente':  plan.estado === 'Pendiente',
          'badge-aprobada':   plan.estado === 'Aprobada',
          'badge-correccion': plan.estado === 'Correccion',
          'badge-rechazada':  plan.estado === 'Rechazada',
        }">
          {{ plan.estado === 'Correccion' ? 'Corrección' : plan.estado }}
        </span>
      </div>

      <div class="archivo-card">
        <i class="ti ti-file-type-pdf" aria-hidden="true"></i>
        <span class="archivo-nombre">{{ plan.archivoNombre }}</span>
        <button class="btn-archivo">
          <i class="ti ti-download" aria-hidden="true"></i> Descargar
        </button>
      </div>

      <div class="contenido-grid">
        <div class="contenido-card">
          <h3><i class="ti ti-target" aria-hidden="true"></i> Objetivos</h3>
          <p>{{ plan.objetivos }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-book-2" aria-hidden="true"></i> Contenidos</h3>
          <p>{{ plan.contenidos }}</p>
        </div>
        <div class="contenido-card">
          <h3><i class="ti ti-puzzle" aria-hidden="true"></i> Actividades</h3>
          <p>{{ plan.actividades }}</p>
        </div>
      </div>

      <!-- Acciones de revisión -->
      <div class="acciones-revision">
        <h2 class="seccion-titulo"><i class="ti ti-gavel" aria-hidden="true"></i> Revisión</h2>
        <div class="botones-revision">
          <button class="btn-revision btn-aprobar" @click="pedirConfirmacion('Aprobada')">
            <i class="ti ti-circle-check" aria-hidden="true"></i> Aprobar
          </button>
          <button class="btn-revision btn-correccion" @click="pedirConfirmacion('Correccion')">
            <i class="ti ti-pencil" aria-hidden="true"></i> Pedir corrección
          </button>
          <button class="btn-revision btn-rechazar" @click="pedirConfirmacion('Rechazada')">
            <i class="ti ti-circle-x" aria-hidden="true"></i> Rechazar
          </button>
        </div>
      </div>

      <!-- Comentarios -->
      <div class="comentarios-section">
        <h2 class="seccion-titulo"><i class="ti ti-message-2" aria-hidden="true"></i> Comentarios</h2>

        <div v-if="plan.comentarios.length" class="comentarios-lista">
          <div v-for="c in plan.comentarios" :key="c.id" class="comentario-item">
            <div class="comentario-cabecera">
              <span class="comentario-autor">{{ c.autor }}</span>
              <span class="comentario-fecha">{{ formatearFecha(c.fecha) }}</span>
            </div>
            <p class="comentario-texto">{{ c.texto }}</p>
          </div>
        </div>
        <p v-else class="sin-comentarios">Todavía no hay comentarios en esta planificación.</p>

        <div class="nuevo-comentario">
          <textarea
            v-model="nuevoComentario"
            placeholder="Escribí una observación o corrección para el docente..."
            rows="3"
          ></textarea>
          <button class="btn-comentar" :disabled="!nuevoComentario.trim()" @click="agregarComentario">
            <i class="ti ti-send" aria-hidden="true"></i> Comentar
          </button>
        </div>
      </div>

      <!-- Historial -->
      <div class="historial-section">
        <h2 class="seccion-titulo"><i class="ti ti-history" aria-hidden="true"></i> Historial</h2>
        <div class="historial-lista">
          <div v-for="(h, idx) in plan.historial" :key="idx" class="historial-item">
            <div class="historial-punto"></div>
            <div class="historial-info">
              <div class="historial-cabecera">
                <span class="badge badge-chica" :class="{
                  'badge-pendiente':  h.estado === 'Pendiente',
                  'badge-aprobada':   h.estado === 'Aprobada',
                  'badge-correccion': h.estado === 'Correccion',
                  'badge-rechazada':  h.estado === 'Rechazada',
                }">
                  {{ h.estado === 'Correccion' ? 'Corrección' : h.estado }}
                </span>
                <span class="historial-fecha">{{ formatearFecha(h.fecha) }}</span>
              </div>
              <p class="historial-nota">{{ h.nota }}</p>
            </div>
          </div>
        </div>
      </div>
    </template>

    <!-- Modal de confirmación -->
    <div v-if="mostrarConfirmacion" class="modal-overlay" @click.self="mostrarConfirmacion = null">
      <div class="modal-confirm">
        <i class="ti ti-help-circle modal-confirm-icon" aria-hidden="true"></i>
        <h3>Confirmar acción</h3>
        <p>{{ textoConfirmacion[mostrarConfirmacion] }}</p>
        <div class="modal-confirm-acciones">
          <button class="btn-cancelar-modal" @click="mostrarConfirmacion = null">Cancelar</button>
          <button class="btn-confirmar-modal" @click="confirmarCambioEstado">Confirmar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page-wrapper {
  width: 100%;
  max-width: 820px;
}

.no-encontrado {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 10px;
  padding: 3rem 0;
  color: #8a9aaa;
  font-size: 15px;
}

.no-encontrado i {
  font-size: 40px;
}

/* ─── Header ─────────────────────────────────────────────────────────────────── */

.plan-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: 1.25rem;
  flex-wrap: wrap;
}

.plan-titulo {
  font-size: 22px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 6px;
}

.dark-mode .plan-titulo {
  color: #ffffff;
}

.plan-meta {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 13.5px;
  color: #5a6a7a;
  flex-wrap: wrap;
}

.dark-mode .plan-meta {
  color: #aabbcc;
}

.meta-sep {
  margin: 0 2px;
  color: #c0c8d0;
}

/* ─── Archivo ────────────────────────────────────────────────────────────────── */

.archivo-card {
  display: flex;
  align-items: center;
  gap: 12px;
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 14px;
  padding: 1rem 1.25rem;
  margin-bottom: 1.5rem;
}

.dark-mode .archivo-card {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.archivo-card i {
  font-size: 26px;
  color: #c0392b;
  flex-shrink: 0;
}

.archivo-nombre {
  flex: 1;
  font-size: 14px;
  font-weight: 600;
  color: #1a2a3a;
  word-break: break-all;
}

.dark-mode .archivo-nombre {
  color: #e2e8f0;
}

.btn-archivo {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: rgba(37, 99, 235, 0.1);
  color: #1e40af;
  border: 1.5px solid rgba(37, 99, 235, 0.3);
  border-radius: 999px;
  padding: 8px 16px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  flex-shrink: 0;
  transition: background 0.2s;
}

.dark-mode .btn-archivo {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.btn-archivo:hover {
  background: rgba(37, 99, 235, 0.2);
}

/* ─── Contenido ──────────────────────────────────────────────────────────────── */

.contenido-grid {
  display: flex;
  flex-direction: column;
  gap: 12px;
  margin-bottom: 2rem;
}

.contenido-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 14px;
  padding: 1.25rem 1.5rem;
}

.dark-mode .contenido-card {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.contenido-card h3 {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 14px;
  font-weight: 700;
  color: #2563eb;
  margin-bottom: 8px;
}

.dark-mode .contenido-card h3 {
  color: #60a5fa;
}

.contenido-card p {
  font-size: 14.5px;
  line-height: 1.55;
  color: #3a4a5a;
}

.dark-mode .contenido-card p {
  color: #cdd9e5;
}

/* ─── Secciones generales ────────────────────────────────────────────────────── */

.seccion-titulo {
  display: flex;
  align-items: center;
  gap: 8px;
  font-size: 16px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 1rem;
}

.dark-mode .seccion-titulo {
  color: #ffffff;
}

.acciones-revision, .comentarios-section, .historial-section {
  margin-bottom: 2rem;
}

/* ─── Botones de revisión ────────────────────────────────────────────────────── */

.botones-revision {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-revision {
  display: inline-flex;
  align-items: center;
  gap: 7px;
  border-radius: 999px;
  padding: 11px 22px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  border: 2px solid transparent;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}

.btn-revision:hover {
  transform: translateY(-1px);
}

.btn-aprobar {
  background: #1d9e75;
  color: #ffffff;
  border-color: #0f6e56;
}

.btn-aprobar:hover {
  background: #168a64;
  box-shadow: 0 4px 14px rgba(29, 158, 117, 0.25);
}

.btn-correccion {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border-color: rgba(186, 117, 23, 0.4);
}

.btn-correccion:hover {
  background: rgba(186, 117, 23, 0.22);
}

.btn-rechazar {
  background: #ffffff;
  color: #c0392b;
  border-color: rgba(192, 57, 43, 0.4);
}

.dark-mode .btn-rechazar {
  background: #1a1a1a;
}

.btn-rechazar:hover {
  background: rgba(192, 57, 43, 0.08);
}

/* ─── Comentarios ────────────────────────────────────────────────────────────── */

.comentarios-lista {
  display: flex;
  flex-direction: column;
  gap: 10px;
  margin-bottom: 1rem;
}

.comentario-item {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 12px;
  padding: 0.9rem 1.1rem;
}

.dark-mode .comentario-item {
  background: #1a1a1a;
  border-color: #1e3a8a;
}

.comentario-cabecera {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 5px;
}

.comentario-autor {
  font-size: 13.5px;
  font-weight: 700;
  color: #2563eb;
}

.dark-mode .comentario-autor {
  color: #60a5fa;
}

.comentario-fecha {
  font-size: 12px;
  color: #8a9aaa;
}

.comentario-texto {
  font-size: 14px;
  color: #3a4a5a;
  line-height: 1.5;
}

.dark-mode .comentario-texto {
  color: #cdd9e5;
}

.sin-comentarios {
  font-size: 13.5px;
  color: #8a9aaa;
  font-style: italic;
  margin-bottom: 1rem;
}

.nuevo-comentario {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.nuevo-comentario textarea {
  padding: 0.7rem 0.85rem;
  border: 1px solid #ccc;
  border-radius: 10px;
  font-size: 14px;
  font-family: arial, sans-serif;
  resize: vertical;
}

.nuevo-comentario textarea:focus {
  outline: none;
  border-color: #2563eb;
}

.dark-mode .nuevo-comentario textarea {
  background: #111827;
  border-color: #2c4f7c;
  color: #e2e8f0;
}

.btn-comentar {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  align-self: flex-end;
  background: #2563eb;
  color: #ffffff;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 9px 18px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, opacity 0.2s;
}

.btn-comentar:hover {
  background: #1d4ed8;
}

.btn-comentar:disabled {
  opacity: 0.4;
  cursor: not-allowed;
}

/* ─── Historial ──────────────────────────────────────────────────────────────── */

.historial-lista {
  display: flex;
  flex-direction: column;
  gap: 0;
}

.historial-item {
  display: flex;
  gap: 14px;
  padding-bottom: 1.1rem;
  position: relative;
}

.historial-item:not(:last-child)::before {
  content: '';
  position: absolute;
  left: 5px;
  top: 14px;
  bottom: 0;
  width: 2px;
  background: rgba(37, 99, 235, 0.2);
}

.historial-punto {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #2563eb;
  border: 2px solid #ffffff;
  box-shadow: 0 0 0 2px #2563eb;
  flex-shrink: 0;
  margin-top: 4px;
}

.dark-mode .historial-punto {
  border-color: #1a1a1a;
}

.historial-info {
  flex: 1;
}

.historial-cabecera {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 4px;
}

.historial-fecha {
  font-size: 12.5px;
  color: #8a9aaa;
  font-weight: 600;
}

.historial-nota {
  font-size: 13.5px;
  color: #3a4a5a;
}

.dark-mode .historial-nota {
  color: #cdd9e5;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
  display: inline-block;
}

.badge-grande {
  font-size: 13.5px;
  padding: 8px 18px;
}

.badge-chica {
  font-size: 11px;
  padding: 4px 11px;
}

.badge-pendiente {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border: 1px solid rgba(186, 117, 23, 0.25);
}

.dark-mode .badge-pendiente {
  background: rgba(252, 238, 33, 0.3);
  color: #f4f421;
  border: 1px solid #f4f421;
}

.badge-aprobada {
  background: rgba(29, 158, 117, 0.12);
  color: #0f6e56;
  border: 1px solid rgba(29, 158, 117, 0.25);
}

.dark-mode .badge-aprobada {
  background: rgba(57, 181, 74, 0.3);
  color: #00ff00;
  border: 1px solid #00ff00;
}

.badge-correccion {
  background: rgba(237, 28, 36, 0.12);
  color: #a81018;
  border: 1px solid rgba(237, 28, 36, 0.25);
}

.dark-mode .badge-correccion {
  background: rgba(237, 28, 36, 0.3);
  color: #ed1c24;
  border: 1px solid #ed1c24;
}

.badge-rechazada {
  background: rgba(80, 80, 80, 0.12);
  color: #404040;
  border: 1px solid rgba(80, 80, 80, 0.25);
}

.dark-mode .badge-rechazada {
  background: rgba(150, 150, 150, 0.2);
  color: #cccccc;
  border: 1px solid #888888;
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
  max-width: 400px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.dark-mode .modal-confirm {
  background: #1a1a1a;
}

.modal-confirm-icon {
  font-size: 38px;
  color: #2563eb;
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
  line-height: 1.5;
}

.dark-mode .modal-confirm p {
  color: #aabbcc;
}

.modal-confirm-acciones {
  display: flex;
  gap: 10px;
  justify-content: center;
}

.btn-cancelar-modal {
  background: #f5f7fa;
  color: #5a6a7a;
  border: 1.5px solid rgba(0,0,0,0.1);
  border-radius: 999px;
  padding: 9px 18px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
}

.dark-mode .btn-cancelar-modal {
  background: #111827;
  color: #aabbcc;
}

.btn-confirmar-modal {
  background: #2563eb;
  color: #ffffff;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 9px 18px;
  font-size: 13.5px;
  font-weight: 700;
  cursor: pointer;
}

.btn-confirmar-modal:hover {
  background: #1d4ed8;
}
</style>
