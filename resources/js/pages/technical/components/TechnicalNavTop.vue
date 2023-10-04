<template>

  <div class="nav-top">

      <div class="breadcrumb">

         <el-breadcrumb separator="/">
            <template v-for="(breadcrumb, index) of breadcrumbs" >
               <el-breadcrumb-item  v-if="breadcrumb.name && !breadcrumb.loading"
                  :key="index"
                  :to="{ name: breadcrumb.name, params: breadcrumb.params }"
               >
                  {{breadcrumb.label}}
               </el-breadcrumb-item>
               <el-breadcrumb-item v-if="!breadcrumb.name && !breadcrumb.loading"
                  :key="index"
               >
                  {{breadcrumb.label}}
               </el-breadcrumb-item>
               <el-breadcrumb-item v-loading="breadcrumb.loading" v-if="breadcrumb.loading"
                  :key="index"
               >
                  cargando
               </el-breadcrumb-item>
            </template>
            
         </el-breadcrumb>

      </div>

      <div class="notifications">
         <router-link :to="{name: 'technical'}" >
            <icon-bell class="black" />
            <div class="number">{{notificationNumber}}</div>
         </router-link>
      </div>

      <div class="user">
         <el-popover  :width="200" trigger="click">
            <template #reference>
               <div class="user">
                  <div class="user-pick">{{dataServer.auth.name[0]}}</div>
                  <div class="user-text">
                     <div class="name">{{dataServer.auth.name}}</div>
                     <div class="role">cuenta</div>
                  </div>
               </div>
            </template>
            <div class="users-links">
               <a class="users-link" :href="`${dataServer.pathDim}/technical/account/exit`" >Cerrar Sesión</a>
            </div>
         </el-popover>
      </div>

   </div>

</template>

<script>
  
   import { ref, onMounted, onUnmounted, watch } from 'vue'

   import { useRoute } from 'vue-router';

   import * as breadcrumbStore from '../../../dataStores/breadcrumbStore';

   export default {
      name: 'TechnicalNavTop',
      props: { },
      setup(props, context){

         const route = useRoute();

         watch(() => route.name, breadcrumbStore.routeChange);

         return {
            dataServer,
            breadcrumbs: breadcrumbStore.breadcrumbs,
            notificationNumber: breadcrumbStore.notificationNumber,
         }

      }

   }

</script>


<style lang="scss" scoped>

   .nav-top{
      height: 80px;
      line-height: inherit;
      background: #fff;
      box-shadow: 0 0 21px 0 rgb(89 102 122 / 10%);
      display: grid;
      grid-template-columns: 1fr auto auto;
      justify-content: flex-end;
      align-items: center;
      gap: 40px;
      padding: 0 20px;
      border-bottom: solid 1px #00000014;
      text-transform: uppercase;

      .breadcrumb{
         display: flex;
         align-items: center;
         font-size: var(--font-size-m);
         color: var(--color-texts-m);
         font-weight: 600;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         margin-bottom: 0;
         cursor: pointer;
         gap: 10px;

         .breadcrumb-item {
            display: flex;
            gap: 10px;
            justify-content: center;
            align-items: center;
         }

      }

      .user{
         display: grid;
         grid-template-columns: auto 1fr;
         gap: 10px;

         .user-pick {
            background: #22222330;
            width: 40px;
            height: 40px;
            border-radius: 5px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            font-weight: 700;
         }

         .user-text{

            .name{

               font-size: var(--font-size-m);
               color: var(--color-texts-m);
               font-weight: 600;
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis;
               margin-bottom: 5px;
               

            }

            .role{
               font-size: var(--font-size-s);
               color: var(--color-texts-s);
               // font-weight: 600;
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis;
            }
            
         }
         
      }

      
   

      .notifications{

         position: relative;

         .number{
            position: absolute;
            top: -8px;
            right: -5px;
            background: var(--color-default-l);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: 700;
         }


      }

   }


   .users-link{

      display: block;
      color: #222223;
      text-align: center;
      padding: 10px;
      border-radius: 3px;

      &:hover{
         background: #f9f9f9;
         // color: red
      }

   }

   .black {
      color: #222223;
   }

</style>