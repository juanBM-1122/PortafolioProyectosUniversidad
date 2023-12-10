<script setup>
import { readonly } from "vue";
import api_url from "../constants";
</script>
<template>
    <div>
        <div class="bg-white p-4 shadow">
            <label class="text-3xl font-bold text-dark-800">REGISTRAR EMPRESA</label>
        </div>
        <form class="container bg-white w-auto max-w-[1200px] m-8 lg:mx-auto p-6 shadow rounded" @submit.prevent="agregar">
            <label for="viñeta" class="w-1/4 text-dark-900 text-right pr-4 font-bold">Informacion general:</label>
            <hr class="my-4 border-t-2 border-black">
            <div name="control-parametros" class="flex justify-center flex-wrap space-y-4">
                <div class="w-full lg:w-1/2 flex items-center">

                    <div class="w-3/4">
                        <input type="text" id="nombreEmpresa" v-model="nombreEmpresa" :disabled="camposDeshabilitados"
                            class="w-full border-b border-gray-300 py-2 px-3 text-gray-900 focus:outline-none focus:border-indigo-600"
                            placeholder="Nombre Empresa" />
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex items-center">
                    <label for="sector" class="w-1/2 rounded-md text-gray-500 text-right pr-2">Sector:</label>
                    <!-- Ajustar pr-2 para dejar espacio del mismo lado que el select -->
                    <div class="w-3/4 flex items-center">
                        <select id="seleccionarSector" v-model="seleccionarSector" :disabled="camposDeshabilitados"
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
                <label for="viñeta" class="w-1/4 text-dark-900 text-right pr-4 font-bold">Tipo de estado financiero:</label>
                <hr class="my-4 border-t-2 border-black">
                <div name="control-parametros" class="flex justify-center flex-wrap space-y-4">
                    <div class="w-full lg:w-1/2 flex items-center">
                    </div>
                    <div class="w-full lg:w-1/2 flex items-center">
                        <label for="sector" class="w-1/2 rounded-md text-gray-500 text-right pr-2">Tipo de estado
                            financiero:</label>

                        <div class="w-3/4 flex items-center">
                            <select id="seleccionarSector" v-model="seleccionarTipoEstadoFinanciero"
                                :disabled="camposdeCuentasDes"
                                class="w-1/2 rounded-md border-0 py-2  text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                                <option value="" disabled>Selecciona un estado </option>

                                <option v-for="seleccionarTipoEstadoFinanciero in listadeEstadosFinancieros"
                                    :key="seleccionarTipoEstadoFinanciero.id" :value="seleccionarTipoEstadoFinanciero.id">
                                    {{
                                        seleccionarTipoEstadoFinanciero.nombre }}
                                </option>

                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div>
                <label for="viñeta" class="w-1/4 text-dark-900 text-right pr-4 font-bold">Catálogo de Cuentas</label>
                <hr class="my-4 border-t-2 border-black">
            </div>
            <div class="flex justify-between">
                <label for="viñeta" class="w-1/4 text-dark-900 text-left pr-4 font-bold">Cuenta</label>
                <br><br>
                <label for="viñeta" class="w-1/3 text-dark-900 text-left pr-4 font-bold">Equivalente en catálogo
                    base del sistema</label>
            </div>
            <div name="control-parametros" class="flex justify-center flex-wrap space-y-4">
                <div class="w-full lg:w-1/2 flex items-center">
                    <div class="w-3/4">
                        <input type="text" id="input1" v-model="seleccionarClasecuentas.nombre" placeholder="A.Activos"
                            :disabled="true"
                            class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>

                </div>
                <div class="w-full lg:w-1/2 flex items-center">
                    <label for="seleccionarClasecuentas"
                        class="w-1/2 rounded-md text-gray-500 text-right pr-2">Activos:</label>
                    <!-- Ajustar pr-2 para dejar espacio del mismo lado que el select -->
                    <div class="w-3/4 flex items-center">
                        <select id="seleccionarClasecuentas" v-model="seleccionarClasecuentas"
                            :disabled="camposdeCuentasDes"
                            class="w-1/2 rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                            <option value="" disabled>Clase de cuenta</option>
                            <option v-for="seleccionarClasecuentas in listaClasecuentas" :key="seleccionarClasecuentas.id"
                                :value="seleccionarClasecuentas">{{ seleccionarClasecuentas.id }} {{
                                    seleccionarClasecuentas.nombre }}
                            </option>

                        </select>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex items-center">

                    <div class="w-3/4">
                        <input type="text" id="input2" v-model="seleccionarsubCuenta.nombre"
                            placeholder="A.a Activos corrientes" :disabled="true"
                            class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex items-center">
                    <label for="seleccionarsubCuenta" class="w-1/2 rounded-md text-gray-500 text-right pr-2">Activos
                        Corriente:</label>
                    <!-- Ajustar pr-2 para dejar espacio del mismo lado que el select -->
                    <div class="w-3/4 flex items-center">
                        <select id="seleccionarsubCuenta" v-model="seleccionarsubCuenta" :disabled="camposdeCuentasDes"
                            class="w-1/2 rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                            <option value="" disabled>Sub Cuentas</option>
                            <option v-for=" seleccionarsubCuenta in  listasubClasecuentas" :key="seleccionarsubCuenta.id"
                                :value="seleccionarsubCuenta">{{ seleccionarsubCuenta.clase_cuenta_id }} {{
                                    seleccionarsubCuenta.nombre }}
                            </option>
                            <!-- Agrega más opciones de sectores según tus necesidades -->
                        </select>
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex items-center">

                    <div class="w-3/4">
                        <input type="text" id="input3" v-model="seleccionarCuenta.nombre" placeholder="A.a.1 Caja"
                            :disabled="true"
                            class="w-full rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600" />
                    </div>
                </div>
                <div class="w-full lg:w-1/2 flex items-center">
                    <label for="seleccionarCuenta " class="w-1/2 rounded-md text-gray-500 text-right pr-2">Caja:</label>
                    <!-- Ajustar pr-2 para dejar espacio del mismo lado que el select -->
                    <div class="w-3/4 flex items-center">
                        <select id="seleccionarCuenta " v-model="seleccionarCuenta" :disabled="camposdeCuentasDes"
                            class="w-1/2 rounded-md border-0 py-2 px-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 ">
                            <option value="" disabled>Nombre de Cuenta</option>
                            <option v-for=" seleccionarCuenta in  listaCuentas" :key="seleccionarCuenta.id"
                                :value="seleccionarCuenta">{{ seleccionarCuenta.sub_cuenta_id }} {{
                                    seleccionarCuenta.nombre }}
                            </option>
                            <!-- Agrega más opciones de sectores según tus necesidades -->
                        </select>
                    </div>
                </div>
                <div class="w-full mx-2 flex justify-between">
                    <div class="flex">
                        <button class="bg-white text-gray-500 hover:text-white hover:bg-green-600 p-3 rounded"
                            @click="guardarCuentaEmpresa">
                            Agregar cuenta+
                        </button>
                    </div>
                </div>
                <div class="w-full mx-2 flex justify-center">
                    <button class="bg-blue-500 text-white hover:bg-blue-700 active:bg-blue-800 py-3 px-8 rounded mr-2"
                        :disabled="camposDeshabilitados" @click="agregarEmpresa">Guardar empresa</button>
                    <button class="bg-red-500 text-white hover:bg-red-700 active:bg-red-800 py-3 px-8 rounded"
                        @click="limpiarFormulario">Cancelar</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import axios from 'axios'

