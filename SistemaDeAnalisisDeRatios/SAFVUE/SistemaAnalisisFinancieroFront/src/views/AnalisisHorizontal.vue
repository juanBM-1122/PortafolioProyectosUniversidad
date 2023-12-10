<script setup>
import api_url from "../constants";
</script>
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
                        <h2 class="text-lg font-semibold text-slate-800 mb-2 dark:text-slate-100">ANÁLISIS HORIZONTAL</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded dark:bg-slate-800">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->

                            <!--Controles-->
                            <div name="control-parametros" class="flex justify-center">
                                <div class="flex mx-2 items-center">
                                    <label for="empresa" class="mx-1 text-gray-500">Empresa</label>
                                    <select name="empresa" id="empresa" v-model="empresa" @change="getYearsDisponibles()"
                                        class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="" disabled selected>Seleccione Empresa</option>
                                        <option v-for="empresa in empresasList" :value="empresa.id">{{ empresa.nombre }}
                                        </option>
                                    </select>
                                </div>
                                <div class="flex w-fit mx-2 items-center">
                                    <label for="inicio" class="mx-1 text-gray-500">Periodo</label>
                                    <select name="inicio" id="inicio" v-model="yearInicial"
                                        @change="sincronizarListasAnios()"
                                        class="mx-1 w-fit rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="" disabled selected>Año Inicio</option>
                                        <option v-for="year in listaAniosInicio" :value="year.year">{{ year.year }}</option>
                                    </select>
                                    <select name="fin" id="fin" v-model="yearFinal"
                                        class="mx-1 w-fit rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                        <option value="" disabled selected>Año Fin</option>
                                        <option v-for="year in listaAniosFin" :value="year.year">{{ year.year }}</option>
                                    </select>
                                </div>

                                <div class="mx-2">
                                    <button
                                        class="bg-emerald-400 text-white hover:bg-emerald-600 active:bg-emerald-700 p-2 rounded"
                                        @click="getAnalisisHorizontal()">Realizar
                                        análisis</button>
                                </div>

                            </div>
                            <hr class="my-4">
                            <!--Tabla-->
                            <table v-for="analisisHorizontal in analisisHorizontalList"
                                class="w-full border-collapse bg-white text-left text-sm text-gray-500 border my-4 dark:bg-slate-800 dark:text-slate-100 dark:border-slate-700">

                                <caption class="text-white font-bold bg-emerald-400 p-2">Análisis Horizontal {{
                                    analisisHorizontal.anio_1 }} -
                                    {{
                                        analisisHorizontal.anio_2 }}</caption>
                                <thead class="text-gray-900 dark:text-slate-100">
                                    <tr class="dark:text-slate-100">
                                        <th scope="col" class="px-6 py-4 font-medium">N</th>
                                        <th scope="col" class="px-6 py-4 font-medium">Cuenta</th>
                                        <th scope="col" class="px-6 py-4 font-medium">{{
                                            analisisHorizontal.anio_1 }}</th>
                                        <th scope="col" class="px-6 py-4 font-medium">{{
                                            analisisHorizontal.anio_2 }}</th>
                                        <th scope="col" class="px-6 py-4 font-medium">V. Absoluta</th>
                                        <th scope="col" class="px-6 py-4 font-medium">V. Relativa</th>
                                    </tr>
                                </thead>
                                <tbody v-for="valores, index in analisisHorizontal.seccion">
                                    <tr v-for="valor, i in valores" class="hover:bg-slate-100 dark:hover:bg-slate-600"
                                        v-bind:class="{ 'bg-slate-400 text-white hover:text-gray-400 dark:bg-slate-700': i == valores.length - 1 }">
                                        <td class="px-6 py-4">{{ index + 1 }} {{ i + 1 }}</td>
                                        <td class="px-6 py-4">{{ valor.nombre_cuenta }}</td>
                                        <td class="px-6 py-4">{{ valor.valor_anio_uno }}</td>
                                        <td class="px-6 py-4">{{ valor.valor_anio_dos }}</td>
                                        <td class="px-6 py-4">{{ Number(valor.variacion_absoluta).toFixed(2) }}</td>
                                        <td class="px-6 py-4">{{ Number(valor.variacion_relativa).toFixed(2) }}%</td>
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
    data() {
        return {
            empresasList: [],
            aniosList: [],
            listaAniosInicio: [],
            listaAniosFin: [],
            empresa: "",
            yearInicial: "",
            yearFinal: "",
            analisisHorizontalList: []
        }
    },

    methods: {
        getAnalisisHorizontal() {
            const params = {
                empresa: this.empresa,
                yearInicial: this.yearInicial,
                yearFinal: this.yearFinal
            }
            axios.post(api_url + 'analisis_horizontal', params).then(
                (response) => {
                    this.analisisHorizontalList = response.data.analisisHorizontalList;
                }
            ).catch((error) => {

            });
        },
        getEmpresas() {
            axios.get(api_url + 'empresas').then(
                (response) => {
                    this.empresasList = response.data;
                    this.empresa = this.empresasList[0].id
                    this.getYearsDisponibles();
                }
            ).catch((error) => {

            });

        },
        getYearsDisponibles() {
            const params = {
                empresa: this.empresa,
            }
            axios.post(api_url + 'obtener_years_empresa', params).then(
                (response) => {
                    this.aniosList = response.data.years
                    this.listaAniosInicio = Array.from(response.data.years)
                    this.listaAniosFin = Array.from(response.data.years)
                    this.listaAniosInicio.splice(this.listaAniosInicio.length - 1, 1);
                    this.listaAniosFin.splice(this.listaAniosFin[0], 1);
                }
            ).catch((error) => {

            });
        },
        sincronizarListasAnios() {
            this.listaAniosFin = this.aniosList.filter(item => item.year > this.yearInicial);
        }
    },
    mounted() {
        //this.getAnalisisHorizontal();
        this.getEmpresas();
        this.getYearsDisponibles();
        //this.sincronizarListasAnios();
    },
    created() {
    }
}
</script>