<script setup lang="ts">
import { useRouter } from 'vue-router'

const router = useRouter()

interface Curso {
  id: number
  grado: string
  seccion: string
  ciclo: string
  turno: string
}

const cursos: Curso[] = [
  { id: 1, grado: '1°', seccion: 'A', ciclo: 'Primario', turno: 'Mañana'  },
  { id: 2, grado: '1°', seccion: 'B', ciclo: 'Primario', turno: 'Tarde'   },
  { id: 3, grado: '2°', seccion: 'A', ciclo: 'Primario', turno: 'Mañana'  },
  { id: 4, grado: '3°', seccion: 'A', ciclo: 'Primario', turno: 'Mañana'  },
  { id: 5, grado: '3°', seccion: 'B', ciclo: 'Primario', turno: 'Tarde'   },
  { id: 6, grado: '4°', seccion: 'A', ciclo: 'Primario', turno: 'Mañana'  },
  { id: 7, grado: '5°', seccion: 'A', ciclo: 'Primario', turno: 'Tarde'   },
  { id: 8, grado: '6°', seccion: 'A', ciclo: 'Primario', turno: 'Mañana'  },
]

const irACurso = (id: number) => {
  router.push({ name: 'docente-curso-planificaciones', params: { id } })
}
</script>

<template>
  <div class="cursos-wrapper">

    <div class="cursos-header">
      <span class="section-label">Mis cursos</span>
    </div>

    <div class="cursos-grid">
      <div
        v-for="curso in cursos"
        :key="curso.id"
        class="curso-card"
        @click="irACurso(curso.id)"
      >
        <div class="curso-icon">
          <i class="ti ti-school" aria-hidden="true"></i>
        </div>
        <div class="curso-info">
          <p class="curso-titulo">{{ curso.grado }} {{ curso.seccion }}</p>
          <p class="curso-subtitulo">{{ curso.ciclo }} — {{ curso.turno }}</p>
        </div>
        <i class="ti ti-arrow-right arrow" aria-hidden="true"></i>
      </div>
    </div>

  </div>
</template>

<style>
.cursos-wrapper {
  width: 100%;
}

/* ─── Header ─────────────────────────────────────────────────────────────────── */

.cursos-wrapper .cursos-header {
  margin-bottom: 14px;
}

.cursos-wrapper .section-label {
  font-size: 12px;
  font-weight: 700;
  color: #8a9aaa;
  text-transform: uppercase;
  letter-spacing: 0.08em;
}

.dark-mode .cursos-wrapper .section-label {
  color: #4a6a8a;
}

/* ─── Grid ───────────────────────────────────────────────────────────────────── */

.cursos-wrapper .cursos-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 14px;
}

/* ─── Tarjeta ────────────────────────────────────────────────────────────────── */

.cursos-wrapper .curso-card {
  background: #ffffff;
  border: 1.5px solid rgba(0, 0, 0, 0.08);
  border-radius: 16px;
  padding: 28px 24px;
  display: flex;
  align-items: center;
  gap: 20px;
  cursor: pointer;
  transition: background 0.2s, border-color 0.2s, transform 0.15s, box-shadow 0.2s;
}

.cursos-wrapper .curso-card:hover {
  border-color: #29abe2;
  box-shadow: 0 4px 16px rgba(41, 171, 226, 0.15);
  transform: translateY(-2px);
}

.cursos-wrapper .curso-card:active {
  transform: translateY(0px) scale(0.99);
  box-shadow: none;
}

.dark-mode .cursos-wrapper .curso-card {
  background: #1a1a1a;
  border-color: #0071bc;
}

.dark-mode .cursos-wrapper .curso-card:hover {
  border-color: #1ab8f0;
  box-shadow: 0 4px 16px rgba(26, 184, 240, 0.15);
}

/* ─── Ícono ──────────────────────────────────────────────────────────────────── */

.cursos-wrapper .curso-icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  background: rgba(51, 204, 255, 0.12);
  border: 1.5px solid rgba(41, 171, 226, 0.25);
  display: flex;
  align-items: center;
  justify-content: center;
  color: #29abe2;
  font-size: 24px;
  flex-shrink: 0;
}

.dark-mode .cursos-wrapper .curso-icon {
  background: rgba(26, 184, 240, 0.08);
  border-color: rgba(13, 159, 214, 0.2);
  color: #1ab8f0;
}

/* ─── Info ───────────────────────────────────────────────────────────────────── */

.cursos-wrapper .curso-info {
  flex: 1;
}

.cursos-wrapper .curso-titulo {
  font-size: 20px;
  font-weight: 700;
  color: #1a2a3a;
  margin-bottom: 6px;
}

.dark-mode .cursos-wrapper .curso-titulo {
  color: #ffffff;
}

.cursos-wrapper .curso-subtitulo {
  font-size: 14px;
  color: #5a6a7a;
}

.dark-mode .cursos-wrapper .curso-subtitulo {
  color: #aabbcc;
}

/* ─── Flecha animada ─────────────────────────────────────────────────────────── */

.cursos-wrapper .arrow {
  font-size: 20px;
  color: #29abe2;
  opacity: 0;
  transition: opacity 0.2s, transform 0.2s;
  margin-left: 4px;
  flex-shrink: 0;
}

.cursos-wrapper .curso-card:hover .arrow {
  opacity: 1;
  transform: translateX(4px);
}
</style>