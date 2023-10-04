<template>

   <div class="site-footer">
      <div class="cont-footer">
         <div class="logo-footer">
            <img class="imgfooter" src="https://boxcero.com/wp-content/uploads/2021/12/thumb999_dimsport-spain_1554820308_1554820308.png" width="270" height="61">
         </div>
         <div class="links-footer">
            <p class="linksabajo">
               <a style="color: #fff;" href="https://boxcero.com/aviso-legal/">Aviso Legal</a> - 
               <a style="color: #fff;" href="https://boxcero.com/politica-de-privacidad/">Política de privacidad</a> - 
               <a style="color: #fff;" href="https://boxcero.com/politica-cookies/">Uso de cookies</a> - 
               <a href="https://www.instagram.com/box.cero/" target="_blank" rel="noopener"><img src="https://dimspainfiles.work4green.org/wp-content/uploads/2021/11/04.png" class="movilimg"></a>
            </p>
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

<style lang="scss" scoped>

   @media (max-width: 1920px) {
      .site-footer {
         margin-top: 55px;
         height: 140px;
         background: url(https://boxcero.com/wp-content/uploads/2022/01/footer.png);
         z-index: 1;
         position: relative;
      }
   }

   .cont-footer {
      display: grid;
      max-width: 1200px;
      margin-left: auto;
      margin-right: auto;
      grid-template-columns: 1fr 2fr;
   }

   .logo-footer {
      align-items: flex-start;
      padding-top: 63px;
   }

   .links-footer {
      align-items: flex-end;
   }

   .linksabajo {
      text-align: right;
      padding-top: 63px;
   }

</style>