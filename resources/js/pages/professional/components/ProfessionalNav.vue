<template>
  <div class="fondo-header">
    <div class="contenedor-header">
      <div class="grid-header">
        <div class="head-logotipo">
          <img src="https://boxcero.com/wp-content/uploads/2021/12/thumb999_dimsport-spain_1554820308_1554820308.png"/>
        </div>
        <div class="head-menu">
            <nav v-if="menuNavActive">
               
               <div class="desplegar" @Click="() => { menuNavActive = !menuNavActive}" >
                  <svg fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M5.293 6.707l5.293 5.293-5.293 5.293c-0.391 0.391-0.391 1.024 0 1.414s1.024 0.391 1.414 0l5.293-5.293 5.293 5.293c0.391 0.391 1.024 0.391 1.414 0s0.391-1.024 0-1.414l-5.293-5.293 5.293-5.293c0.391-0.391 0.391-1.024 0-1.414s-1.024-0.391-1.414 0l-5.293 5.293-5.293-5.293c-0.391-0.391-1.024-0.391-1.414 0s-0.391 1.024 0 1.414z"></path></svg>
               </div>

               <ul class="nav-header nav movil">
                  <li class="enlaces"><a href="/" class="menu-link">Inicio</a></li>
                  <li class="enlaces"><a :href="dataServer.pathDim + '/professional'" class="menu-link">Cuenta</a></li>
                  <li class="enlaces">
                     <a href="#" class="menu-link">CURSOS ONLINE</a>
                     <ul>
                        <li class="submenu"><a href="/curso-online-de-iniciacion-a-la-reprogramacion">CURSO ONLINE INICIACION A LA REPROGRAMACIÓN</a></li>
                        <li class="submenu"><a href="/charlas-formativas-chiptuning">CHARLAS FORMATIVAS CHIPTUNING</a></li>
                     </ul>
                  </li>
                  <li class="enlaces"><a href="/contactanos" class="menu-link">CONTÁCTANOS</a></li>
                  <li class="enlaces"><a href="/blog" class="menu-link">BLOG</a></li>
               </ul>

            </nav>
            
            <nav v-if="!menuNavActive"> 
               
               <div class="pc desplegar" @Click="() => { menuNavActive = !menuNavActive}" >
                 <svg role="img" fill="currentColor" version="1.1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M3 13h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 7h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1zM3 19h18c0.552 0 1-0.448 1-1s-0.448-1-1-1h-18c-0.552 0-1 0.448-1 1s0.448 1 1 1z"></path></svg>
               </div>
               
               <ul class="nav-header nav pc">
                  <li class="enlaces"><a href="/" class="menu-link">Inicio</a></li>
                  <li class="enlaces"><a :href="dataServer.pathDim + '/professional'" class="menu-link">Cuenta</a></li>
                  <li class="enlaces">
                     <a href="#" class="menu-link">CURSOS ONLINE</a>
                     <ul>
                        <li class="submenu"><a href="/curso-online-de-iniciacion-a-la-reprogramacion">CURSO ONLINE INICIACION A LA REPROGRAMACIÓN</a></li>
                        <li class="submenu"><a href="/charlas-formativas-chiptuning">CHARLAS FORMATIVAS CHIPTUNING</a></li>
                     </ul>
                  </li>
                  <li class="enlaces"><a href="/contactanos" class="menu-link">CONTÁCTANOS</a></li>
                  <li class="enlaces"><a href="/blog" class="menu-link">BLOG</a></li>
               </ul>
            </nav>

        </div>
      </div>
    </div>
  </div>

   <div class="nav-sub">
      <a class="item radius-l" :href="dataServer.pathDim + '/professional/orders'">Lista Ordenes</a>
      <a class="item" :href="dataServer.pathDim + '/professional/createorder'">Crear Ordenes</a>
      <a class="item radius-r" :href="dataServer.pathDim + '/professional/credits'">Solicitar Creditos</a>
   </div>
</template>

<script>
   export default {
      data() {
         return {
            dataServer: dataServer,
            menuNavActive: false,
         };
      },
   };

