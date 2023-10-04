<template>

   <div class="layout technical-profile-create">

      <el-dialog
         v-model="dialogCalendar.show"
         :title="dialogCalendar.title"
         :show-close="false"
         :close-on-click-modal="false"
      >
         <el-calendar v-model="dialogCalendar.date" />
         <el-popconfirm title="¿Estás seguro?" @confirm="eventDialogCalendarCancel">
            <template #reference>
               <el-button>{{dialogCalendar.btn1}}</el-button>
            </template>
         </el-popconfirm>
         <el-button @click="eventDialogCalendar" type="primary">{{dialogCalendar.btn2}}</el-button>
      </el-dialog>

      <el-dialog
         v-model="dialogActionsShow"
         title="Ultimas Acciones"
         :show-close="false"
         :close-on-click-modal="false"
      >
         <div class="dialogactions">
            <el-button @click="eventDialogActionsInvoiceEmail" type="primary" :disabled="true">Enviar Presupuesto Por Email</el-button>
            <a class="btn-link" :href="`/dim/public/technical/invoice/pdf/${invoiceCreated.id}`" target="_blank">
               <el-button type="primary">Presupuesto PDF</el-button>
            </a>
            <router-link class="btn-link" :to="{ name: 'customer_profile_company', params: { entityId: company.id, entityType: company.type } }">
               <el-button type="primary">Ver Cliente</el-button>
            </router-link>
            <el-popconfirm title="¿Estás seguro?" @confirm="eventDialogActionsCancel">
               <template #reference>
                  <el-button>Cancelar</el-button>
               </template>
            </el-popconfirm>
         </div>
      </el-dialog>

      <div class="content">

         <div class="box">

            <div class="box-content" v-loading="loading">

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
                        @click-item="companySelected"
                     />
                  </template>

                  <template v-slot:products_search>
                     <SearchPro
                        placeholder="Buscar Producto"
                        v-model="searchProduct"
                        :items="products"
                        :labels="['code', 'name']"
                        labelSelected="code"
                        @click-item="( item ) => productSelected = item"
                     />
                  </template>

                  <template v-slot:products_table >

                     <TablePro v-loading="loadingAddProduct" :columnData="productsInvoice" :column-order="tableInvoiceProducts" filterSearch="" :items-for-page="50" :paginationHide="true">
                        <template v-slot:text-value="slotProps">
                           <span class="text-max-width">{{slotProps.item.name}}</span>
                        </template>
                        <template v-slot:input-code="slotProps">
                           <el-input v-if="slotProps.type == 'new'" v-model="slotProps.item.code" size="small" />
                           <span v-else >{{slotProps.item.code}}</span>
                        </template>
                        <template v-slot:input-name="slotProps">
                           <el-input v-if="slotProps.type == 'new'" v-model="slotProps.item.name" size="small" />
                            <el-tooltip v-else
                              class="box-item"
                              effect="dark"
                              :content="slotProps.item.name"
                              placement="bottom"
                           >
                              <span class="text-limit"  >{{slotProps.item.name}}</span>
                           </el-tooltip>
                        </template>
                        <template v-slot:input-price="slotProps">
                           <el-input-number class="input-number-max-width" 
                              v-model="slotProps.item.price" @change="updateCalc(slotProps.item)" 
                              controls-position="right" size="small" :step="1" :min="1" step-strictly
                           />
                        </template>
                        <template v-slot:input-units="slotProps">
                           <el-input-number class="input-number-max-width" 
                              v-model="slotProps.item.units" @change="updateCalc(slotProps.item)" 
                              controls-position="right" size="small" :step="1" :min="1" step-strictly
                           />
                        </template>
                        <template v-slot:input-discount="slotProps">
                           <el-input-number class="input-number-max-width"
                              v-model="slotProps.item.discount" @change="updateCalc(slotProps.item)"
                              controls-position="right" size="small" :step="1" :min="0" :max="100" step-strictly
                           />
                        </template>
                        <template v-slot:btn-remove="slotProps">
                           <div class="btn-remove" @click="productsInvoiceRm(slotProps.item)">
                              <i class="fa-solid fa-xmark"></i>
                           </div>
                        </template>
                     </TablePro>

                     <div class="invoice-add">
                        <el-button class="el-icon--right" size="small" :icon="Plus" @click="eventAddProductLine" :disabled="true">Añadir Fila</el-button>
                     </div>

                  </template>

               </TechnicalFormEntities>
 
            </div>

         </div>
         
      </div>

   </div>

