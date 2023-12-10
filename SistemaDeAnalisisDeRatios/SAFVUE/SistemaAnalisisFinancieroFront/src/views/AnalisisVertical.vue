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
                        <p class="bg-white text-[20px] font-bold p-[20px]">Análisis Vertical</p>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->
                            
                                <div class="mt-[1%] bg-white w-[100%] m-auto rounded-[5px]">
                                    <div>
                                        <p class="text-lg font-semibold ml-[7.5%]">Parametros para el análisis</p>
                                    </div>
                                    <div
                                        class="flex justify-between items-end w-[100%] m-auto border-b-2 border-slate-200 mt-[1%] p-[1%]">
                                        <div class="flex-auto inline-block">
                                            <label for="empresas" class="inline-block mr-[5%]">Empresa</label>
                                            <select name="empresa" id="empresa"
                                                class="p-[5px] border border-slate-300 bg-white rounded-[5px] w-[50%]"
                                                v-model="parametrosAnalisis.empresa" @change="obtenerAniosDisponibles()">
                                                <option v-for="empresa in empresas" :key="empresa.id" :value="empresa.id">{{
                                                    empresa.nombre }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="flex-auto ">
                                            <label for="anio" class="inline-block mr-[5%]">Año</label>
                                            <select name="anio" id="anio"
                                                class="p-[5px] border border-slate-300 bg-white rounded-[5px] w-[50%]"
                                                v-model="parametrosAnalisis.anio">
                                                <option v-for="year in anios" :key="year.year" :value="year.year">{{
                                                    year.year }}
                                                </option>
                                            </select>
                                        </div>

                                        <div class="grow">
                                            <button type="button"
                                                class="block w-[70%] border border-esmerald-100 bg-emerald-500 text-white rounded-md p-[5px] transition duration-500 ease select-none hover:bg-esmerald-600 focus:outline-none focus:shadow-outline"
                                                @click="obtenerAnalisisVertical()">
                                                Realizar Análisis
                                            </button>
                                        </div>
                                    </div>

                                    <div class="flex justify-start gap-10 ml-[7%] mt-[2px] p-[5px]">
                                        <div :class="[verBalanceGeneral ? 'border-b-4 border-slate-600' : '']"
                                            class="cursor-pointer" @click="mostrarOcultarBalanceGeneral()">Balance General
                                        </div>
                                        <div :class="[verEstadoDeResultado ? 'border-b-4 border-slate-600' : '']"
                                            class="cursor-pointer" @click="mostrarOcultarEstadoResultado()">Estado de
                                            Resultado</div>
                                    </div>

                                    <div class="w-[100%] m-auto mt-[2%] mb-[2%] p-[4px]" v-if="verBalanceGeneral">
                                        <table class="w-[100%]">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cuenta</th>
                                                    <th>Valor Año {{ anioCabeceraTabla }}</th>
                                                    <th> Análisi Vertical</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center mt-[2px]"
                                                    v-for="registroAnalisisActivo in analisisActivos">
                                                    <td class="text-slate-500">{{ registroAnalisisActivo.id }}</td>
                                                    <td class="text-slate-500">{{
                                                        registroAnalisisActivo.cuenta_empresa.nombreCuenta }}</td>
                                                    <td class="text-slate-500">{{ registroAnalisisActivo.valorCuenta }}</td>
                                                    <td class="text-slate-500">{{
                                                        convertirValorAnalisisPorcentaje(registroAnalisisActivo.analisis_vertical[0].valorAnalisisVertical)
                                                    }}</td>
                                                </tr>
                                                <tr class="text-center">
                                                    <td class="text-slate-500"></td>
                                                    <td class="font-bold text-slate-500">Total Activos</td>
                                                    <td class="text-slate-500 font-bold text-bold text-center">{{
                                                        totalActivos }}</td>
                                                    <td class="text-slate-500 font-bold">100%</td>
                                                </tr>

                                                <tr class="text-center mt-[2px]"
                                                    v-for="registroAnalisisPasivo in analisisPasivos">
                                                    <td class="text-slate-500">{{ registroAnalisisPasivo.id }}</td>
                                                    <td class="text-slate-500">{{
                                                        registroAnalisisPasivo.cuenta_empresa.nombreCuenta }}</td>
                                                    <td class="text-slate-500">{{ registroAnalisisPasivo.valorCuenta }}</td>
                                                    <td class="text-slate-500">{{
                                                        convertirValorAnalisisPorcentaje(registroAnalisisPasivo.analisis_vertical[0].valorAnalisisVertical)
                                                    }}</td>
                                                </tr>

                                                <tr class="text-center">
                                                    <td class="text-slate-500"></td>
                                                    <td class="font-bold text-slate-500">Total Pasivo</td>
                                                    <td class="text-slate-500 font-bold text-bold text-center">{{
                                                        totalPasivos }}</td>
                                                    <td class="text-slate-500 font-bold">100%</td>
                                                </tr>

                                                <tr class="text-center mt-[2px]"
                                                    v-for="registroAnalisisPatrimonio in analisisPatrimonio"
                                                    v-if="analisisPatrimonio">
                                                    <td class="text-slate-500">{{ registroAnalisisPatrimonio.id }}</td>
                                                    <td class="text-slate-500">{{
                                                        registroAnalisisPatrimonio.cuenta_empresa.nombreCuenta }}</td>
                                                    <td class="text-slate-500">{{ registroAnalisisPatrimonio.valorCuenta }}
                                                    </td>
                                                    <td class="text-slate-500">{{
                                                        convertirValorAnalisisPorcentaje(registroAnalisisPatrimonio.analisis_vertical[0].valorAnalisisVertical)
                                                    }}</td>
                                                </tr>

                                                <tr class="text-center">
                                                    <td class="text-slate-500"></td>
                                                    <td class="font-bold text-slate-500">Total Patrimonio</td>
                                                    <td class="text-slate-500 font-bold text-bold text-center">{{
                                                        totalPatrimonio }}</td>
                                                    <td class="text-slate-500 font-bold">100%</td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>

                                    <!--Ver estado de Resultados-->

                                    <div class="w-[90%] m-auto mt-[2%] mb-[2%] p-[4px]" v-if="verEstadoDeResultado">
                                        <table class="w-[100%]">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Cuenta</th>
                                                    <th>Valor Año {{ anioCabeceraTabla }}</th>
                                                    <th> Análisis Vertical</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="text-center mt-[2px]"
                                                    v-for="registroIngreso in analisisIngresos">
                                                    <td class="text-slate-500"
                                                        v-if="registroIngreso.valorCuenta != totalVentas">{{
                                                            registroIngreso.id }}</td>
                                                    <td class="text-slate-500"
                                                        v-if="registroIngreso.valorCuenta != totalVentas">{{
                                                            registroIngreso.cuenta_empresa.nombreCuenta }}</td>
                                                    <td class="text-slate-500"
                                                        v-if="registroIngreso.valorCuenta != totalVentas">{{
                                                            registroIngreso.valorCuenta }}</td>
                                                    <td class="text-slate-500"
                                                        v-if="registroIngreso.valorCuenta != totalVentas">{{
                                                            convertirValorAnalisisPorcentaje(registroIngreso.analisis_vertical[0].valorAnalisisVertical)
                                                        }}</td>
                                                </tr>

                                                <tr class="text-center mt-[2px]" v-for="registroCosto in analisisCostos">
                                                    <td class="text-slate-500">{{ registroCosto.id }}</td>
                                                    <td class="text-slate-500">{{ registroCosto.cuenta_empresa.nombreCuenta
                                                    }}</td>
                                                    <td class="text-slate-500">{{ registroCosto.valorCuenta }}</td>
                                                    <td class="text-slate-500">{{
                                                        convertirValorAnalisisPorcentaje(registroCosto.analisis_vertical[0].valorAnalisisVertical)
                                                    }}</td>
                                                </tr>

                                                <tr class="text-center mt-[2px]" v-for="registroGasto in analisisGastos">
                                                    <td class="text-slate-500">{{ registroGasto.id }}</td>
                                                    <td class="text-slate-500">{{ registroGasto.cuenta_empresa.nombreCuenta
                                                    }}</td>
                                                    <td class="text-slate-500">{{ registroGasto.valorCuenta }}</td>
                                                    <td class="text-slate-500">{{
                                                        convertirValorAnalisisPorcentaje(registroGasto.analisis_vertical[0].valorAnalisisVertical)
                                                    }}</td>
                                                </tr>

                                                <tr class="text-center">
                                                    <td class="text-slate-500"></td>
                                                    <td class="font-bold text-slate-500">Ventas Totales</td>
                                                    <td class="text-slate-500 font-bold text-bold text-center">{{
                                                        totalVentas }}</td>
                                                    <td class="text-slate-500 font-bold">100%</td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                                <div>
                                </div>
                            
                        </section>
                    </div>
                </div>
            </main>
        </div>
    </div>
</template>

<script>
import axios from "axios";
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
            anios: [],
            empresas: [],
            parametrosAnalisis: { empresa: "", anio: "" },
            analisisActivos: [],
            totalActivos: 0,
            analisisPasivos: [],
            totalPasivos: 0,
            analisisPatrimonio: [],
            totalPatrimonio: 0,

            analisisIngresos: [],
            analisisCostos: [],
            analisisGastos: [],
            totalVentas: 0,
            verBalanceGeneral: true,
            verEstadoDeResultado: false,
            /*Gastos y costos queda pendiente */
        }
    },
    mounted() {
        //this.obtenerAniosDisponibles();
        this.obtenerEmpresasDisponibles();
    },
    methods: {
        //Obtener las empresas
        obtenerEmpresasDisponibles() {
            axios.get("api/obtener_empresas")
                .then((response) => {
                    this.empresas = response.data;
                    this.parametrosAnalisis.empresa = this.empresas[0].id;
                    this.obtenerAniosDisponibles();
                })
                .catch((response) => {
                    alert("Ocurrió un error");
                });
        },
        //Obtener
        obtenerAniosDisponibles() {
            axios.get("/api/obtener_anios_por_empresa",{params:{empresaId:this.parametrosAnalisis.empresa}})
                .then((response) => {
                    console.log(response.data);
                    this.anios = response.data;
                    this.parametrosAnalisis.anio = this.anios[0].year;
                })
                .catch((response) => {
                    console.log(response);
                });
        },
        obtenerAnalisisVertical() {
            axios.post("/api/realizar_analisis_vertical", this.parametrosAnalisis)
                .then((response) => {
                    this.analisisActivos = response.data.analisisActivos;
                    this.totalActivos = response.data.totalActivos;

                    setTimeout(() => {
                        this.analisisPasivos = response.data.analisisPasivos;
                        this.totalPasivos = response.data.totalPasivos;
                    }, 10);

                    setTimeout(() => {
                        this.analisisPatrimonio = response.data.analisisPatrimonio;
                        this.totalPatrimonio = response.data.totalPatrimonio;
                    }, 12);

                    setTimeout(() => {
                        this.analisisIngresos = response.data.analisisIngresos;
                        this.totalVentas = response.data.totalVentas;
                        console.log(this.analisisIngresos);
                    }, 14);
                    setTimeout(() => {
                        this.analisisCostos = response.data.analisisCostos;
                    }), 16;
                    setTimeout(() => {
                        this.analisisGastos = response.data.analisisGastos;
                    }, 18);

                })
                .catch(
                    ((response) => {
                        alert("Ocurrio un error...");
                    })
                );
        },
        convertirValorAnalisisPorcentaje(valorAnalisisVertical) {
            return (valorAnalisisVertical * 100).toFixed(2) + "%";
        },
        mostrarOcultarBalanceGeneral() {
            this.verBalanceGeneral = true;
            this.verEstadoDeResultado = false;
        },
        mostrarOcultarEstadoResultado() {
            this.verEstadoDeResultado = true;
            this.verBalanceGeneral = false;
        }
    }
}
</script>
