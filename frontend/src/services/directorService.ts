import apiClient from '@/api/axios'

export interface RegistrarUsuarioPayload {
  name: string
  email: string
  password: string
  password_confirmation: string
  role: 'docente' | 'vicedirector' | 'secretario'
}

export const registrarUsuario = async (payload: RegistrarUsuarioPayload) => {
  const response = await apiClient.post('/register', payload)
  return response.data
}