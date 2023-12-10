<template>
  <div
    class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700 transition hover:-translate-y-1 hover:scale-105 ease-in-out delay-100">
    <router-link class="block" to="/ratios_empresa_vs_promedio">
      <div class="px-5 pt-5">
        <header class="flex justify-between items-start mb-2">
          <!-- Icon -->
          <img src="../../images/icon-02.svg" width="32" height="32" alt="Icon 01" />
        </header>
        <h2 class="text-lg font-semibold text-slate-800 dark:text-slate-100 mb-2">Análisis de Ratios</h2>
        <div class="text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase mb-1">Visualización del estado de tu empresa respecto
          a otras del sector</div>
        <div class="flex items-start">
          <div class="text-3xl font-bold text-slate-800 dark:text-slate-100 mr-2">Promedio</div>
          <div class="text-sm font-semibold text-white px-1.5 bg-amber-500 rounded-full">+</div>
        </div>
      </div>
    </router-link>
    <!-- Chart built with Chart.js 3 -->
    <div class="grow max-sm:max-h-[128px] xl:max-h-[128px] mb-8">
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardCard02',
}
</script>