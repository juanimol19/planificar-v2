<template>
  <div class="login-page">
    <div class="login-wrap">

      <!-- Panel izquierdo -->
      <div class="login-left">
        <div class="logo-circle">
          <i class="ti ti-school"></i>
        </div>
        <div class="brand-name">Planificar</div>
        <div class="brand-sub">Crear planificaciones, en el momento.</div>
      </div>

      <!-- Panel derecho -->
      <div class="login-right">
<div class="form-title"></div>
<div class="form-subtitle"></div>

        <div class="form-group fg1">
          <label class="form-label">Usuario</label>
          <div class="input-wrap" id="wrap-user">
            <i class="ti ti-user"></i>
            <input
              type="text"
              id="input-user"
              v-model="form.email"
              placeholder="usuario@gmail.com"
              autocomplete="username"
            />
          </div>
        </div>

        <div class="form-group fg2">
          <label class="form-label">Contraseña</label>
          <div class="input-wrap" id="wrap-pass">
            <i class="ti ti-lock"></i>
            <input
              :type="mostrarPass ? 'text' : 'password'"
              id="input-pass"
              v-model="form.password"
              placeholder="••••••••"
              autocomplete="current-password"
              @keyup.enter="handleLogin"
            />
            <i
              class="ti toggle-pass"
              :class="mostrarPass ? 'ti-eye-off' : 'ti-eye'"
              @click="mostrarPass = !mostrarPass"
            ></i>
          </div>
          <span class="forgot">¿Olvidaste tu contraseña?</span>
        </div>

        <button class="btn-login" id="btn-login" @click="handleLogin" :disabled="cargando">
        <i class="ti ti-login"></i>
        {{ cargando ? 'Ingresando...' : 'Ingresar' }}
        </button>

        <p v-if="errorMsg" class="error-msg">{{ errorMsg }}</p>

        <div class="helper-text">
          ¿Tenés problemas para acceder? Contactá al administrador.
        </div>
      </div>

    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'

const form = ref({ email: '', password: '' })
const mostrarPass = ref(false)
const authStore = useAuthStore()
const errorMsg = ref('')
const cargando = ref(false)

async function handleLogin() {
  errorMsg.value = ''
  cargando.value = true
  try {
    await authStore.login(form.value.email, form.value.password)
  } catch (err: any) {
    errorMsg.value = err.response?.data?.message ?? 'Credenciales incorrectas'
  } finally {
    cargando.value = false
  }
}
function typeText(el: HTMLElement, text: string, speed: number, onDone?: () => void) {
  let i = 0
  const cursor = document.createElement('span')
  cursor.className = 'cursor'
  el.appendChild(cursor)

  const iv = setInterval(() => {
    el.insertBefore(document.createTextNode(text[i]), cursor)
    i++
    if (i >= text.length) {
      clearInterval(iv)
      setTimeout(() => {
        cursor.remove()
        if (onDone) onDone()
      }, 500)
    }
  }, speed)
}

onMounted(() => {
  const titulo = document.querySelector('.form-title') as HTMLElement
  const subtitulo = document.querySelector('.form-subtitle') as HTMLElement

  // Espera a que el panel derecho haya aparecido (delay 1.8s + 0.7s anim = ~2.5s)
  setTimeout(() => {
    typeText(titulo, 'Bienvenido', 75, () => {
      setTimeout(() => {
        typeText(subtitulo, 'Ingresá tus credenciales para continuar', 35)
      }, 200)
    })
  }, 2500)
})
</script>

<style>
.login-page {
  height: 100vh;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #e8f7fd 0%, #f0f9ff 50%, #e0f2fe 100%);
  padding: 0rem;
  font-family: Arial, sans-serif;
  
}

.login-wrap {
  display: flex;
  width: 100%;
  max-width: 1100px;
  height: 90vh;
  border-radius: 20px;
  overflow: hidden;
  box-shadow:
    0 4px 6px rgba(41, 171, 226, 0.07),
    0 20px 60px rgba(41, 171, 226, 0.15),
    0 1px 0px rgba(255, 255, 255, 0.9) inset;
  background: #ffffff;
  position: relative;
}

.login-left {
  position: relative;
  width: 52%;
  background: linear-gradient(145deg, #29ABE2 0%, #33CCFF 60%, #5ad7ff 100%);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 2.5rem 2rem;
  clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);
  z-index: 2;

  opacity: 0;
  transform: translateX(-40px);
  animation: slideInLeft 2.7s ease forwards, hueRotate 7.8s ease forwards;
  animation-delay: 0.2s, 0.2s;

}

.logo-circle {
  width: 120px;
  height: 120px;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.18);
  border: 2.5px solid rgba(255, 255, 255, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 1.5rem;

  opacity: 0;
  transform: scale(0.7);
  animation: popIn 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
  animation-delay: 0.9s;
}

.logo-circle i {
  font-size: 52px;
  color: #fff;
}

.brand-name {
  font-weight: 700;
  font-size: 28px;
  color: #fff;
  letter-spacing: 1px;
  margin-bottom: 0.4rem;

  opacity: 0;
  transform: translateY(10px);
  animation: fadeUp 0.4s ease forwards;
  animation-delay: 1.3s;
}

.brand-sub {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.85);
  text-align: center;

  opacity: 0;
  transform: translateY(10px);
  animation: fadeUp 0.4s ease forwards;
  animation-delay: 1.5s;
}

