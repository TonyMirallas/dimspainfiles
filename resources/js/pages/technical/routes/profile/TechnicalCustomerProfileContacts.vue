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

               <!-- <div class="box-nav-r"></div> -->

            </div>

            <div class="box-content">
               
               <TechnicalTitleLinear title="Lista de Contactos Creados" color="#00000030" :paddingTopRm="true" />

               <table-pro
                  v-loading="loadingFormContact"
                  :columnData="tableData"
                  :column-order="tableDataOrder" filterSearch="" :items-for-page="50"
               >
                  <template v-slot:date-format="slotProps">
                     <span>{{dateToFormat(slotProps.item.created_at)}}</span>
                  </template>
               </table-pro>

               <TechnicalFormEntities
                  :form="formContact"
                  @on-submit="submitCreateContact"
               />

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { useRoute, useRouter } from 'vue-router'
   import { ref, onMounted } from 'vue'

   import entityLead from '../../../../dataConstants/entityLead';

   import * as serviceCustomers from '../../../../services/serviceCustomers';

   import { dateToFormat } from '../../../../helpers/utils';

   import * as breadcrumbStore from '../../../../dataStores/breadcrumbStore';

   export default {
      name: 'TechnicalEntityProfileCompany',
      setup(props, context){

         const route = useRoute()
         const router = useRouter()

         const profileMenuSelected = ref('customer_profile_contacts')

         // Declarar Refs
         const loadingFormContact = ref(false)
         const lead = ref({})
         const formContact = ref(structuredClone(entityLead.formContact))

         const tableData = ref([])
         const tableDataOrder = entityLead.tableContacts

         const submitCreateContact = async ( ) => {

            loadingFormContact.value = true

            await serviceCustomers.createContactCustomer({
               id: route.params.entityId,
               name: formContact.value.contact_name.value,
               email: formContact.value.contact_email.value,
               phone: formContact.value.contact_phone.value,
               position: formContact.value.contact_position.value,
               channel: formContact.value.contact_channel.value,
               observations: formContact.value.contact_observations.value,
            });

            const leadData = await serviceCustomers.getCustomer({ id: route.params.entityId});

            lead.value = leadData
            tableData.value = leadData.contacts

            loadingFormContact.value = false;

         }

         const eventProfileMenuSelected = ( name ) => {

           return router.push({ name })

         }
         
         onMounted( async () => {

            loadingFormContact.value = true
            
            const leadData = await serviceCustomers.getCustomer({ id: route.params.entityId});

            lead.value = leadData
            tableData.value = leadData.contacts

            loadingFormContact.value = false

            breadcrumbStore.set({
               route,
               lead: leadData
            })

         })


         return {
            profileMenuSelected,

            // Refs
            lead,
            formContact,
            loadingFormContact,

            tableData, tableDataOrder,

            // Functions External
            // serviceCustomers,

            // Functions
            eventProfileMenuSelected,
            submitCreateContact,
            dateToFormat

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
