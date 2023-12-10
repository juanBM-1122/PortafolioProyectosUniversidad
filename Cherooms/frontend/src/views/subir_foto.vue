<template>
    <div class="subir_foto">
        <h1>Subir foto</h1>
        <input type="file" @change="onFileChange" />
        <button @click.prevent="uploadFile">Subir</button>
    </div>
</template>

<script>
import { getAPI } from '../axios-api'
export default {
    name: 'subir_foto',
    data() {
        return {
            file: null,
            objeto_creado: [],
        }
    },
    methods: {
        onFileChange(e) {
            this.file = e.target.files[0];
        },
        uploadFile() {
            const formData = new FormData();
            formData.append('foto_lugar', this.file);
            getAPI.post('/foto/', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then((res) => {
                console.log("Subida exitosa");
                console.log(res);
                this.objeto_creado = res.data;
                console.log("AAAAAA", this.objeto_creado.foto_id);
            }).catch(err => {
                console.log(err);
            });
        },
        obt_foto(){
            getAPI.get('/foto/70', )
                .then(response => {
                    console.log('Foto API has received data')
                    console.log(response.data);
                })
                .catch(error => {
                    console.log(error);
                });
            return
    },
        
    }    
}
</script>

