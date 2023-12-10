<template>
    <div style="min-height: 100vh;">
        <!--NAVBAR SUPERIOR-->
        <div class="sticky z-10 top-0 h-16 border-transparent bg-gray-900 lg:py-2.5">
            <div class="px-6 flex justify-between space-x-4 2xl:container">
                <div class="flex justify-left inline-block items-center content-center">
                    <img class="flex inline-block" src="../assets/icon.png" width="20%">
                    <h5 hidden class="flex text-2xl text-gray-600 font-medium lg:inline-block font-bold">
                        &nbsp;&nbsp;cheroomSV</h5>
                </div>
                <div class="flex space-x-4">
                    <button aria-label="chat"
                        class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-auto text-gray-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
                        </svg>
                    </button>
                    <button aria-label="notification"
                        class="w-10 h-10 rounded-xl border bg-gray-100 focus:bg-gray-100 active:bg-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-auto text-gray-600" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path
                                d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
        <!--/NAVBAR SUPERIOR-->

        <div class="md:grid md:grid-cols-12 bg-gray-100 flex">



            <!--MENU LATERAL-->
            <div class="md:col-span-3">
                <sidebar1 />
            </div>
            <!--MENU LATERAL-->


            <div class="mt-5 md:col-span-8 md:mt-0 border-transparent bg-gray-100">
                <br><br>
                <!--CONTENIDO-->
                <div class="flex justify-start item-start space-y-2 flex-col">
                    <h1 class="text-2xl lg:text-2xl font-semibold leading-7 lg:leading-9 text-black-800">
                        Panel de
                        Administracion</h1>
                    <p class="text-sm text-black-300 font-medium leading-6">{{ new Date().toDateString() }}</p>
                </div>

                <div
                    class="mt-10 flex flex-col xl:flex-row justify-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
                    <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">

                        <div v-if="!tiene_publicacion"
                            class="flex flex-col justify-center items-center dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                            <h2 class="text-xl font-bold text-white py-1">
                                ¡Publica tu cuarto!
                            </h2>
                            <h1 class="text-sm font-light text-white py-3">
                                Conoce gente ahora mismo
                            </h1>
                            <div class="pt-6">
                                <button
                                    class="button rounded-full bg-cyan-500 hover:bg-cyan-600 py-2 px-4 active:bg-cyan-700 focus:outline-none focus:ring focus:ring-cyan-300">
                                    <router-link to="/crear_publicacion">Publicar</router-link>
                                </button>
                            </div>

                        </div>



                        <div v-if="tiene_publicacion"
                            class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
                            <p v-if="publicacion.p_activa == true"
                                class="text-lg md:text-lg dark:text-white font-semibold leading-6 lg:leading-5 text-gray-800">
                                Estado:
                                Activa</p>
                            <p v-if="publicacion.p_activa == false"
                                class="text-lg md:text-lg dark:text-white font-semibold leading-6 lg:leading-5 text-gray-800">
                                Estado:
                                Inactiva</p>
                            <div
                                class="mt-4 md:mt-6 flex flex-col md:flex-row justify-start items-start md:items-center md:space-x-6 xl:space-x-8 w-full">
                                <div class="pb-4 md:pb-8 w-full md:w-40">
                                    <img class="w-full hidden md:block"
                                        :src="foto_publi.foto64"
                                        v-if="foto_publi.foto_lugar">
                                    <img class="w-full md:hidden" :src="foto_publi.foto64"
                                        v-if="foto_publi.foto_lugar">
                                </div>
                                <div
                                    class="border-b border-gray-200 md:flex-row flex-col flex justify-between items-start w-full pb-8 space-y-4 md:space-y-0">
                                    <div class="w-full flex flex-col justify-start items-start space-y-8">
                                        <h3
                                            class="text-lg dark:text-white xl:text-lg font-semibold leading-6 text-gray-800">
                                            {{ publicacion.titulo }}</h3>
                                        <div class="flex justify-start items-start flex-col space-y-2">
                                            <p class="text-sm dark:text-white leading-none text-gray-800"><span
                                                    class="dark:text-gray-400 text-gray-300">Contrato: </span> {{
                                                            publicacion.tiempo_contrato
                                                    }}
                                            </p>
                                            <p class="text-sm dark:text-white leading-none text-gray-800"><span
                                                    class="dark:text-gray-400 text-gray-300">Precio: </span> {{
                                                            publicacion.precio
                                                    }}</p>
                                            <p class="text-sm dark:text-white leading-none text-gray-800"><span
                                                    class="dark:text-gray-400 text-gray-300">Descripcion: </span>
                                                {{ publicacion.descrip_lugar }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex justify-between space-x-8 items-start w-full">
                                        <p class="text-base dark:text-white xl:text-lg leading-6"><span
                                                class="text-red-300 line-through"></span></p>
                                        <button @click="modificar_publicacion"
                                            class="button rounded-full bg-cyan-500 hover:bg-cyan-600 py-2 px-4 active:bg-cyan-700 focus:outline-none focus:ring focus:ring-cyan-300">Modificar</button>
                                        <button @click="eliminar_publicacion"
                                            class="button rounded-full py-2 px-4 bg-violet-500 hover:bg-violet-600 active:bg-violet-700 focus:outline-none focus:ring focus:ring-violet-300">
                                            Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                </div>

            </div>

            <!--/CONTENIDO-->
            <div>
            </div>


            <div class="md:col-span-1">
            </div>

            <!-- <modal1 v-if="eliminar" /> -->


            <div>
                <TransitionRoot as="template" :show="eliminar">
                    <Dialog as="div" class="relative z-10" @close="eliminar = false">
                        <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0"
                            enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
                        </TransitionChild>

                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div
                                class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                <TransitionChild as="template" enter="ease-out duration-300"
                                    enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                    enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                                    leave-from="opacity-100 translate-y-0 sm:scale-100"
                                    leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                    <DialogPanel
                                        class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg">
                                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                            <div class="sm:flex sm:items-start">
                                                <div
                                                    class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                                    <ExclamationTriangleIcon class="h-6 w-6 text-red-600"
                                                        aria-hidden="true" />
                                                </div>
                                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                                    <DialogTitle as="h3"
                                                        class="text-lg font-medium leading-6 text-gray-900">Eliminar
                                                    </DialogTitle>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-500">¿Estas seguro que deseas
                                                            eliminar esta publicacion?</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6">
                                            <button type="button"
                                                class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto sm:text-sm"
                                                @click="si_elimina">Eliminar</button>
                                            <button type="button"
                                                class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                                @click="eliminar = false">Cancelar</button>
                                        </div>
                                    </DialogPanel>
                                </TransitionChild>
                            </div>
                        </div>
                    </Dialog>
                </TransitionRoot>
            </div>



        </div>
    </div>

</template>

<style>
.checkbox:checked {
    border: none;
}

.checkbox:checked+.check-icon {
    display: flex;
}
</style>

<script>
import { getAPI } from '../axios-api'
import user from '../helper/user'

import sidebar1 from '../components/Sidebar1.vue'
import modal1 from '../components/modal.vue'

import { ref } from 'vue'
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'
import { ExclamationTriangleIcon } from '@heroicons/vue/24/outline'
import { useMeta } from 'vue-meta'
export default {
    name: "panel_miPublicacion",
    setup() {
        useMeta({
            title: "Panel Roomies",
            description: "¡Crea, publica y conoce! CheroomSV es una plataforma que busca conectar a las personas en la busqueda de su roomate ideal.",
            keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, rooms, conocer, el salvador, rommie",
            'Content-Security-Policy': "upgrade-insecure-requests",
        });
    },
    data() {
        return {
            API_Publicacion: [],
            API_Foto: [],
            Perfil_Logueado: [],
            publicacion: [],
            foto_publi: [],
            eliminar: false,
            tiene_publicacion: true,
        };
    },
    created() {
        this.obt_PubliUser();
    },
    methods: {
        si_elimina() {
            getAPI.delete('/publicacion_alquiler/' + this.publicacion.publicacion_id + '/')
                .then(response => {
                    console.log(response.data);
                })
                .then(_ => {
                    this.eliminar = false;
                    this.$router.go(0)
                })
                .catch(error => {
                    console.log(error);
                })
        },
        modificar_publicacion() {
            this.$router.push({
                name: 'Mod_Publicacion',
            })
        },
        eliminar_publicacion() {
            this.eliminar = true
        },

        obt_FotoPerfil() {
            getAPI.get('/foto/')
                .then(response => {
                    this.API_Foto = response.data;
                    for (let i = 0; i < this.API_Foto.length; i++) {
                        console.log("LA FOTO ES " + this.API_Foto[i].publi_alquiler + " " + this.publicacion.publicacion_id);
                        if (this.API_Foto[i].publi_alquiler == this.publicacion.publicacion_id) {
                            this.foto_publi = this.API_Foto[i];
                        }
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        },
        obt_PubliUser() {
            getAPI.get('/publicacion_alquiler/', {
                headers: user.get_header_authorization_token()
            })
                .then(response => {
                    console.log('Publicacion API has received data')
                    this.API_Publicacion = response.data;
                })
                .then(_ => {
                    this.getUserLogueado();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getUserLogueado() {
            getAPI.get('/user_token/', {
                headers: user.get_header_authorization_token()
            })
                .then(response => {
                    console.log('Perfil API has received data')
                    this.Perfil_Logueado = response.data;
                })
                .then(_ => {
                    this.publi_Filtro();
                })
                .then(_ => {
                    this.obt_FotoPerfil();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        publi_Filtro() {
            this.publicacion = []
            for (let i = 0; i < this.API_Publicacion.length; i++) {
                console.log(this.API_Publicacion[i].perfil.perfil_id + " " + this.Perfil_Logueado.perfil_id)
                if (this.API_Publicacion[i].perfil.perfil_id == this.Perfil_Logueado.perfil_id) {
                    this.publicacion = this.API_Publicacion[i];
                }
            }
            if (Object.keys(this.publicacion).length === 0) {
                this.tiene_publicacion = false;
                console.log("aaaaaaaaaaaaaaa")
            }
        },
    },
    mounted() {

    },
    components: {
        sidebar1: sidebar1,
        modal1,
        Dialog,
        DialogPanel,
        DialogTitle,
        TransitionChild,
        TransitionRoot,
        ExclamationTriangleIcon
    }
};
</script>