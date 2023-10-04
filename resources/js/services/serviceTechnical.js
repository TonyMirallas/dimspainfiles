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


export async function getTechnicals(){

   try{

      const url = dataServer.pathDim + '/api/v1/get-technicals'
      const res = await axios({method: 'GET', url, headers})
      const dataRes = res.data

      if(!dataRes.success) throw new Error(dataRes.message_log)
      
      return dataRes.data

   }catch(e){

      console.log(e.message)
      
      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'Intentalo de nuevo',
         type: 'error',
      })

      return []

   }

}
