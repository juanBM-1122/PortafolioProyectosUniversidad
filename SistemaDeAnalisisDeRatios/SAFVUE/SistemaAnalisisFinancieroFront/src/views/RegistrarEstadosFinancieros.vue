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
                        <p class="bg-white text-[20px] font-bold p-[20px]">Registro de Estados Financieros</p>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded">
                            <!-- AQUI TODO EL CONTENIDO, AJUSTAR O QUITAR SOMBRAS, MARGIN, PADDING, ETC -->
                            <main>
        <div class="bg-white w-[100%] m-auto mt-[2%] rounded-sm mb-[5%]">

            <div class="border-b-4 border-slate-100 p-[5px] m-auto w-[100%] ">

                <div class="flex justify-around p-[5px]">
                    <div class="grow">
                        <label for="empresa">Empresa</label>
                        <select name="empresa" id="empresa" v-model="empresaID"
                            class="p-[5px] border border-slate-300 bg-white rounded-[5px] ml-[5%] w-[60%]"
                            @change="obtenerEmpresasHijo">
                            <option v-for="empresa in listaEmpresas" :value="empresa.id">{{ empresa.nombre }}</option>
                        </select>
                    </div>
                    <div class="grow">
                        <label for="anio">Año de los estados financieros</label>
                        <select name="anio" id="anio" v-model="year"
                            class="p-[5px] border border-slate-300 bg-white rounded-[5px] ml-[5%] w-[25%]">
                            <option v-for="year in listaYears" :value="year">{{ year }}</option>
                        </select>
                    </div>
                    <div>
                        <label for="fileInput"
                            class="inline-block bg-emerald-500 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Seleccionar datos desde un excel
                        </label>
                        <input type="file" id="fileInput" class="opacity-0 absolute z-0 w-0 h-0" @change="onChange" />
                    </div>
                </div>

            </div>
            <div class="grid grid-cols-2">
                <IngresarBalance ref="balanceRef" :tituloEstadoFinanciero="tituloBalance" :empresaId="empresaID">
                </IngresarBalance>
                <IngresarEstadoResultado ref="estadoRef" :tituloEstadoFinanciero="tituloEstadoFinanciero"
                    :empresaId="empresaID"></IngresarEstadoResultado>
            </div>
            <div class="flex justify-end p-[5px]">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-[5%]"
                    @click="guardarValoresCuenta()">
                    Guardar
                </button>
                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-[5%]" @click="cancelar()">
                    Cancelar
                </button>
            </div>
            <div v-if="mensajeExito != ''">
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-white-800 dark:text-white-400 transition duration-75 w-[50%]"
                    role="alert">
                    <span class="font-medium">{{ mensajeExito }}</span>
                </div>
            </div>
            <!--Mensaje de error-->
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                v-if="mensajeError != ''">
                <span class="block sm:inline">{{ mensajeError }}</span>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                </span>
            </div>
        </div>
    </main>
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
import axios from "axios";
import * as XLSX from 'xlsx';
import { ref } from 'vue'
import IngresoEstadosFinancieros from './IngresoEstadosFinancieros.vue';


