<template>
    <div>
        <navbar1></navbar1>
    </div>

    <div class="grid grid-cols-3">
        <div>
            <sidebar1></sidebar1>
        </div>
        <div class="col-span-2">
            <div class="bg-white">
                <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>

                    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
                        <div v-for="product in products" :key="product.id" class="group relative">
                            <div
                                class="min-h-80 aspect-w-1 aspect-h-1 w-full overflow-hidden rounded-md bg-gray-200 group-hover:opacity-75 lg:aspect-none lg:h-80">
                                <img :src="product.imageSrc" :alt="product.imageAlt"
                                    class="h-full w-full object-cover object-center lg:h-full lg:w-full" />
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">
                                        <a :href="product.href">
                                            <span aria-hidden="true" class="absolute inset-0" />
                                            {{ product.name }}
                                        </a>
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">{{ product.color }}</p>
                                </div>
                                <p class="text-sm font-medium text-gray-900">{{ product.price }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a :href="this.$store.state.ruta_foto">
              Aqui esta la prueba de la variable global para la ruta  
            </a>
            <div class="w-full">
                <p>Departamentos</p>
                <div v-for="depa in API_Depa" :key="depa.departamento_id" class="flex">
                    {{ depa.departamento_id }}
                    {{ depa.pais.nombre_pais }}
                    {{ depa.nombre_depa }}
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-center">
        <formLogin ></formLogin>
    </div>
    <div class="flex justify-center">
        <Detalle1></Detalle1>
    </div>
    {{this.$store.state.token}}
        <button @click="get_amigos()">
                click para ver los amigos del usuario registrado
        </button>
    <logout/>

    <button @click="ver_usuario()">
        click par ver el usuario 
    </button>
</template>


<script>
import navbar1 from '../components/Navbar1.vue'
import sidebar1 from '../components/Sidebar1.vue'
import formLogin from '../components/FormLogin.vue'
import Detalle1 from '../components/Detalle1.vue'
import logout from '../components/logout.vue'

import { getAPI } from '../axios-api'


// SE NECESITA IMPORTAR ESTO PARA PODER PODER OBTENER EL USUARIO LOGUEADO
import user from "@/helper/user"



export default {
    name: 'Departamento',
    data() {
        return {
            API_Depa: [],
            token : "",

            // AQUI SE GUARDA EL PERFIL DEL USUARIO LOGUEADO
            Perfil_Logueado : [],
        };
    },
    methods : {
        obtener_cookie : function(){
            console.log(user.get_user_logged())
        },
        get_amigos : function(){
            let url = "/chero_list/"
            getAPI.get(url, {
                headers : user.get_header_authorization_token()
            }).then(
                response => console.log(response.data)
            ).catch(
                error => console.log(error)
            )
        },
        ver_usuario : function(){
            getAPI.post('publicacion_alquiler/',{
                'usuario':'usuario'
            },{
                headers : user.get_header_authorization_token()
            })
        }
    },
    created() {
        getAPI.get('/departamento/',)
            .then(response => {
                console.log('Department API has received data')
                this.API_Depa = response.data;
            })
            .catch(error => {
                console.log(error);
            });


        // SE LLAMA A ESTA FUNCION PARA PODER OBTENER EL USUARIO LOGUEADO.
        // EL PERFIL_USER SE GUARDA EN LA VARIABLE Perfil_Logueado
        getAPI.get('/user_token/', {
            headers : user.get_header_authorization_token()
            }).then(response => {
                    console.log('Perfil logueado obtenido')
                    this.Perfil_Logueado = response.data;
                    console.log(this.Perfil_Logueado)
            }).catch(error => {
                console.log(error);
            });

    },
    components: {
        navbar1: navbar1,
        sidebar1: sidebar1,
        formLogin: formLogin,
        Detalle1: Detalle1,
        logout : logout
    }
};
</script>
  
<script setup>
const products = [
    {
        id: 1,
        name: 'Basic Tee',
        href: '#',
        imageSrc: 'https://tailwindui.com/img/ecommerce-images/product-page-01-related-product-01.jpg',
        imageAlt: "Front of men's Basic Tee in black.",
        price: '$35',
        color: 'Black',
    },

    // More products...
]
</script>