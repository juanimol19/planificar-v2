<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import { getCursosConDocente, getCursosSinAsignar, eliminarCurso } from '@/services/cursoService'
import { getPlanificaciones, estadoActual, labelEstado } from '@/services/planificacionService'
import type { Curso, PlanificacionResumenCurso } from '@/types/Curso'
import type { CursoSinAsignarAPI } from '@/services/cursoService'

const router = useRouter()

const cursos = ref<Curso[]>([])
const cursosSinAsignar = ref<CursoSinAsignarAPI[]>([])
const cargando = ref(true)
const error = ref<string | null>(null)
const eliminandoId = ref<number | null>(null)

const armarDocente = (curso: any): string => {
  const pcc = curso.cursados?.[0]?.persona_cargo_cursados?.[0]
  const persona = pcc?.persona_cargo?.persona
  if (!persona) return 'Sin asignar'
  return `${persona.nombres} ${persona.apellidos}`
}

const claseBadgeTurno = (turno: string): string => {
  if (turno === 'Mañana') return 'badge-manana'
  if (turno === 'Tarde') return 'badge-tarde'
  return 'badge-noche'
}

const cargarCursos = async () => {
  cargando.value = true
  error.value = null
  try {
    const [cursosData, planificacionesData, sinAsignarData] = await Promise.all([
      getCursosConDocente(),
      getPlanificaciones(),
      getCursosSinAsignar(),
    ])

    cursos.value = cursosData.map((curso) => {
      const pccId = curso.cursados?.[0]?.persona_cargo_cursados?.[0]?.id

      const planificaciones: PlanificacionResumenCurso[] = planificacionesData
        .filter((p) => p.persona_cargo_cursado_id === pccId)
        .map((p) => ({
          id: p.id,
          titulo: p.aprendizajes_esperados ?? 'Sin título',
          estado: labelEstado(estadoActual(p.estados_anuales ?? [])),
        }))

      return {
        id: curso.id,
        nombre: `${curso.grado} ${curso.seccion}`,
        ciclo: curso.ciclo,
        turno: curso.turno,
        docente: armarDocente(curso),
        planificaciones,
      }
    })

    cursosSinAsignar.value = sinAsignarData
  } catch (e) {
    error.value = 'No se pudo cargar la lista de cursos.'
    console.error(e)
  } finally {
    cargando.value = false
  }
}

onMounted(cargarCursos)

const irAAgregar = () => router.push('/director/cursos/nuevo')
const verCurso = (id: number) => router.push(`/director/cursos/${id}`)

const eliminarCursoSinAsignar = async (curso: CursoSinAsignarAPI) => {
  const confirmado = confirm(
    `¿Eliminar el curso ${curso.grado} ${curso.seccion} (${curso.turno})? Esta acción no se puede deshacer.`
  )
  if (!confirmado) return

  eliminandoId.value = curso.id
  try {
    await eliminarCurso(curso.id)
    cursosSinAsignar.value = cursosSinAsignar.value.filter((c) => c.id !== curso.id)
  } catch (e) {
    alert('No se pudo eliminar el curso. Intentá nuevamente.')
    console.error(e)
  } finally {
    eliminandoId.value = null
  }
}
</script>

