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

export async function getTracings(){

   try{

      const url = dataServer.pathDim + '/api/v1/get-tasks'
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

export async function postTask(data){

   try{

      const params = {
         "user_id": checkValue(data.user_id) ? null : data.user_id,
         "from_user_id": checkValue(data.from_user_id) ? null : data.from_user_id,
         "customer_id": checkValue(data.customer_id) ? null : data.customer_id,
         "contact_id": checkValue(data.contact_id) ? null : data.contact_id,
         "from_contact_id": checkValue(data.from_contact_id) ? null : data.from_contact_id,
         "channel": checkValue(data.channel) ? null : data.channel,
         "objetive": checkValue(data.objetive) ? null : data.objetive,
         "state": checkValue(data.state) ? null : data.state,
         "description": checkValue(data.description) ? null : data.description,
         "relation": checkValue(data.relation) ? null : data.relation,
         "finished_at": checkValue(data.finished_at) ? null : data.finished_at,
      }
      
      const url = dataServer.pathDim + '/api/v1/post-task'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'La tarea se ha registrado correctamente',
            type: 'success',
         })
      
      }else{

         const translation = {
         }

         for(let key in dataRes.data){

            let errors = dataRes.data[key]

            for(let i in errors){

               let error = errors[i]

               setTimeout(() => {

                  ElNotification({
                     duration: 10000,
                     title: 'Error',
                     message: translation[error],
                     type: 'error',
                  })

               }, i * 100)

            }

         }

      }

      return dataRes

   }catch(err){

      console.log(err.message)

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'No se pudo registrar la tarea',
         type: 'error',
      })

   }

}

export async function putTask(data){

   try{

      const params = {
         "id": checkValue(data.id) ? null : data.id,
         "state": checkValue(data.state) ? null : data.state,
         "result": checkValue(data.result) ? null : data.result,
      }
      
      const url = dataServer.pathDim + '/api/v1/put-task'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'El seguimiento se ha registrado correctamente',
            type: 'success',
         })
      
      }else{

         const translation = {
         }

         for(let key in dataRes.data){

            let errors = dataRes.data[key]

            for(let i in errors){

               let error = errors[i]

               setTimeout(() => {

                  ElNotification({
                     duration: 10000,
                     title: 'Error',
                     message: translation[error],
                     type: 'error',
                  })

               }, i * 100)

            }
         }

      }

      return dataRes

   }catch(err){

      console.log(err.message)

      if(e.code === 'ECONNABORTED') return null

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'No se pudo actualiza el seguimiento',
         type: 'error',
      })

   }

}

export async function sendEmail(data){

   try{

      const params = data
      
      const url = dataServer.pathDim + '/api/v1/send-email'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'El email se ha enviado correctamente',
            type: 'success',
         })
      
      }else{

         const translation = {
         }

         for(let key in dataRes.data){

            let errors = dataRes.data[key]

            for(let i in errors){

               let error = errors[i]

               setTimeout(() => {

                  ElNotification({
                     duration: 10000,
                     title: 'Error',
                     message: translation[error],
                     type: 'error',
                  })

               }, i * 100)

            }
         }

      }

      return dataRes

   }catch(err){

      console.log(err.message)

      if(e.code === 'ECONNABORTED') return null

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'No se pudo enviar el email',
         type: 'error',
      })

   }

}