</script>

<style lang="scss">

   .nav-sub{
         margin: auto;
         display: flex;
         justify-content: center;
         margin: 40px 0;

         .radius-r{
            border-radius: 0 5px 5px 0;
         }

         .radius-l{
            border-radius: 5px 0 0 5px;
         }

         .item{
            text-transform: uppercase;
            background: white;
            color: black;
            padding: 15px;
            display: block;
            font-size: 13px;
            font-weight: 600;
            box-shadow: rgb(60 64 67 / 30%) 0px 1px 2px 0px, rgb(60 64 67 / 15%) 0px 1px 3px 1px;

            &:hover{
               background: #f5f5f5;
            }

         }

      }


   .fondo-header {
      height: 135px;
      background: url(https://dimspainfiles.work4green.org/wp-content/uploads/2021/11/headertop.png) !important;
   }

   .contenedor-header {
      max-width: 1240px;
      margin-left: auto;
      margin-right: auto;
      padding-left: 20px;
      padding-right: 20px;
   }
   .grid-header {
      display: grid;
      grid-template-columns: auto auto;
   }
   .head-logotipo {
      display: flex;
      padding: 1em 0;
   }
   .head-logotipo img {
      padding-top: 10px;      
   }
   .head-menu {
      display: flex;
      justify-content: flex-end;
   }
   .nav-header {
      display: flex;
      flex-wrap: wrap;
      list-style: none;
   }
   .nav-header .menu-link {
      text-decoration: none;
      padding: 0 1em;
      display: inline-block;
      transition: all 0.2s linear;
      color: #fff;
      text-transform: uppercase;
      font-size: 14px;
   }

   .nav-header .enlaces {
      line-height: 54px;
   }

   .nav > li {
      float: left;
   }

   .nav li a {
      color: #fff;
      text-decoration: none;
   }

   .nav li a:hover {
   }

   .nav li ul {
      list-style: none;
      display: none;
      position: absolute;
      min-width: 140px;
   }

   .nav li:hover > ul {
      display: block;
      padding: 0px;
   }

   li.enlaces:hover {
      z-index: 3;
   }

   .nav li ul li {
      background: #171818;
      position: relative;
      box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
   }
   .nav li ul li:last-child {
      border-radius: 0px 0px 10px 10px;
   }
   .nav li ul li:hover {
      background: #323232;
   }

   .nav li ul li ul {
      right: -140px;
      top: 0px;
   }
   .submenu {
      padding-left: 15px;
      padding-right: 15px;
      min-width: 165px;
      z-index: 2;
      text-transform: uppercase;

      line-height: 20px;
      padding: 10px;
      border-bottom: solid 1px #ffffff40;

   }

   .desplegar {text-align: right;margin-top: -40px;padding-right: 30px;}
   .submenu a {font-size: 13.4px;}

   @media only screen and (min-width: 992px) {
      .pc {
         display: block;
      }
      .movil {
         display:none;
      }
      .pc.desplegar {
         display:none;
      }
      .head-logotipo img {
         width:310px;
      }
   }


   @media only screen and (max-width: 991px) {
      .pc {display:none;}
      .movil {display:block;}
      .pc.desplegar {display:block;}
      .img-fluid {width: 100%;}
      .head-logotipo img {width:60%;}
      .grid-header {grid-template-columns: auto;}
      .nav-header {margin: 0;padding-top: 34px;padding-left: 0;}
      .nav > li {background: #262528;position: relative;z-index: 2;width: 100%;}
      .contenedor-header {padding-left: 0px; padding-right: 0px;}
      .head-logotipo {padding: 40px 20px 0px 20px;}
      svg {fill: #ffffff!important;}
      .nav-header .enlaces {line-height: 41.04px;padding-left: 5px;}
      .logo-footer {padding-top: 53px;text-align: center;}
      .imgfooter {width: 120px;height: auto;}
      .linksabajo {text-align: center!important;font-size: 12px;width: 100%;padding-top: 0px!important;}
      .cont-footer {grid-template-columns: auto!important;}
      .movilimg {display:none;}
   }

   
</style>