<template>

   <div class="layout-profesional profesional-create-order">

      <div v-if="dataServer.auth.type == 'Standard'" class="layout-profesional-content" :class="{blur: filesFtp.loading}"  v-loading="filesFtp.loading">

         <div class="files-ftp">
            <div class="layout-profesional-title">{{filesFtpCheck.message}}</div>

            <div class="files-ftp-radio">
               <el-radio v-for="(file, index) in filesFtp.files" @change="changeSelectFile(file)"
                  :key="index" v-model="filesFtp.checked" :label="index" border size="medium">
                     Proceso {{file.numeration}} - {{file.model}}
                  </el-radio>
            </div>

         </div>

      </div>

      <div class="layout-profesional-content" v-if="vehiclesForm.show || dataServer.auth.type == 'Open2'">

         <div class="tabs-type-vehiculo">

            <div class="tabs-type-vehiculo-title">Selecciona Tipo vehículo</div>

            <listapp-form v-model="vehiclesForm.items"></listapp-form>

         </div>

      </div>

      <div class="layout-profesional-content" v-if="yearsForm.show">

         <div class="order-create-year">
            <div>Introducir el año de primera matriculación del vehículo que figura en ficha técnica del mismo</div>
            <el-select v-model="vehicle.data.year" placeholder="Selecciona Año" @change="calcPricesTypeArchive(vehicle.data)">
               <el-option v-for="item in yearsForm.items" :key="item" :label="item" :value="item"></el-option>
            </el-select>
         </div>

      </div>

      <div class="layout-profesional-content" v-if="dataServer.auth.type == 'Open2'">

         <div class="layout-profesional-title">Sube el archivo FPF</div>

         <div class="file-upload">
            <input type="file" @change="fileSelectedFPF" class="custom-file-input">
         </div>

      </div>
      
      <div class="layout-profesional-content">

         <div class="order-create-info">

            <div class="order-create-info-item" v-for="(value, key) in vehicle.items" :key="key">
               <div class="order-create-info-title">{{value.label}}</div>
               <div class="order-create-info-value">
                  <template v-if="vehicle.data[value.key]">{{vehicle.data[value.key]}}</template>
                  <template v-if="!vehicle.data[value.key]">-</template>
               </div>
            </div>

         </div>

      </div>

      <div class="layout-profesional-content">

         <div class="order-create-checks-group" v-for="(_, keyBlock, i) in checks" :key="keyBlock">

            <div class="layout-profesional-title">
               {{checks[keyBlock].label}}
            </div>

            <div class="order-create-checks-group-items grid-3">
               <template v-for="(_, keyItems) in checks[keyBlock].items" :key="keyItems">
                  
                  <div class="order-create-checks-group-item" v-if="keyBlock == 'TYPE_ARCHIVE'">
                     <el-checkbox
                        border
                        v-model="checks[keyBlock].items[keyItems].checked" 
                        :disabled="checks[keyBlock].items[keyItems].disabled" 
                        @change="changeTypeArchive(keyItems)"
                     >
                        {{checks[keyBlock].items[keyItems].label}} - {{checks[keyBlock].items[keyItems].price}} creditos
                        <el-tooltip class="item" effect="dark" :content="checks[keyBlock].items[keyItems].info" placement="top-start">
                           <el-icon><info-filled /></el-icon>
                        </el-tooltip>
                     </el-checkbox>
                  </div>

                  <div class="order-create-checks-group-item" v-if="keyBlock == 'OPTIONS'">
                     <el-checkbox
                        v-model="checks[keyBlock].items[keyItems].checked" 
                        :disabled="checks[keyBlock].items[keyItems].disabled" 
                        @change="changeOptions"
                        border 
                     >
                        {{checks[keyBlock].items[keyItems].label}} <template v-if="!vehicleIsEuro6AndTypeTruck">{{checks[keyBlock].items[keyItems].price}} creditos</template>
                        <el-tooltip class="item" effect="dark" :content="checks[keyBlock].items[keyItems].info" placement="top-start">
                           <el-icon><info-filled /></el-icon>
                        </el-tooltip>
                     </el-checkbox>
                  </div>
                 
               </template>

            </div>

            <el-divider v-if="i < Object.keys(checks).length -1" ></el-divider>

         </div>

      </div>

      <div class="layout-profesional-content black">
         <div class="credits-items">

            <template v-if="vehicleIsEuro6AndTypeTruck">

               <div class="credits-items-euro6">Se aplica un precio fijo al ser EURO6</div>

            </template>
            <template v-else>

               <div class="credits-item" v-for="(item, index) in calculateDiscounts" :key="index">
                 <div class="columnas-2">
                  <div class="credits-item-title">{{item.key.replace(new RegExp('_', 'g'), ' ')}}</div>
                  <div class="credits-item-discount">{{item.discount || item.price || 0}} Creditos</div>
                  </div>
                  <div class="columnas-1">
                  <div class="credits-item-discountPercent" v-if="item.discountPercent">
                     <span>{{item.discountPercent}}% Descuento</span>
                  </div>
                  </div>
               </div>

            </template>


         </div>
         <div class="credits-info">Total de créditos consumidos: <b>{{calculateCostOfCredits}}</b></div>
         <div class="credits-info">Créditos disponibles: <b>{{dataServer.auth.credits}}</b></div>
      </div>

      <div class="layout-profesional-content">

         <div class="additional-note">
            <div class="additional-note-title">{{aditionalNoteCheck.title}}</div>
            <el-input class="additional-note-textarea" v-model="additionalNote" type="textarea"></el-input>
         </div>

      </div>

      <div class="layout-profesional-content">

         <div class="buttons">

            <div class="btn-send" @click="clickProcessOrder" v-loading="processOrderLoading">SIGUIENTE</div>

         </div>

      </div>

   </div>