</template>

<script>

   import { ElNotification } from 'element-plus'

   import { Plus } from '@element-plus/icons-vue'
   import { Calendar } from '@element-plus/icons-vue'
   import { useRoute, useRouter } from 'vue-router'

   import dayjs from 'dayjs';
   import { ref, watch, onMounted } from 'vue'

   import { productsEnables } from '../../../../dataConstants/products';

   import invoice from '../../../../dataConstants/invoice';

   import * as cacheStore from '../../../../dataStores/cacheStore';

   import * as serviceCustomers from '../../../../services/serviceCustomers';
   import * as serviceStock from '../../../../services/serviceStock';
   import * as serviceInvoice from '../../../../services/serviceInvoice';
   import * as serviceTracing from '../../../../services/serviceTracing';
   
   export default {

      name: 'TechnicalEntityCreate',
      setup(){ 

         const route = useRoute()
         const router = useRouter()

         const loading = ref(false)
         const loadingAddProduct = ref(false)
         const form = ref(structuredClone(invoice.formCreate))
         
         const dialogCalendar = ref({
            show: false,
            title: 'Seguimiento del Presupuesto',
            btn1: 'Cancelar',
            btn2: 'Crear',
            date: new Date()
         })

         const dialogActionsShow = ref(false)
         const searchCompnay = ref('')
         const searchProduct = ref('')
         const company = ref({})

         // Se importan los datos customer de la api o del storage
         const customerLead = cacheStore.getCacheData('customers:lead', () => serviceCustomers.getCustomers({type: 'lead'}), [])
         const customerSage = cacheStore.getCacheData('customers:sage', () => serviceCustomers.getCustomers({type: 'sage'}), [])
         
         // Se importan los datos de los productos de la api o del storage
         const products = cacheStore.getCacheData('products', () => {
            return serviceStock.getAll().then( res => res.filter( (item) => productsEnables.find( (item2) => item.code.trim().includes(item2) )))
         }, [])

         const productSelected = ref({});
         const productsInvoice = ref([]);
         const invoiceCreated = ref({});

         // Insertar Datos automaticos al form
         form.value.code.value = new Date().getTime()
         form.value.date_start.value = dayjs().format('YYYY-MM-DD HH:mm')
         form.value.date_end.value = dayjs().add(15, 'day').format('YYYY-MM-DD HH:mm')

         // Detectar cuando se modifican el iva general y el descuento
         watch(() => form.value.iva.value, () => updateCalc() )
         watch(() => form.value.discount.value, () => updateCalc() )

         watch([customerLead, customerSage], () => {

            // Bucar Lead y seleccionarlo
            const profileData = [...customerLead.value, ...customerSage.value].find( ({id}) => id == route.params.entityId )
            if(profileData){

               // Seleccionar Empresa
               searchCompnay.value = profileData.name,
               companySelected(profileData)

               // Seleccionar el primer contacto que no sea company
               // form.value.contact_id.value = profileData.contacts?.[0] ? profileData.contacts[0].id : null

            }
            
         })

         onMounted( async () => {

            loading.value = true;
            setTimeout(() =>  loading.value = false, 1000)

         })

         // Calculo de total
         const calculateUpdateCalc = (item) => {
            let { price, units, discount } = item
            price = parseFloat(price)
            units = parseFloat(units)
            discount = parseFloat(discount)
            const total = (price * units) - (price * units * discount / 100) 
            return total.toFixed(2)
         }

         // Recorre todos los productos y calcula el subtotal
         const calculateSubtotal = (products) => {
            const calc = products.reduce( (acc, item) => {
               return acc + parseFloat(item.total)
            }, 0)
            return parseFloat(calc.toFixed(2))
         }

         // Recorre todos los productos y calcula el iva
         const calculateIva = (products, iva) => {
            const calc = products.reduce( (acc, item) => {
               return acc + parseFloat(item.total) * parseFloat(iva) / 100
            }, 0)
            return parseFloat(calc.toFixed(2))
         }

         // Calcular el subtotal y el iva
         const calculateTotal = (calc_subtotal, calc_iva, discount) => {
            const calc = parseFloat(calc_subtotal) + parseFloat(calc_iva)
            const calcDiscount = calc - (calc * parseFloat(discount) / 100)
            return parseFloat(calcDiscount.toFixed(2))
         }

         const updateCalc = (item) => {

            if(item) item.total = calculateUpdateCalc(item)
            
            form.value.calc_subtotal.value = calculateSubtotal(productsInvoice.value)

            form.value.calc_iva.value = calculateIva(
               productsInvoice.value,
               form.value.iva.value
            )

            form.value.calc_total.value = calculateTotal(
               form.value.calc_subtotal.value,
               form.value.calc_iva.value,
               form.value.discount.value
            )

         }

         const companySelected = (item) => {

            const contact = item.contacts.find( (contact) => contact.id == form.value.contact_id.value )

            form.value.contact_id.value = contact ? contact.id : null

            form.value.contact_id.options = item.contacts.map( ({id, name}) => {
               return { key: id, label: name }
            })

            form.value.company_search.value = item.name
     
            company.value = item
            
         }

         const eventAddProduct = async () => {

            loadingAddProduct.value = true

            // Comprobar si "productSelected.value" esta vacio
            if(!productSelected.value.id){
               return
            }

            // Comprobar si el producto ya esta en la lista
            const index = productsInvoice.value.findIndex( (elm) => elm.id == productSelected.value.id )

            // Si no esta, se añade
            if(index == -1){

               const customerProduct = await serviceCustomers.getCustomerProduct({
                  customer_id: company.value.id,
                  product_id: productSelected.value.id
               })

               if(customerProduct.active){

                  productSelected.value.units = 1
                  productSelected.value.discount = customerProduct.discount
                  productSelected.value.price = customerProduct.price
                  productsInvoice.value.push(productSelected.value)
                  updateCalc(productSelected.value)
                  
               }else{

                  ElNotification({
                     title: 'Producto no disponible',
                     message: 'El producto no esta disponible para este cliente',
                     type: 'warning',
                  })

               }

            }
 
            searchProduct.value = ''

            loadingAddProduct.value = false

         }

         const eventAddProductLine = () => {

            // Crate new product empty
            const product = {
               id: new Date().getTime(),
               code: '',
               value: '',
               price: 0,
               units: 0,
               discount: 0,
               total: 0,
            }

            productsInvoice.value.push(product)
           
         }

         const productsInvoiceRm = (item) => {
            const index = productsInvoice.value.findIndex( (elm) => elm.id == item.id )
            productsInvoice.value.splice(index, 1)
            updateCalc()
         }

         const createInvoice = async (e) => {

            loading.value = true;

            const struct = {
               "customer_id": company.value.id,
               "user_id": dataServer.auth.id,
               "contact_id": form.value.contact_id.value,
               "state": "on_hold",
               "payment": form.value.payment_method.value,
               "iva": form.value.iva.value,
               "discount": form.value.discount.value,
               "subtotal": form.value.calc_subtotal.value,
               "total": form.value.calc_total.value,
               "product_id": productsInvoice.value.map( (item) => item.id ),
               "product_price": productsInvoice.value.map( (item) => item.price ),    
               "product_quantity": productsInvoice.value.map( (item) => item.units ),
               "product_discount":  productsInvoice.value.map( (item) => item.discount ),
               "code": form.value.code.value,
               "observations": form.value.observations.value,
               "finished_at": dayjs(form.value.date_end.value).format('YYYY-MM-DD'),
            }

            invoiceCreated.value = await serviceInvoice.postInvoice(struct).then( ({data}) => data)

            if(invoiceCreated.value.id){
               
               const structTask = {
                  "user_id": dataServer.auth.id,
                  "from_user_id": dataServer.auth.id, 
                  "customer_id": company.value.id,
                  "contact_id": form.value.contact_id.value,
                  "from_contact_id": form.value.contact_id.value,
                  "channel": "email",
                  "objetive": "Presupuesto creado",
                  "state": "closed",
                  "description": "Presupuesto creado",
                  "relation": {"table": "invoice", "id": invoiceCreated.value.id}, 
                  "finished_at": dayjs().format('YYYY-MM-DD'),
               }

               await serviceTracing.postTask(structTask)

               dialogCalendar.value.show = true;

            }

            loading.value = false;

         }

         const eventDialogCalendar = async () => {

            dialogCalendar.value.show = false

            const dateFormat = dayjs(dialogCalendar.value.date).format('YYYY-MM-DD HH:mm:ss')

            const structTask = {
               "user_id": dataServer.auth.id,
               "from_user_id": dataServer.auth.id, 
               "customer_id": company.value.id,
               "contact_id": form.value.contact_id.value,
               "from_contact_id": form.value.contact_id.value,
               "channel": "email",
               "objetive": "Seguimiento de Presupuesto",
               "state": "open",
               "description": "Seguimiento de Presupuesto",
               "relation": {"table": "invoice", "id": invoiceCreated.value.id}, 
               "finished_at": dateFormat,

            }

            await serviceTracing.postTask(structTask)

            dialogActionsShow.value = true;

         }

         const eventDialogCalendarCancel = () => {

            dialogCalendar.value.show = false
            dialogActionsShow.value = true;

         }

         const eventDialogActionsInvoiceEmail = async () => {

            // const sendEmail = await serviceTracing.sendEmail({id: invoiceCreated.value.id})

            // if(sendEmail.success){

            //    const structTask = {
            //       "technical_id": dataServer.auth.id,
            //       "from_user_id": dataServer.auth.id,
            //       "lead_id": company.value.id,
            //       "contact_id": form.value.contact_id.value,
            //       "from_contact_id": form.value.contact_id.value,
            //       "channel": "email",
            //       "objetive": "Presupuesto Enviado",
            //       "state": "closed",
            //       "description": "Presupuesto Enviado",
            //       "finished_at": dayjs().format('YYYY-MM-DD'),
            //       "relation": {"table": "invoice", "id": invoiceCreated.value.id},  
            //    }
   
            //    await serviceTracing.postTask(structTask)

            // }
            
            // dialogActionsShow.value = false;

         }

         const eventDialogActionsCancel = () => {

            dialogActionsShow.value = false;

         }

         const submitForm = (item) => {

            if(item.key == 'products_search_add'){
               return eventAddProduct()
            }
            
            if(item.key == 'create_invoice'){
               return createInvoice()
            }

         }

         return {
            Calendar,
            company,

            form,

            customerLead, customerSage,

            // Refs
            searchCompnay, searchProduct,
            products,
            productsInvoice, loading, loadingAddProduct,
            
            // Var
            tableInvoiceProducts: invoice.tableInvoiceProducts,

            productSelected,

            // Methods
            createInvoice, companySelected, 
            productsInvoiceRm, 
            eventAddProduct, eventAddProductLine,

            dialogCalendar, eventDialogCalendar,
            dialogActionsShow, eventDialogActionsInvoiceEmail, eventDialogActionsCancel,
            eventDialogCalendarCancel,

            submitForm,

            invoiceCreated,

            updateCalc,

            Plus         


         }

      }

   }

