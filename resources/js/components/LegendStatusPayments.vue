<template>

   <div class="legend-status-payments">

      <div class="list">
         <el-tag class="list-label" type="success" size="small" effect="plain">Cancelado</el-tag>
         <div class="list-value">Solicitud cancelada. Consultar motivos con el técnico.</div>
      </div>
      <div class="list">
         <el-tag class="list-label" type="success" size="small" effect="plain">Solicitada</el-tag>
         <div class="list-value">Solicitud pedida por un profesional a su cargo.</div>
      </div>
      <div class="list">
         <el-tag class="list-label" type="success" size="small" effect="plain">Aceptada</el-tag>
         <div class="list-value">Solicitud aceptada pero pendiente de la confirmación de un técnico</div>
      </div>
      <div class="list">
         <el-tag class="list-label" type="success" size="small" effect="plain" >Completada</el-tag>
         <div class="list-value">Solicitud completada y aceptada por el técnico</div>
      </div>
     
   </div>

</template>

<script>

   export default {

      props: {
         payments: Object
      },
      data() {

         return {
            dataServer: dataServer,
         }

      },

      computed: {


      },

      methods: {
       
      },

   }


</script>


<style lang="scss">

   .list {
      display: flex;
      gap: 10px;
      align-items: center;
      margin-bottom: 10px;
   }

   .list-value{
      font-size: 14px;
   }
   
</style>