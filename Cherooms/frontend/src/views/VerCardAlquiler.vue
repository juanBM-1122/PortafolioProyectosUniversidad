<template>
  <div>
    <!--NAVBAR SUPERIOR-->
    <div class="sticky z-10 top-0 h-16 border-transparent bg-gray-900 lg:py-2.5">
      <div class="px-6 flex justify-between space-x-4 2xl:container">
        <div class="flex justify-left inline-block items-center content-center">
          <img class="flex inline-block" src="../assets/icon.png" width="20%" />
          <h5 hidden class="
              flex
              text-2xl text-gray-600
              font-medium
              lg:inline-block
              font-bold
            ">
            &nbsp;&nbsp;cheroomSV
          </h5>
        </div>
        <div class="flex space-x-4">
          <button aria-label="chat" class="
              w-10
              h-10
              rounded-xl
              border
              bg-gray-100
              focus:bg-gray-100
              active:bg-gray-200
            ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 m-auto text-gray-600" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" />
            </svg>
          </button>
          <button aria-label="notification" class="
              w-10
              h-10
              rounded-xl
              border
              bg-gray-100
              focus:bg-gray-100
              active:bg-gray-200
            ">
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

    <div class="md:grid md:grid-cols-12 bg-gray-100 ">
      <!--MENU LATERAL-->
      <div class="md:col-span-3">
        <sidebar1 />
      </div>
      <div class="md:col-span-9">
        <BusquedaClases @recibirBusquedaFiltrada="obtenerBusquedaFiltrada"></BusquedaClases>
        <div class="md:grid md:grid-cols-12" v-if="verificar_consultas">
          <div class="md:col-span-4" v-for="post  in alquileres" :key="post.id_alquileres">
            <div class="max-w-xs bg-white shadow-lg rounded-lg overflow-hidden my-10">
              <div class="px-4 py-2">
                <h1 class="text-gray-900 font-bold text-3xl uppercase">{{ post.titulo }}</h1>
                <p class="text-gray-600 text-sm mt-1">
                  {{ post.descrip_lugar }}
                </p>
              </div>
              <img class="h-56 w-full object-cover mt-2" :src="post.ruta_foto" alt="">
              <div class="flex items-center justify-between px-4 py-2 bg-gray-900">
                <h1 class="text-gray-200 font-bold text-xl">${{ post.precio }}</h1>
                <button class="px-3 py-1 bg-gray-200 text-sm text-gray-900 font-semibold rounded">Mas
                  información</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--MENU LATERAL-->

      <!--CONTENIDO-->

      <!--/CONTENIDO-->
    </div>
  </div>
</template>
<script>
import { getAPI } from "@/axios-api";
import user from "@/helper/user";
import BusquedaClases from "@/views/BusquedaClases.vue";
import sidebar1 from "../components/Sidebar1.vue";
import { useMeta } from 'vue-meta'
export default {
  name: 'Detalle Alquiler',
  setup() {
    useMeta({
      title: "Buscar rommies",
      description: "Busca, filtra, conoce y comparte. CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
      'Content-Security-Policy': "upgrade-insecure-requests",
    });
  },
  data() {
    return {
      fotos: [],
      alquileres: [],
      list_filtro: null,
      prueba_comunicacion: null,
    };
  },
  components: {
    BusquedaClases,
    sidebar1,
  },
  created() {
    let url = "publicacion_alquiler/";
    getAPI
      .get(url, { headers: user.get_header_authorization_token() })
      .then((response) => {
        this.alquileres = response.data;
        console.log(response.data);
      })
      .catch((error) => console.log(error));
    getAPI
      .get("foto/", { headers: user.get_header_authorization_token() })
      .then((response) => {
        this.fotos = response.data;
      })
      .catch((error) => console.log(error));
  },
  methods: {
    emparejar_fotos: function () {
      for (let i = 0; i < this.fotos.length; i++) {
        if (this.alquileres[i]?.publicacion_id) {
          if (this.fotos[i].publi_alquiler == this.alquileres[i].publicacion_id) {
            if (this.alquileres[i].ruta_foto) {
              this.alquileres[i].ruta_foto = this.fotos[i].foto64;
            }
          }
        }

      }
    },
    obtenerBusquedaFiltrada: function (busqueda_filtrada) {
      this.fotos = busqueda_filtrada.fotos
      this.alquileres = busqueda_filtrada.publicaciones;
      console.log(this.fotos)
      console.log(this.alquileres)
    },
  },
  watch: {
    alquileres: function (newAlquileres, oldAlquileres) {
      this.alquileres = newAlquileres
    }
  },
  computed: {
    verificar_consultas: function () {
      if (this.fotos && this.alquileres) {
        this.emparejar_fotos();
        console.log("se ejecuta esto cuando se actualiza")
        return true;
      } else {
        return false;
      }
    },
  },
};
</script>
