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
                        <h2 class="text-lg font-semibold text-slate-800 mb-2 dark:text-slate-100">Análisis de Ratios:
                            Empresas vs Sector</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded dark:bg-slate-800">
                            <!--Controles-->
                            <div name="control-parametros" class="flex justify-center">
                                <div class="flex mx-2 items-center">
                                    <label for="empresa" class="mx-1 text-gray-500">Sector</label>
                                    <select name="empresa" id="empresa" v-model="sector" @change="getYearsDisponibles()"
                                        class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="" disabled selected>Seleccione Sector</option>
                                        <option v-for="sector in sectoresList" :value="sector.id">{{ sector.nombre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="flex w-fit mx-2 items-center">
                                    <label for="inicio" class="mx-1 text-gray-500">Año</label>
                                    <select name="inicio" id="inicio" v-model="year"
                                        class="mx-1 w-fit rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="" disabled selected>Año</option>
                                        <option v-for="year in aniosList" :value="year.year">{{ year.year }}</option>
                                    </select>
                                </div>

                                <div class="mx-2">
                                    <button
                                        class="bg-emerald-400 text-white hover:bg-emerald-600 active:bg-emerald-700 p-2 rounded"
                                        @click="getRatiosEmpresasVsSector()">Realizar
                                        análisis</button>
                                </div>

                            </div>
                            <hr class="my-4">
                            <!--Tabla-->
                            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 border my-4 dark:bg-slate-800 dark:border-slate-700">

                                <caption class="text-white font-bold bg-emerald-400 p-2">Ratios Empresas vs Sector</caption>
                                <thead>
                                    <tr class="text-gray-900 dark:text-slate-100">
                                        <th scope="col" class="px-6 py-4 font-medium">Ratio</th>
                                        <th v-for="empresa in empresas" scope="col"
                                            class="px-6 py-4 font-medium">
                                            {{ empresa.nombre }}</th>
                                        <th scope="col" class="px-6 py-4 font-medium">Sector: {{ nombre_sector
                                        }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="ratio in ratiosPorTipo" class="border-b hover:bg-slate-100 dark:hover:bg-slate-700 dark:text-slate-100 dark:border-slate-700">
                                        <td class="px-6 py-4">{{ ratio.nombreRatio }}</td>
                                        <td class="px-6 py-4" v-for="valor, index in ratio.valores">
                                            <span class="p-1"
                                                :class="{ 'bg-green-200 rounded-md text-emerald-800 font-bold': valor.evaluacionVsSector, 'bg-red-200 rounded-md text-red-800 font-bold': (!valor.evaluacionVsSector && index < ratio.valores.length - 1) }">{{
                                                    Number(valor.valor).toFixed(2) }}</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

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
import { ref } from 'vue'
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'

export default {
    data() {
        return {
            empresas: [],
            ratiosPorTipo: [],

            sectoresList: [],
            aniosList: [],
            year: "",
            sector: "",
            nombre_sector: ""
        }
    },
    components: {
        Sidebar,
        Header
    },
    setup() {
        const sidebarOpen = ref(true)
        return {
            sidebarOpen,
        }
    },
    methods: {
        getRatiosEmpresasVsSector() {
            const params = {
                'sector': this.sector,
                'year': this.year
            }
            axios.post(api_url + 'obtener_ratios_empresa_vs_sector', params).then(
                (response) => {
                    this.ratiosPorTipo = response.data.ratiosPorTipo
                    this.empresas = response.data.empresas
                    console.log(this.getNombreSector())
                }
            ).catch(
                (error) => {

                }
            )
        },
        getSectores() {
            axios.get(api_url + 'obtener_sectores').then(
                (response) => {
                    this.sectoresList = response.data.sectores
                }
            ).catch((error) => {

            });

        },
        getYearsDisponibles() {
            axios.get(api_url + 'obtener_years').then(
                (response) => {
                    this.aniosList = response.data.years
                }
            ).catch((error) => {

            });
        },
        getNombreSector() {
            this.nombre_sector = this.sectoresList.find(element => element.id == this.sector).nombre;
        }
    },
    mounted() {
        this.getYearsDisponibles();
        //this.getRatiosEmpresasVsSector();
        this.getSectores();
    },
    created() {
    }
}
</script>