<template>

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

  <body class="py-20 flex flex-col items-center justify-center">
      <div class="xl:w-1/2 w-11/12">
          <h1 role="heading" tabindex="0" class="text-6xl font-bold 2xl:leading-10 leading-0 text-center text-gray-800">Conoce, Conecta, Comparte</h1>
          <h2 role="contentinfo" tabindex="0" class="text-base leading-normal text-center text-gray-600 mt-5">En cheroomsv puedes encontrar a tu roommie ideal. ¡Que esperas!</h2>
          <br><br>
          <router-link to="/login" class="rounded-full mt-5 bg-sky-500 py-4 px-6">Ingresar Ahora</router-link>
      </div>
      <div class="2xl:px-20 lg:px-12 px-4 flex flex-wrap items-start mt-4">
          <div class="mt-24">
              <div class="flex items-end">
                  <img tabindex="0" src="https://i.ibb.co/kBgtHK6/Rectangle-5.png" alt="girl with blue background" class="w-20 h-20 rounded-lg mr-6" />
                  <img tabindex="0" src="https://i.ibb.co/9nLBtjx/Rectangle-3.png" alt="guy winking" class="w-48 h-36 rounded-lg" />
              </div>
              <div class="flex items-center justify-end my-6">
                  <img tabindex="0" src="https://i.ibb.co/jRbF1KF/Rectangle-4.png" alt="guy smiling" />
              </div>
              <div class="flex items-start">
                  <img tabindex="0" src="https://i.ibb.co/Sf4Q94L/Rectangle-6.png" alt="girl with bluw background" class="w-48 h-48 rounded-lg" />
                  <img tabindex="0" src="https://i.ibb.co/fnNqJrx/Rectangle-7.png" alt="guy with glasses" class="w-20 h-20 rounded-lg ml-6 flex-shrink-0 object-cover object-fit" />
              </div>
          </div>
          <div class="ml-6 mt-32">
              <img tabindex="0" src="https://i.ibb.co/LSxy7fy/Rectangle-9.png" class="w-72 h-80 rounded-lg" alt="guy with sunglasses" />
              <div class="flex items-start mt-6">
                  <img tabindex="0" src="https://i.ibb.co/X8PKD3q/Rectangle-8.png" alt="girl  laughing" class="w-48 h-48 rounded-lg" />
                  <img tabindex="0" src="https://i.ibb.co/2Yj51CY/Rectangle-13.png" alt="guy with glasses" class="w-20 h-20 rounded-lg ml-6 object-cover object-fit" />
              </div>
          </div>
          <div class="mt-14 ml-6">
              <div class="lg:flex">
                  <div>
                      <img tabindex="0" src="https://i.ibb.co/bWGVSkP/Rectangle-10.png" alt="group of friends" class="w-96 h-72 rounded-lg object-center object-fit" />
                  </div>
                  <div>
                      <div class="flex ml-6">
                          <img tabindex="0" src="https://i.ibb.co/80jvpSv/Rectangle-16.png" class="w-20 h-20 rounded-lg mt-14" alt="man" />
                          <img tabindex="0" src="https://i.ibb.co/6PR2Y74/Rectangle-15.png" class="w-20 h-24 rounded-lg ml-6" alt="woman" />
                      </div>
                      <img tabindex="0" src="https://i.ibb.co/M5rvjhk/Rectangle-14.png" alt="boy with blonde hair" class="ml-6 mt-6 w-48 h-32 rounded-lg" />
                  </div>
              </div>
              <div class="mt-6 flex">
                  <img tabindex="0" class="w-48 h-48 rounded-lg" src="https://i.ibb.co/GPpMsbr/Rectangle-12.png" alt="young girl with red hair" />
                  <img tabindex="0" class="w-72 h-56 rounded-lg ml-6" src="https://i.ibb.co/VBcgkVL/Rectangle-11.png" alt="young girl with red hair" />
              </div>
          </div>
      </div>
  </body>
</template>


<script>
import Navbar1Vue from '@/components/Navbar1.vue';
import router from '@/router';
import { useMeta } from 'vue-meta'
export default {
  name: 'HomeView',
  setup() {
    useMeta({
      title: "Home",
      description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "rommie, alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, sv",
      'Content-Security-Policy': "upgrade-insecure-requests",
      og: {
        title: "Home | CheroomSV",
        description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
        image: "https://i.ibb.co/LSxy7fy/Rectangle-9.png",
        url: "https://cheroomsv.com/",
        site_name: "CheroomSV",
        type: "website",
        locale: "es_ES",
        'Content-Security-Policy': "upgrade-insecure-requests",
      },
    });
  },
  components: {
    Navbar1Vue,
    router
}
}
</script>
