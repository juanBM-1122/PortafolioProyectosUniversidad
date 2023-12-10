<template>
  <div class="about">
    <h1>This is an about page</h1>
  </div>
</template>

<script>
import { useMeta } from 'vue-meta'
export default {
  name: 'AboutView',
  setup() {
    useMeta({
      title: "Sobre Nosotros",
      description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
      'Content-Security-Policy': "upgrade-insecure-requests",
    });
  },
}
</script>