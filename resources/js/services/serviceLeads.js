import axios from 'axios'
import { ElNotification, ElMessage } from 'element-plus'

//####################################################
// config
//####################################################

const headers = {
   'Accept': 'application/json',
   'content-type': 'application/json',
   // Bearer token
   'Authorization': 'Bearer ' + dataServer.auth.token
}

const translation = {
   'The cif has already been taken.': 'El CIF ya ha sido registrado.',
   'The email has already been taken.': 'El email del contacto ya ha sido registrado.',
   'The id field is required.': 'El campo id es obligatorio.',
   'The name field is required.': 'El campo nombre es obligatorio.',
   'The email field is required.': 'El campo email es obligatorio.',
   'The pc must be 5 characters.': 'El campo pc debe tener 5 caracteres.',
   'The cif must be 9 characters.': 'El CIF debe tener 9 caracteres',
   'The fiscal name has already.' : 'El nombre fiscal ya ha sido registrado.',
   'The name has already been taken.': 'El nombre comercial ya ha sido registrado.',
   'The fiscal name has already been taken.': 'El nombre fiscal ya ha sido registrado.',
}

// Crea un Lead
export async function create(data){

   try{

      const params = {
         name: data.name.length > 0 ? data.name : null,
         fiscal_name: data.fiscal_name.length > 0 ? data.fiscal_name : null,
         cif: data.cif.length > 0 ? data.cif : null,
         pc: data.pc.length > 0 ? data.pc : null,
         phone: data.phone.length > 0 ? data.phone : null,
         address: data.address.length > 0 ? data.address : null,
         country: data.country.length > 0 ? data.country : null,
         province: data.province.length > 0 ? data.province : null,
         city: data.city.length > 0 ? data.city : null,
         observations: data.observations.length > 0 ? data.observations : null,
         email: data.email.length > 0 ? data.email : null,
         interests: data.interests.length > 0 ? data.interests : null,
         acquisition: data.acquisition.length > 0 ? data.acquisition : null,
         contact_observations: data.contact_observations.length > 0 ? data.contact_observations : null,
      }

      const url = dataServer.pathDim + '/api/v1/post-lead'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'Leads creado correctamente',
            type: 'success',
         })
      
      }else{

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
         message: 'No se pudo crear el Lead',
         type: 'error',
      })

   }

}

export async function createContact(data){

   try{

      const params = {
         "id": data.id,
         "name": data.name.length > 0 ? data.name : null,
         "email": data.email.length > 0 ? data.email : null,
         "phone": data.phone.length > 0 ? data.phone : null,
         "position": data.position.length > 0 ? data.position : null,
      }

      const url = dataServer.pathDim + '/api/v1/post-contact-lead'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'Contacto creado correctamente',
            type: 'success',
         })

      }else{

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
         message: 'No se pudo crear el contacto',
         type: 'error',
      })

   }

}

// Devuelve la lista de todos los leads
export async function getLeads(data){

   try{

      const url = dataServer.pathDim + '/api/v1/get-leads'
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


// Devuelve Un Lead
export async function getLead({id}){

   try{

      const params = { id }
         
      const url = dataServer.pathDim + '/api/v1/get-lead'
      const res = await axios({method: 'GET', url, headers, params})
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
