import { ref } from 'vue'

import dayjs from 'dayjs';
import * as serviceTracing from '../services/serviceTracing';

export const breadcrumbs = ref([])
export const notificationNumber = ref(0)

export const routeChange = ((routeName) => {

   setBreadcrumbs(routeName)
   setNotification(routeName)

});

export const set = (data) => {

   const routeName = data.route.name

   if(routeName == 'customer_profile_company'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: `LISTA DE ${data.route.params.entityType}` },
         { label: data.lead.name },
         { label: 'PERFIL CLIENTE' },
      ]
   }
   if(routeName == 'customer_profile_contacts'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: `LISTA DE ${data.route.params.entityType}` },
         { name: 'customer_profile_company', label: data.lead.name },
         { label: 'CONTACTOS' },
      ]
   }
   if(routeName == 'customer_profile_tracing'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: `LISTA DE ${data.route.params.entityType}` },
         { name: 'customer_profile_company', label: data.lead.name },
         { label: 'SEGUIMIENTO' },
      ]
   }
   if(routeName == 'customer_profile_invoice'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: `LISTA DE ${data.route.params.entityType}` },
         { name: 'customer_profile_company', label: data.lead.name },
         { label: 'PRESUPUESTOS' },
      ]
   }

}


async function setNotification(routeName){

   const tracings = await serviceTracing.getTracings();

   const tracingToday = tracings.filter( tracing => {
      return dayjs(tracing.finished_at).format('YYYY-MM-DD') === dayjs().format('YYYY-MM-DD');
   }).filter( tracing => {
      return tracing.state === 'open'
   })

   notificationNumber.value = tracingToday.length

}

function setBreadcrumbs(routeName){

   // Technical
   if(routeName == 'technical'){
      return breadcrumbs.value = [
         {name: 'technical', label: 'Inicio'}
      ]
   }

   // Technical Customer
   if(routeName == 'customer_list'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { label: 'LISTA DE CLIENTES' },
      ]
   }

   // Technical Lead

   if(routeName == 'customer_list'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { label: 'LISTA DE CLIENTES' },
      ]
   }
   if(routeName == 'customer_create'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: 'LISTA DE CLIENTES' },
         { label: 'CREAR CLIENTE' },
      ]
   }
   if(routeName == 'customer_profile_company'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: 'LISTA DE CLIENTES' },
         { loading: true },
         { label: 'PERFIL CLIENTE' },
      ]
   }
   if(routeName == 'customer_profile_contacts'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: 'LISTA DE CLIENTES' },
         { loading: true },
         { label: 'CONTACTOS' },
      ]
   }
   if(routeName == 'customer_profile_tracing'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: 'LISTA DE CLIENTES' },
         { loading: true },
         { label: 'SEGUIMIENTO' },
      ]
   }
   if(routeName == 'customer_profile_invoice'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'customer_list', label: 'LISTA DE CLIENTES' },
         { loading: true },
         { label: 'PRESUPUESTOS' },
      ]
   }
   
   // Technical Invoice
   
   if(routeName == 'invoice_list'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { label: 'LISTA DE PRESUPUESTOS' },
      ]
   }
   if(routeName == 'invoice_create'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'invoice_list', label: 'LISTA DE PRESUPUESTOS' },
         { label: 'CREAR PRESUPUESTO' },
      ]
   }
   if(routeName == 'invoice_create_id'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'invoice_list', label: 'LISTA DE PRESUPUESTOS' },
         { label: 'CREAR PRESUPUESTO' },
      ]
   }
   
   // Technical tracing

   if(routeName == 'tracing_list'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { label: 'LISTA DE SEGUIMIENTOS' },
      ]
   }
   if(routeName == 'tracing_create'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'tracing_list', label: 'LISTA DE SEGUIMIENTO' },
         { label: 'CREAR SEGUIMIENTO' },
      ]
   }
   if(routeName == 'tracing_create_id'){
      return breadcrumbs.value = [
         { name: 'technical', label: 'Inicio' },
         { name: 'tracing_list', label: 'LISTA DE SEGUIMIENTO' },
         { label: 'CREAR SEGUIMIENTO' },
      ]
   }

}