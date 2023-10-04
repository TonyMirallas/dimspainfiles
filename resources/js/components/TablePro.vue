<template>

   <div class="table">
      
      <div class="items table-grid" :style="`grid-template-columns: ${getSizeTable};`">
         <div class="item-header" v-for="column in columnOrder" :key="column" :class="column.classHeader" :style="column.style" >{{column.label}} </div>
         <template v-for="(item, index) in modelValueComputed" :key="index">
            <div class="item-val" v-for="column in columnOrder" :key="column" :class="column.classItem" :style="column.style">
               <template v-if="column.type == 'text'">
                  {{ columnData[item.index][column.field] }}
               </template>
               <template v-if="column.type == 'check'">
                  <el-checkbox v-model="columnData[item.index][column.field]"></el-checkbox>
               </template>
               <template v-if="column.type == 'slot'">
                  <slot :name="column.slot" :item="columnData[item.index]" ></slot>
               </template>
            </div>
         </template>
      </div>

      <div class="pagination" v-if="!paginationHide">
         <el-pagination layout="prev, pager, next" :total="columnData.length" :page-size="itemsForPage" @current-change="handleCurrentChangePage"></el-pagination>
      </div>
         
   </div>

</template>

<script>

   import { ref, watch, reactive, computed, onMounted } from 'vue'

   export default {
      name: 'TablePro',
      props: [
         'columnData',     // Datos puros de la tabla  
         'columnOrder',    // Las columnas de la tabla
         'itemsForPage',   // Numero de items por pagina
         'filterSearch',   // Texto para filtrar los items
         'paginationHide'  // Si se oculta la paginacion
      ],
      setup(props, context){

         const pageNumber = ref(1)
         
         let columnDataTexts = ref([])

         watch(() => props.columnData, () => {

            columnDataTexts.value = []

            props.columnData.map( (item, index) => {
               const text = getValues(item).join(' ').toLowerCase();
               columnDataTexts.value.push({ text, index })
            })        
           
         }, { deep: true })

         const getValues = (obj, values = []) => {
            for (let key in obj) {
               if (typeof obj[key] === 'object') {
                  getValues(obj[key], values);
               } else {
                  values.push(obj[key]);
               }
            }
            return values.filter((item, pos, self) => self.indexOf(item) == pos);
         }

         // Devuelve los items filtrados
         const modelValueComputed = computed(() => {

            const paginationInit = (pageNumber.value - 1) * props.itemsForPage
            const paginationEnd = pageNumber.value * props.itemsForPage
            
            const searchText = props.filterSearch.toLowerCase()

            if(!searchText || searchText.length <= 0) {
               return columnDataTexts.value.slice(paginationInit, paginationEnd);
            }

            const items = columnDataTexts.value.filter((item) => {

               let flag = true;

               searchText.split(',').forEach((filter) => {

                  const filterText = filter.trim().toLowerCase();

                  if(!filterText || filterText.length == 0) return;

                  if(!item.text.includes(filterText)) flag = false;

               })

               return flag

            })

            return items.slice(paginationInit, paginationEnd);

         })

         const getSizeTable = computed(() => {
            return props.columnOrder.reduce( (acc, column) => `${acc} ${column.size || '1fr'} `, '');
         })

         const handleCurrentChangePage = (val) => {
            pageNumber.value = val;
         }

         props.columnData.map( (item, index) => {
            const text = getValues(item).join(' ').toLowerCase();
            columnDataTexts.value.push({ text, index })
         })

         return {
            handleCurrentChangePage,
            modelValueComputed,
            getSizeTable,
         }

      }

   }
   
</script>


<style lang="scss">
      
   .item-header.start{
      text-align: left;
   }
   .item-header.center{
      text-align: right;
   }
   .item-header.end{
      text-align: right;
   }

   .item-val.start{
      justify-content: flex-start;
   }
   .item-val.center{
      justify-content: center;
   }
   .item-val.end{
      justify-content: flex-end;
   }

   // --------------------------------------------------

   .table{
      font-size: 13px;
   }

   .table-filters{
      display: flex;
      grid-gap: 10px;
      margin-bottom: 10px;
      background: #f9f9f9;
      padding: 20px;
      border-radius: 5px;

      &.hide{
         display: none;
      }

   }

   .table-filters-item{
      
      flex: 1;

      span{
         font-size: 13;
         padding-bottom: 5px;
         display: block;
      }
    
   }

   .table-grid{
      display: grid;
   }

   .items{

      .item-header{
         white-space: nowrap;
         font-weight: bold;
         color: black;
         padding: 15px 15px;
         // border-bottom: solid 1px #c1c1c1;
         background: #f9f9f9;
         // text-align: center;
      }
      
      .item-val{
         display: flex;
         align-items: center;
         // justify-content: center;
         white-space: nowrap;
         border-bottom: solid 1px #0000000f;
         padding: 15px 15px;
      }

   }

   .pagination{
      display: flex;
      justify-content: flex-end;
      margin-top: 20px;
   }

</style>