<template>

   <div class="layout">

      <div class="content">

         <div class="box">

            <div class="box-nav flex-gap-20">
               <div class="box-nav-l flex-1">
                  <el-input v-model="filterSearch" size="large" placeholder="Filtrar por texto"/>
               </div>
               <div class="box-nav-r flex-auto flex-gap-20">

                  <el-select v-model="entityTypeModel" @change="eventEntityTypeModel" placeholder="Tipos de Cliente" size="large">
                     <el-option
                        v-for="(label, key) in entityList"
                        :key="key"
                        :value="key"
                        :label="label"
                     />
                  </el-select>

                  <div class="box-nav-number">{{customersByType.length}}</div>

               </div>
            </div>

            <div class="box-content">
               
               <div class="table" v-loading="loading">

                  <TablePro :column-data="customersByType" :column-order="tableColumnOrder" :filterSearch="filterSearch" :items-for-page="10">

                     <template v-slot:contact-company="slotProps">
                        <router-link 
                           :to="{ name: 'customer_profile_company', params: { entityId: slotProps.item.id, entityType: slotProps.item.type }}">
                           {{slotProps.item.name}}
                        </router-link>
                     </template>

                     <template v-slot:company-phone="slotProps">
                        <span>{{slotProps.item.phone}}</span>
                     </template>

                     <template v-slot:date-format="slotProps">
                        <span>{{dateToFormat(slotProps.item.created_at)}}</span>
                     </template>

                  </TablePro>

               </div>

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { ref, onMounted, computed } from 'vue'
   import { useRoute, useRouter } from 'vue-router'

   import * as cacheStore from '../../../../dataStores/cacheStore';
   import * as serviceCustomers from '../../../../services/serviceCustomers';

   import crmComercial from '../../../../dataConstants/crmComercial';
   import entityLead from '../../../../dataConstants/entityLead';

   import { dateToFormat } from '../../../../helpers/utils';

   export default {
      name: 'TechnicalCustomerList',
      setup(props, context){

         const route = useRoute()
         const router = useRouter()

         const loading = ref(false)
         const entityTypeModel = ref(route.params.entityType)
         const filterSearch = ref('')

         const customerLead = cacheStore.getCacheData('customers:lead', () => serviceCustomers.getCustomers({type: 'lead'}), [])
         const customerSage = cacheStore.getCacheData('customers:sage', () => serviceCustomers.getCustomers({type: 'sage'}), [])

         const tableColumnOrder = entityLead.table
         const entityList =  crmComercial.entityList

         const eventEntityTypeModel = (entity) => {
            router.replace({ name: 'customer_list', params: { entityType: entity } })
         }

         const customersByType = computed(() => {

            switch(entityTypeModel.value){
               case 'lead':
                  return customerLead.value
               case 'sage':
                  return customerSage.value
               default:
                  return []
            }

         })

         return {

            // Refs
            loading,
            entityTypeModel,
            filterSearch,
            customersByType,

            // CONST
            tableColumnOrder,
            entityList,

            // FUNCTIONS,
            dateToFormat,
            eventEntityTypeModel
       
         }

      }

   }

</script>


<style lang="scss" scoped>

   .layout{
      
      .box-content{
         padding: 20px;
      }

   }

</style>
