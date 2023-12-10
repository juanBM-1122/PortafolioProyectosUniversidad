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
                        <h2 class="text-lg font-semibold text-slate-800 mb-2 dark:text-slate-100">GESTIÓN DE SECTORES</h2>
                        <section class="container bg-white w-auto max-w-[1024px] m-6 lg:mx-auto p-4 shadow rounded dark:bg-slate-800">
                            <form @submit.prevent="addSector">
                                <input v-model="newSector" type="text" placeholder="Nuevo sector"
                                    class="border rounded px-2 py-1 block text-sm font-medium leading-6 text-gray-900 ">
                                <!--<button type="submit" class="bg-blue-400 text-white hover:bg-blue-600 active:bg-blue-700 p-2 rounded">
                Añadir
            </button>-->
                            </form>

                            <hr class="my-4">
                            <!--Tabla-->
                            <table class="w-full border-collapse bg-white text-left text-sm text-gray-500 border my-4 dark:bg-slate-700">
                                <thead>
                                    <tr>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900 dark:text-slate-100">Nombre del sector</th>
                                        <th scope="col" class="px-6 py-4 font-medium text-gray-900"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="sector in sectoresList" :value="sector.id">
                                        <td class="px-6 py-4 text-ms dark:text-slate-100">{{ sector.nombre }}</td>
                                        <td class="px-6 py-4 text-ms ">
                                            <button @click="deleteSector(sector.id)"
                                                class="bg-yellow-600 hover:bg-yellow-500 text-white active:bg-yellow-700 px-2 py-1 rounded">
                                                Eliminar
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="flex justify-center space-x-6">
                                <button @click="saveSectors"
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
            newSector: "",
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

        deleteSector(id) {
            axios.delete(api_url + 'sectores/' + id)
                .then(response => {
                    this.getSectores();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        saveSectors() {
            axios.post(api_url + 'sectores', { nombre: this.newSector })
                .then(response => {
                    this.newSector = "";
                    this.getSectores();
                })
                .catch(error => {
                    console.log(error);
                });
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