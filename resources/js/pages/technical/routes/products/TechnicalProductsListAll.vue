<template>

   <div class="layout technical-profile">

      <div class="content">

         <div class="box">

            <div class="box-nav flex-gap-20">
               <div class="box-nav-l flex-1">
                  <el-input size="large" v-model="filterSearch" placeholder="Filtrar por texto"/>
               </div>
               <div class="box-nav-r flex-auto flex-gap-20">

                

                  <div class="box-nav-number">{{getInvoicesFilter.length}}</div>

               </div>
            </div>

            <div class="box-content" v-loading="loading">
               
               <!-- <TablePro :columnData="getInvoicesFilter" :column-order="tableDataOrder" :filterSearch="filterSearch" :items-for-page="50">

                  <template v-slot:entity="slotProps">
                     <template v-if="slotProps.item.customer">
                        <router-link :to="{ name: 'customer_profile_company', params: { entityId: slotProps.item.customer.id, entityType: slotProps.item.customer.type } }">
                           {{slotProps.item.customer.name}}
                        </router-link>
                     </template>
                  </template>

                  <template v-slot:contact="slotProps">
                     <router-link :to="{ name: 'customer_profile_contacts', params: { entityId: slotProps.item.customer.id, entityType: slotProps.item.customer.type } }">
                        {{slotProps.item.contact.name}}
                     </router-link>
                  </template>

                  <template v-slot:created_at="slotProps">
                     <span>{{dateToFormat(slotProps.item.created_at)}}</span>
                  </template>
                  
                  <template v-slot:finished_at="slotProps">
                     <span>{{dateToFormat(slotProps.item.finished_at)}}</span>
                  </template>

                  <template v-slot:state="slotProps">
                     <span>{{stateString(slotProps.item.state)}}</span>
                  </template>

                  <template v-slot:pdf="slotProps">
                     <a :href="`/dim/public/technical/invoice/pdf/${slotProps.item.id}`" target="_blank">Abrir</a>
                  </template>

               </TablePro> -->

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import dayjs from 'dayjs';
   import { useRoute, useRouter } from 'vue-router'

   import { ref, watch, reactive, computed, onMounted } from 'vue'

   import crmComercial from '../../../../dataConstants/crmComercial';
   import invoice from '../../../../dataConstants/invoice';
   import * as serviceInvoice from '../../../../services/serviceInvoice';

   export default {

      name: 'TechnicalInvoiceList',
      setup(){

         const loading = ref(true)
         const profileTypeSelected = ref('lead');
         const filterSearch = ref('')
         const invoicesType = ref([])

         const tableDataOrder = invoice.tableList;

         const dateToFormat = (date) => dayjs(date).format('DD/MM/YYYY');

         const stateString = (date) => {
            if(date == 'on_hold') return 'En espera';
            if(date == 'pending') return 'Pendiente';
            if(date == 'finished') return 'Finalizado';
         }

         const getInvoicesFilter = computed(() => invoicesType.value[profileTypeSelected.value] || [] )

         onMounted( async () => {

            loading.value = true;

            const invoices = await serviceInvoice.getInvoices()

            for(let entityType in crmComercial.entityListInvoice){
               invoicesType.value[entityType] = invoices.filter(item => item.customer.type == entityType )
            }

            loading.value = false;
            
         })

         return {
            // Consts
            dateToFormat,

            stateString,
          
            // Refs
            loading,
            filterSearch,
            profileTypeSelected,
            entityListInvoice: crmComercial.entityListInvoice,

            getInvoicesFilter,
            tableDataOrder,

       
         }

      }

   }

</script>


<style lang="scss" scoped>

   .technical-profile{
      
      .box-content{
         padding: 20px;
      }

   }

</style>
