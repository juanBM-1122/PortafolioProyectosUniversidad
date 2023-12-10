<template>
          <main>
            <div class="w-[90%] m-auto mt-[2%]">
                <table class="w-[100%]">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cuenta</th>
                            <th>Valor Año {{ anioCabeceraTabla }}</th>
                            <th>Análisi Vertical</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="text-center mt-[2px]" v-for="registroAnalisisActivo in analisisActivos">
                            <td class="text-slate-400">{{ registroAnalisisActivo.id }}</td>
                            <td class="text-slate-400">{{ registroAnalisisActivo.cuenta_empresa.nombreCuenta }}</td>
                            <td class="text-slate-400">{{ registroAnalisisActivo.valorCuenta }}</td>
                            <td class="text-slate-400">{{ convertirValorAnalisisPorcentaje(registroAnalisisActivo.analisis_vertical[0].valorAnalisisVertical) }}</td>
                        </tr>
                        <tr class="text-center">
                            <td class="text-slate-400"></td>
                            <td class="font-bold text-slate-500">Total Activos</td>
                            <td class="text-slate-400 font-bold text-bold text-center">{{ totalActivos }}</td>
                            <td class="text-slate-400 font-bold">100%</td>
                        </tr>

                        <tr class="text-center mt-[2px]" v-for="registroAnalisisPasivo in analisisPasivos">
                            <td class="text-slate-400">{{ registroAnalisisPasivo.id }}</td>
                            <td class="text-slate-400">{{ registroAnalisisPasivo.cuenta_empresa.nombreCuenta }}</td>
                            <td class="text-slate-400">{{ registroAnalisisPasivo.valorCuenta }}</td>
                            <td class="text-slate-400">{{ convertirValorAnalisisPorcentaje(registroAnalisisPasivo.analisis_vertical[0].valorAnalisisVertical) }}</td>
                        </tr>

                        <tr class="text-center">
                            <td class="text-slate-400"></td>
                            <td class="font-bold text-slate-500">Total Pasivo</td>
                            <td class="text-slate-400 font-bold text-bold text-center">{{ totalPasivos }}</td>
                            <td class="text-slate-400 font-bold">100%</td>
                        </tr>
                    </tbody>
                </table>
                 {{ parametrosAnalisisFiltro }}
            </div>
          </main>
</template>
<script>
import axios from "axios";
export default {
    props:{parametrosAnalisisFiltro:Object, realizarAnalisisFiltro:Boolean},
    data(){
        return {
            anios:[],
            empresas:[],
            parametrosAnalisis: this.parametrosAnalisisFiltro,
            analisisActivos:[],
            totalActivos:0,
            analisisPasivos:[],
            totalPasivos:0,
            analisisPatrimonio:[],
            totalPatrimonio:0,
            analisisIngresos:[],
            totalIngresos:0,
            anioCabeceraTabla:"",
            realizarAnalisis:this.realizarAnalisisFiltro
        }
    },
    mounted(){

    },
    methods:{
        //Obtener las empresas
        obtenerAnalisisVertical(){
            axios.post("/api/realizar_analisis_vertical",this.parametrosAnalisis)
            .then((response)=>{
                this.anioCabeceraTabla = this.parametrosAnalisis.anio;
                this.analisisActivos = response.data.analisisActivos;
                this.totalActivos = response.data.totalActivos;

                setTimeout(()=>{
                    this.analisisPasivos = response.data.analisisPasivos;
                    this.totalPasivos = response.data.totalPasivos;
                },10);

                setTimeout(()=>{
                    this.analisisPatrimonio = response.data.analisisPatrimonio;
                    this.totalPatrimonio = response.data.totalPatrimonio;
                },15);
        
            })
            .catch(
                ((response)=>{
                    alert("ocurrion un error");
                    alert(response.response.data);
                })
            );
        },
        convertirValorAnalisisPorcentaje(valorAnalisisVertical){
            return (valorAnalisisVertical*100).toFixed(2) + "%";
        },
    },
    watch:{
        realizarAnalisis(newRealizarAnalisis,oldRealizarAnalisis){
            alert("hola")
                this.obtenerAnalisisVertical();
        }
    }
}
</script>
