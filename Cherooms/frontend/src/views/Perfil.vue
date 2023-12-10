<template>
    <link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css">
    <link rel="stylesheet"
        href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">

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

    <sidebar2></sidebar2>

    <div class="h-full bg-gray-200 p-8">
        <div class="bg-white rounded-lg shadow-xl pb-8">
            <div class="w-full h-[250px]">
                <img src="https://vojislavd.com/ta-template-demo/assets/img/profile-background.jpg" class="w-full h-full rounded-tl-lg rounded-tr-lg">
            </div>
            <div class="flex flex-col items-center -mt-20">
                <img :src="Perfil_Logueado.foto64" class="w-40 border-4 border-white rounded-full">
                <div class="flex items-center space-x-2 mt-2">
                    <h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
                                {{ Perfil_Logueado.nombre_user }} {{ Perfil_Logueado.apellidos_user }} </h3>
                    <span class="bg-blue-500 rounded-full p-1" title="Verified">
                        <svg xmlns="http://www.w3.org/2000/svg" class="text-gray-100 h-2.5 w-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>
               
                <div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
                    <i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400">{{}}, {{}}</i>
                </div>

                <div class="mb-2 text-blueGray-600 mt-10">
                    <i class="fas fa-user mr-2 text-lg text-blueGray-400"></i> {{ Perfil_Logueado.edad }} Años
                </div>

                <div class="mb-2 text-blueGray-600">
                    <i class="fas fa-phone mr-2 text-lg text-blueGray-400"></i> {{ Perfil_Logueado.telefono}}
                </div>

                <div class="mb-2 text-blueGray-600">
                    <i class="fas fa-envelope mr-2 text-lg text-blueGray-400"></i> {{ Perfil_Logueado.email}}
                </div>               
                
            </div>

            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                <div class="flex flex-wrap justify-center">
                    <div class="w-full lg:w-9/12 px-4">
                        <h1 class="text-2xl font-semibold leading-normal" >Biografia</h1>

                        <p class="mb-4 text-lg leading-relaxed text-blueGray-700">
                                        {{ Perfil_Logueado.biografia }}
                        </p>

                    </div>
                </div>
            </div>

            <div class="mt-10 py-10 border-t border-blueGray-200 text-center">
                <div class="grid h-52 grid-cols-2 bg-white  shadow-lg">
                    <div class="border pl-0 pt-4 ">
                        <h2 class="font-semibold leading-normal">Preferencias:</h2>
                        <ul 

                            class="border border-gray-200 rounded overflow-hidden shadow-md mt-4 ml-3 mr-4">
                            <li v-for="prefer in filtroPref" :key="prefer.listapref_id" class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out"
                                v-bind:value="prefer">
                                {{ prefer.preferencia.nombre_preferencia }}
                            </li>

                        </ul>
                    </div>

                    <div class="border pl-0 pt-4 ">
                        <h2 class="font-semibold leading-normal">Hobbies: </h2>
                        <ul
                            class="border border-gray-200 rounded overflow-hidden shadow-md mt-4 ml-3 mr-4">
                            <li v-for="hobbie in filtroHob" :key="hobbie.listhobbies_id" class="px-4 py-2 bg-white hover:bg-sky-100 hover:text-sky-900 border-b last:border-none border-gray-200 transition-all duration-300 ease-in-out"
                                v-bind:value="hobbie">
                                {{ hobbie.hobbie.nombre_hobbie }}
                            </li>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="mt-10 py-10 border-t border-blueGray-200 text-center space-x-4 align-center">
                <h2 class="py-4 text-2xl font-semibold leading-normal">Redes Sociales: </h2>
                <a :href="('https://www.facebook.com/' + Perfil_Logueado.user_facebook)">

                                <button
                                    class="bg-blue-500 px-4 py-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="w-4 h-4">
                                        <path fill="currentColor"
                                            d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z" />
                                    </svg>
                                    <span>Facebook</span>
                                </button>
                            </a>

                            <a :href="('https://www.twitter.com/' + Perfil_Logueado.user_twitter)">
                                <button
                                    class="bg-blue-300 px-4 py-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-4 h-4">
                                        <path fill="currentColor"
                                            d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z" />
                                    </svg>
                                    <span>Twitter</span>
                                </button>
                            </a>

                            <a :href="('https://www.instagram.com/' + Perfil_Logueado.user_insta)">
                                <button
                                    class="bg-red-500 px-4 py-2 font-semibold text-white inline-flex items-center space-x-2 rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4 h-4">
                                        <path fill="currentColor"
                                            d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z" />
                                    </svg>
                                    <span>Instagram</span>
                                </button>
                            </a>

            </div>
            
        </div>

    </div>

</template>

<script>
import sidebar2 from '../components/sidebar2.vue'
import { getAPI } from '../axios-api'
import user from "../helper/user"
export default {
    data() {
        return {
            API_Hobbies: [],
            API_Preferencias: [],
            token: "",
            Perfil_Logueado: [],
            filtroHob: [],
            filtroPref: [],
        };
    },
    created() {
        getAPI.get('/user_token/', {
            headers: user.get_header_authorization_token()
        }).then(response => {
            console.log('Perfil Logueado obtenido')
            this.Perfil_Logueado = response.data;
            console.log(this.Perfil_Logueado)
        }).then(_ => {
            this.traerListaHobbie();
            this.traerListaPreferencia();
        })
            .catch(error => {
                console.log(error);
            });
    },
    methods: {
        traerListaPreferencia() {
            getAPI.get('/lista_preferencia/')
                .then(response => {
                    console.log("Preferencias has received data")
                    this.API_Preferencias = response.data;
                }).then(_ => {
                    this.filtroPrefe();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        traerListaHobbie() {
            getAPI.get('/listadodehobbies/',)
                .then(response => {
                    console.log('Hobbie has received data')
                    this.API_Hobbies = response.data;
                })
                .then(_ => {
                    this.filtroHobbie();
                })
                .catch(error => {
                    console.log(error);
                });
        },

        //Filtrar hobbies segun el perfil logueado
        filtroHobbie() {
            var hobbies = this.API_Hobbies;
            var perfil = this.Perfil_Logueado;
            for (var i = 0; i < hobbies.length; i++) {
                if (hobbies[i].perfil.perfil_id == perfil.perfil_id) {
                    this.filtroHob.push(hobbies[i]);
                }
            }
        },

        filtroPrefe() {
            var preferencias = this.API_Preferencias;
            var perfil = this.Perfil_Logueado;
            for (var i = 0; i < preferencias.length; i++) {
                if (preferencias[i].perfil.perfil_id == perfil.perfil_id) {
                    this.filtroPref.push(preferencias[i]);
                }
            }
        },
    },
    components: {
        sidebar2: sidebar2,
    }
};
</script>