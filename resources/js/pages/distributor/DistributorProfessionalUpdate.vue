<template>
   
   <div class="layout">

      <div class="content">

         <h1 class="content-title">Datos del Cliente ({{professional.user}})</h1>

         <div class="content-back" v-loading="loading">

            <el-form
               :model="professional"
               label-position="top"
            >

               <div class="grid-3">
                     
                  <el-form-item label="Usuario" prop="user">
                     <el-input v-model="professional.user" disabled></el-input>
                  </el-form-item>

                  <el-form-item label="Persona Contacto" prop="name">
                     <el-input v-model="professional.name" disabled></el-input>
                  </el-form-item>

                  <el-form-item label="Email" prop="email">
                     <el-input v-model="professional.email" type="email" disabled></el-input>
                  </el-form-item>

               </div>

               <div class="grid-3">

                  <el-form-item label="Teléfono" prop="phone">
                     <el-input v-model="professional.phone" disabled></el-input>
                  </el-form-item>

                  <el-form-item label="Provincia" prop="province">
                     <el-input v-model="professional.province" disabled></el-input>
                  </el-form-item>

                  <el-form-item label="Nombre Empresa" prop="company">
                     <el-input v-model="professional.company" disabled></el-input>
                  </el-form-item>

               </div>

            </el-form>

         </div>

         <h1 class="content-title">Peticiones de creditos ({{payments.length}})</h1>

         <div class="content-back" v-loading="loading">

            <distributor-peyments :data="payments" ></distributor-peyments>

         </div>
      
         <h1 class="content-title">Lista de ordenes ({{orders.length}})</h1>
         
         <div class="content-back" v-loading="loading">

            <technical-component-orders :orders="orders" :btn-hide="true" ></technical-component-orders>
               
         </div>

      </div>
      
  </div>

</template>
<script>

   import dayjs from 'dayjs';
   import * as api from '../../services/api';

   export default {

      data() {

         return {

            dataServer: dataServer,
            loading: false,
            professional: {},
            payments: [],
            orders: [],
            creditsRequest: [
               { id: 1, date: '13/02/2022', credits: '100', status: 'pending' },
               { id: 2, date: '13/02/2022', credits: '100', status: 'cancelled' },
               { id: 3, date: '13/02/2022', credits: '100', status: 'approved' },
            ],
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

      async mounted() {

         this.loading = true;

         this.professional = (await api.getProfessional({id: this.$route.params.id})).data;
         this.orders = (await api.getOrdersByProfessional({id: this.$route.params.id})).data;
       
         const getPayments = (await api.getPayments({
            "professional_id": this.$route.params.id,
            "distributor_id": this.dataServer.auth.id,
            "status":  null
         })).data;

         this.payments = getPayments.map( payment => {

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

      methods: {


      },

   };

</script>

<style lang="scss" scoped>

   .credits-list{
      display: flex;
      justify-content: space-between;
      background: #f3f3f3;
      padding: 15px;
      margin: 10px 0;
      border-radius: 5px;
   }

   .credits-list-item-title {
      font-weight: 500;
      font-size: 14px;
      margin-bottom: 5px;
   }

   .credits-list-item-val {
      font-size: 13px;
   }

   .el-select{
      width: 100%;
   }

   .el-checkbox.is-bordered{
      width: 100%;
      padding: 12px !important;
   }

   .btn-submit {
      margin-top: 20px;
   }

</style>