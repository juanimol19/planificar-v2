import apiClient from '@/api/axios'

export interface SitRevistaAPI {
  id: number
  revista: string
  created_at: string
  updated_at: string
}

export const getSitRevistas = async (): Promise<SitRevistaAPI[]> => {
  const response = await apiClient.get('/sit-revista')
  return response.data
}