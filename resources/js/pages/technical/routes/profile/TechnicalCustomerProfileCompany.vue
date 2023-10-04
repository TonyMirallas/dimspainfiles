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
               
               <TechnicalFormEntities
                  class="padding"
                  v-loading="formLoding"
                  :form="form"
                  @on-submit="formSubmit"
               />

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { useRoute, useRouter } from 'vue-router'
   import { ref, onMounted } from 'vue'

   import locations from '../../../../dataConstants/locations';
   import entityLead from '../../../../dataConstants/entityLead';

   import * as serviceCustomers from '../../../../services/serviceCustomers';
   
   import * as breadcrumbStore from '../../../../dataStores/breadcrumbStore';

   export default {
      name: 'TechnicalEntityProfileCompany',
      setup(props, context){

         const route = useRoute()
         const router = useRouter()

         const formLoding = ref(false);
         const form = ref(structuredClone(entityLead.form));
         const profileMenuSelected = ref('customer_profile_company')

         // Se añaden los paises al selector del form
         form.value.company_country.options = locations.countriesLabel

         // Desactivar La parte del contacto 
         form.value.title_contact.hide = true
         form.value.contact_name.hide = true
         form.value.contact_email.hide = true
         form.value.contact_phone.hide = true
         form.value.contact_position.hide = true
         form.value.contact_observations.hide = true
         form.value.contact_channel.hide = true
         
         // // Desactivar los botones
         form.value.submit_create.hide = true
         form.value.submit_create_budget.hide = true
         form.value.submit_create_tracing.hide = true

         const formSubmit = async ( data ) => {

            console.log("Editar lead")

         }

         const eventProfileMenuSelected = ( name ) => {

           return router.push({ name })

         }

         onMounted( async () => {

            formLoding.value = true

            // Se obtiene el lead
            const leadData = await serviceCustomers.getCustomer({ id: route.params.entityId});

            form.value.company_name.value = leadData.name
            form.value.company_legal_representative_name.value = leadData.legal_representative_name
            form.value.company_tax_number.value = leadData.tax_number
            form.value.company_email.value = leadData.email
            form.value.company_phone.value = leadData.phone
            form.value.company_country.value = leadData.contry
            form.value.company_province.value = leadData.province
            form.value.company_city.value = leadData.city
            form.value.company_pc.value = leadData.pc
            form.value.company_address.value = leadData.address
            form.value.company_acquisition.value = leadData.acquisition
            form.value.company_interests.value = leadData.interests.map( ({name}) => name )
            form.value.company_notes.value = leadData.notes

            // Desabiltar el formulario
            for(let key in form.value){ form.value[key].disabled = true  }

            formLoding.value = false

            breadcrumbStore.set({
               route,
               lead: leadData
            })

         })

         return {

            // Consts

            // Refs
            profileMenuSelected,
            form,
            formLoding,

            // Methods
            formSubmit,
            eventProfileMenuSelected,

         }

      }

   }

</script>


<style lang="scss" scoped>

   .padding{
      padding: 20px;
      min-height: 50vh;
   }


</style>
