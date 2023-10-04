<template>

   <div class="layout-profesional profesional-orders">

      <div class="layout-profesional-content">
         
         <h1>Lista de Ordenes</h1>
         
            <div class="orders-menu">

               <el-radio-group class="orders-menu-selectors" v-model="statusSelected">
                  <el-radio-button label="Todas"><span class="label1">Todas</span> <span class="bubble">{{bubbles['Todas']}}</span></el-radio-button>
                  <el-radio-button label="Pendiente"><span class="label2">Pendiente </span> <span class="bubble">{{bubbles['Pendiente']}}</span></el-radio-button>
                  <el-radio-button label="En Proceso"><span class="label3">En Proceso</span> <span class="bubble">{{bubbles['En Proceso']}}</span></el-radio-button>
                  <el-radio-button label="Completado"><span class="label4">Completado</span> <span class="bubble">{{bubbles['Completado']}}</span></el-radio-button>
                  <el-radio-button label="Devolución"><span class="label5">Devolución</span> <span class="bubble">{{bubbles['Devolución']}}</span></el-radio-button>
               </el-radio-group>

               <div class="orders-menu-searchs">

                  <el-input v-model="searchFilter" placeholder="Busca en todas las columnas" />

               </div>

            </div>

            <div class="demo-collapse">
               <el-collapse v-model="activeNames">

                  <template v-for="(order, index) in orderByStatus" :key="order.id" >

                     <el-collapse-item v-if="order" :title="`${order.created_at_format} - ${order.manufacture} `" :name="index">
                        
                        <div class="agrupado">
                           <div class="detalle">Orden ID</div>
                           <div class="detalleinfo">{{order.id || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Fecha</div>
                           <div class="detalleinfo">{{order.emission || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Estandar</div>
                           <div class="detalleinfo">{{dateFormat || '-'  }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Combustible</div>
                           <div class="detalleinfo">{{order.fuel || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Tipo Vehículo</div>
                           <div class="detalleinfo">{{order.veh_type || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Marca</div>
                           <div class="detalleinfo">{{order.manufacture || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Modelo</div>
                           <div class="detalleinfo">{{order.model || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Motor</div>
                           <div class="detalleinfo">{{order.type || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">kw</div>
                           <div class="detalleinfo">{{order.kw || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Opciones</div>
                           <div class="detalleinfo">{{order.options || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">SHW</div>
                           <div class="detalleinfo">{{order.shw_file || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Estado</div>
                           <div class="detalleinfo">{{order.status || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Año</div>
                           <div class="detalleinfo">{{order.year || '-' }}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Archivo Profesional</div>
                           <div class="detalleinfo">{{order.professional_file || 'Sin Archivo'}}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Archivo Tecnico</div>
                           <div class="detalleinfo">{{order.technical_file || 'Sin archivo'}}</div>
                        </div>
                        <div class="agrupado">
                           <div class="detalle">Notas</div>
                           <div class="detalleinfo">{{order.notes || '-' }}</div>
                        </div>

                           <!-- <div class="orders-details-label">Costo Creditos</div> 
                              <div class="orders-details-value">{{calcCostCredits}}</div>  -->
                     


                     </el-collapse-item>

                  </template>
                  
               </el-collapse>
            </div>
                  
      </div>

   </div>

</template>

<script>
   import dayjs from 'dayjs';

   import * as api from '../../services/api';

   export default {

      data() {
         
         return {
            dataServer: dataServer,
            loading: true,
            orderData: [],
            professionalData: {},
            activeNames: ['1'],
            statusSelected: 'Todas',
            searchFilter: '',
            btnHide: false,
            bubbles: {
               'Todas': 0,
               'Pendiente': 0,
               'En Proceso': 0,
               'Completado': 0,
               'Devolución': 0,
            }
         }
      },
      
      mounted() {

         this.getData()

      },

      watch: {

         

      },

      computed: {

         orderByStatus: function() {

            return this.filterOrders(this.orderData, this.statusSelected, this.searchFilter)
   
         },

         dateFormat(){

            if(!this.order) return '-';

            return dayjs(this.order.created_at).format('DD/MM/YYYY HH:mm');

         },

         calcCostCredits() {

            if (this.order.payments) {

               const order = this.order.payments.filter( pay => pay.payment == 'order' )

               if(!order || order.length == 0) return '-';

               return order[0].credits;

            } else {

               return '-'

            }

         }

      },

      methods: {

         async getData(){

            this.loading = true;
            
            this.orderData = (await api.getOrdersByProfessional({id: this.dataServer.auth.id})).data;
            // this.professionalData = await api.getProfessional({id: this.orderData.professionalId});

            this.bubbles['Todas'] = this.filterOrders(this.orderData, 'Todas', '').length
            this.bubbles['Pendiente'] = this.filterOrders(this.orderData, 'Pendiente', '').length
            this.bubbles['En Proceso'] = this.filterOrders(this.orderData, 'En Proceso', '').length
            this.bubbles['Completado'] = this.filterOrders(this.orderData, 'Completado', '').length
            this.bubbles['Devolución'] = this.filterOrders(this.orderData, 'Devolución', '').length

            this.loading = false;

         },

         filterOrders(orderData, statusSelected, searchFilter){

            if(!orderData || orderData.length == 0) return [];

            return orderData.filter(function(order) {
               if(statusSelected == 'Todas') return order
               return order.status == statusSelected;
            })
            .filter(function(order) {
               return Object.keys(order).some(function(key) {
                  if (typeof order[key] === 'string' || typeof order[key] === 'number') {
                     return order[key].toString().toLowerCase().indexOf(searchFilter.toLowerCase()) > -1;
                  }
               })
            })
            .map( function(order) {
               order.created_at_format = dayjs(order.created_at).format('DD/MM/YYYY');
               /* order.created_at_format = dayjs(order.created_at).format('DD/MM/YYYY HH:mm'); */
               return order;
            });

         }
         

      },


   }

</script>


<style lang="scss" scoped>

   .orders-menu-selectors{
      // width: 100%;
   }

   .agrupado:nth-child(2n+1) {
      background:#f2f2f2;
   }

   .detalleinfo, .detalle {
      word-break: break-all;
      padding: 2px;
      padding-left: 10px;
   }

   .agrupado {
      display: grid;
      grid-template-columns: 1fr 1fr;
   }
   
   .orders-details-value {
      // text-align: end;
   }

   .orders-details-label {
         text-align: start!important;
   }
  
   .list-items {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 20px;
   }

   .item-text {
      display: grid;
      gap: 10px;
      grid-template-columns: auto 1fr;
      align-items: flex-end;
   }

   .label {
      font-size: 14px;
      font-weight: 600;
      text-transform: uppercase;
   }

   .value {
     font-size: 15px;
      line-height: 25px;
   }

   .orders-menu{
      margin-top: 40px;
      // display: flex;
      // justify-content: space-between;
      // flex-wrap: wrap;
   }

   .orders-menu-selectors{
      position: relative;
      margin-bottom: 10px;

      .label1:before {
         content: "\f067";
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         padding-right: 5px;
      }
      .label2:before {
         content: "\f06a";
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         padding-right: 5px;
      }
      .label3:before {
         content: "\f017";
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         padding-right: 5px;
      }
      .label4:before {
         content: "\f058";
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         padding-right: 5px;
      }
      .label5:before {
         content: "\f1da";
         font-family: "Font Awesome 6 Free";
         font-weight: 900;
         padding-right: 5px;
      }

      .bubble{
         position: absolute;
         top: -20px;
         right: -10px;
         background: white;
         border-radius: 50%;
         width: 26px;
         height: 26px;
         z-index: 1;
         display: flex;
         justify-content: center;
         align-items: center;
         color: black;
         font-size: 12px;
         box-shadow: 0 3px 17px 2px rgb(0 0 0 / 16%);
         font-weight: 700;
      }

   }
   
   .list-items{
      padding: 15px;
   }
   
</style>