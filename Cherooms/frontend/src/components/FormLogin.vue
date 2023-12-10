<template>
    <section class="h-screen">
      <div class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800" role="alert" v-if="verificar_registro">
        <span class="font-medium">{{is_register}}</span> 
    </div>
    <div v-if ="verificar_errores" class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800" role="alert">
  <span class="font-medium">{{errors.wrong_credential}}</span> 
</div>
  <div class="px-6 h-full text-gray-800">
    <div
      class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6"
    >
      <div
        class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0 config-img"
      >
        <img
          src="../assets/login2.jpg"
          class="w-full"
          alt="Sample image"
        />
      </div>
      <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
        <p class="text-login">Login</p>
        <form class="formulario" @submit.prevent="submitForm()">
          <!-- Username input -->
          <div class="mb-6">
            <input
              v-model="username"
              type="text"
              class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              id="user"
              placeholder="Usuario"
            />
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="alert" v-if="errors.username">
            <strong class="font-bold">{{errors.username}}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg id ="flechita" class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>
          </div>
          <!-- Password input -->
          <div class="mb-6">
            <input
              type="password"
              class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              id="password"
              placeholder="Password"
              v-model="password"
            />

            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert" id="alert-1" v-if="errors.password">
            <strong class="font-bold">{{errors.password}}</strong>
            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
            </div>

          </div>
            <div>
              
            </div>
          <div class="flex justify-between items-center mb-6">
            <div class="form-group form-check">
              <input
                type="checkbox"
                class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain float-left mr-2 cursor-pointer"
                id="exampleCheck2"
              />
              <label class="form-check-label inline-block text-gray-800" for="exampleCheck2"
                >Remember me</label
              >
            </div>
          </div>

          <div class=" lg:text-left text-center flex flex-col items-center">
            <button
              type="submit"
              class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out btn-config"
            >
              Login
            </button>
            <p class="text-sm font-semibold mt-2 pt-1 mb-0">       
              <router-link to="/register/" class="text-red-600 hover:text-red-700 focus:text-red-700 transition duration-200 ease-in-out register-conf">
                Register
              </router-link>
            </p>
          </div>
          <div class=" lg:text-left text-center flex flex-col items-center">
            <button
              type="submit"
              class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out btn-config--1"
            >
            <font-awesome-icon icon="fa-brands fa-google"/>
              Sign in whit google
            </button>
            <button
              type="submit"
              class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out btn-config--2"
            >
            <font-awesome-icon icon="fa-brands fa-facebook" />
              Login in whit Facebook 
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
</template>

<style scoped>
 .text-login{
    margin-bottom: 10%;
    font-size: 3em;
    font-weight: bold;
 }

 .btn-config{
  width: 50%;
 }
 .btn-config--1{
  background: white;
  color: black;
  margin-top: 5px;
  margin-bottom: 5px;
  width: 50%;
 }
 .btn-config--2{
  margin-top:5px;
  background-color: #08266f;
  width: 50%;
 }
 .btn-config--1:hover{
  background: white;
 }
 .register-conf{
  color: #3673c5;
  text-decoration: underline;
 }
.register-conf:hover {
  color: #0f3e8d;
}

@media screen and (max-width: 769px) {
  .formulario{
    width: 100%;
  }
  .btn-config--1{
    width: 100%;
  }
  .btn-config--2{
    width: 100%;
    margin-bottom: 10px;
  }
  .btn-config{
    width: 100%;
  }
}

</style>

<script >
import user from "../helper/user"
import { getAPI } from '../axios-api';
  export default {
      name : "FormLogin", 
      data(){
        return{
          username : "",
          password : "",
          token : "",
          is_register : "",
          errors : {
            username : "",
            password : "",
            wrong_credential : "",
          }
        }
      },
      created () {
        if (user.get_user_register()!= undefined){
            this.is_register = user.get_user_register()
        }
      },  
      methods : {
        submitForm :  async function(){
          if(this.isValidForm()){
            let credentials = {
              username : this.username,
              password : this.password,
            }
               this.errors.wrong_credential =  this.$store.dispatch('login',credentials)
               if (this.errors.wrong_credential)
               {
                this.errors.wrong_credential = "El usuario o la contraseña son incorrectos";
               }
          }
          else{
            console.log("Form no valid")
          }
        },
        obtenerObjetoUsuario : function() {
          let usuario  = {
            username : this.username,
            password : this.password
          }
          return JSON.stringify(usuario)
        },
        isValidForm : function(){
          let valid = true
          if(!this.username){
            this.errors.username = "El usuario no puede quedar en blanco"
          }
          else{
            this.errors.username = ""
          }
          if(!this.password){
            this.errors.password = "La contraseña no puede quedar en blanco";
          }
          else{
            this.errors.password = ""
          }
          if(this.errors.username || this.errors.password){
            valid = false
          }
          return valid
        },
        setUserLogin : function (){
          this.$router.push("/panel_publicacion/")
          //location.replace("/departamento/")
        }
      },
      computed : {
        verificar_errores : function(){
          if (this.errors.wrong_credential!=""){
            return true
          }
          else{
            return false
          }
        },
        verificar_registro : function(){
        if(this.is_register){
          return true
        }
        else{
          false
        }
      }
      },
  }
  </script>