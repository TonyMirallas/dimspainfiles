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

const translation = {
   'The cif has already been taken.': 'El CIF ya ha sido registrado.',
   'The email has already been taken.': 'El email ya ha sido registrado.',
   'The id field is required.': 'El campo id es obligatorio.',
   'The name field is required.': 'El campo nombre es obligatorio.',
   'The email field is required.': 'El campo email es obligatorio.',
   'The pc must be 5 characters.': 'El campo pc debe tener 5 caracteres.',
   'The cif must be 9 characters': 'El CIF debe tener 9 caracteres', 
}

// Devuelve los productos del almacen
export async function getAll(data){

   try{

      const url = dataServer.pathDim + '/api/v1/get-products'
      const res = await axios({method: 'GET', url, headers})
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
