<template>

   <div class="test-component">

      <h2>TestComponent</h2>

       <template v-for="(item, index) in itemsFilter" :key="index">

         <slot name="demo" :item="item"></slot>

       </template>

   </div>

</template>

<script>

   import { ref, watch, reactive, computed, onMounted } from 'vue'

   export default {
      name: 'testComponent',
      props: [
         'items',
      ],
      setup(props, context){

         const itemsFilter = computed(() => {
            return props.items.slice(0, 10)
         })

         return {
            itemsFilter
         }

      }

   }
   
</script>


<style lang="scss">
      


</style>