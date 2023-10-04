<template>

   <div class="payments" v-for="payment in payments" :key="payment.id">

      <div class="payments-item">
         <div class="payments-list-item-title">ID Transacción</div>
         <div class="payments-list-item-val">{{payment.id}}</div>
      </div>

      <div class="payments-item">
         <div class="payments-list-item-title">Fecha</div>
         <div class="payments-list-item-val">{{payment.date}}</div>
      </div>

      <div class="payments-item">
         <div class="payments-list-item-title">Creditos</div>
         <div class="payments-list-item-val">{{payment.credits}}</div>
      </div>

      <div class="payments-item">
         <div class="payments-list-item-title">Forma de pago</div>
         <div class="payments-list-item-val">{{payment.payment}}</div>
      </div>

   </div>


</template>

<script>

   import dayjs from 'dayjs';

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

         dateFormat(){

            // if(!this.order) return '-';

            // return dayjs(this.order.created_at).format('DD/MM/YYYY HH:mm');

         },

      },

      methods: {
       
      },

   }


</script>


<style lang="scss">

   .payments{
      display: flex;
      justify-content: space-between;
      background: #f3f3f3;
      padding: 15px;
      margin: 10px 0;
      border-radius: 5px;
   }

   .payments-item-title {
      font-weight: 500;
      font-size: 14px;
      margin-bottom: 5px;
   }

   .payments-item-val {
      font-size: 13px;
   }
   
</style>