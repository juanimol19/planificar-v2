import { createRouter, createWebHistory } from 'vue-router'

import DirectorLayout from '@/layouts/DirectorLayout.vue'

import DirectorDashboardView from '@/views/director/DirectorDashboardView.vue'
import DocentesView from '@/views/director/DocentesView.vue'
import CursosView from '@/views/director/CursosView.vue'
import PlanificacionesView from '@/views/director/PlanificacionesView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),

  routes: [
    {
      path: '/',
      component: DirectorLayout,

      children: [
        {
          path: '',
          name: 'dashboard',
          component: DirectorDashboardView,
        },
        {
          path: 'docentes',
          name: 'docentes',
          component: DocentesView,
        },
        {
          path: 'cursos',
          name: 'cursos',
          component: CursosView,
        },
        {
          path: 'planificaciones',
          name: 'planificaciones',
          component: PlanificacionesView,
        },
      ],
    },
  ],
})

export default router
