<template>

   <div class="test-view">


      <template v-if="users[0]">
         {{users[0].age}}
      </template>

      <TestComponent
         :items="users"
      >

         <template v-slot:demo="slotProps">
            
            <div>{{slotProps.item.name}} - {{slotProps.item.age}}</div>

            <el-input-number class="input-number-max-width" 
               v-model="slotProps.item.age" 
               controls-position="right" size="small" :step="1" :min="1" step-strictly
            />
          
         </template>


      </TestComponent>

   </div>

</template>

<script>

   import { ref, onMounted } from 'vue'


   export default {

      name: 'testView',
      setup(){

         const users = ref([
            { name: 'Juan', age: 1 },
            { name: 'Pedro', age: 2 },
            { name: 'Maria', age: 3 },
         ])

         onMounted(() => {
            
            setTimeout(() => {

               users.value[0].age = 10

               users.value.push({ name: 'Sofia', age: 4 })
          
          
            }, 5000);

         })

         return {

            users

         }


      }

   }

</script>


<style lang="scss" scoped>


</style>
