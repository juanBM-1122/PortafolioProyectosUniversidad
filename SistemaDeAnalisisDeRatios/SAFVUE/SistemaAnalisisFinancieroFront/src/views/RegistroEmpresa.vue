<script setup>
import { readonly } from "vue";
import api_url from "../constants";
</script>
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
                        <h2 class="text-lg font-semibold text-slate-800 mb-2">REGISTRO DE EMPRESAS</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->
                            <form class="container bg-white w-auto max-w-[1200px] m-8 lg:mx-auto p-2"
                                @submit.prevent="agregar">
                                <label for="viñeta" class="w-1/4 text-dark-900 text-right pr-4 font-bold">Informacion
                                    general de la
                                    empresa:</label>
                                <hr class="my-4 border-t-2 border-black">
                                <div name="control-parametros" class="flex justify-center flex-wrap space-y-4">
                                    <div class="w-full lg:w-1/2 flex items-center">
                                        <label for="nombreEmpresa"
                                            class="w-1/2 rounded-md text-gray-500 text-right pr-2">Nombre:</label>
                                        <div class="w-3/4">
                                            <input type="text" id="nombreEmpresa" v-model="nombreEmpresa"
                                                 required
                                                class="w-1/2 rounded-md border-0 py-2  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600"
                                                placeholder="Nombre Empresa" />
                                        </div>
                                    </div>
                                    <div class="w-full lg:w-1/2 flex items-center">
                                        <label for="sector"
                                            class="w-1/2 rounded-md text-gray-500 text-right pr-2">Sector:</label>
                                        <!-- Ajustar pr-2 para dejar espacio del mismo lado que el select -->
                                        <div class="w-3/4 flex items-center">
                                            <select id="seleccionarSector" v-model="seleccionarSector"
                                                 required
                                                class="w-1/2 rounded-md border-0 py-2  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                <option value="" disabled>Selecciona un sector</option>
                                                <option v-for="seleccionarSector in listaSector" :key="seleccionarSector.id"
                                                    :value="seleccionarSector.id">{{ seleccionarSector.nombre }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div>
                                    <label for="viñeta" class="w-1/4 text-dark-900 text-right pr-4 font-bold">Catálogo de
                                        Cuentas</label>
                                    <hr class="my-4 border-t-2 border-black">
                                </div>
                                <!--contenedor de estados financieros-->
                                <div class="grid grid-cols-2">
                                    <!--Cuentas de balance-->
                                    <div id="cuentas-balance" class="shadow m-4 p-2">
                                        <h4 class="font-bold text-center">Cuentas de Balance General</h4>

                                        <div id="activos" class="m-4">
                                            <div class="w-full text-center font-bold">Activos</div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaActivos"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaActivos[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                                                </div>
                                                <div class="w-fit flex items-center group">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaActivos[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.activos" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                        <!-- Agrega más opciones de sectores según tus necesidades -->
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaActivos, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaActivos, 1)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>

                                        <div id="pasivos" class="m-4">
                                            <div class="w-full text-center"><span class="font-bold">Pasivos</span></div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaPasivos"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaPasivos[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />

                                                </div>
                                                <div class="w-fit flex items-center">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaPasivos[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.pasivos" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaPasivos, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaPasivos, 1)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div id="patrimonio" class="m-4">
                                            <div class="w-full text-center"><span class="font-bold">Patrimonio</span></div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaPatrimonio"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaPatrimonio[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                                                </div>
                                                <div class="w-fit flex items-center group">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaPatrimonio[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.patrimonio" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                        <!-- Agrega más opciones de sectores según tus necesidades -->
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaPatrimonio, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaPatrimonio, 1)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!--Cuentas de resultados-->
                                    <div id="cuentas-balance" class="shadow m-4 p-2">
                                        <h4 class="font-bold text-center">Cuentas de Resultados</h4>

                                        <div id="ingresos" class="m-4">
                                            <div class="w-full text-center"><span class="font-bold">Ingresos</span></div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaIngresos"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaIngresos[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                                                </div>
                                                <div class="w-fit flex items-center">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaIngresos[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.ingresos" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                        <!-- Agrega más opciones de sectores según tus necesidades -->
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaIngresos, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaIngresos, 2)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>

                                        <div id="gastos" class="m-4">
                                            <div class="w-full text-center"><span class="font-bold">Gastos</span></div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaGastos"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaGastos[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                                                </div>
                                                <div class="w-fit flex items-center">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaGastos[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.gastos" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                        <!-- Agrega más opciones de sectores según tus necesidades -->
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaGastos, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaGastos, 2)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>

                                        </div>

                                        <hr>

                                        <div id="costos" class="m-4">
                                            <div class="w-full text-center"><span class="font-bold">Costos</span></div>
                                            <div class="grid grid-cols-2 gap-2 py-1">
                                                <div class="text-center font-semibold">
                                                    Nombre de la cuenta
                                                </div>
                                                <div class="text-center font-semibold">
                                                    Equivalente en catalogo base
                                                </div>
                                            </div>
                                            <div v-for="cuenta, index in cuentaEmpresaCostos"
                                                class="grid grid-cols-2 gap-2 py-1 group">
                                                <div class="w-fit">
                                                    <input type="text" id="input3"
                                                        v-model="cuentaEmpresaCostos[index].nombre" required
                                                        placeholder="A.a.1 Caja" :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                                                </div>
                                                <div class="w-fit flex items-center">
                                                    <select id="seleccionarCuenta "
                                                        v-model="cuentaEmpresaCostos[index].cuenta_id" required
                                                        :disabled="false"
                                                        class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                                        <option value="" disabled>Nombre de Cuenta</option>
                                                        <option v-for=" cuenta in  listaCuentas.costos" :key="cuenta.id"
                                                            :value="cuenta.id">{{
                                                                cuenta.id }} {{ cuenta.nombre }}
                                                        </option>
                                                        <!-- Agrega más opciones de sectores según tus necesidades -->
                                                    </select>
                                                    <button type="button"
                                                        @click="removeCuentaEmpresaFromList(cuentaEmpresaCostos, cuenta)"
                                                        class="opacity-0 group-hover:opacity-100">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="red"
                                                            class="w-6 h-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="w-full mx-2 flex justify-between">
                                                <div class="flex">
                                                    <button
                                                        class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                                                        type="button" @click="addCuentaEmpresa(cuentaEmpresaCostos, 2)">
                                                        Agregar cuenta+
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <!--Inputs de cuentas-->
                                <div name="control-parametros" class="">
                                    <div class="w-full mx-2 flex justify-center">
                                        <button
                                            class="bg-blue-500 text-white hover:bg-blue-700 active:bg-blue-800 py-3 px-8 rounded mr-2"
                                             @click="guardarCuentaEmpresa">Guardar
                                            empresa</button>
                                        <button
                                            class="bg-red-500 text-white hover:bg-red-700 active:bg-red-800 py-3 px-8 rounded"
                                            type="button" @click="limpiarFormulario">Cancelar</button>
                                    </div>
                                </div>
                            </form>
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
import { showMessages } from '../components/toast.js'
import { useToast } from 'vue-toastification';

const toast = useToast();

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
            nombreEmpresa: '',
            listaSector: [],
            seleccionarSector: '',
            listaCuentas: [],
            seleccionarTipoEstadoFinanciero: '',
            listadeEstadosFinancieros: [],
            empresas: null,
            cuentaEmpresaActivos: [],
            cuentaEmpresaPasivos: [],
            cuentaEmpresaPatrimonio: [],
            cuentaEmpresaIngresos: [],
            cuentaEmpresaGastos: [],
            cuentaEmpresaCostos: [],
        };
    },
    methods: {
        removeCuentaEmpresaFromList(listaCuentaEmpresa, cuenta_a_eliminar) {

            let posicion = listaCuentaEmpresa.indexOf(cuenta_a_eliminar);
            listaCuentaEmpresa.splice(posicion, 1);

        },
        addCuentaEmpresa(listaDestino, tipo_estado_financiero) {
            let cuentaEmpresa = {
                id: listaDestino.length + 1,
                cuenta_id: "",
                nombre: "",
                tipo_estado_financiero_id: tipo_estado_financiero,
                empresa_id: this.empresas
            }
            listaDestino.push(cuentaEmpresa);
        },
        guardarCuentaEmpresa() {
            const params = {
                nombreEmpresa: this.nombreEmpresa,
                sectorEmpresa: this.seleccionarSector,
                cuentasActivos: this.cuentaEmpresaActivos,
                cuentasPasivos: this.cuentaEmpresaPasivos,
                cuentasPatrimonio: this.cuentaEmpresaPatrimonio,
                cuentasIngresos: this.cuentaEmpresaIngresos,
                cuentasGastos: this.cuentaEmpresaGastos,
                cuentasCostos: this.cuentaEmpresaCostos,
            }
            //console.log(params)
            axios.post(api_url + 'cuenta_empresas', params)
                .then(response => {
                    //alert('Empresa registrada correctamente');
                    showMessages(true,"Empresa registrada correctamente")
                    this.$router.push('/');
                    this.$router.got(-1);
                })
                .catch(error => {
                    console.log(error);
                    //showMessages(false,"Error al registrar empresa")
                });
        },

        limpiarFormulario() {
            // Restablece los valores iniciales de los campos
            this.nombreEmpresa = '';
            this.seleccionarSector = '';
            this.seleccionarClasecuentas = '';
            this.seleccionarsubCuenta = '';
            this.seleccionarCuenta = '';
            // Habilita todos los campos nuevamente
            this.camposDeshabilitados = false;
        },

        getTipoFinanciero() {

            // Realiza una solicitud para obtener las subcuentas relacionadas con la clase de cuenta seleccionada
            axios.get(api_url + 'tipo_estado_financieros').then((response) => {
                this.listadeEstadosFinancieros = response.data;
            })
                .catch((error) => {

                });

        },
        getCuenta() {
            axios.get(api_url + 'cuentas_por_clase').then(
                (response) => {
                    this.listaCuentas = response.data.cuentas;
                    /*this.listaCuentas.activos.forEach(activo => {
                        let cuentaEmpresa = {
                            cuenta_id: activo.id,
                            nombre: activo.nombre,
                            tipo_estado_financiero_id: 1,
                            empresa_id: this.empresas
                        }
                        this.cuentaEmpresaActivos.push(cuentaEmpresa);
                    })*/
                    this.setCuentaEmpresaInicial(this.listaCuentas.activos, 1, this.cuentaEmpresaActivos);
                    this.setCuentaEmpresaInicial(this.listaCuentas.pasivos, 1, this.cuentaEmpresaPasivos);
                    this.setCuentaEmpresaInicial(this.listaCuentas.patrimonio, 1, this.cuentaEmpresaPatrimonio);
                    this.setCuentaEmpresaInicial(this.listaCuentas.ingresos, 2, this.cuentaEmpresaIngresos);
                    this.setCuentaEmpresaInicial(this.listaCuentas.gastos, 2, this.cuentaEmpresaGastos);
                    this.setCuentaEmpresaInicial(this.listaCuentas.costos, 2, this.cuentaEmpresaCostos);

                }
            ).catch((error) => {
                console.log(error)
            });

        },
        setCuentaEmpresaInicial(listaCuentas, tipo_estado_financiero, destino) {
            let i = 0;
            listaCuentas.forEach(cuenta => {
                let cuentaEmpresa = {
                    id: i,
                    cuenta_id: cuenta.id,
                    nombre: cuenta.nombre,
                    tipo_estado_financiero_id: tipo_estado_financiero,
                    empresa_id: this.empresas
                }
                destino.push(cuentaEmpresa);
                i++;
            })
        },
        getSector() {
            axios.get(api_url + 'sectorempresas').then(
                (response) => {
                    this.listaSector = response.data;

                }
            ).catch((error) => {
                console.log(error)
            });

        },
    },
    created() {
    },
    mounted() {
        this.getSector();
        this.getCuenta()
        this.getTipoFinanciero();
    },
};
</script>
  