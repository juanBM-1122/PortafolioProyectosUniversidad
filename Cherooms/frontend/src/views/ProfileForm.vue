<template>
    <div>
        <navbar1></navbar1>
    </div>

    <div class="grid md:grid-cols-6">
        <div>
            <sidebar1></sidebar1>
        </div>
        <div class="col-span-5">

            <body class="antialiased font-sans bg-gray-200 overflow-hidden">
                <div class="" style="">
                    <div class="bg-gray-100">
                        <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                            <form @submit.prevent="submit">
                                <div class="mt-10 sm:mt-0">
                                    <div class="md:grid md:grid-cols-4 md:gap-6">
                                        <div class="md:col-span-1">
                                            <div class="px-4 sm:px-0">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">Personal
                                                    Information
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600">Por favor complete su información
                                                    personal.</p>
                                            </div>
                                        </div>
                                        <div class="mt-5 md:col-span-3 md:mt-0">

                                            <div class="overflow-hidden shadow sm:rounded-md">
                                                <div class="bg-white px-4 py-5 sm:p-6">
                                                    <div class="grid grid-cols-6 gap-6">
                                                        <div class="col-span-6 sm:col-span-2">
                                                            <label for="first-name"
                                                                class="block text-sm font-medium text-gray-700">First
                                                                name</label>
                                                            <input type="text" v-model.lazy="userData.firstname"
                                                                id="first-name" autocomplete="given-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-2">
                                                            <label for="last-name"
                                                                class="block text-sm font-medium text-gray-700">Last
                                                                name</label>
                                                            <input type="text" v-model.lazy="userData.lastname"
                                                                id="last-name" autocomplete="family-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-2">
                                                            <label for="user"
                                                                class="block text-sm font-medium text-gray-700">Username</label>
                                                            <input type="text" v-model.lazy="userData.user" id="user"
                                                                autocomplete="family-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-4">
                                                            <label for="email-address"
                                                                class="block text-sm font-medium text-gray-700">Email
                                                                address</label>
                                                            <input type="text" v-model.lazy="userData.email"
                                                                id="email-address" autocomplete="email"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-2">
                                                            <label for="genero"
                                                                class="block text-sm font-medium text-gray-700">Genero</label>
                                                            <select id="genero" v-model="userData.selectedGenero"
                                                                autocomplete="genero-name"
                                                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                                <option v-for="option in optionsGenero"
                                                                    :value="option.value">
                                                                    {{ option.text }}
                                                                </option>
                                                            </select>
                                                        </div>



                                                        <!--    <div class="col-span-6 sm:col-span-3">
                                                    <label for="country"
                                                        class="block text-sm font-medium text-gray-700">Country</label>
                                                    <select id="country" v-model="userData.selectedCountry"
                                                        autocomplete="country-name"
                                                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                        <option v-for="option in optionsCountry" :value="option.value">
                                                            {{ option.text }}
                                                        </option>
                                                    </select>
                                                </div>-->

                                                        <!--<div class="col-span-6 sm:col-span-4">
                                                    <label for="street-address"
                                                        class="block text-sm font-medium text-gray-700">Street
                                                        address</label>
                                                    <input type="text" v-model="userData.streetaddress"
                                                        id="street-address" autocomplete="street-address"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </div>-->

                                                        <div class="col-span-6 sm:col-span-2">
                                                            <label for="age"
                                                                class="block text-sm font-medium text-gray-700">Edad</label>
                                                            <input type="number" v-model="userData.age" id="age"
                                                                autocomplete="age" min="18"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>


                                                        <div class="col-span-6 sm:col-span-2 ">
                                                            <label for="city"
                                                                class="block text-sm font-medium text-gray-700">city</label>
                                                            <select id="city" v-model="userData.selectedCity"
                                                                autocomplete="city-name"
                                                                class="mt-1 block w-full rounded-md border border-gray-300 bg-white py-2 px-3 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                                                                <option v-for="option in optionsCity"
                                                                    :value="option.value">
                                                                    {{ option.text }}
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-2 ">
                                                            <label for="city"
                                                                class="block text-sm font-medium text-gray-700">Hobbies</label>

                                                            <VueMultiselect class="text-sm" v-model="userData.selectedHobbie"
                                                                :options="optionsHobbie" :multiple="true"
                                                                :close-on-select="false"
                                                                placeholder="Seleccione sus hobbies..."
                                                                label="name" track-by="id"
                                                                required />
                                                        </div>

                                                        <!--<div class="col-span-6 sm:col-span-2">
                                                    <label for="state"
                                                        class="block text-sm font-medium text-gray-700">State /
                                                        Province</label>
                                                    <input type="text" v-model="userData.state" id="state"
                                                        autocomplete="address-level1"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </div>-->

                                                        <!--<div class="col-span-6 sm:col-span-2">
                                                    <label for="postal-code"
                                                        class="block text-sm font-medium text-gray-700">ZIP / Postal
                                                        code</label>
                                                    <input type="text" v-model="userData.postalcode" id="postal-code"
                                                        autocomplete="postal-code"
                                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="hidden sm:block" aria-hidden="true">
                                    <div class="py-5">
                                        <div class="border-t border-gray-200"></div>
                                    </div>
                                </div>

                                <div>
                                    <div class="md:grid md:grid-cols-4 md:gap-6">
                                        <div class="md:col-span-1">
                                            <div class="px-4 sm:px-0">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">Profile</h3>
                                                <p class="mt-1 text-sm text-gray-600">Cuentanos sobre ti.</p>
                                            </div>
                                        </div>
                                        <div class="mt-5 md:col-span-3 md:mt-0">

                                            <div class="shadow sm:overflow-hidden sm:rounded-md">
                                                <div class="space-y-6 bg-white px-4 py-5 sm:p-6">

                                                    <div>
                                                        <label for="about"
                                                            class="block text-sm font-medium text-gray-700">Añade
                                                            una descripción sobre ti</label>
                                                        <div class="mt-1">
                                                            <textarea id="about" v-model="userData.about" rows="3"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                                                placeholder="A mi me gusta compartir..."></textarea>
                                                        </div>
                                                        <p class="mt-2 text-sm text-gray-500">Esta información es muy
                                                            importante.</p>
                                                    </div>

                                                    <div>
                                                        <label
                                                            class="block text-sm font-medium text-gray-700 text-left">Sube
                                                            una foto de perfil</label>
                                                        <div
                                                            class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                                            <div class="space-y-1 text-center">
                                                                <svg class="mx-auto h-12 w-12 text-gray-400"
                                                                    stroke="currentColor" fill="none"
                                                                    viewBox="0 0 48 48" aria-hidden="true">
                                                                    <path
                                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                                        stroke-width="2" stroke-linecap="round"
                                                                        stroke-linejoin="round" />
                                                                </svg>
                                                                <div class="max-w-md-2">
                                                                    <img v-if="src_image" :src="src_image"
                                                                        :key="pointshover" class="h-48 w-48">
                                                                </div>

                                                                <div class="flex text-sm text-gray-600">
                                                                    <label for="file"
                                                                        class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                                        <span>Sube una imagen</span>
                                                                        <input type="file" id="file" ref="file"
                                                                            @change="onFileChange" required />
                                                                    </label>
                                                                </div>
                                                                <p class="text-xs text-gray-500">PNG, JPG, GIF de hasta
                                                                    10MB
                                                                </p>
                                                                <p class="pl-1">or drag and drop</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="hidden sm:block" aria-hidden="true">
                                    <div class="py-5">
                                        <div class="border-t border-gray-200"></div>
                                    </div>
                                </div>

                                <div class="mt-10 sm:mt-0">
                                    <div class="md:grid md:grid-cols-4 md:gap-6">
                                        <div class="md:col-span-1">
                                            <div class="px-4 sm:px-0">
                                                <h3 class="text-lg font-medium leading-6 text-gray-900">Medios de
                                                    Contacto
                                                </h3>
                                                <p class="mt-1 text-sm text-gray-600">Por favor, completa toda la
                                                    información
                                                    para
                                                    lograr mejor alcance.</p>
                                            </div>
                                        </div>
                                        <div class="mt-5 md:col-span-3 md:mt-0">
                                            <div class="overflow-hidden shadow sm:rounded-md">
                                                <div class="bg-white px-4 py-5 sm:p-6">
                                                    <div class="grid grid-cols-6 gap-6">
                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="telefono"
                                                                class="block text-sm font-medium text-gray-700">Ingrese
                                                                número
                                                                de telefono</label>
                                                            <input type="text" v-model="userData.telefono" id="telefono"
                                                                autocomplete="given-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="whatsapp"
                                                                class="block text-sm font-medium text-gray-700">WhatsApp</label>
                                                            <input type="text" v-model="userData.whatsapp" id="whatsapp"
                                                                autocomplete="family-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-6">
                                                            <h1>Redes Sociles (Enlaces a perfil)</h1>
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="facebook"
                                                                class="block text-sm font-medium text-gray-700">Facebook</label>
                                                            <input type="text" v-model="userData.facebook" id="facebook"
                                                                autocomplete="family-name"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>

                                                        <div class="col-span-6 sm:col-span-3">
                                                            <label for="instagram"
                                                                class="block text-sm font-medium text-gray-700">Instagram</label>
                                                            <input type="text" v-model="userData.instagram"
                                                                id="instagram" autocomplete="instagram"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>



                                                        <div class="col-span-6">
                                                            <label for="twitter"
                                                                class="block text-sm font-medium text-gray-700">Twitter</label>
                                                            <input type="text" v-model="userData.twitter" id="twitter"
                                                                autocomplete="twitter"
                                                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                                                <button type="submit"
                                                    class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </body>
        </div>

    </div>

