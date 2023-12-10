<template>
    <div class="flex h-screen overflow-hidden dark:bg-slate-700">
        <!-- Sidebar -->
        <Sidebar :sidebarOpen="sidebarOpen" @close-sidebar="sidebarOpen = false" />
        <!-- Content area -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">
            <!-- Site header -->
            <Header :sidebarOpen="sidebarOpen" @toggle-sidebar="sidebarOpen = !sidebarOpen" />
            <main>
                <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
                    <div class="px-5 pt-5">
                        <h2 class="text-lg font-semibold text-slate-800 mb-2 dark:text-slate-100">REGISTRO DE RATIOS POR SECTOR</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded dark:bg-slate-800">
                            <label for="" class="text font-semibold dark:text-slate-100">Información general</label>

                            <div class="py-4">
                                <div class="py-4">
                                    <label for="sector" class="mx-1 text-black dark:text-slate-100">Sector: </label>

                                    <select name="sector" id="sector" v-model="selectedSector" class="border rounded px-8 py-1 text-left">
                                        <option value="" disabled>Seleccionar sector</option>
                                        <option v-for="sector in sectoresList" :value="sector.id">{{ sector.nombre }}</option>
                                    </select>
                                </div>
                            </div>

                            <hr class="my-4">
                            <!--Tabla-->
                            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 border my-4 dark:bg-slate-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-slate-100">#</th>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-slate-100">Nombre del Ratio</th>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-slate-100">Valor Sector</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ratio, index) in ratiosList" :key="ratio.id">
                                        <td class="px-6 py-4 text-ms dark:text-slate-100">{{ index + 1 }}</td>
                                        <td class="px-6 py-4 text-ms dark:text-slate-100">{{ ratio.nombre }}</td>
                                        <td class="px-6 py-4 text-ms ">
                                            <input type="number" v-model.number="ratio.valor" class="border rounded px-2 py-1">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-center space-x-6">
                                <button @click="saveRatios"
                                    class="bg-blue-600 hover:bg-blue-500 text-white active:bg-blue-700 px-6 py-2 rounded">
                                    Guardar
                                </button>

                                <router-link to="/"
                                    class="bg-red-600 text-white hover:bg-red-500 active:bg-red-700 py-2 px-6 rounded">
                                    Cancelar
                                </router-link>
                            </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>



<script>
import axios from 'axios'
import api_url from "../constants";
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'
import { ref } from 'vue'

export default {
    data() {
        return {
            sectoresList: [],
            ratiosList: [],
            selectedSector: '',
            isUpdating: false,
        }
    },

    methods: {

        getSectores() {
            axios.get(api_url + 'obtener_sectores').then(
                (response) => {
                    this.sectoresList = response.data.sectores
                }
            ).catch((error) => {
                console.log(error);
            });
        },

        getRatiosForSector() {
            if (this.selectedSector) {
                axios.get(api_url + 'ratios', { params: { sector_id: this.selectedSector } }).then(
                    (response) => {
                        this.ratiosList = response.data.ratios
                        this.isUpdating = this.ratiosList.length > 0;
                    }
                ).catch((error) => {
                    console.log(error);
                });
            } else {
                this.ratiosList = [];
                this.isUpdating = false;
            }
        },

        saveRatios() {
            // Preparar los datos para enviar a la API
            const data = this.ratiosList.map(ratio => ({
                id: ratio.id,
                //sector_id: this.selectedSector,
                valor: ratio.valor,
                ratio_id: ratio.ratio_id,
            }));

            axios.post(api_url + 'guardar_editar_ratio', { valoresSectorRatio: data, sector_id: this.selectedSector }).then(
                (response) => {
                    console.log(response.data.valores);
                    this.getRatiosForSector();
                }
            ).catch((error) => {
                console.log(error);
            });
        },

        formatNumber(value){
            return Number(value).toFixed(2);
        },

    },

    watch: {
        selectedSector() {
            this.getRatiosForSector();
        },
    },

    mounted() {
        this.getSectores();
    },

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