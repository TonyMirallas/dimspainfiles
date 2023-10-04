<template>
   <div class="file-upload">
      <input type="file" @change="fileSelected" class="custom-file-input">
   </div>
</template>

<script>

   import axios from 'axios';
   import * as utils from '../../../helpers/utils';

   export default {
      name: 'FileUpload',
      props: {
         file: {
            type: String,
         },
      },
      data() {
         return {
            dataServer: dataServer,
            fileExtension: null,
            fileName: null,
            fileData: null,
         };
      },
      methods: {

         fileSelected(event) {

            this.file = 'yee'

            // // Get Name of File
            // this.fileData = event.target.files[0];
            // this.fileName = event.target.files[0].name;
            // this.fileExtension = this.fileName.split('.').pop();

            // if(this.fileExtension !== 'FPF') {
            //    event.target.value = '';
            //    return utils.notificationUser({
            //       success: false,
            //       message: 'Solo se permite archivos con extensión .FPF',
            //    });
            // }
    
         },

         fileUpload(){

            const data = new FormData();
            data.append('professional_id', this.dataServer.auth.id);
            data.append('file_name', this.fileName);
            data.append('file_data', this.fileData);
       
            const url = dataServer.pathDim + '/api/v1/post-order-file-upload'

            axios({
               method: 'post',
               url: url,
               data: data,
               headers: {'Content-Type': 'multipart/form-data' }
            })
            // .then(utils.notificationUser)

         }
      }
   };


</script>

<style lang="scss">

   .custom-file-input::-webkit-file-upload-button {
      visibility: hidden;
   }

   .custom-file-input::before {
      content: "Seleccionar Archivo";
      display: inline-flex;
      background: #28282a;
      color: white;
      height: 46px;
      align-items: center;
      padding: 0 20px;
      border-radius: 4px;
      font-size: var(--el-font-size-base,14px);
      font-weight: 500;
      outline: none;
      white-space: nowrap;
      cursor: pointer;
   }

  
   
</style>