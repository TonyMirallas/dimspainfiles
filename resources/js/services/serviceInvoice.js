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
   'The selected payment is invalid.': 'El método de pago seleccionado no es válido.',
   'The selected state is invalid.': 'El estado seleccionado no es válido.',
   'The payment field is required.': 'El campo método de pago es obligatorio.',
   'The contact id field is required.': 'El campo id de contacto es obligatorio.',
   'The product discount field is required.': 'El campo descuento es obligatorio.',
   'The product id field is required.': 'El campo id de producto es obligatorio.',
   'The product price field is required.': 'El campo precio es obligatorio.',
   'The product quantity field is required.': 'El campo cantidad es obligatorio.',
}

// Comprobar si el dato es null o undefined o vacío
const checkValue = (value) => {
   if (value === null || value === undefined || value.length === 0) {
      return true
   }
   return false
}

// Devuelve los productos del almacen
export async function getInvoices(){

   try{

      const url = dataServer.pathDim + '/api/v1/get-invoices'
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


export async function postInvoice(data){

   try{

      const params = {
         "customer_id": checkValue(data.customer_id) ? null : data.customer_id,
         "user_id": checkValue(data.user_id) ? null : data.user_id,
         "contact_id": checkValue(data.contact_id) ? null : data.contact_id,
         "state": checkValue(data.state) ? null : data.state,
         "payment": checkValue(data.payment) ? null : data.payment,
         "iva": checkValue(data.iva) ? null : data.iva,
         "discount": checkValue(data.discount) ? null : data.discount,
         "subtotal": checkValue(data.subtotal) ? null : data.subtotal,
         "total": checkValue(data.total) ? null : data.total,
         "product_id": checkValue(data.product_id) ? null : data.product_id,
         "product_price": checkValue(data.product_price) ? null : data.product_price,
         "product_quantity": checkValue(data.product_quantity) ? null : data.product_quantity,
         "product_discount": checkValue(data.product_discount) ? null : data.product_discount,
         "code": checkValue(data.code) ? null : data.code,
         "observations": checkValue(data.observations) ? null : data.observations,
         "finished_at": checkValue(data.finished_at) ? null : data.finished_at,
      }

      const url = dataServer.pathDim + '/api/v1/post-invoice'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      console.log( dataRes )

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'El Presupuesto se ha creado correctamente',
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

      if(e.code === 'ECONNABORTED') return []

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'Intentalo de nuevo',
         type: 'error',
      })

   }

}


export async function updateState(data){

   try{

      const params = data

      const url = dataServer.pathDim + '/api/v1/put-invoice'
      const res = await axios({method: 'POST', url, headers, params})
      const dataRes = res.data

      if(dataRes.success){

         ElNotification({
            duration: 10000,
            title: 'Operación Completada',
            message: 'El Presupuesto se ha cambiado correctamente',
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

      if(e.code === 'ECONNABORTED') return []

      ElNotification({
         duration: 10000,
         title: 'Error',
         message: 'Intentalo de nuevo',
         type: 'error',
      })

   }

}