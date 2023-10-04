<template>
   <div class="layout technicalcreate">
      
      <div class="content">

         <h1 class="content-title">Cuenta</h1>

         <div class="content-back">

            <el-form ref="form" label-position="top">

               <div class="grid-3">

                  <el-form-item label="ID" >
                     <el-input v-model="dataServer.auth.id" disabled ></el-input>
                  </el-form-item>

                  <el-form-item label="Nombre" >
                     <el-input v-model="dataServer.auth.user" disabled ></el-input>
                  </el-form-item>

                  <el-form-item label="Email" >
                     <el-input v-model="dataServer.auth.email" type="email" disabled ></el-input>
                  </el-form-item>
                  
               </div>

            </el-form>

         </div>
      </div>
      
  </div>

</template>

<script>

export default {

   data() {
      return {
         dataServer: dataServer,
      }
   },
   
}

</script>

<style lang="scss">


</style>