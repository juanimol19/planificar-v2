<script setup lang="ts">
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { registrarUsuario } from '@/services/directorService'

const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  role: 'docente' as 'docente' | 'vicedirector' | 'secretario',
})

const errores = ref<Record<string, string>>({})
const enviado = ref(false)
const cargando = ref(false)
const errorServidor = ref('')

const validar = (): boolean => {
  errores.value = {}

  if (!form.name.trim())
    errores.value.name = 'El nombre es obligatorio.'

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

  return Object.keys(errores.value).length === 0
}

const guardar = async () => {
  if (!validar()) return

  cargando.value = true
  errorServidor.value = ''

  try {
    await registrarUsuario({ ...form })
    enviado.value = true
    setTimeout(() => router.push('/director/docentes'), 1200)
  } catch (error: any) {
    const data = error.response?.data
    if (data?.errors) {
      // Errores de validación del backend
      for (const [campo, mensajes] of Object.entries(data.errors)) {
        errores.value[campo] = (mensajes as string[])[0]
      }
    } else {
      errorServidor.value = data?.message ?? 'Ocurrió un error al registrar el usuario.'
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
      <h1 class="paso-titulo">Agregar nuevo usuario</h1>
      <p class="paso-desc">Registrá las credenciales de acceso del nuevo usuario al sistema.</p>

      <div v-if="enviado" class="exito-box">
        <i class="ti ti-circle-check" aria-hidden="true"></i>
        Usuario registrado correctamente. Redirigiendo...
      </div>

      <div v-if="errorServidor" class="error-box">
        <i class="ti ti-alert-circle" aria-hidden="true"></i>
        {{ errorServidor }}
      </div>

      <form v-if="!enviado" @submit.prevent="guardar">
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

        <div class="form-group">
          <label for="role">Rol</label>
          <select id="role" v-model="form.role">
            <option value="docente">Docente</option>
            <option value="vicedirector">Vicedirector</option>
            <option value="secretario">Secretario</option>
          </select>
        </div>

        <div class="form-nav">
          <button type="button" class="btn-nav btn-anterior" @click="cancelar" :disabled="cargando">
            Cancelar
          </button>
          <button type="submit" class="btn-nav btn-submit" :disabled="cargando">
            <i v-if="cargando" class="ti ti-loader-2" aria-hidden="true"></i>
            {{ cargando ? 'Registrando...' : 'Registrar usuario' }}
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
