import { ref } from 'vue'

// Se guardan todos los estados rectaivos
const cacheData = {}

// Se encarga de devolver el dato cacheado y de hacer la petición a la API para actualizarlo
export const getCacheData = (key, funcData, defaultData) => {

   if(!cacheData[key]) cacheData[key] = ref(defaultData)

   if(localStorage[key]){
      cacheData[key].value = JSON.parse(localStorage[key])
   }
   
   funcData().then( data => {
      if(!data || data.length === 0) return
      localStorage[key] = JSON.stringify(data)
      cacheData[key].value = data
   })

   return cacheData[key]

}



