<template>
  <section class="h-screen">
    <div v-if="verificar_errores"
      class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
      <span class="font-medium">{{ errors.wrong_credential }}</span>
    </div>
    <div class="px-6 h-full text-gray-800">
      <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
        <div class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0 config-img">
          <img src="../assets/login2.jpg" class="max-w-full h-auto" alt="Sample image" />
        </div>
        <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
          <p class="text-login">Registrarse</p>
          <form class="formulario" @submit.prevent="submitForm()">
            <!-- Username input -->
            <div class="mb-6">
              <input v-model="username" type="text"
                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="user" placeholder="Username" />

              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert" v-if="errors.username">
                <strong class="font-bold">{{ errors.username }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>

            <!-- Name input -->
            <div class="mb-6">
              <input v-model="name" type="text"
                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="user" placeholder="Nombre" />

              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert" v-if="errors.name">
                <strong class="font-bold">{{ errors.name }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>

            <!-- Last Name input -->
            <div class="mb-6">
              <input v-model="lastName" type="text"
                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="user" placeholder="Apellidos" />

              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert" v-if="errors.lastName">
                <strong class="font-bold">{{ errors.lastName }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>

            <!--Sexo input-->
            <div class="mb-6">
              <select id="countries"
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 genero"
                v-model="genero">
                <option value="Seleccione su sexo">Seleccione su sexo </option>
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
              </select>
            </div>

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
              id="alert" v-if="errors.genero">
              <strong class="font-bold">{{ errors.genero }}</strong>
              <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                  <title>Close</title>
                  <path
                    d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                </svg>
              </span>
            </div>

            <!--Ciudad Input-->

            <div class="mb-6" v-if="lista_ciudades">
              <select id="countries"
                class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 genero"
                v-model="ciudad">
                <option selected value="Seleccione su ciudad">Seleccione su ciudad</option>
                <option v-for="ciudad in lista_ciudades" :key="ciudad.ciudad_id" :value="ciudad.ciudad_id">
                  {{ ciudad.nombre_ciudad }}</option>
              </select>
              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert" v-if="errors.ciudad">
                <strong class="font-bold">{{ errors.ciudad }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>

            <!-- Email input -->
            <div class="mb-6">
              <input v-model="email" type="email"
                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="user" placeholder="roomate@gmail.com" />

              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert" v-if="errors.email">
                <strong class="font-bold">{{ errors.email }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg id="flechita" class="fill-current h-6 w-6 text-red-500" role="button"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>



            <!-- Password input -->
            <div class="mb-6">
              <input type="password"
                class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                id="password" placeholder="Password" v-model="password" />

              <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert"
                id="alert-1" v-if="errors.password">
                <strong class="font-bold">{{ errors.password }}</strong>
                <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                  <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20">
                    <title>Close</title>
                    <path
                      d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z" />
                  </svg>
                </span>
              </div>
            </div>
            <!--prueba buttons-->
            <div class="flex items-center">
              <input checked id="default-radio-2" type="radio" value="necesito_cuarto" name="default-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                v-model="tipo_usuario">
              <label for="default-radio-2" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Necesito
                Cuarto</label>
            </div>
            <div class="flex items-center mb-4">
              <input id="default-radio-1" type="radio" value="tengo_cuarto" name="default-radio"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                v-model="tipo_usuario">
              <label for="default-radio-1" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Tengo
                Cuarto</label>
            </div>
            <!--fin prueba buttons-->


            <div class=" lg:text-left text-center flex flex-col items-center">
              <button type="submit"
                class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out btn-config">
                Registrarse
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>
  
<style scoped>
.text-login {
  margin-bottom: 10%;
  font-size: 2em;
  font-weight: bold;
}

.btn-config {
  width: 50%;
}

.btn-config--1 {
  background: white;
  color: black;
  margin-top: 5px;
  margin-bottom: 5px;
  width: 50%;
}

.btn-config--2 {
  margin-top: 5px;
  background-color: #08266f;
  width: 50%;
}

.btn-config--1:hover {
  background: white;
}

.register-conf {
  color: #3673c5;
  text-decoration: underline;
}

.register-conf:hover {
  color: #0f3e8d;
}

.genero {
  font-size: 100%;
  border-radius: 5px;
  padding: 2%;
}



@media screen and (max-width: 769px) {
  .formulario {
    width: 100%;
  }

  .btn-config--1 {
    width: 100%;
  }

  .btn-config--2 {
    width: 100%;
    margin-bottom: 10px;
  }

  .btn-config {
    width: 100%;
  }
}
</style>
  
<script >
import user from "../helper/user";
import { getAPI } from '../axios-api';
import { useMeta } from 'vue-meta'
export default {
  name: "FormLogin",
  setup() {
    useMeta({
      title: "¡Un paso mas!",
      description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
      'Content-Security-Policy': "upgrade-insecure-requests",
    });
  },
  data() {
    return {
      username: "",
      name: "",
      lastName: "",
      genero: "Seleccione su sexo",
      email: "",
      password: "",
      token: "",
      tipo_usuario: "necesito_cuarto",
      necesito_cuarto: null,
      ciudad: "Seleccione su ciudad",
      lista_ciudades: [],
      errors: {
        username: "",
        name: "",
        lastName: "",
        email: "",
        password: "",
        genero: "",
        wrong_credential: "",
      }
    }
  },
  methods: {
    submitForm: function () {
      if (this.isValidForm()) {
        const url = "register/"
        getAPI.post(url, {
          username: this.username,
          name: this.name,
          lastName: this.lastName,
          email: this.email,
          sexo: this.genero,
          password: this.password,
          necesita_cuarto: this.necesito_cuarto,
          ciudad: this.ciudad
        },
        )
          .then(response => {
            user.set_user_register(this.username)

            this.$router.push('/login')
            this.errors.wrong_credential
          })
          .catch(error => {
            this.errors.wrong_credential = error["response"]["data"]['error']
          })
      }
      else {
        console.log("Form no valid")
      }
    },
    obtenerObjetoUsuario: function () {
      let usuario = {
        username: this.username,
        password: this.password
      }
      return JSON.stringify(usuario)
    },
    isValidForm: function () {
      let valid = true
      if (!this.username) {
        this.errors.username = "El usuario no puede quedar en blanco";
      }
      else {
        this.errors.username = ""
      }
      if (!this.name) {
        this.errors.name = "El nombre no puede qudar vacio";
      }
      else {
        this.errors.name = ""
      }
      if (!this.lastName) {
        this.errors.lastName = "El/los apellidos no pueden quedar vacios";
      }
      else {
        this.errors.lastName = "";
      }
      if (this.genero === "Seleccione su sexo") {
        this.errors.genero = "Necesita seleccionar su sexo";
      }
      else {
        this.errors.genero = "";
      }
      if (this.ciudad === "Seleccione su ciudad") {
        this.errors.ciudad = "Necesita seleccionar una ciudad"
      }
      else {
        this.errors.ciudad = ""
      }
      if (this.validar_email()) {
        this.errors.email = ""
      }
      else {
        this.errors.email = "verifique el email se un email valido"
      }
      if (!this.password) {
        this.errors.password = "La contraseña no puede quedar en blanco";
      }
      else {
        this.errors.password = ""
      }
      if (this.errors.username || this.errors.password || this.errors.lastName || this.errors.genero || this.errors.email || this.errors.password || this.errors.ciudad) {
        valid = false
      }
      if (this.tipo_usuario == "necesito_cuarto")
        this.necesito_cuarto = true
      else if (this.tipo_usuario == "tengo_cuarto")
        this.necesito_cuarto = false
      return valid
    },
    setUserLogin: function () {
      this.$router.push("/panel_publicacion")
      //location.replace("/departamento/")
    },
    validar_email: function () {
      let expRegularEmail = new RegExp("^[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$");
      return expRegularEmail.test(this.email)
    }
  },
  created(){
          let url = '/ciudad/'
          getAPI.get(url).then(response =>{
            this.lista_ciudades = response.data
          }).catch(
            console.log("No hay ciudades en la base de datos")
          )
        },
  computed: {
    verificar_errores: function () {
      if (this.errors.wrong_credential != "") {
        return true
      }
      else {
        return false
      }
    }
  }
}
</script>