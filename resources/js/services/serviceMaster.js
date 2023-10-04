import axios from 'axios'
import { ElNotification, ElMessage } from 'element-plus'
import * as utils from './utils'

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

export async function getAll(data){

   try{

      return [
         { "id": 1, "name": 'Master Empresa 1' }
      ]

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
