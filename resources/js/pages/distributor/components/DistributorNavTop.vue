<template>

   <el-menu
      :default-active="navUserIndex"
      :router="true" 
      class="nav-user"
      mode="horizontal"
      background-color="#222"
      text-color="#fff"
      active-text-color="#ffd04b"
   >
      <el-menu-item index="/technical" class="nav-user-logo">
         <img :src="dataServer.images.technical_logo" alt="">
      </el-menu-item>
      <el-menu-item disabled>{{dataServer.auth.user}}</el-menu-item>
      <el-sub-menu index="/technical/account">
         <template #title><el-icon><user-filled /></el-icon>Cuenta</template>
         <el-menu-item index="/technical/account/settings" >
            <el-icon><tools /></el-icon>Cliente
         </el-menu-item>
         <el-menu-item index="/technical/account/exit">
            <el-icon><switch-button /></el-icon>Salir
         </el-menu-item>
      </el-sub-menu>
   </el-menu>

   <div class="line"></div>

   <el-menu
      :default-active="navPagesIndex"
      :router="true" 
      class="nav-pages"
      mode="horizontal"
   >
      <el-menu-item index="/distributor">
         <el-icon><histogram /></el-icon>Portada
      </el-menu-item>
      <el-menu-item index="/distributor/professional/list">
         <el-icon><histogram /></el-icon>Lista de Profesionales
      </el-menu-item>
      <el-menu-item index="/distributor/professional/requested">
         <el-icon><list /></el-icon>Acciones pendientes
      </el-menu-item>
      <el-menu-item index="/distributor/payments">
         <el-icon><credit-card /></el-icon>Pagos
      </el-menu-item>
   </el-menu>
   
   <!-- <breadcrumb></breadcrumb> -->


</template>

<script>

 export default {

    // props
      props: {
         navUserIndex: {
            type: String,
            default: "/technical"
         },
         navPagesIndex: {
            type: String,
            default: "/technical"
         }
      },
      data() {

         return {
            dataServer: dataServer,
         }

      },

      methods: {
         handleMenuItem(path) {

            window.location.href = this.dataServer.pathDim + path;

         },
      },

 }


</script>


<style lang="scss">

   .nav-user {
      display: grid;
      grid-template-columns: 1fr auto auto auto;
      justify-content: unset;
      // justify-items: end;
      padding: 0 80px;
   }

   .nav-user-logo{
      justify-self: left;
      padding: 10px;

      img{
         width: 100%;
         height: 100%;
         object-fit: contain;
      }

   }

   .nav-pages {
      padding: 0 80px;
   }

   
</style>