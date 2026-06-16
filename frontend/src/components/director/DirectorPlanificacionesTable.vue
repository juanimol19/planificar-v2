<script setup lang="ts">
import { ref } from 'vue'
import type { Planificacion } from '@/types/Planificacion'

const planificacionSeleccionada = ref<Planificacion | null>(null)
const showModal = ref(false)

const planificaciones: Planificacion[] = [
  { id: 1, docente: 'Juan Pérez',    curso: '5° A', estado: 'Pendiente'  },
  { id: 2, docente: 'María Gómez',   curso: '4° B', estado: 'Aprobada'   },
  { id: 3, docente: 'Carlos López',  curso: '6° A', estado: 'Correccion' },
  { id: 4, docente: 'Ana Martínez',  curso: '3° A', estado: 'Pendiente'  },
  { id: 5, docente: 'Luis Fernández',curso: '2° B', estado: 'Aprobada'   },
]

const verPlanificacion = (plan: Planificacion) => {
  planificacionSeleccionada.value = plan
  showModal.value = true
}

const cerrarModal = () => {
  showModal.value = false
  planificacionSeleccionada.value = null
}

const aprobar = () => {
  if (planificacionSeleccionada.value) {
    planificacionSeleccionada.value.estado = 'Aprobada'
  }
  cerrarModal()
}

const pedir = () => {
  if (planificacionSeleccionada.value) {
    planificacionSeleccionada.value.estado = 'Correccion'
  }
  cerrarModal()
}
</script>

<template>
  <div class="tabla-wrapper">
    <table class="tabla">
      <thead>
        <tr>
          <th>ID</th>
          <th>Docente</th>
          <th>Curso</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="plan in planificaciones" :key="plan.id">
          <td>{{ plan.id }}</td>
          <td>
            <div class="tabla-nombre">
              <div class="tabla-avatar">{{ plan.docente.split(' ').map(n => n[0]).join('') }}</div>
              {{ plan.docente }}
            </div>
          </td>
          <td>{{ plan.curso }}</td>
          <td>
            <span class="badge" :class="{
              'badge-pendiente':  plan.estado === 'Pendiente',
              'badge-aprobada':   plan.estado === 'Aprobada',
              'badge-correccion': plan.estado === 'Correccion',
            }">
              {{ plan.estado === 'Correccion' ? 'Corrección' : plan.estado }}
            </span>
          </td>
          <td>
            <button class="btn-tabla" @click="verPlanificacion(plan)">
              <i class="ti ti-eye" aria-hidden="true"></i> Ver
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal -->
  <div v-if="showModal" class="modal-overlay" @click.self="cerrarModal">
    <div class="modal">
      <div class="modal-header">
        <h2>Planificación #{{ planificacionSeleccionada?.id }}</h2>
        <button class="modal-close" @click="cerrarModal" aria-label="Cerrar">
          <i class="ti ti-x"></i>
        </button>
      </div>
      <div class="modal-body">
        <div class="modal-row">
          <span class="modal-label">Docente</span>
          <span class="modal-value">{{ planificacionSeleccionada?.docente }}</span>
        </div>
        <div class="modal-row">
          <span class="modal-label">Curso</span>
          <span class="modal-value">{{ planificacionSeleccionada?.curso }}</span>
        </div>
        <div class="modal-row">
          <span class="modal-label">Estado</span>
          <span class="badge" :class="{
            'badge-pendiente':  planificacionSeleccionada?.estado === 'Pendiente',
            'badge-aprobada':   planificacionSeleccionada?.estado === 'Aprobada',
            'badge-correccion': planificacionSeleccionada?.estado === 'Correccion',
          }">
            {{ planificacionSeleccionada?.estado === 'Correccion' ? 'Corrección' : planificacionSeleccionada?.estado }}
          </span>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn-modal btn-aprobar" @click="aprobar">
          <i class="ti ti-circle-check" aria-hidden="true"></i> Aprobar
        </button>
        <button class="btn-modal btn-correccion" @click="pedir">
          <i class="ti ti-pencil" aria-hidden="true"></i> Pedir corrección
        </button>
        <button class="btn-modal btn-cancelar" @click="cerrarModal">
          Cancelar
        </button>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* ─── Tabla ──────────────────────────────────────────────────────────────────── */

