<template>
  <div
    class="col-span-full xl:col-span-6 bg-white dark:bg-slate-800 shadow-lg rounded-sm border border-slate-200 dark:border-slate-700">
    <header class="px-5 py-4 border-b border-slate-100 dark:border-slate-700">
      <h2 class="font-semibold text-slate-800 dark:text-slate-100">Gráfica de Variación</h2>
    </header>
    <div class="p-3">
      <header
        class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm font-semibold p-2">
        Ratios</header>
      <div>
        <router-link class="block" to="/variacion_ratios">
          <ul class="my-1">
            <!-- Item -->
            <li class="flex px-2">
              <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                  <path d="M18.3 11.3l-1.4 1.4 4.3 4.3H11v2h10.2l-4.3 4.3 1.4 1.4L25 18z" />
                </svg>
              </div>
              <div class="grow flex items-center border-b border-slate-100 dark:border-slate-700 text-sm py-2">
                <div class="grow flex justify-between">
                  <div class="self-center text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase mb-1">
                    Consulta la variación de los ratios en el tiempo
                  </div>
                  <div class="shrink-0 self-end ml-2">
                    <a class="font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400"
                      href="#"><span class="hidden sm:inline"> -&gt;</span></a>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </router-link>
      </div>
    </div>

    <div class="p-3">
      <header
        class="text-xs uppercase text-slate-400 dark:text-slate-500 bg-slate-50 dark:bg-slate-700 dark:bg-opacity-50 rounded-sm font-semibold p-2">
        Cuentas</header>
      <div>
        <router-link class="block" to="/variacion_cuentas">
          <ul class="my-1">
            <!-- Item -->
            <li class="flex px-2">
              <div class="w-9 h-9 rounded-full shrink-0 bg-indigo-500 my-2 mr-3">
                <svg class="w-9 h-9 fill-current text-emerald-50" viewBox="0 0 36 36">
                  <path d="M18.3 11.3l-1.4 1.4 4.3 4.3H11v2h10.2l-4.3 4.3 1.4 1.4L25 18z" />
                </svg>
              </div>
              <div class="grow flex items-center border-b border-slate-100 dark:border-slate-700 text-sm py-2">
                <div class="grow flex justify-between">
                  <div class="self-center text-xs font-semibold text-slate-400 dark:text-slate-500 uppercase mb-1">
                    Consulta la variación de las cuentas en el tiempo
                  </div>
                  <div class="shrink-0 self-end ml-2">
                    <a class="font-medium text-indigo-500 hover:text-indigo-600 dark:hover:text-indigo-400"
                      href="#0"><span class="hidden sm:inline"> -&gt;</span></a>
                  </div>
                </div>
              </div>
            </li>
          </ul>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'DashboardCard05',
}
</script>