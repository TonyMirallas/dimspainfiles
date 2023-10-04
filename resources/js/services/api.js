import axios from 'axios'

//####################################################
// config
//####################################################

const headers = {
   'Accept': 'application/json',
   'content-type': 'application/json',
   'Authorization': 'Bearer ' + dataServer.auth.token
}


//####################################################
// Technicals
//####################################################
export async function getData(params){
   
   const url = dataServer.pathDim + '/api/v1/get-data'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getTechnicals(params){
   
   const url = dataServer.pathDim + '/api/v1/get-technicals'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getTechnical(params){
   
   const url = dataServer.pathDim + '/api/v1/get-technical'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function postTechnical(params){
   
   const url = dataServer.pathDim + '/api/v1/post-technical'
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}

// Comercial

export async function sageCustomers(params){

   params = {
      "token": "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6Ik56TXdPVVJHTVVZNU5ERXpRelJHUVVNMVF6azJSa1U1UVRJMU0wRTROemhGUmpWQ04wSTNOQSJ9.eyJpc3MiOiJodHRwczovL2lkLnNhZ2UuY29tLyIsInN1YiI6ImF1dGgwfDdhZDI2ZTI0MDY3NzRhNWM3ZDMxMjZmNjAwYzM4ODlmMDAwYWM5MjcxZmUyZGNjMyIsImF1ZCI6WyJzMmVzcC9zMjAwLnNhZ2UuY29tL2FwaSIsImh0dHBzOi8vc2FnZS1jaWQtcHJvZC5ldS5hdXRoMC5jb20vdXNlcmluZm8iXSwiaWF0IjoxNjQ4NTM1OTY0LCJleHAiOjE2NDg1NjQ3NjQsImF6cCI6ImphcklMUmVXdm92RWVnTEZVUzUxTHNrUU45cUxweTcyIiwic2NvcGUiOiJvcGVuaWQgcHJvZmlsZSBlbWFpbCBTYWxlczpSZWFkV3JpdGUgb2ZmbGluZV9hY2Nlc3MifQ.dKjReQVsscMPN13SJXLr64C5Q7TIjEsEFoTVRXrItrqIaQF2M3a96-opd3ngXGl-UgBrPyUzf5vStSqb-jeSB3ojFztQwEoi_OkJ_jozZ4qxsC-dKFkW_mqpy9aC8fONGGsqCtiuRwnDQ5QV-xbglAdUkME9oM7Asfl6tzx1uyDEURIzeXWZ3_88l7JaIJNHcAhNKCrom1Yw38CoP4T47VVdoWbUqYBftZqnSMMIjmZ38MATmbiAVLRhYUxOuh-Gxi3zVakAH8Db8bJA_MZWCRaC_KDWKT2oqRUMHn2EQE1KiuG0FW3MbtJrNFvwHr4IJItLkL_pNvdpMUcSthP8uw"
   }
   
   const url = dataServer.pathDim + '/api/v1/sage-customers'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}

//####################################################
// Professional
//####################################################

export async function getProfessionals(params){
   
   const url = dataServer.pathDim + '/api/v1/get-professionals'
   const res = await axios({method: 'GET', url, headers, params}).catch(err => {
      console.log("Error en getProfessionals: ", err)
   })
   return res.data

}
export async function getProfessional(params){
   
   const url = dataServer.pathDim + '/api/v1/get-professional'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getProfessionalFiles(params){
   
   const url = dataServer.pathDim + '/api/v1/get-professional-files'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function postProfessional(params){
   
   const url = dataServer.pathDim + '/api/v1/post-professional'
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}
export async function updateProfessional(params){
   
   const url = dataServer.pathDim + '/api/v1/update-professional'
   const res = await axios({method: 'POST', url, headers, params})
   return res.data
   
}

//####################################################
// Distributor
//####################################################

export async function getDistributors(params){
   
   const url = dataServer.pathDim + '/api/v1/get-distributors'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getDistributor(params){
   
   const url = dataServer.pathDim + '/api/v1/get-distributor'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getDistributorProfessionals(params){
   
   const url = dataServer.pathDim + '/api/v1/get-distributor-professionals'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function postDistributor(params){
   
   const url = dataServer.pathDim + '/api/v1/post-distributor'
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}
export async function updateDistributor(params){
   
   const url = dataServer.pathDim + '/api/v1/update-distributor'
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}

//####################################################
// Payment
//####################################################

export async function getPayments(params){
   
   const url = dataServer.pathDim + '/api/v1/get-payments'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data
   
}
export async function getPayment(params){
   
   const url = dataServer.pathDim + '/api/v1/get-payment'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function postPayment(params){
   
   const url = dataServer.pathDim + '/api/v1/post-payment' 
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}
export async function updatePayment(params){
   
   const url = dataServer.pathDim + '/api/v1/update-payment' 
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}
export async function refundPayment(params){
   
   const url = dataServer.pathDim + '/api/v1/refund-payment' 
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}

//####################################################
// Order
//####################################################

export async function getOrders(params){
   
   const url = dataServer.pathDim + '/api/v1/get-orders'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getOrder(params){
   
   const url = dataServer.pathDim + '/api/v1/get-order'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function getOrdersByProfessional(params){
   
   const url = dataServer.pathDim + '/api/v1/get-order-professional'
   const res = await axios({method: 'GET', url, headers, params})
   return res.data

}
export async function postOrder(params){
   
   const url = dataServer.pathDim + '/api/v1/post-order' 
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}
export async function updateOrderStatus(params){
   
   const url = dataServer.pathDim + '/api/v1/update-order' 
   const res = await axios({method: 'POST', url, headers, params})
   return res.data

}