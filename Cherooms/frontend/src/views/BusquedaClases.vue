<template>
<div>   <!--CONTENIDO-->
    <div class="flex p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800" role="alert" v-if="alerta">
  <svg aria-hidden="true" class="flex-shrink-0 inline w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
  <span class="sr-only">Info</span>
  <div>
    <span class="font-medium">Info alert!</span> Al parecer no hay resultados para esta busqueda
  </div>
</div>
<div class="mt-5 md:col-span-8 md:mt-0 border-transparent bg-gray-100">
    <div class="shadow sm:overflow-hidden sm:rounded-md "> 
        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">


            <div class="grid grid-cols-3 gap-6 ajuste-grid">
                <div class="col-span-3 sm:col-span-2 ajuste-input">
                    <label for="company-website"
                        class="block text-left text-sm font-medium text-gray-700">
                        Ubica los roommates de donde desees
                    </label>
                        <div>
                        <input type="text" v-model="param_ciudad" required class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm "
                        @input="obtenerFiltro()" id = "inputCiudad"/>                                  
                        <ul v-if="habilitar_filtro_lista">
                            <li v-for="ciudad in lista_filtro_ciudades" :key="ciudad.ciudad_id" class="hover:bg-indigo-600 li-config ciudad" 
                            @click="seleccionar_ciudad_filtro(ciudad.ciudad_id)" :id = "'ciudad '+ciudad.ciudad_id">
                                {{ciudad.nombre_ciudad}}
                            </li>
                        </ul> 
                        </div>                             
                </div>
                <!--
                    prueba de componente
                -->
                    

                <!--Fin de prueba del componente-->

                <div class="col-span-3 sm:col-span-2">

                    <div class="mt-1 flex rounded-md shadow-sm">

                        <div>
                            <label for="company-website"
                                class="block text-left text-sm font-medium text-gray-700">Necesidad</label>
                            <select v-model="tipo_usuario"
                                class="block rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" >
                                <option value="Tengo Cuarto">Tengo cuarto</option>
                                <option value="Necesito Cuarto">Necesito Cuarto</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="company-website"
                                class="block text-left text-sm font-medium text-gray-700">Renta</label>
                            <select v-model="monto_renta"
                                class="block rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option disabled value="">Please select one</option>
                                <option value="700">$0 a $700</option>
                                <option value="2500">$701 a $2500</option>
                                <option value="10000000000">mas de $2500</option>
                            </select>
                        </div>

                        <div>
                            <label for="company-website"
                                class="block text-left text-sm font-medium text-gray-700">Departamento</label>
                            <select v-model="departamento"
                                class="block rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option v-for="dep in list_departamento" :key="dep.departamento_id" :value="dep.departamento_id">{{dep.nombre_depa}}</option>
                            </select>
                        </div>
                        <button type="submit" class="block rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 ajuste-boton"
                            @click="obtener_datos_filtrados()"
                        >Buscar</button>    
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!--/CONTENIDO-->
    </div>
</template>

<style scoped>
  .ajuste-grid{
        display: flex;
        justify-content: flex-start;
  }
  .ajuste-input{
    width: 50%;
  }
  .ajuste-boton{
    margin-left: 2%;
  }
  select {
    margin-left: 2px;
  }
  ul{
    position: absolute;
    z-index: 90px;
    background-color: white;
    width:  48%;
    margin-top: 0.05%;
  }
  .li-config:hover{
    color: white;
    cursor: pointer;
    padding: 5px;
  }
  
/*
<!--hay que terminar de hacer la barra responsiva -->
*/
</style>

<script>
import CheckBoxMamalon from '../components/CheckBoxMamalon.vue'
import SimpleForm from '../components/SimpleForm.vue'
import VueMultiselect from 'vue-multiselect'
import sidebar1 from '../components/Sidebar1.vue'
import { getAPI } from '../axios-api'
import user from '../helper/user'

export default {
    name: 'Busqueda',
    data (){
        return {
            departamento : null,
            tipo_usuario : null,
            monto_renta : 0,
            param_ciudad : null,
            list_departamento : [],
            lista_filtro_ciudades : null,
            request_data_filter : null,
            filtro_error : false,
        }
    },
    methods:{
        recibirBusquedaFiltrada : function (){
            //modiificar para que mande los filtros de verdad
            //this.obtener_datos_filtrados()
            //this.$emit('recibirBusquedaFiltrada',this.request_data_filter)
            //console.log(this.request_data_filter)
        },
        validar_filtros : function(){
            if(this.departamento || this.tipo_usuario || this.monto_renta || this.param_ciudad){
                    return true
            }   
            else{
                return false
            }
        },
        obtener_datos_filtrados : function(){
            if (this.validar_filtros()){
                let parametros_url = "/publicacion_alquiler?departamento="+this.departamento+"&tipo_usuario="+this.tipo_usuario+"&monto_renta="+this.monto_renta+"&ciudad="+this.param_ciudad+"&es_filtro=true"
            getAPI.get(parametros_url,
            {
                headers : user.get_header_authorization_token()
            }
            ).then(
                (response) =>{
                    //this.request_data_filter = response.data
                    this.filtro_error = false
                    this.tipo_usuario = null,
                    this.monto_renta = 0,
                    this.param_ciudad = null,
                    this.departamento = null,
                    this.$emit('recibirBusquedaFiltrada',response.data)
                }
            ).catch(
                error =>{
                    this.filtro_error = true,
                    this.tipo_usuario = null,
                    this.monto_renta = 0,
                    this.param_ciudad = null,
                    this.departamento = null,
                    console.log(error)
                }
            )
            }
            else{
                console.log("Reiniciar es cierto")
                let parametros_url = "publicacion_alquiler?reiniciar=True";
                getAPI.get(parametros_url,
                {
                    headers : user.get_header_authorization_token()
                }).then(
                    (response) =>{
                    this.tipo_usuario = null,
                    this.monto_renta = 0,
                    this.param_ciudad = null,
                    this.departamento = null,
                    this.$emit('recibirBusquedaFiltrada',response.data)
                    }
                )
            }
        },
        obtenerFiltro : function(){
            let url = 'ciudad/?nombre_ciudad='+this.param_ciudad+"&es_filtro=true"
            getAPI.get(url).then(
                response => this.lista_filtro_ciudades = response.data
            ).catch(
                err => {console.log(err)
                        this.lista_filtro_ciudades = null
                }
            )
        },
        seleccionar_ciudad_filtro : function(ciudad_id){
           let li = document.getElementById("ciudad "+ciudad_id)
           this.param_ciudad = li.textContent
           this.lista_filtro_ciudades = null;
        },
        reiniciar_elementos : function(){
            console.log("hicimos click en el template")
            this.lista_filtro_ciudades = null;
        }
    },
    computed:{
        habilitar_filtro_lista: function(){
            if (this.lista_filtro_ciudades!=null){
                    return true;
            }
            else{
                return false;
            }
        },
        alerta : function(){
            if (this.filtro_error == true){
                return true
            }
            else{
                return false
            }
        }
    },
    components: {
        CheckBoxMamalon: CheckBoxMamalon,
        SimpleForm: SimpleForm,
        VueMultiselect,
        sidebar1: sidebar1,
    },
    created(){
        let url = "departamento/"
        getAPI.get(url).then(
            response => {
                this.list_departamento = response.data
            }
        ).catch(
            error =>{
                console.log(error)
            }
        )
    }
};
</script>