</script>

<style lang="scss">

   .calc_total, .calc_iva, .calc_subtotal{

      .el-input__inner{
         color: #2196f3 !important;
         font-weight: 600;
         text-align: end;
      }

   }

</style>

<style lang="scss" scoped>

   .technical-profile-create{
      
      .box-content{
         padding: 20px;
      }

   }

   .text-limit{
      max-width: 200px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
   }

   .dialogactions{
      padding: 20px;
      display: grid;
      justify-content: center;
      gap: 20px;
      border: solid 1px #00000012;

      .btn-link button {
         width: 100%;
      }

   }

   .input-number-max-width{
      width: 100px;
   }

   .text-max-width{
      max-width: 200px;
      text-overflow: ellipsis;
      overflow: hidden;
      white-space: nowrap;
   }

   .form-entities{
      display: flex;
      flex-wrap: wrap;
      gap: 0 20px;

      .el-select{
         width: 100%;
      }

      .el-checkbox.is-bordered{
         width: 100%;
         padding: 12px !important;
      }

      .line{
         height: 1px;
         background: #efefef;
         width: 100%;
         margin: 20px 0 5px 0;
      }
      
      .line-hard{
         width: 100%;
         display: block;
         border-bottom: solid 1px #cc181f;
         margin: 20px 0;
      }

      .title{
         width: 100%;
         display: block;
         font-size: 18px;
         font-weight: 500;
         border-bottom: solid 1px #cc181f;
         color: #cc181f;
         padding: 20px 0 10px 0;
         margin-bottom: 10px;
      }

   }

   .invoice-add{
      margin-top: 20px;
      display: flex;
      justify-content: flex-end;
   }

   .products{

      .product{
         display: grid;
         grid-template-columns: auto 1fr auto auto auto auto auto auto;
      }

   }

   .btn-remove{
      background: #f9f9f9;
      height: 30px;
      width: 30px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      cursor: pointer;

      i{
         padding-top: 2px;
      }

      &:hover{
         background: #cc181f;
         color: #fff;
      }

   }

</style>






