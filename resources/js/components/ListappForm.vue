<template>
   
   <div class="listapp-form">

      <div class="vehicles-tipoveh">

         <el-radio-group class="tabs-type-vehiculo-radio-group" v-model="modelValue.veh_type" @change="eventChangeTipoVeh" style="margin-bottom: 30px">
            <el-radio-button label="CAR">Auto</el-radio-button>
            <el-radio-button label="BIKE">Bike</el-radio-button>
            <el-radio-button label="LCV">LCV</el-radio-button>
            <el-radio-button label="TRUCK">Truck</el-radio-button>
            <el-radio-button label="TRACTOR">Tractor</el-radio-button>
            <el-radio-button label="MARINE" disabled>Marine</el-radio-button>
         </el-radio-group>

      </div>

      <div class="vehicles-selects">

         <!-- <el-select v-model="modelValue.veh_type" placeholder="Selecciona tipo Vechiculo" @change="eventChangeTipoVeh">
            <el-option v-for="item in formsSelectedState.veh_type" :key="item" :label="item" :value="item"></el-option>
         </el-select> -->

         <el-select v-model="modelValue.manufacture" placeholder="Selecciona Marca" @change="eventChangeMarca">
            <el-option v-for="item in formsSelectedState.manufacture" :key="item" :label="item" :value="item"></el-option>
         </el-select>

         <el-select v-model="modelValue.model" placeholder="Selecciona Modelo" @change="eventChangeModelo">
            <el-option v-for="item in formsSelectedState.model" :key="item" :label="item" :value="item"></el-option>
         </el-select>

         <el-select v-model="modelValue.type" placeholder="Selecciona Motor">
            <el-option v-for="item in formsSelectedState.type" :key="item" :label="item" :value="item"></el-option>
         </el-select>

      </div>

   </div>

</template>

<script>

   import axios from 'axios';

   const API_URL = 'https://api-listapp.agenciat1.es'

   export default {

      props: ['modelValue'],
      data() {
         return {
            formsSelectedState: {
               veh_type: null,
               manufacture: null,
               model: null,
               type: null,
            },
         }
      },
      async mounted() {

         // this.formsSelectedState.veh_type = await this.getTiposVeh()

      },
      methods: {

         async eventChangeTipoVeh(){
            this.formsSelectedState.manufacture = await this.getMarcas()
            this.formsSelectedState.model = []
            this.formsSelectedState.type = []
            this.modelValue.manufacture = null
            this.modelValue.model = null
            this.modelValue.type = null
         },

         async eventChangeMarca(){
            this.formsSelectedState.model = await this.getModelos()
            this.formsSelectedState.type = []
            this.modelValue.model = null
            this.modelValue.type = null
         },

         async eventChangeModelo(){
            this.formsSelectedState.type = await this.getTiposMotor()
            this.modelValue.type = null
         },

         // API
         async getTiposVeh(){

            const enpoint = '/api/v1/get/tipos-veh'
            const params = {}

            return await axiosPost({enpoint, params})
            
         },
         async getMarcas(){
            
            const enpoint = '/api/v1/get/marcas-by-tipo-veh'

            const params = {
               "veh_type": this.modelValue.veh_type 
            } 

           return await axiosPost({enpoint, params})

         },
         async getModelos(){

            const enpoint = '/api/v1/get/modelos-by-marca'

            const params = {
               "veh_type":  this.modelValue.veh_type ,
               "manufacture":  this.modelValue.manufacture 
            }

            return await axiosPost({enpoint, params})

         },
         async getTiposMotor(){

            const enpoint = '/api/v1/get/tipos-motor-by-modelo'

            const params = {
               "veh_type":  this.modelValue.veh_type,
               "manufacture":  this.modelValue.manufacture,
               "model": this.modelValue.model,
            }

            return await axiosPost({enpoint, params})

         }

      },

   }

   async function axiosPost({enpoint, params}){

      const result = await axios({
         url: API_URL + enpoint,
         method: 'POST',
         headers: {
            'Accept': 'application/json',
            'content-type': 'application/json',
         },
         params
      })

      return result.data

   }

</script>



<style scoped>

   .listapp-form{
      display: grid;
      align-items: center;
      gap: 20px;
   }

   .vehicles-selects{
      display: flex;
      justify-items: center;
      align-items: center;
      gap: 10px;
   }

   .tabs-type-vehiculo-radio-group{
      width: 100%;
      margin-bottom: 0;
   }

</style>