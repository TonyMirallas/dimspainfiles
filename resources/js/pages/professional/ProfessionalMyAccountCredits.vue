<template>

<div class="container">
   <div class="row">
      <div class="col-12 col-md-4">
         <h1>Solicitud de Créditos</h1>
         Mostrando los 5 resultados
      </div>
      <div class="col-12 col-md-8 derecha">

      </div>

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>

         </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>

         </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>

         </div>
      </div>

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>
         </div>
      </div>

      

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>
         </div>
      </div>

      

      <div class="col-12 col-sm-6 col-md-3">
         <div class="contenedor producto">
               <img src="https://i.imgur.com/DW4r993.jpg">
               <div class="pcategoria">archivo </div>
               <div class="pnombre">V03CS003 – 300 créditos</div>
               <div class="pprecio">300,00 €</div>
               <div class="comprar"><a href="#" rel="nofollow">Solicitar Creditos</a></div>
         </div>
      </div>


   </div>
</div>

</template>

<script>

   export default {

      data() {

         return {

            dataServer: dataServer,

         }

      },

   }

</script>

<style lang="scss">

   .container {
      // padding-top:50px;
      padding-bottom:50px;
   }

   .contenedor {
      padding-top:30px;
   }
   
   .contenido {
      text-align: center;
      padding: 20px;
      background: #FFFFFF;
      border-radius: 5px;
      margin:5px;
      margin-bottom:20px;
      box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 1px 3px 1px;
   }
   .contenido p {
      text-align:justify;
      margin:0px;
   }
   .contenido h2 {
      margin-top: 10px;
      text-align:left;
   }
   .infopersona {
      text-align: center;
      padding: 10px;
   }
   .infopersona p {
      text-align: center;
      padding-top: 20px;
   }
   .infopersona p.salir {
      color: #ff0000;
      font-weight: 700;
      font-size: 12px;
      text-decoration: underline;
   }
   .infopersona img {
      border-radius: 50%;
      width: 100px;
      box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
   }
   .infopersona span {
      font-weight: 700;
   }
   h3.contacto {
      font-size: 20px;
      color: #212123;
   }
   .contenido i {font-size: 40px;
      padding-top: 10px;
      color: #ea1820;
   }

   .derecha {
      text-align: right;
   }

   .comprar {
      background: linear-gradient(90deg, #28282a 0%, #101010 65%) !important;
      text-align: center;
      font-weight: 600;
      padding: 7px;
      border-radius: 9px;
   }

   .comprar a {
      color:#ffffff;
   }

   .pcategoria {
      font-size: 12px;
      color: #787878;
      padding-top: 10px;
      text-transform: capitalize;
   }

   .pnombre {
      font-weight: 600;
      padding-top: 5px;
      padding-bottom: 5px;

   }

   .pprecio {
      padding-bottom: 15px;
      font-weight: 700;
      color: #646464;
   }

   .producto img {
      width: 100%;
   }

   select {
         padding: 0.5em;    
         border: 1px solid #ddd;
         border-radius: 0;
         box-shadow: none;
   }
</style>