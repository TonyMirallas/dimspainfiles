<template>

   <div class="layout">

      <div class="content">

         <h1 class="content-title">Lista Clientes ({{tableData.length}})</h1>

         <div class="content-back" v-loading="loading">

            <table-pro v-model="tableData" :column-order="tableDataOrder" :items-for-page="50">
               <template v-slot:btn-edit="slotProps">
                  <router-link :to="`/distributor/professional/${slotProps.item.id}`">{{slotProps.item.user}}</router-link>
               </template>
            </table-pro>

         </div>
      </div>

   </div>

</template>

<script>

   import * as api from '../../services/api';

   export default {

      data() {
         
         return {
            dataServer: dataServer,
            loading: true,
            tableData: [],
            tableDataOrder: [],
         }
      },
      
      mounted() {
         
         this.getData()

      },

      methods: {

         async getData(){

            // address: "Calle falsa"
            // cif: "6929152C"
            // company: "professional1Company"
            // country: "ESPAÑA"
            // description: "lore ipsum"
            // distributor_id: 1
            // email: "professional1@email.com"
            // id: 1
            // initial_invoice: null
            // name: "professional1Name"
            // phone: "1111111"
            // province: "GRANADA"
            // state: 1
            // tax_company: null
            // town: "GRANADA"
            // type: "Standard"
            // user: "F2044"

            this.loading = true;

            // Definición de las columnas de la tabla
            this.tableDataOrder = [
               {label: 'Profesional', field: 'user', type: 'slot', slot: 'btn-edit', filter: true},
               {label: 'Nombre Taller', field: 'company', type: 'text', filter: true},
               {label: 'CIF', field: 'cif', type: 'text'},
               {label: 'Email', field: 'email', type: 'text'},
               {label: 'Telefono', field: 'phone', type: 'text'},
               // {label: 'Factura inicial', field: 'initial_invoice', type: 'text', filter: true},
               // {label: 'Creditos', field: 'credits', type: 'text'},
               {label: 'Provincia', field: 'province', type: 'text'},
            ]

            // Definición de los datos de la tabla
            this.tableData = (await api.getDistributorProfessionals({id: this.dataServer.auth.id})).data;

            this.loading = false;

         }

      },


   }
</script>