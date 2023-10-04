<template>

   <div class="layout technical-profile-create">

      <div class="content">

         <div class="box">

            <div class="box-content">

               <TechnicalFormEntities
                  v-loading="loading"
                  :form="form"
                  @on-submit="submitForm"
               >

               <template v-slot:company_search>
                  <SearchPro 
                     placeholder="Buscar Empresa"
                     v-model="searchCompnay"
                     :items="[...customerLead, ...customerSage]"
                     :labels="['name']"
                     labelSelected="name"
                     @click-item="eventCompanySelected"
                  />
               </template>

               </TechnicalFormEntities>

            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { ref, onMounted, watch } from 'vue'
   import { useRoute, useRouter } from 'vue-router'
   import dayjs from 'dayjs';
 
   import tracing from '../../../../dataConstants/tracing';

   import * as cacheStore from '../../../../dataStores/cacheStore';
   import * as serviceCustomers from '../../../../services/serviceCustomers';
   import * as serviceUsers from '../../../../services/serviceUsers';
   import * as serviceTechnical from '../../../../services/serviceTechnical';
   import * as serviceTracing from '../../../../services/serviceTracing';

   export default {

      name: 'TechnicalEntityCreate',
      setup(){

         const route = useRoute()
         const router = useRouter()

         const formCreate = structuredClone(tracing.formCreate)

         const loading = ref(true);
         const form = ref(formCreate);

         const searchCompnay = ref('')
         const companySelected = ref({});

         const customerLead = cacheStore.getCacheData('customers:lead', () => serviceCustomers.getCustomers({type: 'lead'}), [])
         const customerSage = cacheStore.getCacheData('customers:sage', () => serviceCustomers.getCustomers({type: 'sage'}), [])

         form.value.date_created.value = dayjs().format('YYYY-MM-DD HH:mm');
         form.value.finished_at.value = dayjs().add(5, 'day').format('YYYY-MM-DD HH:mm');

         watch([customerLead, customerSage], () => {

            // Se auto selecciona la empresa en caso de que exista
            const profileData = [...customerLead.value, ...customerSage.value].find( ({id}) => id == route.params.entityId )

            if(profileData){

               // Seleccionar Empresa
               searchCompnay.value = profileData.name,
               eventCompanySelected(profileData)

            }
            
         })

         onMounted( async () => {

            loading.value = true;
            
            // Se obtienen los technicals
            const technicals = await serviceUsers.getUsers({ rol: "commercial" })

            form.value.technical_id.options = technicals.map( (item) => {
               return { key: item.id, label: item.name }
            })

            form.value.technical_id.value = dataServer.auth.id

            loading.value = false;

         })

         const eventCompanySelected = (item) => {

            const contact = item.contacts.find( (contact) => contact.id == form.value.contact_id.value )
            const contactFrom = item.contacts.find( (contact) => contact.id == form.value.from_contact_id.value )

            form.value.contact_id.value = contact ? contact.id : null
            form.value.from_contact_id.value = contactFrom ? contactFrom.id : null
            
            form.value.from_contact_id.options = item.contacts.map( (item) => {
               return { key: item.id, label: item.name }
            })

            form.value.contact_id.options = item.contacts.map( (item) => {
               return { key: item.id, label: item.name }
            })

            companySelected.value = item

         }
         
         const submitForm = async (item) => {

            loading.value = true

            const structTask = {
               "user_id": form.value.technical_id.value,
               "from_user_id": dataServer.auth.id, 
               "customer_id": companySelected.value.id,
               "contact_id": form.value.contact_id.value,
               "from_contact_id": form.value.from_contact_id.value,
               "channel": form.value.channel.value,
               "objetive": form.value.objetive.value,
               "state": "open",
               "description": form.value.description.value,
               "relation": {},
               "finished_at": dayjs(form.value.finished_at.value).format('YYYY-MM-DD HH:mm'),
            }

            await serviceTracing.postTask(structTask)

            loading.value = false

            if(item.key == 'submit_form_crete'){
               return router.go()
            }

            if(item.key == 'submit_form_create_redirect'){

               return router.push({ name: 'customer_profile_tracing', params: { 
                  entityType: companySelected.value.type,
                  entityId: companySelected.value.id
               }})
               
            }

         }

         return {

            // Refs
            form,
            loading,
            searchCompnay,
         
            customerLead, customerSage,

            // Variables

            // Functions External

            // Functions
            submitForm,
            eventCompanySelected,

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