<template>
  <div class="acciones-top">
    <button class="btn-agregar" @click="irAAgregar">
      <i class="ti ti-plus" aria-hidden="true"></i> Agregar curso
    </button>
  </div>

  <div v-if="cargando">Cargando cursos...</div>
  <div v-else-if="error">{{ error }}</div>

  <template v-else>
    <div class="tabla-wrapper">
      <table class="tabla">
        <thead>
          <tr>
            <th>ID</th>
            <th>Curso</th>
            <th>Ciclo</th>
            <th>Turno</th>
            <th>Docente</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="curso in cursos" :key="curso.id">
            <td>{{ curso.id }}</td>
            <td>
              <div class="tabla-nombre">
                <div class="tabla-icon">
                  <i class="ti ti-books" aria-hidden="true"></i>
                </div>
                {{ curso.nombre }}
              </div>
            </td>
            <td>{{ curso.ciclo }}</td>
            <td>
              <span class="badge-turno" :class="claseBadgeTurno(curso.turno)">
                {{ curso.turno }}
              </span>
            </td>
            <td>{{ curso.docente }}</td>
            <td>
              <button class="btn-tabla" @click="verCurso(curso.id)">
                <i class="ti ti-eye" aria-hidden="true"></i> Ver
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div v-if="cursosSinAsignar.length" class="tabla-wrapper tabla-sin-asignar">
      <h2 class="subtitulo-seccion">Cursos sin asignar</h2>
      <p class="paso-desc">Estos cursos fueron creados pero todavía no tienen docente ni año lectivo asociado.</p>

      <table class="tabla">
        <thead>
          <tr>
            <th>ID</th>
            <th>Curso</th>
            <th>Ciclo</th>
            <th>Turno</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="curso in cursosSinAsignar" :key="curso.id">
            <td>{{ curso.id }}</td>
            <td>
              <div class="tabla-nombre">
                <div class="tabla-icon">
                  <i class="ti ti-books" aria-hidden="true"></i>
                </div>
                {{ curso.grado }} {{ curso.seccion }}
              </div>
            </td>
            <td>{{ curso.ciclo }}</td>
            <td>
              <span class="badge-turno" :class="claseBadgeTurno(curso.turno)">
                {{ curso.turno }}
              </span>
            </td>
            <td>
              <button class="btn-tabla" @click="verCurso(curso.id)">
                <i class="ti ti-eye" aria-hidden="true"></i> Ver
              </button>
              <button
                class="btn-tabla btn-eliminar"
                :disabled="eliminandoId === curso.id"
                @click="eliminarCursoSinAsignar(curso)"
              >
                <i class="ti ti-trash" aria-hidden="true"></i>
                {{ eliminandoId === curso.id ? 'Eliminando...' : 'Eliminar' }}
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
</template>

<style scoped>
.acciones-top {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 1rem;
}

.btn-agregar {
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

.btn-agregar:hover {
  background: #1d4ed8;
  box-shadow: 0 4px 16px rgba(37, 99, 235, 0.2);
  transform: translateY(-2px);
}

.btn-agregar:active {
  transform: translateY(0) scale(0.97);
  box-shadow: none;
}

.tabla-wrapper {
  border-radius: 16px;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.dark-mode .tabla-wrapper {
  border-color: #1e3a8a;
}

.tabla-sin-asignar {
  margin-top: 2rem;
}

.subtitulo-seccion {
  padding: 16px 20px 0;
  font-size: 16px;
  font-weight: 700;
  color: #1a2a3a;
}

.dark-mode .subtitulo-seccion {
  color: #e2e8f0;
}

.tabla-sin-asignar .paso-desc {
  padding: 4px 20px 16px;
  font-size: 13px;
  color: #64748b;
  margin: 0;
}

.dark-mode .tabla-sin-asignar .paso-desc {
  color: #94a3b8;
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

.tabla-icon {
  width: 34px;
  height: 34px;
  border-radius: 10px;
  background: rgba(37, 99, 235, 0.12);
  border: 1.5px solid rgba(37, 99, 235, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 16px;
  color: #2563eb;
  flex-shrink: 0;
}

.dark-mode .tabla-icon {
  background: rgba(37, 99, 235, 0.15);
  color: #60a5fa;
}

.badge-turno {
  font-size: 12px;
  font-weight: 700;
  padding: 5px 14px;
  border-radius: 999px;
}

.badge-manana {
  background: rgba(37, 99, 235, 0.1);
  color: #1e40af;
  border: 1px solid rgba(37, 99, 235, 0.25);
}

.badge-tarde {
  background: rgba(124, 58, 237, 0.1);
  color: #5b21b6;
  border: 1px solid rgba(124, 58, 237, 0.25);
}

.badge-noche {
  background: rgba(15, 23, 42, 0.08);
  color: #1e293b;
  border: 1px solid rgba(15, 23, 42, 0.25);
}

.dark-mode .badge-manana {
  background: rgba(37, 99, 235, 0.2);
  color: #60a5fa;
  border-color: #2563eb;
}

.dark-mode .badge-tarde {
  background: rgba(124, 58, 237, 0.2);
  color: #a78bfa;
  border-color: #7c3aed;
}

.dark-mode .badge-noche {
  background: rgba(148, 163, 184, 0.15);
  color: #cbd5e1;
  border-color: #64748b;
}

.tabla tbody td:last-child {
  display: flex;
  align-items: center;
  gap: 10px;
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

.btn-eliminar {
  background: #dc2626;
  border-color: #991b1b;
}

.btn-eliminar:hover {
  background: #b91c1c;
  box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
}

.btn-eliminar:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
  box-shadow: none;
}

.tabla tbody td:last-child {
  display: flex;
  align-items: center;
  justify-content: flex-end;
  gap: 10px;
}
</style>
