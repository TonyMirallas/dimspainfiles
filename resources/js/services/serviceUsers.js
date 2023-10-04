import axios from 'axios'
import { ElNotification, ElMessage } from 'element-plus'

//####################################################
// config
//####################################################

const headers = {
   'Accept': 'application/json',
   'content-type': 'application/json',
   'Authorization': 'Bearer ' + dataServer.auth.token
}



// Comprobar si el dato es null o undefined o vacío
const checkValue = (value) => {
   if (value === null || value === undefined || value.length === 0) {
      return true
   }
   return false
}


export async function getUsers(data){

   try{

      const params = {
         rol: checkValue(data.rol) ? null : data.rol,
      }

      const url = dataServer.pathDim + '/api/v1/get-users'
      const res = await axios({method: 'GET', url, headers, params})
      const dataRes = res.data

      if(!dataRes.success) throw new Error(dataRes.message_log)
      
      return dataRes.data

   }catch(e){

      console.log(e.message)

      if(e.code === 'ECONNABORTED') return []
      
      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'Intentalo de nuevo',
         type: 'error',
      })

      return []

   }

}