</template>

<script>

   import { ElNotification } from 'element-plus'
   import axios from 'axios'

   import * as api from "../../services/api";
   import * as apiExternal from "../../services/apiExternal";
   import * as utils from '../../helpers/utils';

   export default({

      data() {
         
         return {

            // Usuario
            dataServer: dataServer,
            creditos: 0,
 
            // Archivos FPF si es Open2
            fileExtensionFPF: null,
            fileNameFPF: null,
            fileDataFPF: null,

            // Archivos Shadow
            filesFtp: { 
               loading: true,
               checked: null,
               files: null,
            },

            yearsForm: {
               show: false,
               items: [
                  1995, 1996, 1997, 1998, 1999, 2000, 2001, 2002, 2003, 2004, 2005, 2006, 
                  2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 
                  2019, 2020, 2021, 2022, 2023, 2024
               ],
            },

            vehiclesForm: {
               show: false,
               items: {
                  veh_type: null,
                  manufacture: null,
                  model: null,
                  type: null,
               }
            },
            
            // Datos de Vehiculo
            vehicle: {
               data: {},
               items:[
                  {label: 'Marca', key: 'manufacture'},
                  {label: 'Modelo', key: 'model'},
                  {label: 'Year', key: 'year'},
                  {label: 'Kw', key: 'kw'},
                  {label: 'Combustible', key: 'fuel'},
               ]
            },

            // Listsa de opciones
            checks: {
               'TYPE_ARCHIVE': {
                  label: 'Tipo de Archivos',
                  items: {
                     'ECOLINE': {label: 'ECOLINE', 'checked': false, 'price': 0, disabled: false, 'info': 'Reprogramación-Optimización electrónica enfocada a Reducir el consumo de combustible. Perfil de conducción eficiente en trayectos de media y larga distancia.'},
                     'RACE': {label: 'RACE', 'checked': false, 'price': 0, disabled: false, 'info': 'Reprogramación-Optimización electrónica enfocada a Reducir el consumo de combustible. Perfil de conducción eficiente en trayectos de media y larga distancia.'},
                     // 'ORIGINAL': {label: 'Original', 'checked': false, 'price': 0, disabled: false},
                     'CLONATION': {label: 'CLONATION', 'checked': false, 'price': 0, disabled: false, 'info': 'Solicítanos la posibilidad de clonar tu centralita solo para casos de lecturas con sistema New Trasdata (BDM-JTAG-EGPT…). Ámbito de reparación de Ecus.'},
                     'RESTORE_ORIGINAL_SETTINGS': {label: 'RESTORE_ORIGINAL_SETTINGS', 'checked': false, 'price': 0, disabled: false, 'info': 'Restaurar la configuración original'},
                     'HOT_START': {label: 'HOT_START', 'checked': false, 'price': 0, disabled: false, 'info': 'Solución al problema de arranque en caliente'},
                  }
               },
               'OPTIONS': {
                  label: 'Opciones para diagnosis/circuito',
                  items: {
                     // OPTIONS
                     'ADBLUE_OFF': {label: 'ADBLUE_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de Adblue por fallos'},
                     'AIRPUMP_OFF': {label: 'AIRPUMP_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de la bomba de aire secundario'},
                     'CAT_OFF': {label: 'CAT_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de la segunda lambda por supresor catalizador o fallos'},
                     'COLD_START_OFF': {label: 'COLD_START_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactiva la estrategia para el arranque en frío'},
                     'DPF_OFF': {label: 'DPF_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión del FAP / DPF por fallos'},
                     'DTC_OFF': {label: 'DTC_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'desactivación de DTC fallo Ecu interno	'},
                     'DTC_P0601': {label: 'DTC_P0601', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación de DTC P0601'},
                     'DTC_P0605': {label: 'DTC_P0605', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación de DTC P0605'},
                     'DTC_P061B': {label: 'DTC_P061B', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación de DTC P0601B'},
                     'DTC_P0638': {label: 'DTC_P0638', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación de DTC P0638'},
                     'DTC_P2085': {label: 'DTC_P2085', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación de DTC P2085'},
                     'EGR_OFF': {label: 'EGR_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de la EGR por fallos'},
                     'GPFOPF_OFF': {label: 'GPFOPF_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión del GPF por fallos'},
                     'HARD_CUT': {label: 'HARD_CUT', 'checked': false, 'price': 0, disabled: false, 'info': 'Activación del corte de RPM'},
                     // 'HOT_START': {label: 'HOT_START', 'checked': false, 'price': 0, disabled: false, 'info': 'Solución al problema de arranque en caliente'},
                     'LAUNCH_ON': {label: 'LAUNCH_ON', 'checked': false, 'price': 0, disabled: false, 'info': 'Activación del launch control'},
                     'NOX_OFF': {label: 'NOX_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión del sensor NOX por fallos'},
                     'POP&BANG': {label: 'POP&BANG', 'checked': false, 'price': 0, disabled: false, 'info': 'Aplicación de petardeos en la fases de deceleración'},
                     'POP&BANG_S/D': {label: 'POP&BANG_S/D', 'checked': false, 'price': 0, disabled: false, 'info': 'Aplicación de petardeos en la fases de deceleración en modo Sport/Dynamic	'},
                     'S&S_OFF': {label: 'S&S_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de Start&Stop'},
                     'SET_SD': {label: 'SET_SD', 'checked': false, 'price': 0, disabled: false, 'info': 'Ajuste de prestaciones en Sport Display'},
                     'SWIRL_OFF': {label: 'SWIRL_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de las trampillas del colector admisión por fallos'},
                     'TVA_OFF': {label: 'TVA_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de la mariposa de admisión'},
                     'WG_RATTLE_FIX': {label: 'WG_RATTLE_FIX', 'checked': false, 'price': 0, disabled: false, 'info': 'Solución a la vibración de la wastegate'},
                     // PATCH
                     'ABS_OFF': {label: 'ABS_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Gestión de la señal del sensor ABS '},
                     'CAV': {label: 'CAV', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactiva la señal de paro por el caballete'},
                     'CL_OFF': {label: 'CL_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación del control del Lambda'},
                     'COLD_START': {label: 'COLD_START', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactiva la función de arranque en frío'},
                     'DECEL_FCUT_OFF': {label: 'DECEL_FCUT_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'En fase de deceleración se corta la inyección de combustible'},
                     'EGR0': {label: 'EGR0', 'checked': false, 'price': 0, disabled: false, 'info': 'Cierre de la válvula EGR por gestión del componente - implica que el actuador trabaje correctamente'},
                     'EVAP_OFF': {label: 'EVAP_OFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactiva el funcionamiento de la válvula de purga canister'},
                     'SOFF': {label: 'SOFF', 'checked': false, 'price': 0, disabled: false, 'info': 'Desactivación limitación de velocidad máxima'},
                  }
               },

         

            },

            // Campos extra
            additionalNote: '',

            calculateDiscounts: [],

            processOrderLoading: false,

         }
         
      },

      async mounted() {

         // Cargar archivos shadow del ftp
         this.filesFtp.loading = true;
         this.filesFtp.files = (await api.getProfessionalFiles({id: this.dataServer.auth.id})).data;
         this.filesFtp.loading = false;

         // Check files object not empty ?
         this.filesFtp.checked = Object.keys(this.filesFtp.files).length > 0 ? Object.keys(this.filesFtp.files)[0] : null;
   

      },

      watch: {

         // Se lanza cuando seleccionas un tipo de vehiculo en el formulario applist
         'vehiclesForm.items.type': async function(value) {

            // Si el cambio es a null no se llama a la api
            if(!value) return;

            // Llama a la API para obtener los datos del vehiculo
            this.vehicle.data = await apiExternal.getVehiclesData({
               'manufacture': this.vehiclesForm.items.manufacture,
               'model': this.vehiclesForm.items.model,
               'type': this.vehiclesForm.items.type,
            })

            // Si el vehiculo no tiene año se muestra el formulario de selección.
            this.checkIfYearFrom()

         },

         // Se lanza cuando ya tenemos la información del vehículo obtenido de la API general
         'vehicle.data': function(value) {

            // Modifica el estado de los checks de OPTIONS segun el tipo de vehiculo
            this.optionsModifySelection(value)

            this.calcPricesTypeArchive(value)

         },


      },

      computed: {
         
         // Se comprueba si hay archivos shadow en el ftp
         filesFtpCheck(){

            return {
               message: 
                  !this.filesFtp.files || this.filesFtp.files.length <= 0 ? 
                     'No tienes procesos pendientes' :
                     'Procesos pendientes',
            }

         },

         // Comprueba si hay opciones habilitadas para el tipo de vehículo
         aditionalNoteCheck() {
            
            let flag = true;

            for(let key in this.checks['OPTIONS'].items) {
               if(!this.checks['OPTIONS'].items[key].disabled) {
                  flag = false
                  break;
               }
            }

            return {
               title: flag ? 'No hay opciones habilitadas para este tipo de vehículo' : 'NOTAS ADICIONALES',
            }

         },

         // Calcula el coste de creditos segun las type_archive y las opciones seleccionadas
         calculateCostOfCredits(){
            
            const sum = this.calculateDiscounts.reduce( (acc, {type, price, discount}) => {

               if(this.vehicleIsEuro6AndTypeTruck && type == 'OPTIONS'){
                  acc += 0;
               }else if(this.vehicleIsEuro6AndTypeTruck && type == 'TYPE_ARCHIVE'){
                  acc += price;
               }else{
                  acc += discount || price;
               }

               return acc

            }, 0)


            if(this.vehicleIsEuro6AndTypeTruck) sum + 2000;

            return sum;
            
         },

         // Se comprueba si el vechiulo es euro 6 y es un tipo de vehiculo de carga
         vehicleIsEuro6AndTypeTruck(){

            if(!this.vehicle.data || Object.keys(this.vehicle.data).length === 0) return 0;

            if(
               this.vehicle.data.normative.indexOf('EURO6') != -1 &&
               ['TRUCK', 'TRACTOR', 'MARINE'].indexOf(this.vehicle.data.veh_type) != -1
            ) {
               return true
            }else{
               return false
            }
            
         }

      },
   
      methods: {

         /*******************************************************************************************/
         /*  EVENTOS
         /*******************************************************************************************/

         // Evento de seleccion de archivo shadow
         async changeSelectFile(file){

            // Se resetean estados
            this.typeArchiveToUnchek();
            this.optionsToUnchek();
            this.vehiclesFormToUnchek();

            // Llama a la API para obtener los datos del vehiculo
            this.vehicle.data = await apiExternal.getVehiclesData({
               'manufacture': file.manufacturer,
               'model': file.model,
               'type': file.type,
            })

            // En caso de no tener datos del vehiculo, se muestra el formulario
            this.checkIfVehicleFrom()

            // Si el vehiculo no tiene año se muestra el formulario de selección.
            this.checkIfYearFrom()

         },

         // Evento de selección de TYPE ARCHIVE
         changeTypeArchive(key){

            // Se desmanufacturen todas las opciones al cambiar de type_archive
            this.optionsToUnchek();

            // Modifica el estado de los checks de OPTIONS segun el tipo de vehiculo
            this.optionsModifySelection(key);

            // Convierte a varios selectores de TYPE_ARCHIVE en radio buttons
            this.radioButtonTypeArchive(key)

            // Si se selecciona en archive algunas de las siguientes opciones, se desactivan todas las options
            this.disabledAllOptionsForTypeArchive(key)

            // Devuelve los elementos seleccionados que aplican para el descuento
            const checksForDiscount = this.getTypeArchiveAndOptionsCheckedForDiscount()

            // Devuelve los descuentos calculados de la seleccion de checks
            this.calculateDiscounts = this.getCalculateDiscounts(checksForDiscount)

            // Invertir array
            this.calculateDiscounts.reverse()

         },

         // Evento de selección de OPTIONS
         changeOptions(){
            
            // Devuelve los elementos seleccionados que aplican para el descuento
            const checksForDiscount = this.getTypeArchiveAndOptionsCheckedForDiscount()

            // Devuelve los descuentos calculados de la seleccion de checks
            this.calculateDiscounts = this.getCalculateDiscounts(checksForDiscount)

            // Invertir array
            this.calculateDiscounts.reverse()

         },

         // Evento de selección de archivo FPF para open2
         fileSelectedFPF(event){

            if(!event.target.files[0]) return;
     
            this.fileDataFPF = event.target.files[0];
            this.fileNameFPF = event.target.files[0].name;
            this.fileExtensionFPF = this.fileNameFPF.split('.').pop();

            if(this.fileExtensionFPF != 'FPF') {
               event.target.value = '';
               // return utils.notificationUser({
               //    success: false,
               //    message: 'Solo se permite archivos con extensión .FPF',
               // });
            }

         },

         async clickProcessOrder(){

            this.processOrderLoading = true;

            // Comprobar si el usuario tiene los creditos suficientes
            if(this.calculateCostOfCredits > this.dataServer.auth.credits) {

               // return utils.notificationUser({
               //    success: false,
               //    message: 'No tienes suficientes creditos.',
               // });

            }

            // Se optionen todas las keys de los checks seleccionados
            const typeArchiveAndOptionsList = []

            for(let option in this.checks['TYPE_ARCHIVE'].items){
               if(this.checks['TYPE_ARCHIVE'].items[option].checked) typeArchiveAndOptionsList.push(option)
            }

           for(let option in this.checks['OPTIONS'].items){
               if(this.checks['OPTIONS'].items[option].checked) typeArchiveAndOptionsList.push(option)
            }
            
            const formData = {
               credits: this.calculateCostOfCredits * -1,
               type: this.vehicle.data.type,
               manufacture: this.vehicle.data.manufacture,
               emission: this.vehicle.data.normative,
               model: this.vehicle.data.model,
               veh_type: this.vehicle.data.veh_type,
               year: this.vehicle.data.year,
               fuel: this.vehicle.data.fuel,
               kw: this.vehicle.data.kw ? parseFloat(this.vehicle.data.kw.replace(',', '.'), 2) : null,
               notes: this.additionalNote,
               options: typeArchiveAndOptionsList.join(','),
               professional_file: this.fileNameFPF,
               technical_file: null,
               shw_file: this.filesFtp.checked,
               professional_id: this.dataServer.auth.id,
               status: 'Completed',
               payment: 'order',
            };

            // Comprobar si las keys de formData estan vacias
            const check = [
               'credits', 'type', 'manufacture', 'emission', 
               'model', 'veh_type', 'year', 'fuel', 'kw', 'professional_id'
            ].every(key => formData[key])

            if(!check) {

               this.processOrderLoading = false;

               // return utils.notificationUser({
               //    success: false,
               //    message: 'Te faltan datos por rellenar',
               // });

            }

            // Si es Open2 hacemos un upload del archivo FPF
            if(dataServer.auth.type.indexOf('Open2') != -1) {

               if(!this.fileDataFPF){
                  // return utils.notificationUser({
                  //    success: false,
                  //    message: 'Tienes que seleccionar un archivo FPF',
                  // });
               }
             
               const data = new FormData();
               data.append('professional_id', this.dataServer.auth.id);
               data.append('file_name', this.fileNameFPF);
               data.append('file_data', this.fileDataFPF);
         
               const url = dataServer.pathDim + '/api/v1/post-order-file-upload'

               axios({
                  method: 'post',
                  url: url,
                  data: data,
                  headers: {'Content-Type': 'multipart/form-data' }
               })
               // .then(({data}) => utils.notificationUser(data))

            }

            // Crear Orden
            api.postOrder(formData)
               // .then(utils.notificationUser)
               .then(() => this.processOrderLoading = false)

         },

         /*******************************************************************************************/
         /*  FUNCIONES
         /*******************************************************************************************/

         // Devuelve los elementos seleccionados que aplican para el descuento
         getTypeArchiveAndOptionsCheckedForDiscount(){

            // ECOLINE | RACE | HOT_START cuentan para sumar para aplicar 
            // diferentes descuentos 20, 40, 50% pero solo HOT_START puede ser descontada

            let checkedsIsTrue = []

            // Get checked Archive 
            for(let option in this.checks['TYPE_ARCHIVE'].items){
               if(this.checks['TYPE_ARCHIVE'].items[option].checked){
                  const order = ['ECOLINE', 'RACE'].indexOf(option) != -1 ? 1 : 0
                  checkedsIsTrue.push({
                     key: option, price: this.checks['TYPE_ARCHIVE'].items[option].price, order, type: 'TYPE_ARCHIVE'
                  })
               }
            }

            // Get checked Options
            for(let option in this.checks['OPTIONS'].items){
               if(this.checks['OPTIONS'].items[option].checked){
                  checkedsIsTrue.push({
                     key: option, price: this.checks['OPTIONS'].items[option].price, order: 0, type: 'OPTIONS'
                  })
               }
            }

            return checkedsIsTrue

         },

         // Devuelve los descuentos calculados de la seleccion de checks
         getCalculateDiscounts(checksForDiscount){

            // Order by price asc
            const moreCheap = checksForDiscount.sort((a,b) => a.order - b.order || a.price - b.price)
        
            if(checksForDiscount.length == 2){

               // Apply 20% discount to the cheapest
               moreCheap[0].discount = moreCheap[0].price * 0.8
               moreCheap[0].discountPercent = 20

            }else if(checksForDiscount.length == 3){

               // Apply 40% discount to the cheapest
               moreCheap[0].discount = moreCheap[0].price * 0.6
               moreCheap[0].discountPercent = 40

               moreCheap[1].discount = moreCheap[1].price * 0.6
               moreCheap[1].discountPercent = 40

            }else if(checksForDiscount.length >= 4){

               // Apply a 50% discount to all through a map less than the most expensive
               moreCheap.slice(0, -1).map((_, index) => {
                  moreCheap[index].discount = moreCheap[index].price * 0.5
                  moreCheap[index].discountPercent = 50
               })
            
            }

            return moreCheap;

         },


         // Modifica el estado de los checks de OPTIONS segun el tipo de vehiculo
         optionsModifySelection(){

            // Se obtienen tanto options como patch
            const optionsMap = this.vehicle.data.option ? this.vehicle.data.option.split('/').map( i => i.trim() ) : []
            const patchMap = this.vehicle.data.patch ? this.vehicle.data.patch.split('/').map( i => i.trim() ) : []

            for(let option in this.checks['OPTIONS'].items){

               this.checks['OPTIONS'].items[option].disabled = false

               if(![...optionsMap, ...patchMap].includes(option)) this.checks['OPTIONS'].items[option].disabled = true

            }

         },

         // Definición de creditos segun vehiculo
         calcPricesTypeArchive({veh_type}){

            if(!this.vehicle.data || Object.keys(this.vehicle.data).length === 0) return

            if(veh_type == 'CAR' || veh_type == 'LCV' || veh_type == 'BIKE'){
               // OPTIONS
               this.checks.OPTIONS.items.ADBLUE_OFF.price = 200
               this.checks.OPTIONS.items.AIRPUMP_OFF.price = 150
               this.checks.OPTIONS.items.CAT_OFF.price = 150
               this.checks.OPTIONS.items.COLD_START_OFF.price = 150
               this.checks.OPTIONS.items.DPF_OFF.price = 200
               this.checks.OPTIONS.items.DTC_OFF.price = 150
               this.checks.OPTIONS.items.DTC_P0601.price = 150
               this.checks.OPTIONS.items.DTC_P0605.price = 150
               this.checks.OPTIONS.items.DTC_P061B.price = 150
               this.checks.OPTIONS.items.DTC_P0638.price = 150
               this.checks.OPTIONS.items.DTC_P2085.price = 150
               this.checks.OPTIONS.items.EGR_OFF.price = 100
               this.checks.OPTIONS.items.GPFOPF_OFF.price = 200
               this.checks.OPTIONS.items.HARD_CUT.price = 200
               // this.checks.OPTIONS.items.HOT_START.price = 100
               this.checks.OPTIONS.items.LAUNCH_ON.price = 200
               this.checks.OPTIONS.items.NOX_OFF.price = 150
               this.checks.OPTIONS.items['POP&BANG'].price = 200
               this.checks.OPTIONS.items['POP&BANG_S/D'].price = 200
               this.checks.OPTIONS.items['S&S_OFF'].price = 150
               this.checks.OPTIONS.items.SET_SD.price = 150
               this.checks.OPTIONS.items.SWIRL_OFF.price = 150
               this.checks.OPTIONS.items.TVA_OFF.price = 150
               this.checks.OPTIONS.items.WG_RATTLE_FIX.price = 150
               // PATCH
               this.checks.OPTIONS.items.ABS_OFF.price = 150
               this.checks.OPTIONS.items.CAV.price = 150
               this.checks.OPTIONS.items.CL_OFF.price = 150
               this.checks.OPTIONS.items.COLD_START.price = 150
               this.checks.OPTIONS.items.DECEL_FCUT_OFF.price = 150
               this.checks.OPTIONS.items.EGR0.price = 100
               this.checks.OPTIONS.items.EVAP_OFF.price = 150
               this.checks.OPTIONS.items.SOFF.price = 150

               // TYPE_ARCHIVE
               this.checks.TYPE_ARCHIVE.items.CLONATION.price = 50   
               this.checks.TYPE_ARCHIVE.items.RESTORE_ORIGINAL_SETTINGS.price = 150   
               this.checks.TYPE_ARCHIVE.items.HOT_START.disabled = false 
               this.checks.TYPE_ARCHIVE.items.HOT_START.price = 50  

               const year = parseInt(this.vehicle.data.year)
               const kw = parseInt(this.vehicle.data.kw)
               
               if(this.vehicle.data.fuel.toLowerCase().includes('diesel')){

                  const con1 = kw < 330 && year < 2018 ? true : false
                  const con2 = kw < 220 && year >= 2018 ? true : false

                  const con3 = kw >= 220 && year >= 2018 ? true : false
                  const con4 = kw >= 330 ? true : false

                  if(con1 || con2) {
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 200   
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 200   
                  }else if(con3 || con4) {
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 350   
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 350 
                  }else{
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 0
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 0
                  }

               }else if(this.vehicle.data.fuel.toLowerCase().includes('petrol')){

                  const con1 = kw < 330 && year < 2010 ? true : false
                  const con2 = kw < 183 && year >= 2010 && year <= 2018 ? true : false
                  const con3 = kw < 147 && year >= 2018 ? true : false

                  const con4 = kw > 330 && year < 2010 ? true : false
                  const con5 = kw >= 183 && kw <= 257 && year >= 2010 ? true : false
                  const con6 = kw >= 147 && kw <= 183 && year >= 2018 ? true : false

                  const con7 = kw >= 257 && kw <= 330 && year >= 2010 ? true : false

                  const con8 = kw > 330 && year >= 2010 ? true : false

                  if(con1 || con2 || con3) {
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 200   
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 200   
                  }else if(con4 || con5 || con6) {
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 350   
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 350
                  }else if(con7) {
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 400   
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 400
                  }else if(con8){
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 600   
                  }else{
                     this.checks.TYPE_ARCHIVE.items.RACE.price = 0
                     this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 0
                  }
               
               }

            }

            if(veh_type == 'TRUCK' || veh_type == 'TRACTOR' || veh_type == 'MARINE'){
               // OPTIONS
               this.checks.OPTIONS.items.ADBLUE_OFF.price = 500
               this.checks.OPTIONS.items.DPF_OFF.price = 500
               this.checks.OPTIONS.items.EGR_OFF.price = 300
               // TYPE_ARCHIVE
               this.checks.TYPE_ARCHIVE.items.ECOLINE.price = 500   
               this.checks.TYPE_ARCHIVE.items.RACE.price = 500   
               this.checks.TYPE_ARCHIVE.items.CLONATION.price = 100   
               this.checks.TYPE_ARCHIVE.items.RESTORE_ORIGINAL_SETTINGS.price = 200   
               this.checks.TYPE_ARCHIVE.items.HOT_START.disabled = true 
            }

         },

         // Convierte a varios selectores de TYPE_ARCHIVE en radio buttons
         radioButtonTypeArchive(key){

            // Estos selectores de archive solo pueden estar seleccionado uno a la vez
            const itemsFilter = ['ECOLINE', 'RACE', 'CLONATION']
            if(itemsFilter.indexOf(key) != -1 && this.checks['TYPE_ARCHIVE'].items[key].checked){ 
               
               for(let itemFilterKey of itemsFilter){
                  if(itemFilterKey != key){
                     this.checks['TYPE_ARCHIVE'].items[itemFilterKey].checked = false
                  }else{
                      this.checks['TYPE_ARCHIVE'].items[itemFilterKey].checked = true
                  }
               }

            }
            
         },

         // Si se selecciona en archive algunas de las siguientes opciones, se desactivan todas las options
         disabledAllOptionsForTypeArchive(key){

            const isCheck = this.checks['TYPE_ARCHIVE'].items[key].checked 
            const isContain =  ['CLONATION', 'RESTORE_ORIGINAL_SETTINGS'].indexOf(key) != -1
            
            if(isCheck && isContain){ 
               for(let option in this.checks['OPTIONS'].items){
                  this.checks['OPTIONS'].items[option].disabled = true
               }
            }

         },

         // En caso de no tener datos del vehiculo, se muestra el formulario
         checkIfVehicleFrom(){
            Object.keys(this.vehicle.data).length === 0 ? this.vehiclesForm.show = true : this.vehiclesForm.show = false
         },
            
         // Si el vehiculo no tiene año se muestra el formulario de selección.
         checkIfYearFrom(){
            this.vehicle.data.type && !this.vehicle.data.year ? this.yearsForm.show = true : this.yearsForm.show = false
         },

         // Resetea el formulario de vehiculos
         vehiclesFormToUnchek(){
            this.vehiclesForm.items.veh_type = null
            this.vehiclesForm.items.manufacture = null
            this.vehiclesForm.items.model = null
            this.vehiclesForm.items.type = null
         },

         // Desmanufacture todas los TYPE_ARCHIVE
         typeArchiveToUnchek(){

            for(let key in this.checks['TYPE_ARCHIVE'].items){
               this.checks['TYPE_ARCHIVE'].items[key].checked = false
            }

         },

         // Desmanufacture todas las opciones
         optionsToUnchek(){

            for(let key in this.checks['OPTIONS'].items){
               this.checks['OPTIONS'].items[key].checked = false
            }

         },

      }

   });

</script>


<style lang="scss">

   .tabs-type-vehiculo{

      .tabs-type-vehiculo-title{
         font-size: 20px;
         font-weight: bold;
         margin-bottom: 20px;
         text-transform: uppercase;
      }

   }

   .files-ftp{

      .files-ftp-title{
         font-size: 20px;
         font-weight: bold;
         margin-bottom: 20px;
         text-transform: uppercase;
      }	

   }

   .layout-profesional-content{
      margin: auto;
      max-width: 1000px;
      background: white;
      padding: 50px;
      margin: 20px auto;
      border-radius: 5px;
   }
   .layout-profesional-content.black{
       background: #00000085;
   }

   .order-create-info{
      display: flex;
      justify-content: center;
      align-items: center;

      .order-create-info-item{
         display: flex;
         flex: 1;
         flex-direction: column;
         justify-content: center;
         align-items: center;
         border-right: 1px solid #e0e0e0;

         &:last-child{
            border-right: none;
         }

         .order-create-info-title{
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            text-transform: uppercase;
         }

         .order-create-info-value{
            font-size: 14px;
            text-align: center;
         }
       
      }

   }

   .order-create-year{
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 20px;
      font-size: 18px;
      font-weight: 500;
      color: #f56c6c;
   }

   .credits-info{
      font-size: 20px;
      text-align: center;
      color: white;
      margin-top: 20px;
   }

   .credits-items{
      color: white;
      display: flex;
      flex-direction: column;
      gap: 10px;
      margin: auto;
   }
   
   .credits-items-euro6{
      text-align: center;
      font-size: 20px;
   }

   .credits-item{
      display: grid;
      gap: 0px;
      word-break: break-all;
      text-align: center;
      padding-bottom: 10px;
      padding-top: 10px;
      border-bottom: 1px solid #4c4c4c;
   }

   .credits-item-title {
      justify-self: center;
      text-overflow: ellipsis;
      overflow: hidden;
   }

   .credits-item-discount{
      font-weight: 600;
   }


   .layout-profesional-title{
      font-weight: bold;
      text-transform: uppercase;
      font-size: 25px;
      margin-bottom: 30px;
      border-bottom: 3px solid #ea1820;
   }

   .columnas-2 {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 10px;
      justify-items: center;
   }

   .columnas-1 {
      text-align:center;
   }

   .credits-item-discountPercent span {
      background: #ea1820;
      border-radius: 10px;
      padding: 1px 15px;
   }

   .credits-item-discountPercent {
      padding-top: 10px;
      padding-bottom: 10px;
   }

   .order-create-checks-group-items{
      display: grid;
      grid-template-columns: 1fr 1fr 1fr;
      gap: 10px;
   }
   
   .additional-note-title{
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
      text-transform: uppercase;
   }

   .additional-note-textarea textarea {
      min-height: 200px !important;
   }

   .btn-send {
      background: #409eff;
      padding: 15px;
      border-radius: 5px;
      color: white;
      margin: auto;
      max-width: 200px;
      text-align: center;
      font-weight: 600;
      font-size: 20px;
   }

   .btn-send:hover{

      background: #3a8ee6;
      color: white;
      cursor: pointer;

   }

   .custom-file-input::-webkit-file-upload-button {
      visibility: hidden;
   }

   .custom-file-input::before {
      content: "Seleccionar Archivo";
      display: inline-flex;
      background: #28282a;
      color: white;
      height: 46px;
      align-items: center;
      padding: 0 20px;
      border-radius: 4px;
      font-size: var(--el-font-size-base,14px);
      font-weight: 500;
      outline: none;
      white-space: nowrap;
      cursor: pointer;
   }

   @media only screen and (max-width: 991px) {
      .order-create-info {flex-direction: column;}
      .order-create-info .order-create-info-item {    border-right: none;    padding-bottom: 10px;}
      .order-create-checks-group .order-create-checks-group-items {grid-template-columns: 1fr;} 
      .layout-profesional-content {padding: 20px;}
      .vehicles-selects {flex-direction: column;}
      .orders-menu-searchs {width: 100%!important;}
   }

</style>