.tabla-wrapper {
  margin-top: 1.5rem;
  border-radius: 16px;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.dark-mode .tabla-wrapper {
  border-color: #1e3a8a;
}

.tabla {
  width: 100%;
  border-collapse: collapse;
  background: #ffffff;
}

.dark-mode .tabla {
  background: #1a1a1a;
}

.tabla thead {
  background: #2563eb;
}

.tabla thead th {
  padding: 14px 20px;
  text-align: left;
  font-size: 13px;
  font-weight: 700;
  color: #ffffff;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.tabla tbody tr {
  border-bottom: 1px solid rgba(0, 0, 0, 0.06);
  transition: background 0.15s;
}

.tabla tbody tr:last-child {
  border-bottom: none;
}

.tabla tbody tr:nth-child(even) {
  background: #f5f7fa;
}

.dark-mode .tabla tbody tr:nth-child(even) {
  background: #111827;
}

.tabla tbody tr:hover {
  background: rgba(37, 99, 235, 0.06);
}

.dark-mode .tabla tbody tr:hover {
  background: rgba(37, 99, 235, 0.1);
}

.tabla tbody td {
  padding: 14px 20px;
  font-size: 15px;
  color: #1a2a3a;
}

.dark-mode .tabla tbody td {
  color: #e2e8f0;
}

.tabla-nombre {
  display: flex;
  align-items: center;
  gap: 10px;
}

.tabla-avatar {
  width: 34px;
  height: 34px;
  border-radius: 50%;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 12px;
  font-weight: 700;
  color: #2563eb;
  flex-shrink: 0;
}

.dark-mode .tabla-avatar {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.btn-tabla {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  background: #2563eb;
  color: #ffffff;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 7px 16px;
  font-size: 13px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}

.btn-tabla:hover {
  background: #1d4ed8;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
  transform: translateY(-1px);
}

.btn-tabla:active {
  transform: translateY(0);
  box-shadow: none;
}

/* ─── Badges ─────────────────────────────────────────────────────────────────── */

.badge {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
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

/* ─── Modal ──────────────────────────────────────────────────────────────────── */

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.45);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal {
  background: #ffffff;
  border-radius: 20px;
  width: 100%;
  max-width: 480px;
  padding: 2rem;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.dark-mode .modal {
  background: #1a1a1a;
}

.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}

.modal-header h2 {
  font-size: 18px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .modal-header h2 {
  color: #ffffff;
}

.modal-close {
  background: none;
  border: none;
  font-size: 20px;
  color: #5a6a7a;
  cursor: pointer;
  padding: 4px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 8px;
  transition: background 0.15s;
}

.modal-close:hover {
  background: rgba(0,0,0,0.06);
}

.modal-body {
  display: flex;
  flex-direction: column;
  gap: 14px;
  margin-bottom: 1.5rem;
}

.modal-row {
  display: flex;
  align-items: center;
  gap: 12px;
}

.modal-label {
  font-size: 13px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  min-width: 80px;
}

.modal-value {
  font-size: 15px;
  font-weight: 600;
  color: #1a2a3a;
}

.dark-mode .modal-value {
  color: #e2e8f0;
}

.modal-footer {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;
}

.btn-modal {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  border-radius: 999px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  border: 2px solid transparent;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}

.btn-modal:hover {
  transform: translateY(-1px);
}

.btn-modal:active {
  transform: translateY(0);
}

.btn-aprobar {
  background: #2563eb;
  color: #ffffff;
  border-color: #1e40af;
}

.btn-aprobar:hover {
  background: #1d4ed8;
  box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
}

.btn-correccion {
  background: rgba(186, 117, 23, 0.12);
  color: #854f0b;
  border-color: rgba(186, 117, 23, 0.4);
}

.btn-correccion:hover {
  background: rgba(186, 117, 23, 0.2);
}

.btn-cancelar {
  background: #f5f7fa;
  color: #5a6a7a;
  border-color: rgba(0,0,0,0.1);
}

.btn-cancelar:hover {
  background: #e2e8f0;
}
</style>
