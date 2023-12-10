<template>
  <div id="app">
      <metainfo>
        <template v-slot:title="{ content }">{{ content ? `${content} | cheroomSV` : `cheroomSV` }}</template>
      </metainfo>
      <router-view />
  </div>
</template>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>

<script>

import { useMeta } from 'vue-meta'

export default {
  name: "app",
  setup() {
    useMeta({
      title: 'Home',
      htmlAttrs: { lang: 'es', amp: true },
      description: "CheroomSV es una plataforma que busca conectar a las personas en la busqueda de un roomate. Comparte, conoce, alquila y vive con tu compañero ideal.",
      keywords: "alquilar, roommate, buscar, compañero, cheroomsv, cuarto, alquiler, chero, hotel, room, conocer, el salvador",
    });
  },
 mounted(){
    console.log(this.$store.state.ruta_foto)
    console.log(this.$store.state.username)
 }
}
</script>