export default {
    data() {
        return {
            nombreEmpresa: '',
            listaSector: [],
            seleccionarSector: '',
            listaClasecuentas: [],
            seleccionarClasecuentas: '',
            listasubClasecuentas: [],
            seleccionarsubCuenta: '',
            seleccionarCuenta: '',
            listaCuentas: [],
            seleccionarTipoEstadoFinanciero: '',
            listadeEstadosFinancieros: [],
            camposDeshabilitados: false,
            camposdeCuentasDes: true,
            ultimaEmpresa: null,
            empresas:null,
        };
    },
    methods: {


        agregarEmpresa() {
            const params = {
                sector_empresa_id: this.seleccionarSector,
                nombre: this.nombreEmpresa,
            }
            console.log(params);
            axios.post(api_url + 'empresas', params).then(
                (response) => {
                    this.empresas = response.data.empresa.id
                    alert('Se ha guardado la empresa' + '\n' + this.nombreEmpresa);
                    alert('Ingresa tus cuentas que se relacionan al catalogo ');
                    this.camposDeshabilitados = true;
                    this.camposdeCuentasDes = false;

                }
            ).catch((error) => {

            });
        },

        guardarCuentaEmpresa() {
            alert(this.empresas)
            axios.post(api_url + 'cuenta_empresas', {
               empresa_id: this.empresas, 
                cuenta_id: this.seleccionarClasecuentas.id,
                tipo_estado_financiero_id: this.seleccionarTipoEstadoFinanciero,
                nombreCuenta: this.seleccionarCuenta.nombre,
            })
                .then(response => {
                    console.log(response.data);
                    console.log(this.nombreEmpresa + this.seleccionarClasecuentas + this.seleccionarTipoEstadoFinanciero + this.nombreCuenta)
                })
                .catch(error => {
                    console.log(error);
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

        getSubCuenta() {
            axios.get(api_url + 'subcuentas').then((response) => {
                this.listasubClasecuentas = response.data;
            })
                .catch((error) => {
                    console.log(error);
                });

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
            axios.get(api_url + 'cuenta').then(
                (response) => {
                    this.listaCuentas = response.data;

                }
            ).catch((error) => {
                console.log(error)
            });

        },
        getClaseCuentas() {
            axios.get(api_url + 'clasecuentas').then(
                (response) => {
                    this.listaClasecuentas = response.data;

                }
            ).catch((error) => {
                console.log(error)
            });

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
        axios.get('/empresas/ultima')
            .then(response => {
                this.empresas = response.data.empresa_id;
            console.log(this.empresas); // Agrega esto para verificar el valor
            })
            .catch(error => {
                console.error('Error al obtener el último empresa_id', error);
            });
    },
    mounted() {
        this.getSector();
        this.getClaseCuentas();
        this.getSubCuenta();
        this.getCuenta()
        this.getTipoFinanciero();


    },
};
</script>
  