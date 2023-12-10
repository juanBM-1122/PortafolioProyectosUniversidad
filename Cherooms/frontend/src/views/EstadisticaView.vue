<template>

    <div>
        <navbar1></navbar1>
    </div>

 
        <div>
            <sidebar1></sidebar1>
        </div>
      
            <div class="bg-gray">
                <div class="mx-auto max-w-2xl py-14 px-4 sm:py-20 sm:px-6 lg:max-w-7xl lg:px-8">
                    <h2 class="text-4xl font-bold tracking-tight text-gray-900">Estadisticas</h2>
                </div>
                
            </div>
            <div class="mx-auto max-w-1xl py-16 px-2 sm:py-5 sm:px-1 lg:max-w-6xl lg:px-12">    
                         
<table >
<tr>
  <td >
    <div class="space-y-6  px-12 pt-5 pb-6">
                <div class="mx-auto max-w-2xl py-14 px-4 sm:py-5 sm:px-6 lg:max-w-7xl lg:px-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">N° de ventas por mes</h2>
                </div>
                <Bar
                    :chart-options="chartOptions"
                    :chart-data="chartData"
                    :chart-id="chartId"
                    :dataset-id-key="datasetIdKey"
                    :plugins="plugins"
                    :css-classes="cssClasses"
                    :styles="styles"
                    :width="width"
                    :height="height"
                />
      </div>

  </td>
  <td1 ></td1>
  <td >
    <div class="space-y-6  px-12 pt-5 pb-6">
      <div class="mx-auto max-w-2xl py-16 px-4 sm:py-5 sm:px-6 lg:max-w-7xl lg:px-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Total de ingresos por mes</h2>
                </div>
                <Bar
                    :chart-options="chartOptions"
                    :chart-data="chartData2"
                    :chart-id="chartId"
                    :dataset-id-key="datasetIdKey"
                    :plugins="plugins"
                    :css-classes="cssClasses"
                    :styles="styles"
                    :width="width"
                    :height="height"
                />
      </div>

  </td>
</tr>

</table>

</div>

</template>

<script>
import navbar1 from '../components/Navbar1.vue'
import sidebar1 from '../components/Sidebar1.vue'
import { Bar } from 'vue-chartjs'
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale)

export default {
  name: 'BarChart',
  components: { Bar },
  props: {
    chartId: {
      type: String,
      default: 'bar-chart'
    },
    datasetIdKey: {
      type: String,
      default: 'label'
    },
    width: {
      type: Number,
      default: 400
    },
    height: {
      type: Number,
      default: 400
    },
    cssClasses: {
      default: '',
      type: String
    },
    styles: {
      type: Object,
      default: () => {}
    },
    plugins: {
      type: Object,
      default: () => {}
    }
  },
  data() {
    return {
      chartData: {
        labels: [ 'Enero', 'Febrero', 'Marzo','Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre','octubre', 'Noviembre', 'Diciembre' ],
        datasets: [ { label: 'Venta',
            backgroundColor: '#0000ff',
            data: [30, 40, 12,50, 20, 45,40, 20, 12,40, 20, 55] } ]
      },
      chartData2: {
        labels: [ 'Enero', 'Febrero', 'Marzo','Abril', 'Mayo', 'Junio','Julio', 'Agosto', 'Septiembre','octubre', 'Noviembre', 'Diciembre' ],
        datasets: [ { label: 'Ingresos',
            backgroundColor: '#2fdc00',
            data: [400, 200, 120,300, 256, 423,156, 354, 367,657, 874, 956] } ]
      },
      chartOptions: {
        responsive: true
      }
    }
  }
}
</script>
<style>
      td {
  padding: 10px;
 
  background: linear-gradient(#c9c8f7,#fcfdae);

  border: rgb(122, 122, 122) 1px solid;
}
td1 {
  padding: 10px;
  background: linear-gradient(#ffffff,#ffffff);

}
</style> 
    