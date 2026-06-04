import { createRouter, createWebHistory } from 'vue-router'

import DirectorLayout from '@/layouts/DirectorLayout.vue'
import DirectorDashboardView from '@/views/director/DirectorDashboardView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),

  routes: [
    {
      path: '/',
      component: DirectorLayout,

      children: [
        {
          path: '',
          name: 'director-dashboard',
          component: DirectorDashboardView,
        },
      ],
    },
  ],
})

export default router
