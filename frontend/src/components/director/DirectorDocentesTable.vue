<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { docentesMock } from '@/data/docentesMock'
import type { Docente } from '@/types/Docente'

const router = useRouter()

const docenteSeleccionado = ref<Docente | null>(null)
const showModal = ref(false)

const verPerfil = (docente: Docente) => {
  docenteSeleccionado.value = docente
  showModal.value = true
}

const cerrarModal = () => {
  showModal.value = false
  docenteSeleccionado.value = null
}

const irAAgregar = () => {
  router.push('/director/docentes/nuevo')
}

const formatearFecha = (fecha: string) => {
  return new Date(fecha).toLocaleDateString('es-AR', { year: 'numeric', month: 'long', day: 'numeric' })
}
</script>

<template>
  <div class="acciones-top">
    <button class="btn-agregar-docente" @click="irAAgregar">
      <i class="ti ti-plus" aria-hidden="true"></i> Agregar docente
    </button>
  </div>

  <div class="tabla-wrapper">
    <table class="tabla">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Grado</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="docente in docentesMock" :key="docente.id">
          <td>{{ docente.id }}</td>
          <td>
            <div class="tabla-nombre">
              <div class="tabla-avatar">{{ docente.nombre[0] }}{{ docente.apellido[0] }}</div>
              {{ docente.nombre }} {{ docente.apellido }}
            </div>
          </td>
          <td>{{ docente.email }}</td>
          <td>{{ docente.grado }}</td>
          <td>
            <span class="badge-estado" :class="docente.estado === 'Activo' ? 'badge-activo' : 'badge-inactivo'">
              {{ docente.estado }}
            </span>
          </td>
          <td>
            <button class="btn-tabla" @click="verPerfil(docente)">
              <i class="ti ti-eye" aria-hidden="true"></i> Ver
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Modal de perfil -->
  <div v-if="showModal" class="modal-overlay" @click.self="cerrarModal">
    <div class="modal">
      <div class="modal-header">
        <div class="modal-header-info">
          <div class="modal-avatar">{{ docenteSeleccionado?.nombre[0] }}{{ docenteSeleccionado?.apellido[0] }}</div>
          <div>
            <h2>{{ docenteSeleccionado?.nombre }} {{ docenteSeleccionado?.apellido }}</h2>
            <span class="badge-estado" :class="docenteSeleccionado?.estado === 'Activo' ? 'badge-activo' : 'badge-inactivo'">
              {{ docenteSeleccionado?.estado }}
            </span>
          </div>
        </div>
        <button class="modal-close" @click="cerrarModal" aria-label="Cerrar">
          <i class="ti ti-x"></i>
        </button>
      </div>

      <div class="modal-body">
        <div class="modal-grid">
          <div class="modal-row">
            <span class="modal-label"><i class="ti ti-id"></i> DNI</span>
            <span class="modal-value">{{ docenteSeleccionado?.dni }}</span>
          </div>
          <div class="modal-row">
            <span class="modal-label"><i class="ti ti-mail"></i> Email</span>
            <span class="modal-value">{{ docenteSeleccionado?.email }}</span>
          </div>
          <div class="modal-row">
            <span class="modal-label"><i class="ti ti-phone"></i> Teléfono</span>
            <span class="modal-value">{{ docenteSeleccionado?.telefono }}</span>
          </div>
          <div class="modal-row">
            <span class="modal-label"><i class="ti ti-school"></i> Grado</span>
            <span class="modal-value">{{ docenteSeleccionado?.grado }}</span>
          </div>
          <div class="modal-row">
            <span class="modal-label"><i class="ti ti-calendar"></i> Ingreso</span>
            <span class="modal-value">{{ docenteSeleccionado ? formatearFecha(docenteSeleccionado.fechaIngreso) : '' }}</span>
          </div>
        </div>

        <div class="modal-planificaciones">
          <h3 class="modal-subtitulo"><i class="ti ti-clipboard-list"></i> Planificaciones</h3>
          <div v-if="docenteSeleccionado?.planificaciones.length" class="plan-lista">
            <div v-for="plan in docenteSeleccionado.planificaciones" :key="plan.id" class="plan-item">
              <span>{{ plan.curso }}</span>
              <span class="badge" :class="{
                'badge-pendiente':  plan.estado === 'Pendiente',
                'badge-aprobada':   plan.estado === 'Aprobada',
                'badge-correccion': plan.estado === 'Correccion',
              }">
                {{ plan.estado === 'Correccion' ? 'Corrección' : plan.estado }}
              </span>
            </div>
          </div>
          <p v-else class="plan-vacio">Este docente no tiene planificaciones registradas.</p>
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn-modal btn-cancelar" @click="cerrarModal">Cerrar</button>
      </div>
    </div>
  </div>
