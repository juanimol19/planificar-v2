import { defineStore } from 'pinia'
import { ref, computed } from 'vue'
import apiClient from '@/api/axios'
import router from '@/router'

interface User {
  id: number
  name: string
  email: string
  [key: string]: unknown
}

export const useAuthStore = defineStore('auth', () => {
  const user = ref<User | null>(null)
  const role = ref<string | null>(null)
  const token = ref<string | null>(null)

  const isAuthenticated = computed(() => !!token.value)

  function redirectByRole() {
    if (role.value === 'docente') {
      router.push('/docente/inicio')
    } else if (['director', 'vicedirector', 'secretario'].includes(role.value ?? '')) {
      router.push('/director/inicio')
    } else {
      router.push('/login')
    }
  }

  async function login(email: string, password: string) {
    const response = await apiClient.post('/login', { email, password })
    const { user: userData, role: userRole, access_token } = response.data

    user.value = userData
    role.value = userRole
    token.value = access_token

    localStorage.setItem('access_token', access_token)
    localStorage.setItem('auth_user', JSON.stringify(userData))
    localStorage.setItem('auth_role', userRole)

    redirectByRole()
  }

  function logout() {
    user.value = null
    role.value = null
    token.value = null

    localStorage.removeItem('access_token')
    localStorage.removeItem('auth_user')
    localStorage.removeItem('auth_role')

    router.push('/login')
  }

  function initAuth() {
    const storedToken = localStorage.getItem('access_token')
    const storedUser = localStorage.getItem('auth_user')
    const storedRole = localStorage.getItem('auth_role')

    if (storedToken && storedUser && storedRole) {
      token.value = storedToken
      user.value = JSON.parse(storedUser)
      role.value = storedRole
    }
  }

  return {
    user,
    role,
    token,
    isAuthenticated,
    login,
    logout,
    initAuth,
  }
})