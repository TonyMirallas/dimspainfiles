<template>

   <div class="layout technical-profile">

      <div class="content">

         <div class="box">

            <div class="box-nav flex-gap-20">

               <div class="box-nav-l flex-1">
                  <div class="box-title">Calendario De Seguimiento</div>
               </div>
               
            </div>

            <div class="box-content">

               <DatePikerNot />
      
            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   console.log( dataServer )

   export default {

      name: 'Technical',
      setup(){


      }

   }

</script>


<style lang="scss" scoped>

   .technical-profile{
      
      .box-content{
         padding: 20px;
      }

   }

   .open{
      color: #00b300;
   }

   .closed{
      color: #ff0000;
   }

   .cancelled{
      color: #ffa500;
   }

</style>
