<template>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />
        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    <div class="px-5 pt-5">
                        <h2 class="text-lg font-semibold text-slate-800 mb-2">TITULO DE LA PAGINA</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->
                            <label>hola mundo aksja</label>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'
import { ref } from 'vue'

export default {
    components: {
        Sidebar,
        Header
    },
    setup() {
        const sidebarOpen = ref(false)
        return {
            sidebarOpen,
        }
    },
}
</script>