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
                        <h2 class="text-lg font-semibold text-slate-800 mb-2 dark:text-slate-100">VARIACIONES DE CUENTAS</h2>
                        <section class="container bg-white dark:bg-slate-800 w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->
                                <!--Controles-->
                                <div name="control-parametros" class="flex justify-center">
                                    <div class="flex mx-2 items-center">
                                        <label for="empresa" class="mx-1 text-gray-500">Empresa</label>
                                        <select name="empresa" id="empresa" v-model="empresa" @change="onChangeEmpresa()"
                                            class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                            <option value="" disabled selected>Seleccione Empresa</option>
                                            <option v-for="empresa in empresasList" :value="empresa.id">{{ empresa.nombre }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex mx-2 items-center">
                                        <label for="cuenta" class="mx-1 text-gray-500">Cuenta</label>
                                        <select name="cuenta" id="cuenta" v-model="cuenta"
                                            class="w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                            <option value="" disabled selected>Seleccione cuenta</option>
                                            <option v-for="cuenta in cuentas" :value="cuenta.id">{{ cuenta.nombreCuenta }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="flex w-fit mx-2 items-center">
                                        <label for="inicio" class="mx-1 text-gray-500">Periodo</label>
                                        <select name="inicio" id="inicio" v-model="yearInicial"
                                            @change="sincronizarListasAnios()"
                                            class="mx-1 w-fit rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                            <option value="" disabled selected>Año Inicio</option>
                                            <option v-for="year in listaAniosInicio" :value="year.year">{{ year.year }}
                                            </option>
                                        </select>
                                        <select name="fin" id="fin" v-model="yearFinal"
                                            class="mx-1 w-fit rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                            <option value="" disabled selected>Año Fin</option>
                                            <option v-for="year in listaAniosFin" :value="year.year">{{ year.year }}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="mx-2">
                                        <button
                                            class="bg-emerald-400 text-white hover:bg-emerald-600 active:bg-emerald-700 p-2 rounded"
                                            @click="getValoresCuenta()">
                                            Obtener Datos
                                        </button>
                                    </div>

                                </div>
                                <hr class="my-4">
                                <!--Grafico-->
                                <div v-if="data.length>0" class="flex justify-center dark:text-slate-100">
                                    <h2>{{ empresa.nombre }}</h2>
                                    <h3 class="font-semibold">Variacion de la cuenta {{ nombreCuenta }}</h3>
                                </div>
                                <div class="flex justify-center dark:text-white">
                                    <Chart v-if="data.length > 0" :data="data" :margin="margin" :direction="direction" :axis="axis">

                                        <template #layers>
                                            <Grid strokeDasharray="2,2" class="dark:stroke-white"/>
                                            <Line :dataKeys="['year', 'valor']" :lineStyle="{class:'dark:stroke-emerald-500'}" :dotStyle="{class:'dark:stroke-emerald-500'}" />
                                        </template>

                                        <template #widgets>
                                            <Tooltip color="gray" :config="{
                                                name: { hide: true },
                                                year: { label: 'Año', color: '#0077b6', format: (value) => { return value } },
                                                valor: { label: 'valor ($)' },
                                                inc: { hide: true },
                                            }" />
                                        </template>

                                    </Chart>
                                </div>
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>
  
<script lang="ts">
import axios from 'axios'
import { defineComponent, ref } from 'vue'
import { Chart, Grid, Line, Tooltip } from 'vue3-charts'
import api_url from "../constants";
// para sidebar
import Sidebar from '../partials/Sidebar.vue'
import Header from '../partials/Header.vue'
//import { ref } from 'vue'

export default defineComponent({
    name: 'LineChart',
    components: {
        Chart, Grid, Line, Tooltip, Sidebar,
        Header
    },
    setup() {
        const sidebarOpen = ref(false)
        //const data = ref(plByMonth)
        const direction = ref('horizontal')
        const margin = ref({
            left: 0,
            top: 20,
            right: 20,
            bottom: 0
        })

        const axis = ref({
            primary: {
                type: 'band',
            },
            secondary: {
                domain: ['dataMin', 'dataMax + 100'],
                type: 'linear',
                ticks: 8,
                format: (value) => {
                    return value = "$ " + value
                }
            }
        })

        return { direction, margin, axis, sidebarOpen }
    },
    data() {
        return {
            data: [],
            cuentas: [],
            empresasList: [],
            aniosList: [],
            listaAniosInicio: [],
            listaAniosFin: [],
            empresa: "",
            cuenta: "",
            yearInicial: "",
            yearFinal: "",
            nombreCuenta: ''

        }
    },
    mounted() {
        this.data = []
        this.getEmpresas();
        this.getYearsDisponibles();
    },
    methods: {
        getValoresCuenta() {
            const params = {
                empresa: this.empresa,
                cuenta: this.cuenta,
                inicio: this.yearInicial,
                fin: this.yearFinal
            }
            axios.post(api_url + 'obtener_valores_cuenta_empresa', params).then(
                (response) => {
                    this.data = response.data.valoresCuenta
                    this.nombreCuenta = response.data.cuenta.nombreCuenta
                }
            ).catch(
                (error) => {

                }
            )
        },
        getCuentas() {
            const params = {
                empresa: this.empresa
            }
            axios.post(api_url + 'obtener_cuentas_empresa', params).then(
                (response) => {
                    this.cuentas = response.data.cuentas
                }
            ).catch(
                (error) => {

                }
            )
        },
        getEmpresas() {
            axios.get(api_url + 'empresas').then(
                (response) => {
                    this.empresasList = response.data;
                    this.empresa = this.empresasList[0].id
                    this.getYearsDisponibles();
                    this.getCuentas();
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
        },
        onChangeEmpresa() {
            this.getYearsDisponibles();
            this.getCuentas();
        }
    }
})
</script>