<template>
   
   <div class="layout-profesional profesional-home">

      <!-- <div class="nav-sub">
         <a class="item radius-l" :href="dataServer.pathDim + '/professional/orders'">Lista Ordenes</a>
         <a class="item" :href="dataServer.pathDim + '/professional/createorder'">Crear Ordenes</a>
         <a class="item radius-r" :href="dataServer.pathDim + '/professional/credits'">Solicitar Creditos</a>
      </div> -->

      <div class="grid-2">

         <div class="content">
            <img src="https://i.imgur.com/kWe90v0.png" class="img-fluid">
            <p>Bienvenido, <span class="negrita">Usuario_prueba!</span></p>
            <p class="salir">Cerrar sesión</p>
         </div>

         <div class="content" v-loading="loading">
            <h2>Ultima Orden</h2>
            <div class="order" v-if="orderData.length > 0">
               <div class="item"><span class="label">ID</span><span class="text">{{orderData[0].id}}</span></div>
               <div class="item"><span class="label">Fecha</span><span class="text">{{formatDate(orderData[0].created_at)}}</span></div>
               <div class="item"><span class="label">Marca</span><span class="text">{{orderData[0].manufacture}}</span></div>
               <div class="item"><span class="label">Modelo</span><span class="text"> {{orderData[0].model}}</span></div>
               <div class="item"><span class="label">Motor</span><span class="text">{{orderData[0].type}}</span></div>
            </div>
         </div>
         
      </div>


   <div class="grid-3">

      <div class="content">
         <a href="mailto:clientes@dimspainfiles.es"> <i class="far fa-envelope icon"></i>
         <h3 class="text">Escríbenos<br> un mail</h3></a>
      </div>

      <div class="content">
         <a href="tel:+34932895900"><i class="fas fa-phone icon"></i>
         <h3 class="text">Llámanos por teléfono</h3></a>
      </div>

      <div class="content">
         <a href="https://api.whatsapp.com/send?phone=34659150469&text=Necesito%20asistencia%20especializada"><i class="fab fa-whatsapp icon"></i>
         <h3 class="text">Mediante Whatsapp</h3></a>
      </div>

   </div>

</div>

</template>

<script>

   import * as api from '../../services/api';

   export default {

      data() {

         return {
            dataServer: dataServer,
            orderData: [],
            loading: false
         }

      },

      async mounted(){

         this.loading = true;
         
         this.orderData = (await api.getOrdersByProfessional({id: this.dataServer.auth.id})).data;

         this.loading = false;

      },

      methods: {

         formatDate(value){

            const date = new Date(value);

            const day = date.getDate();
            const month = date.getMonth() + 1;
            const year = date.getFullYear();
            const hours = date.getHours();
            const minutes = date.getMinutes();
      
            return `${day}/${month}/${year} ${hours}:${minutes}`;
            

         }

      }

   }

</script>

<style lang="scss">

   .profesional-home {

      max-width: 1000px;
      margin: 80px auto;

     
      img{
         border-radius: 50%;
         width: 100px;
         box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 1px 3px 1px;
      }

      .grid-2{
         grid-template-columns: 1fr 2fr;
      }
     
      .grid-2, .grid-3{
         gap: 20px;
      }

      .content{
         background: white;
         padding: 50px;
         border-radius: 5px;
         width: 100%;
         margin: 10px 0;
         text-align: center;
         box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 1px 3px 1px;
      }

      .icon{
         font-size: 40px;
         padding-top: 10px;
         color: #ea1820;
      }

      .text {
         font-size: 20px;
         color: #212123;
      }

      .salir{
         color: #ff0000;
         font-weight: 700;
         font-size: 12px;
         text-decoration: underline;
      }

      .negrita{
         font-weight: 700;
      }

      .order{

         .item{

            display: flex;
            justify-content: space-between;
            padding: 5px 0;

            .label{
               font-size: 14px;
               color: #212123;
               font-weight: 500;
            }

            .text{
               font-size: 14px;
               color: #212123;
               font-weight: 600;
            }


         }

      }

   }


</style>