export default {
    components: {
        Sidebar,
        Header,
        IngresarBalance: IngresoEstadosFinancieros,
        IngresarEstadoResultado: IngresoEstadosFinancieros,
    },
    setup() {
        const sidebarOpen = ref(false)
        return {
            sidebarOpen,
        }
    },
    data() {
        return {
            listaEmpresas: [],
            empresaID: "",
            listaYears: [],
            year: 2023,
            yearInicio: 2000,
            yearFin: 2050,
            idBalanceGeneral: 1,
            idEstadoDeResultado: 2,
            tituloBalance: "Balance General",
            tituloEstadoFinanciero: "Estado de Resultado",
            valoresCuentaEmpresaBalance: [],
            valoresCuentaEmpresaEstadoResultado: [],
            array_valores_cuentas_balance: [],
            array_valores_cuentas_resultado: [],
            excel_data: [],
            mensajeExito: "",
            mensajeError: "",
        }
    },
    mounted() {
        this.obtenerEmpresasRegistradas();
        this.llenarListaAnios();
    },
    methods: {
        obtenerEmpresasRegistradas() {
            axios.get("/api/obtener_empresas")
                .then((response) => {
                    this.listaEmpresas = response.data;
                    this.empresaID = this.listaEmpresas[0].id;
                    this.obtenerEmpresasHijo(this.empresaID);
                })
                .catch((response) => {
                    console.log(response);
                });
        },

        llenarListaAnios() {
            for (let i = 2000; i <= 2050; i++) {
                this.listaYears.push(i);
            }
        },
        verMensajeHijo() {
            this.$refs.balanceRef.mostrarAlerta();
        },
        obtenerEmpresasHijo() {
            //this.$refs.balanceRef.getEmpresasDesdePadre(this.empresaID);
            //this.$refs.estadoRef.getEmpresasDesdePadre(this.empresaID);
            this.getCuentasEmpresa();
        },
        getCuentasEmpresa() {
            axios.get("/api/" + 'empresas/' + this.empresaID).then(
                (response) => {
                    this.array_valores_cuentas_balance = [];
                    this.array_valores_cuentas_resultado = [];
                    this.empresa = response.data;
                    (response.data.get_cuentas_empresa).forEach(cuenta => {
                        if (cuenta.tipo_estado_financiero_id === this.idBalanceGeneral) {
                            let valor_cuenta = {
                                cuenta_empresa_id: null,
                                nombreCuenta: null,
                                valorCuenta: null
                            }
                            valor_cuenta.cuenta_empresa_id = cuenta.id;
                            valor_cuenta.nombreCuenta = cuenta.nombreCuenta;

                            this.array_valores_cuentas_balance.push(valor_cuenta);
                        }
                        else if (cuenta.tipo_estado_financiero_id === this.idEstadoDeResultado) {
                            let valor_cuenta = {
                                cuenta_empresa_id: null,
                                nombreCuenta: null,
                                valorCuenta: null
                            }
                            valor_cuenta.cuenta_empresa_id = cuenta.id;
                            valor_cuenta.nombreCuenta = cuenta.nombreCuenta;

                            this.array_valores_cuentas_resultado.push(valor_cuenta);
                        }
                    });
                    this.$refs.balanceRef.setEmpresasDesdePadre(this.array_valores_cuentas_balance);
                    this.$refs.estadoRef.setEmpresasDesdePadre(this.array_valores_cuentas_resultado);
                }
            ).catch((error) => {
                console.log(error);
            });
        },
        onChange(event) {
            const file = event.target.files[0]
            /* Boilerplate to set up FileReader */
            const reader = new FileReader()
            reader.onload = (e) => {
                /* Parse data */
                const bstr = e.target.result
                const wb = XLSX.read(bstr, { type: 'binary' })
                /* Get first worksheet */
                const wsname = wb.SheetNames[0]
                const ws = wb.Sheets[wsname]
                /* Convert array of arrays */
                const data = XLSX.utils.sheet_to_json(ws, { header: 1 })
                /* Update state */
                this.excel_data = data
                this.setValoresCuentas()
                const header = data.shift()
            }
            reader.readAsBinaryString(file)
        },
        setValoresCuentas() {
            this.array_valores_cuentas_balance.forEach(cuenta => {
                this.excel_data.forEach(row => {
                    if (cuenta.nombreCuenta == row[0]) {
                        cuenta.valorCuenta = row[1];
                    }
                });
            });
            this.array_valores_cuentas_resultado.forEach(cuenta => {
                this.excel_data.forEach(row => {
                    if (cuenta.nombreCuenta == row[0]) {
                        cuenta.valorCuenta = row[1];
                    }
                });
            });

            this.$refs.balanceRef.setEmpresasDesdePadre(this.array_valores_cuentas_balance);
            this.$refs.estadoRef.setEmpresasDesdePadre(this.array_valores_cuentas_resultado);
        },
        guardarValoresCuenta() {
            // console.log(this.array_valores_cuentas_balance.concat(this.array_valores_cuentas_resultado));
            let valoresCuentaEmpresa = this.array_valores_cuentas_balance.concat(this.array_valores_cuentas_resultado);
            if (!this.verificarDatosCompletos(valoresCuentaEmpresa)) {
                this.mensajeError = "Verifique que los datos esten completos y tengan el formato correcto";
                setTimeout(()=>{
                    this.mensajeError = "";
                },3000);
            } else {
                console.log(valoresCuentaEmpresa);
                axios.post("/api/estados_financieros", {
                    "empresaId": this.empresaID,
                    "year": this.year,
                    "valoresCuentaEmpresa": valoresCuentaEmpresa
                })
                    .then(
                        (response) => {
                            this.getCuentasEmpresa();
                            this.mensajeExito = response.data.mensaje;
                            console.log(response.data.valoresCuentasGuardados)
                            this.mensajeExito = response.data.mensaje;
                            setTimeout(() => {
                                this.mensajeExito = "";
                            }, 4000);
                        }
                    )
                    .catch(
                        (response) => {
                            alert("Ocurrio un error");
                        }
                    );
            }

        },

        verificarDatosCompletos(array_cuentas_empresa){
            let estanDatosCompletos = true;
            array_cuentas_empresa.forEach(valorCuenta=>{
                if(valorCuenta.valorCuenta === null){
                    estanDatosCompletos = false;
                }
            });

            return estanDatosCompletos;
        },
        cancelar(){
            this.$router.push({path:"/"});
        }
    },
}
</script>