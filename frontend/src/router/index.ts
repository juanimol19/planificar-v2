import { createRouter, createWebHistory } from 'vue-router'
import DocenteLayout from '@/layouts/DocenteLayout.vue'
import DirectorLayout from '@/layouts/DirectorLayout.vue'
import { useAuthStore } from '@/stores/auth'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      redirect: '/login',
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('@/views/LoginView.vue'),
    },
    {
      path: '/docente',
      component: DocenteLayout,
      children: [
        {
          path: 'inicio',
          name: 'docente-inicio',
          component: () => import('@/views/docente/DocenteInicio.vue'),
        },
        {
          path: 'mis-cursos',
          name: 'docente-mis-cursos',
          component: () => import('@/views/docente/DocenteMisCursos.vue'),
        },
        {
          path: 'mis-cursos/:id',
          name: 'docente-curso-planificaciones',
          component: () => import('@/views/docente/DocenteCursoPlanificaciones.vue'),
        },
        {
          path: 'planificaciones',
          name: 'docente-planificaciones',
          component: () => import('@/views/docente/DocentePlanificaciones.vue'),
        },
        {
          path: 'mi-perfil',
          name: 'docente-mi-perfil',
          component: () => import('@/views/docente/DocenteMiPerfil.vue'),
        },
      ],
    },
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
          path: 'cursos/nuevo',
          name: 'director-cursos-nuevo',
          component: () => import('@/views/director/CursoFormView.vue'),
        },
        {
          path: 'cursos/:id',
          name: 'director-curso-detalle',
          component: () => import('@/views/director/CursoDetalleView.vue'),
        },
        {
          path: 'planificaciones',
          name: 'director-planificaciones',
          component: () => import('@/views/director/PlanificacionesView.vue'),
        },
        {
          path: 'planificaciones/:id',
          name: 'director-planificacion-detalle',
          component: () => import('@/views/director/PlanificacionDetalleView.vue'),
        },
        {
          path: 'perfil',
          name: 'director-perfil',
          component: () => import('@/views/director/DirectorPerfilView.vue'),
        },
      ],
    },
  ],
})

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  const isAuthenticated = authStore.isAuthenticated
  const role = authStore.role

  if (to.path === '/login') {
    if (isAuthenticated) {
      if (role === 'docente') return next('/docente/inicio')
      if (['director', 'vicedirector', 'secretario'].includes(role ?? '')) return next('/director/inicio')
    }
    return next()
  }

  if (to.path.startsWith('/docente')) {
    if (!isAuthenticated || role !== 'docente') return next('/login')
    return next()
  }

  if (to.path.startsWith('/director')) {
    if (!isAuthenticated || !['director', 'vicedirector', 'secretario'].includes(role ?? '')) {
      return next('/login')
    }
    return next()
  }

  next()
})

export default router