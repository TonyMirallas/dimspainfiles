<template>

   <div class="layout technical-profile-create">

      <div class="content">

         <div class="box">

            <div class="box-nav">

               <div class="box-nav-l"></div>

               <div class="box-nav-r flex-auto flex-gap-20">

                  <el-select v-model="profileTypeSelected" placeholder="Tipos de Cliente" size="large">
                     <el-option
                        v-for="(label, key) in entityCreate"
                        :key="key"
                        :value="key"
                        :label="label"
                     />
                  </el-select>

               </div>

            </div>

            <div class="box-content">

               <TechnicalFormEntities
                  v-loading="loading"
                  :form="form"
                  @on-submit="submitForm"
               />

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { ref } from 'vue'
   import { useRouter } from 'vue-router'
 
   import locations from '../../../../dataConstants/locations';
   import entityLead from '../../../../dataConstants/entityLead';
   import crmComercial from '../../../../dataConstants/crmComercial';

   import * as serviceCustomers from '../../../../services/serviceCustomers';

   export default {

      name: 'TechnicalEntityCreate',
      setup(){

         const profileTypeSelected = ref('lead');

         const router = useRouter()

          // Create clone of entityLead not reference
         const entityLeadForm = structuredClone(entityLead.form)

         // Declarar Refs
         const loading = ref(false);
         const form = ref(entityLeadForm);

         let leadCreateRes = null

         // Se añaden los paises al selector del form
         entityLeadForm.company_country.options = locations.countriesLabel
         entityLeadForm.submit_update.hide = true

         const createLead = async () => {

            leadCreateRes = await serviceCustomers.createCustomer({
               name: form.value.company_name.value,
               // commercial_name: '',
               legal_representative_name: form.value.company_legal_representative_name.value,
               tax_number: form.value.company_tax_number.value,
               pc: form.value.company_pc.value,
               phone: form.value.company_phone.value,
               address: form.value.company_address.value,
               country: form.value.company_country.value,
               province: form.value.company_province.value,
               city: form.value.company_city.value,
               notes: form.value.company_notes.value, // Cambiar esto en los struct
               email: form.value.company_email.value,
               interests: form.value.company_interests.value,
               acquisition: form.value.company_acquisition.value,
               competitors: form.value.company_competitors.value,
               type: profileTypeSelected.value
            });

            if(!leadCreateRes.success){

               leadCreateRes = null

            }else{

               form.value.company_name.disabled = true
               form.value.company_legal_representative_name.disabled = true
               form.value.company_tax_number.disabled = true
               form.value.company_email.disabled = true
               form.value.company_phone.disabled = true
               form.value.company_country.disabled = true
               form.value.company_province.disabled = true
               form.value.company_city.disabled = true
               form.value.company_pc.disabled = true
               form.value.company_address.disabled = true
               form.value.company_acquisition.disabled = true
               form.value.company_interests.disabled = true
               form.value.company_notes.disabled = true


            }

         }

         const createContact = async () => {

            const contact = await serviceCustomers.createContactCustomer({
               id: leadCreateRes.data.id,
               name: form.value.contact_name.value,
               email: form.value.contact_email.value,
               phone: form.value.contact_phone.value,
               position: form.value.contact_position.value,
               channel: form.value.contact_channel.value,
               observations: form.value.contact_observations.value,
            });

            if(contact.success){

               return true

            }else{

               return false

            }

         }

         const createContactCompany = async () => {

            const contact = await serviceCustomers.createContactCustomer({
               id: leadCreateRes.data.id,
               name: form.value.company_name.value,
               email: form.value.company_email.value,
               phone: form.value.company_phone.value,
               position: 'company',
               channel: null,
               observations: null,
            });

            if(contact.success){

               return true

            }else{

               return false

            }

         }

         const submitFormEnd = (item) => {

            if(item.key == 'submit_create' ){
               
               return router.go()

            }

            if(item.key == 'submit_create_budget' ){
               
               return router.push({ name: 'invoice_create_id', params: { entityId: leadCreateRes.data.id } })

            }

            if(item.key == 'submit_create_tracing'){

               return router.push({ name: 'tracing_create_id', params: { entityId: leadCreateRes.data.id } })

            }

         }

         const submitForm = async ( item ) => {

            loading.value = true;

            if(!leadCreateRes){

               await createLead()

            }

            if(leadCreateRes){

               const createContactCompanyRes = await createContactCompany()
               const createContactRes = await createContact()

               if(createContactCompanyRes && createContactRes) submitFormEnd(item)

            }

            loading.value = false;

         }

         return {
            // Refs
            form,
            loading,

            // Variables

            // Functions External
            serviceCustomers,

            // Functions
            submitForm,

            profileTypeSelected,
            entityCreate: crmComercial.entityCreate,


         }

      }

   }

</script>


<style lang="scss" scoped>

   .technical-profile-create{
      
      .box-content{
         padding: 20px;
      }

   }

</style>