</template>

<script>
import navbar1 from '../components/Navbar1.vue'
import sidebar1 from '../components/Sidebar1.vue'
import formLogin from '../components/FormLogin.vue'
import Detalle1 from '../components/Detalle1.vue'
import logout from '../components/logout.vue'
import VueMultiselect from 'vue-multiselect'
import { getAPI } from '../axios-api'
import Cookies from "js-cookie";
// SE NECESITA IMPORTAR ESTO PARA PODER PODER OBTENER EL USUARIO LOGUEADO
import user from "@/helper/user"
import { useMeta } from 'vue-meta'
export default {
    name: 'ProfileForm',
    setup() {
        useMeta({
            title: "Perfil",
            description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
            keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
            'Content-Security-Policy': "upgrade-insecure-requests",
        });
    },
    data() {
        return {
            data: {
                image: null
            },
            userData: {
                firstname: '',
                lastname: '',
                email: '',
                user: '',
                selectedCity: '',
                selectedHobbie: '',
                streetaddress: '',
                age: '',
                state: '',
                postalcode: '',
                about: '',
                telefono: '',
                whatsapp: '',
                facebook: '',
                instagram: '',
                twitter: '',
                selectedGenero: '',
            },
            optionsCity: [],
            optionsHobbie: [],
            file: null,
            optionsGenero: [
                { text: 'Masculino', value: 1 },
                { text: 'Femenino', value: 0 },
                { text: 'Prefiero no Decirlo', value: 2 },
            ],
            perfil_creada: null,
            // AQUI SE GUARDA EL PERFIL DEL USUARIO LOGUEADO
            Perfil_Logueado: [],
            id_user: null,
            flagUpdate: false,
            src_image: null
        }
    },
    mounted() {
        getAPI.get('/ciudad/')
            .then(response => {
                let data = response.data;
                data.forEach((value, index) => {
                    this.optionsCity.push({ text: value.nombre_ciudad, value: value.ciudad_id });
                });
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false)


        getAPI.get('/hobbie/')
            .then(response => {
                let data = response.data;
                data.forEach((value, index) => {
                    this.optionsHobbie.push({ name: value.nombre_hobbie, id: value.hobbie_id });
                });
            })
            .catch(error => {
                console.log(error)
                this.errored = true
            })
            .finally(() => this.loading = false)




        // SE LLAMA A ESTA FUNCION PARA PODER OBTENER EL USUARIO LOGUEADO.
        // EL PERFIL_USER SE GUARDA EN LA VARIABLE Perfil_Logueado

        let request = { 'token': user.get_header_authorization_token().Authorization.replace("Token ", "") };
        console.log(request);
        getAPI.post('/user_token_admin/', request, {
            headers: user.get_header_authorization_token()
        }).then(response => {
            this.Perfil_Logueado = response.data;
            this.id_user = this.Perfil_Logueado.token;
            console.log("ID USEer")
            console.log(this.id_user);
            getAPI.get("/perfil/" + this.id_user + "/")
                .then(response => {
                    console.log(response.data)
                    this.flagUpdate = true
                    let data = response.data;
                    this.userData.perfil_id = data.perfil_id
                    this.userData.firstname = data.nombre_user
                    this.userData.lastname = data.apellidos_user
                    this.userData.email = data.email
                    this.userData.user = data.user
                    this.userData.selectedCity = data.ciudad
                    this.userData.age = data.edad
                    this.userData.about = data.biografia
                    this.userData.telefono = data.telefono
                    this.userData.whatsapp = data.telefono
                    this.userData.facebook = data.user_facebook
                    this.userData.instagram = data.user_insta
                    this.userData.twitter = data.user_twitter
                    this.userData.selectedGenero = data.genero
                    this.src_image = "http://127.0.0.1:8000/" + data.foto_perfil
                })
                .catch(error => {
                    this.flagUpdate = false
                    console.log(error)
                    this.errored = true
                })
                .finally(() => this.loading = false)

        }).catch(error => {
            console.log(error);
        });




    },
    methods: {
        //Agarrar la imagen subida y guardarla en 'file'
        onFileChange(e) {
            this.file = e.target.files[0];
        },
        submit() {

            let formData = new FormData();
            //file corresponde a la imagen subida
            formData.append('foto_perfil', this.file);
            formData.append('email', this.userData.email);
            formData.append('nombre_user', this.userData.firstname);
            formData.append('apellidos_user', this.userData.lastname);
            formData.append('edad', this.userData.age);
            formData.append('biografia', this.userData.about);
            formData.append('telefono', this.userData.telefono);
            formData.append('username', this.userData.user);
            formData.append('user_facebook', this.userData.facebook);
            formData.append('user_insta', this.userData.instagram);
            formData.append('user_twitter', this.userData.twitter);
            formData.append('ciudad', this.userData.selectedCity);
            formData.append('genero', this.userData.selectedGenero);
            formData.append('user', this.id_user);
            formData.append('foto64', null);


            if (this.flagUpdate == true) {
                let id = this.userData.perfil_id
                getAPI.put(`/perfil/${id}/`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    console.log("Subida exitosa");
                    console.log(res);
                    //guardare hobbies
                    this.guadarHobbies();

                    location.reload();
                }).catch(err => {
                    console.log(err);
                });
            } else {

                getAPI.post(`/perfil/`, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }).then((res) => {
                    console.log("Subida exitosa");
                    console.log(res);
                    location.reload();
                }).catch(err => {
                    console.log(err);
                });

            }

        },
        get_user_logged() {
            return Cookies.get('userLogged')
        },
        //Guardar las hobbies seleccionadaos
        guadarHobbies() {
            for (let i = 0; i < this.userData.selectedHobbie.length; i++) {
                getAPI.post('/listadodehobbies/', {
                    perfil: this.userData.perfil_id,
                    hobbie: this.userData.selectedHobbie[i].id,
                })
                    .then(response => {
                        console.log('Hobbies guardados')
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

    },
    components: {
        navbar1: navbar1,
        sidebar1: sidebar1,
        formLogin: formLogin,
        Detalle1: Detalle1,
        logout: logout,
        VueMultiselect,
    }
}

</script>