<template>

   <div class="layout">

      <div class="layot-nav">

         <div class="nav-left"> 

            <div class="title">
               <img class="logo" :src="`${dataServer.pathDim}/img/logo.png`" alt="">
            </div>

            <div class="subtitle">
               <div class="text-1">CRM Comercial</div>
               <div class="text-2">Departamento Sage</div>
            </div>
            
            <div class="for-item" v-for="(item, index) in crmComercialRef" :key="index">
               
               <div class="item" :class="{ selected: item.subActive }" @click="setSubActive(item)">
                  <component v-bind:is="item.icon"></component>
                  <div class="name">{{item.label}}</div>
                  <i v-if="item.sub" class="arrow fa-solid fa-chevron-down grid-r"></i>
               </div>

               <div class="expand" :class="{ selected: item.subActive }">
                  <a :href="$router.resolve({ name: item.name, params: item.params }).href" class="item sub" v-for="(item, index) in item.sub" :key="index">
                     <div class="icon-line"></div>
                     <div class="name">{{item.label}}</div>
                  </a>
               </div>

            </div>
         
            <div class="subtitle">
               <div class="text-1">CRM Técnico</div>
               <div class="text-2">Departamiento dimspainfiles</div>
            </div>
            
            <div class="for-item" v-for="(item, index) in crmTechnicalRef" :key="index">

               <div class="item" :class="{ selected: item.subActive }" @click="setSubActive(item)">
                  <component v-bind:is="item.icon"></component>
                  <div class="name">{{item.label}}</div>
                  <i v-if="item.sub" class="arrow fa-solid fa-chevron-down grid-r"></i>
               </div>

               <div class="expand" :class="{ selected: item.subActive }">
                  <router-link :to="{ name: item.name, params: item.params }" class="item sub" v-for="(item, index) in item.sub" :key="index">
                     <div class="icon-line"></div>
                     <div class="name">{{item.label}}</div>
                  </router-link>
               </div>

            </div>

         </div>

         <div class="nav-right">

            <TechnicalNavTop />

            <div class="components">

               <router-view></router-view>

            </div>

         </div>

      </div>

   </div>

</template>

<script>

import { ref, onMounted, onBeforeMount, watch, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router'

import crmTechnical from '../../../dataConstants/crmTechnical';
import crmComercial from '../../../dataConstants/crmComercial';


export default {

      name: 'TechnicalApp',
      setup(){

         const route = useRoute()

         const crmTechnicalRef = ref(crmTechnical.routes)
         const crmComercialRef = ref(crmComercial.routes)
         
         const setSubActive = (argItem) => {

            crmTechnicalRef.value.forEach(item => {
               if(item.subActive && item.label != argItem.label) {
                  item.subActive = false;
               }
            })

            crmComercialRef.value.forEach(item => {
               if(item.subActive && item.label != argItem.label) {
                  item.subActive = false;
               }
            })

            argItem.subActive = !argItem.subActive

         }

         watch(() => route.name, (routeName) => {

            crmComercialRef.value.forEach(item => {

               if(item.routeNames.includes(routeName)) {
                  item.subActive = true;
               }else{
                   item.subActive = false;
               }

            })

         })

         return {

            // Vars
            dataServer,

            // Refs
            crmTechnicalRef,
            crmComercialRef,

            // Methods
            setSubActive,

            // refs Globals

         }

      }

}

</script>


<style lang="scss" scoped>

   .grid-r{
      justify-self: end;
   }

   .layout{
      position: relative;
      // background: #f2f2f2;
      // height: 100vh;

      .layot-nav{
         display: grid;
         grid-template-columns: auto 1fr;
         z-index: 1;
         position: fixed;
         top: 0;
         width: 100vw;
         height: 100vh;
         user-select: none;

         .title{
            height: 80px;
            border-bottom: solid 1px #00000014;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #222223;

            .logo{
               width: 70%;
               height: 100%;
               object-fit: contain;
            }

         }

         .subtitle{
            background-color: var(--color-default-s);
            padding: 15px;
            margin: var(--margin-default-m);
            border-radius: 10px;
         
            .text-1{
               color: var(--color-texts-m);
               font-size: var(--font-size-m);
               font-weight: 600;
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis;
               margin-bottom: 8px;
            }

            .text-2{
               color: var(--color-texts-m);
               font-size: var(--font-size-s);
               margin-bottom: 0;
               text-transform: capitalize;
               line-height: 1;
               width: 100%;
               overflow: hidden;
               text-overflow: ellipsis;
            }

         }

         .for-item{

            display: grid;
            gap: 5px;

            .expand{
               max-height: 0;
               overflow: hidden;
               transition: all 0.3s ease-in-out;
            }

            .expand.selected{
               transition: all 0.5s ease-in-out;
               max-height: 300px;
            }

         }

         .item{
            display: grid;
            grid-template-columns: auto auto 1fr;
            align-items: center;
            gap: 10px;
            padding: 15px;
            font-size: var(--font-size-m);
            margin: 0 var(--margin-default-m);
            border-radius: 10px;
            background-color: white;
            color: var(--color-texts-m);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
         
            svg {
               width: 22px;
            }

            &.selected{
               background-color: var(--color-default-l);
               color: var(--color-default-s);

               .arrow{
                  transform: rotate(0deg);
               }

            }

            &:hover{
               background-color: var(--color-default-s);
               color: var(--color-default-l);
            }

            .arrow{

               transform: rotate(-90deg);
               transition: all 0.3s ease-in-out;

            }

            i{
               // color: var(--color-texts-s);
            }
         }

         .sub{

            display: flex;
            align-items: center;
            margin: 0 var(--margin-default-m);
            padding: 10px 0;
            margin-left: 32px;

            .icon-line{
               width: 10px;
               height: 3px;
               background-color: var(--color-texts-m);
               border-radius: 5px;
               
            }

            .name{
               font-size: var(--font-size-m);
               color: var(--color-texts-s);
               white-space: nowrap;
               overflow: hidden;
               text-overflow: ellipsis;
            }

            &:hover{
               background-color: white;
            }

            &:hover .name{
               color: var(--color-default-l);
            }

            .name.selected{
               color: var(--color-default-l);
            }

         }

      }

      .nav-left{
         height: 100%;
         width: 280px;
         line-height: inherit;
         background: #fff;
         text-align: left;
         box-shadow: 0 0 21px 0 rgb(89 102 122 / 10%);
      }

      .components{

         overflow: auto;
         height: calc(100vh - 81px);

      }

   }

   .router-link-active .name {
      color: var(--color-default-l) !important;
   }

   
</style>
