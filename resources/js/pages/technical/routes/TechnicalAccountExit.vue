<template>
   <div class="layout technicalcreate">

      <div class="content">

         <h1 class="content-title">Salir</h1>

         <div class="content-back">
            
         </div>

      </div>
      
  </div>

</template>
<script>

export default {

   data() {
      return {
         dataServer: dataServer,
      }
   },

   mounted() {

      document.cookie.split(";").forEach(function(c) { document.cookie = c.replace(/^ +/, "").replace(/=.*/, "=;expires=" + new Date().toUTCString() + ";path=/"); });

      // Refres url
      setTimeout(() => window.location.reload(), 2000);


   },

   
};
</script>

<style lang="scss">


</style>