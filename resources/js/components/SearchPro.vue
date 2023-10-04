<template>

   <div id="search-pro" class="search-pro" ref="searchpro">

      <div 
         class="el-input el-input--large el-input--suffix">
         <div class="el-input__wrapper">
            <input class="el-input__inner" type="text" v-model="modelValue" @focus="eventFocus">
            <div class="search-pro-num">
               {{itemsFilterNum}}
            </div>
         </div>
      </div>

      <div class="search-pro-dialog" :class="{ show: dialogShow }" >

         <div class="company-list">
            <template v-if="itemsFilter.length <= 0">
               <div class="item not-result">No se encontraron resultados</div>
            </template>
            <template v-else>
               <div class="item" v-for="(item, i) of itemsFilter" :key="i" @click="eventClickItem(item)">
                  <div class="item-label" v-for="(label, j) of labels" :key="j">
                     {{ item[label] ? item[label] : ' ------ ' }}
                  </div>
               </div>
            </template>
         </div>

      </div>

   </div>

</template>

<script>

   import { ref, watch, reactive, computed, onMounted } from 'vue'

   export default {

      name: 'SearchPro',
      emits: ['update:modelValue', 'click-item'],
      props: {
         // String or null
         modelValue: {
            type: String,
            default: ''
         },
         items: {
            type: Array,
            required: true
         },
         labels: {
            type: Array,
            default: () => []
         },
         labelSelected: {
            type: String,
            default: ''
         },
         placeholder: {
            type: String,
            default: '',
         },
      },
      setup(props, context){

         const dialogShow = ref(false)
         const searchpro = ref(null)
         const itemsFilterNum  = ref(0)

         let itemsTexts = []

         watch(() => props.items, () => {

            itemsFilterNum.value = props.items.length
            
            itemsTexts = []

            props.items.map(item => {

               const text = Object.values(item).filter(
                  value => typeof value !== 'object' && value !== null
               ).join(' ').toLowerCase()
               
               const struct = { text, id: item.id }

               props.labels.forEach(key => struct[key] = item[key])

               itemsTexts.push(struct)

            })

         })

         const eventFocus = () => dialogShow.value = true
         const eventOutside  = () => dialogShow.value = false

         const itemsFilter = computed(() => {

            if(props.items.length <= 0) return []
            
            const searchText = props.modelValue.toLowerCase()

            if(!searchText || searchText.length <= 0) {
               itemsFilterNum.value = itemsTexts.length
               return itemsTexts
            }

            const filt = itemsTexts.filter((item) => {
               return item.text.includes(searchText)
            })

            itemsFilterNum.value = filt.length

            return filt

         })

         onMounted(() => {

            document.addEventListener('mouseup', function(e) {
               if(!searchpro.value) return
               if (!searchpro.value.contains(e.target)) return eventOutside()
            });

         })

         const eventClickItem = (data) => {

            const item = props.items.find(({id}) => id == data.id)

            context.emit('update:modelValue', data[props.labelSelected])
            context.emit('click-item', item)

            dialogShow.value = false

         }

         props.items.map(item => {

            const text = Object.values(item).filter(
               value => typeof value !== 'object' && value !== null
            ).join(' ').toLowerCase()
            
            const struct = { text, id: item.id }

            props.labels.forEach(key => struct[key] = item[key])

            itemsTexts.push(struct)

         })

         return {

            eventClickItem,
            eventFocus,
            searchpro,
            dialogShow,
            itemsFilterNum,

            itemsFilter,

            // search,
            // searchShow,
         
            // items, itemsFilter,

            // labels: props.labels,
            // placeholder: props.placeholder,

            // eventClickItem

         }

      }

   }


</script>

<style lang="scss">

   .company-pop {
      margin: 0 !important;
      padding: 10px 0 !important;
   }

</style>

<style lang="scss" scoped>

   .search-pro{
      position: relative;
   }

   .search-pro-num{
      border-left: solid 1px #dfe2e8;
      font-size: 13px;
      text-align: center;
      font-weight: 500;
      color: #00000094;
      padding-left: 14px;
   }

   .search-pro-dialog{
      display: none;
   }

   .show{
      display: block;
   }

   .company-list{
      max-height: 200px;
      max-width: 600px;
      min-width: 400px;
      overflow-y: auto;
      overflow-x: hidden;
      position: absolute;
      background: white;
      border-radius: 5px;
      box-shadow: 0 3px 8px 1px rgb(0 0 0 / 10%);
      margin-top: 10px;
      z-index: 100;

      .not-result{
         padding: 15px !important;
      }

      .item{
         margin: 0;
         cursor: pointer;
         overflow: hidden;
         padding: 5px 10px;
         display: flex;
         gap: 20px;

         &:hover{
            background: #f5f7fa;
         }

         // El primer div es para el icono
         .item-label:first-child{
            font-weight: 600;
         }

         .item-label{
            line-height: 34px;
            color: var(--el-text-color-regular);
            font-size: var(--el-font-size-base);
            list-style: none;
            text-align: left;
            white-space: nowrap;
            text-overflow: ellipsis;
           
         }

      }

      &::-webkit-scrollbar {
         width: 8px;
         background-color: #F5F5F5;
      }

      &::-webkit-scrollbar-thumb {
         border-radius: 10px;
         background-color: #dfdfdf;
      }

      &:-webkit-scrollbar-track {
         -webkit-box-shadow: inset 0 0 6px rgb(0 0 0 / 10%);
         background-color: #F5F5F5;
         border-radius: 10px;
      }

  }

</style>