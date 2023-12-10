<template>

    <article>
         <section>
            <VerCardAlquilerVue/>
         </section>
    </article>

</template>


<script>
    import VerCardAlquilerVue from "./VerCardAlquiler.vue";
    export default {
      name : "home",
      props : {

      },
      components :{
        VerCardAlquilerVue,
      }
    }

</script>
