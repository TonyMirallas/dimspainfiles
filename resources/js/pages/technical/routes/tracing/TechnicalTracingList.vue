<template>

   <div class="layout technical-profile">

      <div class="content">

         <div class="box">

            <div class="box-nav flex-gap-20">

               <div class="box-nav-l flex-1">
                   <el-input size="large" class="flex-1" v-model="filterSearch" placeholder="Filtrar por texto"/>
               </div>

               <div class="box-nav-r flex-auto flex-gap-20">

                  <el-select v-model="profileTypeSelected" placeholder="Tipos de Cliente" size="large">
                     <el-option
                        v-for="(label, key) in entityListInvoice"
                        :key="key"
                        :value="key"
                        :label="label"
                     />
                  </el-select>

                  <div class="box-nav-number">{{getTaskFilter.length}}</div>

               </div>
            </div>

            <div class="box-content" v-loading="loading">
               
               <TablePro :columnData="getTaskFilter" :column-order="tableDataOrder" :filterSearch="filterSearch" :items-for-page="50">

                  <template v-slot:finished_at="slotProps">
                     <span>{{dateToFormat(slotProps.item.finished_at)}}</span>
                  </template>

                  <template v-slot:company_name="slotProps">
                     <router-link :to="{ name: 'customer_profile_company', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type } }">
                        {{slotProps.item.customer.name}}
                     </router-link>
                  </template>

                  <template v-slot:company_contact="slotProps">
                     <router-link :to="{ name: 'customer_profile_contacts', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type } }">
                        {{slotProps.item.contact.name}}
                     </router-link>
                  </template>

                  <template v-slot:company_phone="slotProps">
                     {{slotProps.item.contact.phone}}
                  </template>

                  <template v-slot:state="slotProps">
                     <div :class="slotProps.item.state">{{stateString[slotProps.item.state]}}</div>
                  </template>

                  <template v-slot:open="slotProps">
                     <router-link :to="{ name: 'customer_profile_tracing', params: { entityId: slotProps.item.customer_id, entityType: slotProps.item.customer.type } }">
                        Abrir
                     </router-link>
                  </template>

               </TablePro>

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import dayjs from 'dayjs';

   import { ref, watch, reactive, computed, onMounted } from 'vue'

   import crmComercial from '../../../../dataConstants/crmComercial';
   import invoice from '../../../../dataConstants/invoice';
   import tracing from '../../../../dataConstants/tracing';
   import * as serviceInvoice from '../../../../services/serviceInvoice';
   import * as serviceTracing from '../../../../services/serviceTracing';

   export default {

      name: 'TechnicalTracingList',
      setup(){


         const loading = ref(true);
         const profileTypeSelected = ref('lead');
         const filterSearch = ref('')
         const tasksType = ref({});

         const tableDataOrder = tracing.tableTracing;

         const dateToFormat = (date) => dayjs(date).format('DD/MM/YYYY');

         const stateString = {
            'open': 'Abierto',
            'closed': 'Cerrado',
            'cancelled': 'Cancelado',
         }

         const getTaskFilter = computed(() => tasksType.value[profileTypeSelected.value] || [] )

         onMounted( async () => {

            loading.value = true;

            const tasks = await serviceTracing.getTracings()

            for(let entityType in crmComercial.entityListInvoice){
               tasksType.value[entityType] = tasks.filter(item => item.customer.type == entityType )
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


            getTaskFilter,
            tableDataOrder,

            // Methods
       
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