</template>

<style scoped>
/* ─── Botón agregar ──────────────────────────────────────────────────────────── */

.acciones-top {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.btn-agregar-docente {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  background: #2563eb;
  color: #ffffff;
  border: 2px solid #1e40af;
  border-radius: 999px;
  padding: 10px 20px;
  font-size: 14px;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
}

.btn-agregar-docente:hover {
  background: #1d4ed8;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.2);
  transform: translateY(-2px);
}

.btn-agregar-docente:active {
  transform: translateY(0) scale(0.97);
  box-shadow: none;
}

/* ─── Tabla ──────────────────────────────────────────────────────────────────── */

.tabla-wrapper {
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

/* ─── Badge estado docente ───────────────────────────────────────────────────── */

.badge-estado {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
}

.badge-activo {
  background: rgba(29, 158, 117, 0.12);
  color: #0f6e56;
  border: 1px solid rgba(29, 158, 117, 0.25);
}

.dark-mode .badge-activo {
  background: rgba(57, 181, 74, 0.3);
  color: #00ff00;
  border: 1px solid #00ff00;
}

.badge-inactivo {
  background: rgba(120, 120, 120, 0.12);
  color: #5a5a5a;
  border: 1px solid rgba(120, 120, 120, 0.25);
}

.dark-mode .badge-inactivo {
  background: rgba(150, 150, 150, 0.2);
  color: #aaaaaa;
  border: 1px solid #888888;
}

/* ─── Badges planificación (dentro del modal) ───────────────────────────────── */

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
  padding: 1rem;
}

.modal {
  background: #ffffff;
  border-radius: 20px;
  width: 100%;
  max-width: 560px;
  max-height: 90vh;
  overflow-y: auto;
  padding: 2rem;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
}

.dark-mode .modal {
  background: #1a1a1a;
}

.modal-header {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
  margin-bottom: 1.5rem;
}

.modal-header-info {
  display: flex;
  align-items: center;
  gap: 14px;
}

.modal-avatar {
  width: 54px;
  height: 54px;
  border-radius: 50%;
  background: rgba(37, 99, 235, 0.12);
  border: 2px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 18px;
  font-weight: 700;
  color: #2563eb;
  flex-shrink: 0;
}

.dark-mode .modal-avatar {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.modal-header h2 {
  font-size: 18px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 6px;
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
  flex-shrink: 0;
}

.modal-close:hover {
  background: rgba(0,0,0,0.06);
}

.modal-body {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.modal-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
  gap: 14px;
}

.modal-row {
  display: flex;
  flex-direction: column;
  gap: 4px;
}

.modal-label {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.dark-mode .modal-label {
  color: #6b7c8c;
}

.modal-value {
  font-size: 15px;
  font-weight: 600;
  color: #1a2a3a;
}

.dark-mode .modal-value {
  color: #e2e8f0;
}

.modal-subtitulo {
  display: flex;
  align-items: center;
  gap: 6px;
  font-size: 14px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 10px;
}

.dark-mode .modal-subtitulo {
  color: #ffffff;
}

.plan-lista {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.plan-item {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #f5f7fa;
  border-radius: 10px;
  padding: 10px 14px;
  font-size: 14px;
  font-weight: 600;
  color: #1a2a3a;
}

.dark-mode .plan-item {
  background: #111827;
  color: #e2e8f0;
}

.plan-vacio {
  font-size: 13px;
  color: #8a9aaa;
  font-style: italic;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  margin-top: 1.5rem;
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

.btn-cancelar {
  background: #f5f7fa;
  color: #5a6a7a;
  border-color: rgba(0,0,0,0.1);
}

.btn-cancelar:hover {
  background: #e2e8f0;
}
</style>
