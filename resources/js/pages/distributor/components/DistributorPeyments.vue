<template>

   <div class="payments-menu">

      <el-radio-group class="payments-menu-selectors" v-model="statusSelected">
         <el-radio-button label="Todas"></el-radio-button>
         <el-radio-button label="Solicitado"></el-radio-button>
         <el-radio-button label="Aceptado"></el-radio-button>
         <el-radio-button label="Completado"></el-radio-button>
         <el-radio-button label="Cancelado"></el-radio-button>
         <el-radio-button label="Reembolsado"></el-radio-button>
      </el-radio-group>

      <div class="payments-menu-searchs">

         <el-input v-model="searchFilter" placeholder="Busca en todas las columnas" />

      </div>

   </div>

  <div class="demo-collapse">
      <el-collapse v-model="activeNames">

         <template v-for="(item, index) in orderByStatus" :key="index" >

            <el-collapse-item :title="`${item.id} - ${item.created_at_format}`" :name="index">

               <div class="grid-2">

                  <div>
                      <div class="payments-details">
                        <div class="payments-details-label">ID</div>
                        <div class="payments-details-value">{{item.id}}</div>
                     </div>

                     <div class="payments-details">
                        <div class="payments-details-label">Fecha</div>
                        <div class="payments-details-value">{{item.created_at_format}}</div>
                     </div>

                     <div class="payments-details">
                        <div class="payments-details-label">Creditos Solicitados</div>
                        <div class="payments-details-value">{{item.credits}}</div>
                     </div>

                     <div class="payments-details">
                        <div class="payments-details-label">Estado</div>
                        <div class="payments-details-value">{{item.statusTranslate}}</div>
                     </div>
                  </div>

                  <div>
                     
                     <el-button type="primary" size="small" 
                        @click="clickAccept(item.id)" :disabled="item.stateBtnAccept">
                        ACEPTAR
                     </el-button>

                     <el-button type="warning" size="small" 
                        @click="clickCancel(item.id)" :disabled="item.stateBtnCancel">
                        CANCELAR
                     </el-button>

                  </div>

               </div>
               
               

            </el-collapse-item>

         </template>
      </el-collapse>
   </div>
</template>

<script>

   import * as api from '../../../services/api';
   import * as utils from '../../../helpers/utils';

   export default {

      props: {
         data: {
            type: Array,
            default: []
         },
      },
      data() {

         return {
            dataServer: dataServer,
            activeNames: ['1'],
            statusSelected: 'Todas',
            searchFilter: '',
         }

      },

      computed: {

         orderByStatus: function() {

            if(!this.data || this.data.length == 0) return [];

            return this.data.filter(function(item) {
               if(this.statusSelected == 'Todas') return item
               return item.statusTranslate == this.statusSelected;
            }.bind(this))
            .filter(function(item) {
               return Object.keys(item).some(function(key) {
                  if (typeof item[key] === 'string' || typeof item[key] === 'number') {
                     return item[key].toString().toLowerCase().indexOf(this.searchFilter.toLowerCase()) > -1;
                  }
               }.bind(this))
            }.bind(this))

         }

      },

      methods: {

         async clickAccept(id){

            api.updatePayment({id, "status": "Accepted" })
               // .then(utils.notificationUser)
               .then(this.getData)

         },

         async clickCancel(id){

            api.updatePayment({id, "status": "Canceled" })
               // .then(utils.notificationUser)
               .then(this.getData)
   
         }
     
      },

   }


</script>


<style lang="scss">

   .payments-menu{
      display: flex;
      justify-content: space-between;
   }

   .payments-menu-selectors{
      margin-bottom: 10px;
   }
   
   .el-collapse{
      border: none;
   }
   .el-collapse-item__header{
      background: #f3f3f3;
      padding: 0 15px;
      font-weight: bold;
      user-select: none;
      margin: 10px 0;
      border-radius: 5px;
   }

   .list-items{
      padding: 15px;
   }  

   .payments-details {
      display: flex;
      gap: 10px;
   }

   .payments-details-label{
      font-weight: bolder;
   }

   
</style>