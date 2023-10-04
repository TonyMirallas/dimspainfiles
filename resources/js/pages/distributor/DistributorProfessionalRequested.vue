<template>

   <div class="layout">

      <div class="content">

         <h1 class="content-title">Lista Solicitudes de Creditos ({{tableData.length}})</h1>

         <div class="content-back" v-loading="loading">

            <table-pro v-model="tableData" :column-order="tableDataOrder" :items-for-page="50">
               <template v-slot:btn-edit="slotProps">
                  <router-link :to="`/distributor/professional/${slotProps.item['professional.id']}`">
                     {{slotProps.item['professional.user']}}
                  </router-link>
               </template>
               <template v-slot:btn-accept="slotProps">
                  <el-button type="primary" size="small" @click="clickAccept(slotProps.item.id)" :disabled="slotProps.item.stateBtnAccept">
                     ACEPTAR
                  </el-button>
               </template>
               <template v-slot:btn-cancel="slotProps">
                  <el-button type="warning" size="small" @click="clickCancel(slotProps.item.id)" :disabled="slotProps.item.stateBtnCancel">
                     CANCELAR
                  </el-button>
               </template>
            </table-pro>

         </div>
      </div>

   </div>

</template>

<script>

   import dayjs from 'dayjs';
   import * as api from '../../services/api';
   import * as utils from '../../helpers/utils';

   export default {

      data() {
         
         return {
            dataServer: dataServer,
            loading: true,
            tableData: [],
            tableDataOrder: [],
            statusTranslate: {
               Completed: 'Completado',
               Requested: 'Solicitado',
               Canceled: 'Cancelado',
               Accepted: 'Aceptado',
               Processing: 'Procesando',
               Refunded: 'Reembolsado',
               Pending: 'Pendiente',
            }
         }
      },
      
      mounted() {
         
         this.getData()

      },

      methods: {

         async getData(){

            this.loading = true;

            // Definición de las columnas de la tabla
            this.tableDataOrder = [
               {label: 'ID', field: 'id', type: 'text', filter: true},
               {label: 'Fecha', field: 'created_at_format', type: 'text'},
               {label: 'Creditos', field: 'credits', type: 'text'},
               {label: 'Profesional', field:"professional.user", type: 'slot', slot: 'btn-edit', filter: true},
               {label: 'Estado', field: 'statusTranslate', type: 'text', filter: true},
               {label: '', type: 'slot', slot: 'btn-accept'},
               {label: '', type: 'slot', slot: 'btn-cancel'},
            ]

            // Definición de los datos de la tabla
            const getPayments = (await api.getPayments({
               "professional_id": null,
               "distributor_id": this.dataServer.auth.id,
               "status":  null
            })).data

            this.tableData = getPayments
               .filter( payment => ["Requested", "Accepted"].indexOf(payment.status) > -1 )
               .map( payment => {

                  const stateBtnAccept = payment.status == 'Requested' ? false : true
                  const stateBtnCancel = payment.status == 'Requested' ? false : true

                  return {
                     "id": payment.id,
                     "credits": payment.credits,
                     "status": payment.status,
                     "statusTranslate": this.statusTranslate[payment.status],
                     "created_at": payment.created_at,
                     "created_at_format": dayjs(payment.created_at).format('DD/MM/YYYY HH:mm'),
                     "professional.id": payment.professional.id,
                     "professional.user": payment.professional.user,
                     "professional.email": payment.professional.email,
                     "professional.company": payment.professional.company,
                     stateBtnAccept,
                     stateBtnCancel
                  }

               })

            this.loading = false;

         }, 

         async clickAccept(id){

            api.updatePayment({id, "status": "Accepted" })
               // .then(utils.notificationUser)
               .then(this.getData)

         },

         async clickCancel(id){

            api.updatePayment({id, "status": "Canceled" })
               // .then(utils.notificationUser)
               .then(this.getData)
   
         }

      },


   }
</script>