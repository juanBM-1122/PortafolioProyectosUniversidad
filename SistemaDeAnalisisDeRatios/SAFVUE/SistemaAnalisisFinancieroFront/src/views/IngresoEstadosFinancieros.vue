<template>
    <div>
        <div class="custom-file-upload flex justify-around p-[10px]">
        <div class="grow">
            <p class="text-bold text-[20px] text-center">{{ tituloEstadoFinanciero }}</p>
        </div>
        </div>

        <div class="">
            <table class="table-auto">
                <thead>
                    <tr>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Cuenta
                        </th>
                        <th
                            class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            Valor
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(cuenta, index) in array_valores_cuentas" :key="index">
                        <td class="px-6 py-4 text-ms ">{{ cuenta.nombreCuenta }}</td>
                        <td class="px-6 py-4 text-ms ">
                            <input type="number" v-model="cuenta.valorCuenta" class="border rounded px-2 py-1">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
        </div>
    </div>
</template>

<script>
import * as XLSX from 'xlsx';
import axios from 'axios';
import api_url from '../constants';

export default {
    props: { tituloEstadoFinanciero: String },
    data() {
        return {
            excel_data: [],
            empresa_id: null,
            empresa: null,
            cuentas: [],
            array_valores_cuentas: [],
            obj_valor_cuenta: {
                cuenta_empresa_id: null,
                nombreCuenta: null,
                valorCuenta: null
            }
        };
    },
    created() {
       // this.empresa_id = this.empresaId;
        //this.getCuentasEmpresa()
    },
    methods: {
        onChange(event) {
            const file = event.target.files[0]
            /* Boilerplate to set up FileReader */
            const reader = new FileReader()
            reader.onload = (e) => {
                /* Parse data */
                const bstr = e.target.result
                const wb = XLSX.read(bstr, { type: 'binary' })
                /* Get first worksheet */
                const wsname = wb.SheetNames[0]
                const ws = wb.Sheets[wsname]
                /* Convert array of arrays */
                const data = XLSX.utils.sheet_to_json(ws, { header: 1 })
                /* Update state */
                this.excel_data = data
                this.setValoresCuentas()
                const header = data.shift()
            }
            reader.readAsBinaryString(file)
        },
        getCuentasEmpresa() {
            axios.get(api_url + 'empresas/' + this.empresa_id).then(
                (response) => {
                    console.log("Las cuentas de la empresa son");
                    console.log(response.data);
                    this.empresa = response.data;
                    (response.data.get_cuentas_empresa).forEach(cuenta => {
                        if (cuenta.tipo_estado_financiero_id === this.idTipoEstadoFinanciero) {
                            let valor_cuenta = {
                                cuenta_empresa_id: null,
                                nombreCuenta: null,
                                valorCuenta: null
                            }
                            valor_cuenta.cuenta_empresa_id = cuenta.id;
                            valor_cuenta.nombreCuenta = cuenta.nombreCuenta;

                            this.array_valores_cuentas.push(valor_cuenta);
                        }
                    });
                }
            ).catch((error) => {
                console.log(error);
            });
        },
        setValoresCuentas() {
            this.array_valores_cuentas.forEach(cuenta => {
                this.excel_data.forEach(row => {
                    if (cuenta.nombreCuenta == row[0]) {
                        cuenta.valorCuenta = row[1];
                    }
                });
            });
        },
        getEmpresasDesdePadre(idEmpresa){
            this.array_valores_cuentas = [];
            this.empresa_id = idEmpresa;
            this.getCuentasEmpresa();
        },

        setEmpresasDesdePadre(array_valores_cuentas){
            this.array_valores_cuentas = array_valores_cuentas;
        },

    },
    watch:{
      
    }
};
</script>