.login-right {
  flex: 1;
  background: #ffffff;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: center;
  padding: 2.5rem 2.5rem 2.5rem 3.5rem;
  z-index: 1;

  opacity: 0;
  transform: translateX(40px);
  animation: slideInRight 0.7s ease forwards;
  animation-delay: 1.8s;
}

.form-title {
  font-weight: 700;
  font-size: 22px;
  color: #1a2a3a;
  margin-bottom: 0.3rem;
  min-height: 1.4em;

  opacity: 0;
  animation: fadeUp 0.4s ease forwards;
  animation-delay: 2.2s;
}

.form-subtitle {
  font-size: 13px;
  color: #5a6a7a;
  margin-bottom: 2rem;
  min-height: 1.2em;

  opacity: 0;
  animation: fadeUp 0.4s ease forwards;
  animation-delay: 2.4s;
}

.cursor {
  display: inline-block;
  width: 2px;
  height: 1em;
  background: #29ABE2;
  vertical-align: text-bottom;
  margin-left: 1px;
  animation: blink 0.7s steps(1) infinite;
}

.form-group {
  width: 100%;
  margin-bottom: 1.1rem;
}

.form-label {
  font-size: 12px;
  font-weight: 700;
  color: #5a6a7a;
  text-transform: uppercase;
  letter-spacing: 0.5px;
  margin-bottom: 6px;
  display: block;

  opacity: 0;
  animation: fadeUp 0.3s ease forwards;
}

.fg1 .form-label { animation-delay: 2.5s; }
.fg2 .form-label { animation-delay: 2.65s; }

.input-wrap {
  display: flex;
  align-items: center;
  background: #f2efef;
  border-radius: 10px;
  border: 1.5px solid transparent;
  padding: 0 12px;
  gap: 8px;
  transition: border-color 0.2s, background 0.2s;

  opacity: 0;
  animation: fadeUp 0.3s ease forwards;
}

.fg1 .input-wrap { animation-delay: 2.6s; }
.fg2 .input-wrap { animation-delay: 2.75s; }

.input-wrap:focus-within {
  border-color: #29ABE2;
  background: #fff;
}

.input-wrap i {
  font-size: 18px;
  color: #5a6a7a;
  flex-shrink: 0;
}

.input-wrap input {
  border: none;
  background: transparent;
  outline: none;
  font-family: Arial, sans-serif;
  font-size: 14px;
  color: #1a2a3a;
  padding: 11px 0;
  width: 100%;
}

.input-wrap input::placeholder {
  color: #aabbc4;
}

.toggle-pass {
  cursor: pointer;
  transition: color 0.2s;
}

.toggle-pass:hover {
  color: #29ABE2;
}

.forgot {
  font-size: 12px;
  color: #29ABE2;
  text-align: right;
  display: block;
  margin-top: 6px;
  cursor: pointer;
  transition: opacity 0.2s;

  opacity: 0;
  animation: fadeUp 0.3s ease forwards;
  animation-delay: 2.85s;
}

.forgot:hover {
  opacity: 0.75;
}

.btn-login {
  width: 100%;
  margin-top: 1.5rem;
  padding: 13px;
  border-radius: 10px;
  border: none;
  background: linear-gradient(90deg, #29ABE2, #33CCFF);
  color: #fff;
  font-family: Arial, sans-serif;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  letter-spacing: 0.3px;
  transition: transform 0.15s, box-shadow 0.15s;
  box-shadow: 0 4px 14px rgba(41, 171, 226, 0.35);

  opacity: 0;
  animation: fadeUp 0.4s ease forwards;
  animation-delay: 2.95s;
}

.btn-login i {
  font-size: 18px;
}

.btn-login:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(41, 171, 226, 0.45);
}

.btn-login:active {
  transform: scale(0.98);
}

.helper-text {
  font-size: 12px;
  color: #5a6a7a;
  margin-top: 1.2rem;
  text-align: center;
  width: 100%;

  opacity: 0;
  animation: fadeUp 0.3s ease forwards;
  animation-delay: 3.1s;
}

.input-wrap.typing {
  border-color: #29ABE2;
  background: #fff;
}

@keyframes slideInLeft {
  to { opacity: 1; transform: translateX(0); }
}
@keyframes slideInRight {
  to { opacity: 1; transform: translateX(0); }
}
@keyframes popIn {
  to { opacity: 1; transform: scale(1); }
}
@keyframes fadeUp {
  to { opacity: 1; transform: translateY(0); }
}
@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0; }
}
@keyframes hueRotate {
  0%   { filter: hue-rotate(550deg); }
  100% { filter: hue-rotate(1deg); }
}

.error-msg {
  color: #e23636;
  font-size: 12px;
  margin-top: 0.8rem;
  text-align: center;
  width: 100%;
}

@media (max-width: 600px) {
  .login-page {
    padding: 0;
    height: 100vh;
  }
  .login-wrap {
    flex-direction: column;
    height: 100vh;
    border-radius: 0;
  }
  .login-left {
    width: 100%;
    clip-path: polygon(0 0, 100% 0, 100% 82%, 0 100%);
    padding: 2rem 1.5rem;
    min-height: 200px;
    height: auto;
  }
  .login-right {
    padding: 2rem 1.5rem;
  }
}
</style>
