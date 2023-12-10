import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'dashboard',
      component: () => import('../views/Dashboard.vue')
    },
    {
      path: '/plantilla',
      name: 'plantilla',
      component: () => import('../views/PLANTILLA.vue')
    },
    {
      path: '/analisis_horizontal',
      name:'analisisHorizontal',
      component: () => import('../views/AnalisisHorizontal.vue')
    },
    {
      path: "/analisis_vertical",
      name:"analisisVertical",
      component: () => import("../views/AnalisisVertical.vue")
    },
    {
      path: '/ratios_empresa_vs_sector',
      name: 'analisisRatioEmpresaVsSector',
      component: ()=> import('../views/RatioEmpresaVsRatioSector.vue')
    },
    {
      path: '/ratios_empresa_vs_promedio',
      name: 'analisisRatioEmpresaVsPromedio',
      component: ()=> import('../views/RatioEmpresaVsRatioPromedio.vue')
    },
    {
      path: '/gestion_sectores',
      name:'gestion_sectores',
      component: () => import('../views/GestionSectores.vue')
    },
    {
      path: '/registro_ratios_por_sector',
      name:'registro_ratios_por_sector',
      component: () => import('../views/RegistroRatiosPorSector.vue')
    },
    {
      path: '/variacion_cuentas',
      name:'variacion_cuentas',
      component: () => import('../views/variacionCuentas.vue')
    },
    {
      path: '/variacion_ratios',
      name:'variacion_ratios',
      component: () => import('../views/variacionRatios.vue')
    },
    {
      path: '/ingresar_estados_financieros',
      name:'ingresos_estados_financieros',
      component: () => import('../views/IngresoEstadosFinancieros.vue')
    },
    {
      path:'/registrar_estados_financieros',
      name:"registrar_estados_financieros",
      component: ()=> import("../views/RegistrarEstadosFinancieros.vue")
    },
    {
      path: '/registro_empresa',
      name:'registroempresa',
      component: () => import('../views/RegistroEmpresa.vue')
    }
  ]
})

export default router
