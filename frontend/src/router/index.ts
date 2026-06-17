import { createRouter, createWebHistory } from 'vue-router'
import DirectorLayout from '@/layouts/DirectorLayout.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/director',
      component: DirectorLayout,
      children: [
        {
          path: 'inicio',
          name: 'director-inicio',
          component: () => import('@/views/director/DirectorDashboardView.vue'),
        },
        {
          path: 'docentes',
          name: 'director-docentes',
          component: () => import('@/views/director/DocentesView.vue'),
        },
        {
          path: 'docentes/nuevo',
          name: 'director-docentes-nuevo',
          component: () => import('@/views/director/DocenteFormView.vue'),
        },
        {
          path: 'cursos',
          name: 'director-cursos',
          component: () => import('@/views/director/CursosView.vue'),
        },
        {
          path: 'planificaciones',
          name: 'director-planificaciones',
          component: () => import('@/views/director/PlanificacionesView.vue'),
        },
        {
          path: 'perfil',
          name: 'director-perfil',
          component: () => import('@/views/director/DirectorPerfilView.vue'),
        },
      ],
    },
    {
      path: '/',
      redirect: '/director/inicio',
    },
  ],
})

export default router
