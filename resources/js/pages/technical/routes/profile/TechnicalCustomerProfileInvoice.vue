<template>

   <div class="layout">

      <div class="content">

         <div class="box">

            <div class="box-nav">

               <div class="box-nav-l">

                  <el-radio-group v-model="profileMenuSelected" @change="eventProfileMenuSelected">
                     <el-radio-button label="customer_profile_company">Perfil Cliente</el-radio-button>
                     <el-radio-button label="customer_profile_contacts">Contactos</el-radio-button>
                     <el-radio-button label="customer_profile_tracing">Seguimiento</el-radio-button>
                     <el-radio-button label="customer_profile_invoice">Presupuestos</el-radio-button>
                  </el-radio-group>

               </div>

            </div>

            <div class="box-nav-sub">
               
               <router-link :to="{ name: 'invoice_create_id', params: { entityId } }">
                  <el-button>Crear Nuevo Presupuesto</el-button>
               </router-link> 

            </div>

            <div class="box-content" v-loading="loading">
               
               <TablePro :columnData="tableData" :column-order="tableDataOrder" :filterSearch="filterSearch" :items-for-page="50">

                  <template v-slot:entity="slotProps">
                     <template v-if="slotProps.item.customer">
                        <router-link :to="{name: 'customer_profile_company'}">
                           {{slotProps.item.customer.name}}
                        </router-link>
                     </template>
                  </template>

                  <template v-slot:contact="slotProps">
                     <router-link :to="{name: 'customer_profile_contacts' }">
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

                     <el-select v-model="slotProps.item.state" size="small" @change="eventStateChange(slotProps.item)">
                        <el-option value="on_hold" label="En espera" />
                        <el-option value="approved" label="Aprobado" />
                        <el-option label="cancelled" value="cancelado" />
                     </el-select>

                  </template>

                  <template v-slot:pdf="slotProps">
                     <a :href="`/dim/public/technical/invoice/pdf/${slotProps.item.id}`" target="_blank">Abrir</a>
                  </template>

               </TablePro>

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { useRoute, useRouter } from 'vue-router'
  
   import { ref, watch, reactive, computed, onMounted } from 'vue'
 
   import * as serviceCustomers from '../../../../services/serviceCustomers';
   import crmComercial from '../../../../dataConstants/crmComercial';
   import invoice from '../../../../dataConstants/invoice';
   import * as serviceInvoice from '../../../../services/serviceInvoice';

   import { dateToFormat } from '../../../../helpers/utils';

   import * as breadcrumbStore from '../../../../dataStores/breadcrumbStore';

   export default {
      name: 'TechnicalEntityProfileCompany',
      setup(props, context){

         const route = useRoute()
         const router = useRouter()

         const profileMenuSelected = ref('customer_profile_invoice')

         const eventProfileMenuSelected = ( name ) => {

           return router.push({ name })

         }

         const loading = ref(false)
         const tableRowsNum = ref(0)
         const filterSearch = ref('')
         const profileTypeSelected = ref('lead');

         const tableData = ref([]);
         const tableDataOrder = invoice.tableList;

         const changeTableRowsNum = (rows) => tableRowsNum.value = rows;

         
         onMounted( async () => {

            await loadData()

         })

         const eventStateChange = async (invoice) => {

            loading.value = true;

            await serviceInvoice.updateState({
               "id": invoice.id,
               "state": invoice.state
            })

            await loadData()

            loading.value = false;

         }
            
         const loadData = async () => {

            loading.value = true;
            
            const leadData = await serviceCustomers.getCustomer({ id: route.params.entityId});
            const invoices = await serviceInvoice.getInvoices()

            const invoicesSelfs = invoices.filter( invoice => route.params.entityId == invoice.customer_id ) 

            tableData.value = invoicesSelfs

            breadcrumbStore.set({
               route,
               lead: leadData
            })

            loading.value = false;

         }

         return {

            profileMenuSelected,
            eventProfileMenuSelected,

            // Consts
            dateToFormat,
          
            // Refs
            tableRowsNum,
            filterSearch,
            profileTypeSelected,
            entityListInvoice: crmComercial.entityListInvoice,


            tableData,
            tableDataOrder,

            // Methods
            changeTableRowsNum,
            eventStateChange,

            loading,

            entityId: route.params.entityId,
       
         }

      }

   }

</script>


<style lang="scss" scoped>

   .box-content{
      padding: 20px;
      min-height: 50vh;
   }

</style>
