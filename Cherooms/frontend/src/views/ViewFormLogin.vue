<template>
  <FormLogin />
</template>

<script>

import { useMeta } from 'vue-meta'
import FormLogin from "@/components/FormLogin.vue"

export default {
  name: "viewFormLogin",
  setup() {
    useMeta({
      title: "Login",
      description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
      'Content-Security-Policy': "upgrade-insecure-requests",
    });
  },
  components: {
    FormLogin
  }
}
</script>