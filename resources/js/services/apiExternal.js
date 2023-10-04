import axios from 'axios'

//####################################################
// config
//####################################################

const headers = {
   'Accept': 'application/json',
   'content-type': 'application/json',
}

export async function getVehiclesData(params){

   const url = 'https://api-listapp.agenciat1.es/api/v1/get/data-by-marca-modelo-tipo'

   const res = await axios({method: 'POST', url, headers, params})

   return res.data

}
