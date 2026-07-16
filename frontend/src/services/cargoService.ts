import apiClient from '@/api/axios'

export interface CargoAPI {
  id: number
  cargo: string
}

export const getCargos = async (): Promise<CargoAPI[]> => {
  const response = await apiClient.get('/cargos')
  return response.data
}