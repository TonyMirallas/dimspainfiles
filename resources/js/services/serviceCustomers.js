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


export async function getCustomers(data){

   try{

      const params = {
         type: checkValue(data.type) ? null : data.type,
      }

      const url = dataServer.pathDim + '/api/v1/get-customers'
      const res = await axios({method: 'GET', url, headers, params})
      const dataRes = res.data

      if(!dataRes.success) throw new Error(dataRes.message_log)

      return dataRes.data

   }catch(e){

      console.log('getCustomers', e.message)

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

export async function getCustomer(data){

   try{

      const params = {
         id: checkValue(data.id) ? null : data.id,
      }

      const url = dataServer.pathDim + '/api/v1/get-customer'
      const res = await axios({method: 'GET', url, headers, params})
      const dataRes = res.data

      if(!dataRes.success) throw new Error(dataRes.message_log)
      
      return dataRes.data

   }catch(e){

      console.log('getCustomer', e.message)

      if(e.code === 'ECONNABORTED') return []
      
      ElNotification({
         duration: 10000,
         title: 'Error',
         message: '2 Intentalo de nuevo',
         type: 'error',
      })

      return []

   }

}

export async function getCustomerProduct(data){

   try{

      const params = {
         customer_id: checkValue(data.customer_id) ? null : data.customer_id,
         product_id: checkValue(data.product_id) ? null : data.product_id,
      }
      
      const url = dataServer.pathDim + '/api/v1/get-customer-product'
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
         message: 'No se pudo obtener el descuento del producto',
         type: 'error',
      })

      return []

   }

}

export async function createCustomer(data){

   try{

      const params = {
         name: checkValue(data.name) ? null : data.name,
         legal_representative_name: checkValue(data.legal_representative_name) ? null : data.legal_representative_name,
         tax_number: checkValue(data.tax_number) ? null : data.tax_number,
         pc: checkValue(data.pc) ? null : data.pc,
         phone: checkValue(data.phone) ? null : data.phone,
         address: checkValue(data.address) ? null : data.address,
         country: checkValue(data.country) ? null : data.country,
         province: checkValue(data.province) ? null : data.province,
         city: checkValue(data.city) ? null : data.city,
         notes: checkValue(data.notes) ? null : data.notes,
         email: checkValue(data.email) ? null : data.email,
         interests: checkValue(data.interests) ? null : data.interests,
         acquisition: checkValue(data.acquisition) ? null : data.acquisition,
         competitors: checkValue(data.acquisition) ? null : data.competitors,
         type: checkValue(data.type) ? null : data.type,
      }

      const url = dataServer.pathDim + '/api/v1/post-customer'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'Cliente creado correctamente',
            type: 'success',
         })
      
      }else{

         console.log( dataRes )

         const translation = {
            'The email has already been taken.': 'Ya existe otro Cliente de empresa con ese correo electrónico.',
            'The legal representative name has already been taken.': 'Ya existe otro Cliente de empresa con ese nombre legal.',
            'The name has already been taken.': 'Ya existe otro Cliente de empresa con ese nombre.',
            'The tax number has already been taken.': 'Ya existe otro Cliente de empresa con ese número de identificación fiscal.',
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

      if(e.code === 'ECONNABORTED') return []

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'No se pudo crear',
         type: 'error',
      })

   }

}

export async function createContactCustomer(data){

   try{

      const params = {
         id: checkValue(data.id) ? null : data.id,
         name: checkValue(data.name) ? null : data.name,
         email: checkValue(data.email) ? null : data.email,
         phone: checkValue(data.phone) ? null : data.phone,
         position: checkValue(data.position) ? null : data.position,
         channel: checkValue(data.channel) ? null : data.channel,
         observations: checkValue(data.observations) ? null : data.observations,
      }

      const url = dataServer.pathDim + '/api/v1/post-contact-customer'
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

         console.log( dataRes )

         const translation = {
            'The email has already been taken.': 'Ya existe otro contacto con ese correo electrónico.',
            'The name has already been taken.': 'Ya existe otro contacto con ese nombre.',
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
      
      if(e.code === 'ECONNABORTED') return []

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'No se pudo crear el contacto',
         type: 'error',
      })

   }

}