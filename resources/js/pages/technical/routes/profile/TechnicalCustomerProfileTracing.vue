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

            <div class="box-nav-sub">
               
               <router-link :to="{ name: 'tracing_create_id', params: { entityId } }">
                  <el-button>Crear Nuevo Seguimiento</el-button>
               </router-link> 

            </div>

            <div class="box-content" v-loading="loading" >
   
               <div v-for="(form, index) of formsOpen" :key="index">
                  <TechnicalFormEntities :form="form" >
                     <template v-slot:state>
                        <el-select size="large" v-model="form.state.value" @change="eventChangeState(form)" >
                           <el-option v-for="item in form.state.options" :key="item.value" :label="item.label" :value="item.key" />
                        </el-select>
                     </template>

                     <template v-slot:slot1 v-if="form.invoice_id.value">

                        <a class="btn-link" :href="`/dim/public/technical/invoice/pdf/${form.invoice_id.value}`" target="_blank">
                           <el-button size="small">Presupuesto PDF</el-button>
                        </a>

                     </template>

                  </TechnicalFormEntities>
               </div>

               <div v-for="(form, index) of formsClosed" :key="index">
                  <TechnicalFormEntities :form="form">
                     <template v-slot:state>
                        <el-select size="large" v-model="form.state.value" disabled>
                           <el-option v-for="item in form.state.options" :key="item.value" :label="item.label" :value="item.key" />
                        </el-select>
                     </template>
                     <template v-slot:slot1 v-if="form.invoice_id.value">

                        <a class="btn-link" :href="`/dim/public/technical/invoice/pdf/${form.invoice_id.value}`" target="_blank">
                           <el-button size="small">Presupuesto PDF</el-button>
                        </a>

                     </template>

                  </TechnicalFormEntities>
               </div>
               
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

   import { ElMessage, ElMessageBox } from 'element-plus'

   import tracing from '../../../../dataConstants/tracing';

   import * as serviceLeads from '../../../../services/serviceLeads';
   import * as serviceTracing from '../../../../services/serviceTracing';
   import * as serviceUsers from '../../../../services/serviceUsers';
   import * as serviceTechnical from '../../../../services/serviceTechnical';
   import * as serviceCustomers from '../../../../services/serviceCustomers';

   // import { breadcrumbs } from '../../../../dataStores/globalStore'; 

   import { dateToFormat } from '../../../../helpers/utils';

  import * as breadcrumbStore from '../../../../dataStores/breadcrumbStore';

   export default {
      name: 'TechnicalEntityProfileCompany',
      setup(props){

         const statusToLabel = {
            'open': 'Abierto', 
            'closed': 'Cerrado',
         }

         const route = useRoute()
         const router = useRouter()

         const loading = ref(false)
         const formsOpen = ref([])
         const formsClosed = ref([])
         const profileMenuSelected = ref('customer_profile_tracing')
         
         onMounted( async () => {

            loading.value = true;

            const leadData = await serviceCustomers.getCustomer({ id: route.params.entityId});

            breadcrumbStore.set({
               route,
               lead: leadData
            })

            await loadData();

            loading.value = false;

         })

         const loadData = async () => {

            loading.value = true;

            formsOpen.value = [];
            formsClosed.value = [];

            const technicals = await serviceUsers.getUsers({ rol: "commercial" })
         
            const technicalsIdToName = technicals.reduce( (acc, technical) => {
               acc[technical.id] = technical.name;
               return acc;
            }, {})

            const tasks = await serviceTracing.getTracings()

            const tasksFilter = tasks.filter( task => task.customer_id == route.params.entityId )

            const taskOpen = tasksFilter.filter( task => task.state == 'open' )
            const taskClosed = tasksFilter.filter( task => task.state == 'closed' )
            
            taskOpen.sort( (a, b) => {
               const date = new Date(a.finished_at) - new Date(b.finished_at)
               const id = a.id - b.id
               return date || id
            })

            taskClosed.sort( (a, b) => {
               const date = new Date(a.finished_at) - new Date(b.finished_at)
               const id = a.id - b.id
               return date || id
            })

            for(let task of taskOpen){
               const formStruct = createFormStruct(task, technicalsIdToName);
               formsOpen.value.push(formStruct)
            }

            for(let task of taskClosed){
               const formStruct = createFormStruct(task, technicalsIdToName);
               formsClosed.value.push(formStruct)
            }
      
            loading.value = false;

         }

         const createFormStruct = (task, technicalsIdToName) => {

            const formTaskList = structuredClone(tracing.formTaskList)

            formTaskList.id = task.id;
            formTaskList.from_user_id.value = technicalsIdToName[task.from_user_id]
            formTaskList.contact_id.value = task.contact.name
            formTaskList.from_contact_id.value = task.from_contact.name
            formTaskList.channel.value = task.channel
            formTaskList.objetive.value = task.objetive
            formTaskList.description.value = task.description
            formTaskList.result.value = task.result
            formTaskList.state.value = task.state

            formTaskList.title1.label = dateToFormat(task.finished_at)

            formTaskList.invoice_id = { key: 'invoice_id', value: null }

            if(task.relation && task.relation.table == 'invoice'){
               formTaskList.invoice_id.value = task.relation.id // Esto hay que hacerlo bien mirando "table"
            }

            if(task.state == 'closed'){

               formTaskList.from_user_id.disabled = true
               formTaskList.contact_id.disabled = true
               formTaskList.from_contact_id.disabled = true
               formTaskList.channel.disabled = true
               formTaskList.objetive.disabled = true
               formTaskList.description.disabled = true
               formTaskList.result.disabled = true
               formTaskList.state.disabled = true

            }

            return formTaskList

         }

          const eventProfileMenuSelected = ( name ) => {

           return router.push({ name })

         }

         const eventChangeState = async (task) => {

            loading.value = true;

            ElMessageBox.prompt('¿Resultado Del Seguimiento?', {
               confirmButtonText: 'Guardar',
               cancelButtonText: 'Cancel',
               inputPattern: /^.+$/,
               inputErrorMessage: 'El resultado es requerido',
            }).then( async ({value}) => {

               const struct = {
                  "id": task.id,
                  "state": "closed",
                  "result": value
               }

               await serviceTracing.putTask(struct)

               // Resfresh page
               loadData()

   
            }).catch(() => {

               task.state.value = 'open'

               loading.value = false;

            })

         }
    
         return {
            
            loading,
            formsOpen, formsClosed,

            statusToLabel,
            eventChangeState,
            dateToFormat,

            profileMenuSelected,

            eventProfileMenuSelected,

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
