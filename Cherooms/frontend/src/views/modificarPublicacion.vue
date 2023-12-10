<template>
    <div>
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

        <div class="md:grid md:grid-cols-12 bg-gray-100">



            <!--MENU LATERAL-->
            <div class="md:col-span-3">
                <sidebar1 />
            </div>
            <!--MENU LATERAL-->


            <!--CONTENIDO-->
            <div class="mt-5 md:col-span-8 md:mt-0 border-transparent bg-gray-100">

                <form @submit.prevent="onSubmit">
                    <br>
                    <p class="font-sans text-2xl font-bold">¡Publica la informacion de tu alquiler!</p>
                    <br>
                    <div class="shadow sm:overflow-hidden sm:rounded-md">
                        <div class="space-y-6 bg-white px-4 py-5 sm:p-6">


                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="company-website"
                                        class="block text-left text-sm font-medium text-gray-700">Ponle un titulo a tu
                                        publicaci&oacute;n</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <!-- <span
                                            class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">http://</span> -->
                                        <input type="text" v-model="titulo" required
                                            class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Se renta casa en..." />
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label for="about" class="block text-sm font-medium text-gray-700 text-left">Describe tu
                                    hogar y lo que esperas compartir!</label>
                                <div class="mt-1">
                                    <textarea id="about" name="about" rows="3" v-model="descrip_lugar" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                        placeholder="Mi casita humilde..." />
                                </div>
                                <p class="mt-2 text-sm text-gray-500"></p>
                            </div>


                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-3">
                                    <label for="first-name"
                                        class="block text-sm font-medium text-gray-700 text-left">Departamento</label>
                                    <select v-model="depa_seleccion" name="departamento" id="departamento_id" required
                                        v-on:change="getCiudadFiltro"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled value="">Seleccione un elemento</option>
                                        <option v-for="depa in API_Depa" :key="depa.departamento_id"
                                            v-bind:value="depa">
                                            {{ depa.nombre_depa }}
                                        </option>
                                    </select>
                                    <br>
                                    <label for="last-name"
                                        class="block text-sm font-medium text-gray-700 text-left">Ciudad</label>
                                    <select name="ciudad" id="ciudad_id" v-model="ciu_seleccion" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option disabled value="">Seleccione un elemento</option>
                                        <option v-for="ciu in cius" :key="ciu.ciudad_id" v-bind:value="ciu"> {{
                                                ciu.nombre_ciudad
                                        }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-3">
                                    <p class="text-bold text-sm">GOOGLE MAPS HERE</p>
                                </div>
                            </div>

                            <div class="text-left text-sm">
                                <label>Amenidades</label>
                                <VueMultiselect class="text-sm" v-model="amenis_seleccion" :options="API_Amenidad"
                                    :multiple="true" :close-on-select="false"
                                    placeholder="Seleccione las comodidades de su hogar..." label="nombre_amenidad"
                                    track-by="nombre_amenidad" required />
                            </div>


                            <div class="grid grid-cols-4 gap-2 block-inline">

                                <div class="col-span-2">
                                    <label for="renta"
                                        class="block text-left text-sm font-medium text-gray-700">Renta</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">$</span>
                                        <input type="number" name="renta" id="rent" v-model="precio"
                                            class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="Valor de la cuota mensual, trimestral..." required />
                                    </div>
                                </div>

                                <div class="col-span-2">
                                    <label for="ocupo" class="block text-left text-sm font-medium text-gray-700">Max.
                                        Ocupantes</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="ocupantes" id="ocu" v-model="num_ocupantes"
                                            class="block w-full flex-1 rounded-none rounded-r-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                                            placeholder="2 personas..." required />
                                    </div>
                                </div>

                            </div>


                            <div>
                                <label for="contrat" class="block text-left text-sm font-medium text-gray-700">Tiempo
                                    inicial de Contrato</label>
                                <select name="contrato" id="contrato_id" v-model="tiempo_contrato" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    <option disabled selected value="">Seleccione un tipo de contrato</option>
                                    <option value="Mensual">Mensual</option>
                                    <option value="Trimestral">Trimestral</option>
                                    <option value="Semestral">Semestral</option>
                                    <option value="Anual">Anual</option>
                                </select>
                            </div>

                            <div class="text-left">
                                <label for="activ" class="block text-left text-sm font-medium text-gray-700"></label>
                                <div class="flex items-start">
                                    <div class="flex h-5">
                                        <input id="comments" name="comments" type="checkbox" v-model="p_activa"
                                            class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="comments" class="font-medium text-gray-700 text-left">Publicacion
                                            Activa</label>
                                        <p class="text-gray-500 text-left">Especifique si la publicacion se mostrará a
                                            los demás</p>
                                    </div>
                                </div>
                            </div>





                            <!-- <div>
                                <label class="block text-sm font-medium text-gray-700">Sube fotos del loca</label>
                                <div class="mt-1 flex items-center">
                                    <span class="inline-block h-12 w-12 overflow-hidden rounded-full bg-gray-100">
                                        <svg class="h-full w-full text-gray-300" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </span>
                                    <button type="button"
                                        class="ml-5 rounded-md border border-gray-300 bg-white py-2 px-3 text-sm font-medium leading-4 text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Change</button>
                                </div>
                            </div> -->

                            <div>
                                <label class="block text-sm font-medium text-gray-700 text-left">Sube una foto del
                                    lugar</label>
                                <div
                                    class="mt-1 flex justify-center rounded-md border-2 border-dashed border-gray-300 px-6 pt-5 pb-6">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="file"
                                                class="relative cursor-pointer rounded-md bg-white font-medium text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:text-indigo-500">
                                                <span>Sube una imagen</span>
                                                <input type="file" id="file" ref="file" @change="onFileChange"/>
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF de hasta 10MB</p>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                </div>
                                <div class="bg-black">
                                    <img v-if="foto_ORIGIN" :src="foto_ORIGIN.foto64" width="100" height="100" alt="icon">
                                </div>
                                
                            </div>
                        </div>

                        <div class="bg-gray-50 px-4 py-3 sm:px-6 flex justify-between">
                            <button type="submit"
                                class="inline-flex rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white 
                                shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Guardar</button>
                            <button type="button" @click="regresar"
                                class="inline-flex rounded-md border border-transparent bg-red-600 py-2 px-4 text-sm font-medium text-white 
                                shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Cancelar</button>
                        </div>

                    </div>
                </form>

            </div>
            <!--/CONTENIDO-->
            <div class="md:col-span-1">
            </div>

        </div>
    </div>
</template>

<style src="vue-multiselect/dist/vue-multiselect.css">

</style>

<script>
import CheckBoxMamalon from '../components/CheckBoxMamalon.vue'
import SimpleForm from '../components/SimpleForm.vue'
import VueMultiselect from 'vue-multiselect'
import sidebar1 from '../components/Sidebar1.vue'
import { getAPI } from '../axios-api'
import user from '../helper/user'
import { useMeta } from 'vue-meta'
export default {
    name: 'Mod_Publicacion',
    setup() {
        useMeta({
            title: "Cambios en el hogar...",
            description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de su roomate ideal.",
            keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
            'Content-Security-Policy': "upgrade-insecure-requests",
        });
    },
    data() {
        return {
            //INFO DE LA PUBLICACION TRAIDA
            publi_ORIGIN: [],
            amenis_ORIGIN: [],
            foto_ORIGIN: [],
            listAmenis_ORIGIN: [],

            fotito: '',
            // AQUI SE GUARDA EL PERFIL DEL USUARIO LOGUEADO
            Perfil_Logueado: [],
            //Datos a enviar al servidor para crear una nueva publicacion
            perfil: null,
            titulo: "",
            descrip_lugar: "",
            coordenadas: "",
            num_ocupantes: 0,
            precio: 0,
            tiempo_contrato: "",
            p_activa: false,
            //Datos para el formulario
            file: null,
            publi_creada: [],
            depa_seleccion: [],
            ciu_seleccion: [],
            cius: [],
            amenis_seleccion: [],
            //Datos para mostrar en el formulario
            API_Depa: [],
            API_Ciudad: [],
            API_Amenidad: [],
            API_Publicacion: [],
            API_Foto: [],
            API_List_Amenidad: [],
        };
    },
    created() {
        // SE LLAMA A ESTA FUNCION PARA PODER OBTENER EL USUARIO LOGUEADO.
        // EL PERFIL_USER SE GUARDA EN LA VARIABLE Perfil_Logueado
        getAPI.get('/user_token/', {
            headers: user.get_header_authorization_token()
        }).then(response => {
            console.log('Perfil logueado obtenido')
            this.Perfil_Logueado = response.data;

            //console.log(this.Perfil_Logueado)
        }).catch(error => {
            console.log(error);
        });

        //API's para traer los datos del formulario
        getAPI.get('/departamento/',)
            .then(response => {
                console.log('Department API has received data')
                this.API_Depa = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        getAPI.get('/ciudad/',)
            .then(response => {
                console.log('Ciudad API has received data')
                this.API_Ciudad = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        getAPI.get('/amenidades/',)
            .then(response => {
                console.log('Amendidad API has received data')
                this.API_Amenidad = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        getAPI.get('/lista_amenidad/',)
            .then(response => {
                console.log('Lista Amenidad API has received data')
                this.API_List_Amenidad = response.data;
            })
            .catch(error => {
                console.log(error);
            });
        getAPI.get('/foto/',)
            .then(response => {
                console.log('Foto API has received data')
                this.API_Foto = response.data;
            })
            .catch(error => {
                console.log(error);
            });
    },
    mounted() {
        this.obt_PubliUser();
    },
    methods: {
        regresar() {
            this.$router.push('/panel_publicacion');
        },
        obt_PubliUser() {
            getAPI.get('/publicacion_alquiler/', {
                headers: user.get_header_authorization_token()
            })
                .then(response => {
                    console.log('Publicacion API has received data')
                    this.API_Publicacion = response.data;
                    // console.log(this.API_Publicacion[0].perfil.perfil_id)
                    // console.log(this.Perfil_Logueado.perfil_id)
                })
                .then(_ => {
                    this.getPublicacionFiltro();
                })
                .then(_ => {
                    this.getFotoFiltro();
                })
                .then(_ => {
                    this.getAmenidadFiltro();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        getPublicacionFiltro() {
            for (let i = 0; i < this.API_Publicacion.length; i++) {
                if (this.API_Publicacion[i].perfil.perfil_id == this.Perfil_Logueado.perfil_id) {
                    console.log("PUBLICACION A MOD " + this.API_Publicacion[i].titulo)

                    this.publi_ORIGIN = this.API_Publicacion[i];

                    this.perfil = this.Perfil_Logueado;
                    this.publi_creada = this.API_Publicacion[i];
                    this.titulo = this.API_Publicacion[i].titulo;
                    this.descrip_lugar = this.API_Publicacion[i].descrip_lugar;
                    this.coordenadas = this.API_Publicacion[i].coordenadas;
                    this.num_ocupantes = this.API_Publicacion[i].num_ocupantes;
                    this.precio = this.API_Publicacion[i].precio;
                    this.tiempo_contrato = this.API_Publicacion[i].tiempo_contrato;
                    this.p_activa = this.API_Publicacion[i].p_activa;
                }
            }
            console.log("Datos obtenidos de la publicacion" + this.Perfil_Logueado.perfil_id + " --" + this.API_Publicacion[0].perfil.perfil_id)
        },

        getFotoFiltro() {
            for (let i = 0; i < this.API_Foto.length; i++) {
                if (this.API_Foto[i].publi_alquiler == this.publi_creada.publicacion_id) {
                    this.foto_ORIGIN = this.API_Foto[i];
                    console.log(this.foto_ORIGIN.foto_lugar)
                }
            }
            console.log("Foto obtenida de la publicacion")
        },
        getAmenidadFiltro() {
            this.amenis_ORIGIN = [];
            this.amenis_seleccion = [];
            for (let i = 0; i < this.API_List_Amenidad.length; i++) {
                console.log("Amenidad " + this.API_List_Amenidad[i].publicacion.titulo)
                if (this.API_List_Amenidad[i].publicacion.publicacion_id == this.publi_creada.publicacion_id) {
                    this.amenis_seleccion.push(this.API_List_Amenidad[i].amenidad);
                    this.listAmenis_ORIGIN.push(this.API_List_Amenidad[i]);
                    this.amenis_ORIGIN.push(this.API_List_Amenidad[i].amenidad);
                }
            }
            console.log("Amenidades obtenidas de la publicacion")
        },
        onSubmit() {
            this.updatePublicacion();
        },
        //Filtro de ciudad segun seleccion de departamento
        getCiudadFiltro() {
            this.cius = []
            for (let i = 0; i < this.API_Ciudad.length; i++) {
                if (this.API_Ciudad[i].departamento.nombre_depa == this.depa_seleccion.nombre_depa) {
                    this.cius.push(this.API_Ciudad[i])
                }
            }
        },
        updatePublicacion() {
            getAPI.put('/publicacion_alquiler/' + this.publi_creada.publicacion_id + '/', {
                titulo: this.titulo,
                descrip_lugar: this.descrip_lugar,
                coordenadas: this.coordenadas,
                num_ocupantes: this.num_ocupantes,
                precio: this.precio,
                tiempo_contrato: this.tiempo_contrato,
                p_activa: this.p_activa,
                perfil: this.perfil.perfil_id,
            }, {
                headers: user.get_header_authorization_token()
            })
                .then(response => {
                    console.log('Publicacion API has received data')
                    console.log(response.data);
                    //Guardo la publicacion creada para usar el id en el submit de las FOTOS
                    this.publi_creada = response.data;
                    //Llamo a la funcion que sube las fotos
                    if(this.file != null){
                        this.uploadFile();
                    }
                    //Llamo a la funcion que guarda las amenidades
                    this.updateAmenidades();
                })
                .then(response => {
                    console.log('Publicacion updated')
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error);
                });
        },
        
        updateAmenidades() {
            for (let i = 0; i < this.listAmenis_ORIGIN.length; i++) {
                getAPI.delete('/lista_amenidad/' + this.listAmenis_ORIGIN[i].listamenidad_id + '/', {
                    headers: user.get_header_authorization_token()
                })
                    .then(response => {
                        console.log('Amenidad deleted')
                        console.log(response.data)
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
            for (let i = 0; i < this.amenis_seleccion.length; i++) {
                getAPI.post('/lista_amenidad/', {
                    publicacion: this.publi_creada.publicacion_id,
                    amenidad: this.amenis_seleccion[i].amenidad_id,
                }, {
                    headers: user.get_header_authorization_token()
                })
                    .then(response => {
                        console.log('Amenidad created')
                        console.log(response.data)
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },

        //Agarrar la imagen subida y guardarla en 'file'
        onFileChange(e) {
            this.file = e.target.files[0];
        },
        eliminarFoto() {
            getAPI.delete('/foto/' + this.foto_ORIGIN.foto_id + '/', {
                headers: user.get_header_authorization_token()
            })
                .then(response => {
                    console.log('Foto deleted')
                    console.log(response.data)
                })
                .catch(error => {
                    console.log(error);
                });
        },
        //Enviar la imagen al servidor
        uploadFile() {
            //Eliminamos la foto anterior
            this.eliminarFoto();
            const formData = new FormData();
            //file corresponde a la imagen subida
            formData.append('foto_lugar', this.file);
            getAPI.post('/foto/', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                console.log("Subida de foto exitosa");
                console.log(res);
            }).catch(err => {
                console.log(err);
            });
        },








        //Funcion para POST de nueva publicacion
        submitNewPublicacion() {
            getAPI.post('/publicacion_alquiler/', {
                perfil: this.perfil,
                titulo: this.titulo,
                descrip_lugar: this.descrip_lugar,
                //Por ahora que no está lo de Maps
                coordenadas: this.depa_seleccion.nombre_depa + " " + this.ciu_seleccion.nombre_ciudad,
                num_ocupantes: this.num_ocupantes,
                precio: this.precio,
                tiempo_contrato: this.tiempo_contrato,
                fecha_publi: new Date().toISOString().slice(0, 10),
                p_activa: this.p_activa,
            }, {
                headers: user.get_header_authorization_token(),
            })
                .then(response => {
                    console.log('Publicacion API has received data')
                    console.log(response.data);
                    //Guardo la publicacion creada para usar el id en el submit de las FOTOS
                    this.publi_creada = response.data;
                    //Llamo a la funcion que sube las fotos
                    this.uploadFile();
                    //Llamo a la funcion que guarda las amenidades
                    this.guadarAmenidades();
                })
                .catch(error => {
                    console.log(error);
                });
        },
        
        //Guardar las amenidades seleccionadas
        guadarAmenidades() {
            for (let i = 0; i < this.amenis_seleccion.length; i++) {
                getAPI.post('/lista_amenidad/', {
                    publicacion: this.publi_creada.publicacion_id,
                    amenidad: this.amenis_seleccion[i].amenidad_id,
                })
                    .then(response => {
                        console.log('Amenidad API has send data')
                        console.log(response.data);
                    })
                    .catch(error => {
                        console.log(error);
                    });
            }
        },
    },
    components: {
        CheckBoxMamalon: CheckBoxMamalon,
        SimpleForm: SimpleForm,
        VueMultiselect,
        sidebar1: sidebar1,
    }
};


</script>