<script setup lang="ts">
interface Docente {
  id: number
  nombre: string
  email: string
}

const docentes: Docente[] = [
  { id: 1, nombre: 'Juan Pérez',    email: 'juan@escuela.com'   },
  { id: 2, nombre: 'María Gómez',   email: 'maria@escuela.com'  },
  { id: 3, nombre: 'Carlos López',  email: 'carlos@escuela.com' },
  { id: 4, nombre: 'Ana Martínez',  email: 'ana@escuela.com'    },
  { id: 5, nombre: 'Luis Fernández',email: 'luis@escuela.com'   },
]
</script>

<template>
  <div class="tabla-wrapper">
    <table class="tabla">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Email</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="docente in docentes" :key="docente.id">
          <td>{{ docente.id }}</td>
          <td>
            <div class="tabla-nombre">
              <div class="tabla-avatar">{{ docente.nombre.split(' ').map(n => n[0]).join('') }}</div>
              {{ docente.nombre }}
            </div>
          </td>
          <td>{{ docente.email }}</td>
          <td>
            <button class="btn-tabla">
              <i class="ti ti-eye" aria-hidden="true"></i> Ver
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
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
</style>
