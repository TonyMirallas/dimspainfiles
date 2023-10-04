<!doctype html>
<html lang="{{ app()->getLocale() }}">
      <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1">
         <title>Laravel</title>
         <link rel="preconnect" href="https://fonts.googleapis.com">
         <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
         <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
        <link href="{{asset('css/app.css')}}" rel="stylesheet">
      </head>
    <body>
      
      <div id="app" class="app-distributor">
        <distributor-nav-top></distributor-nav-top>
        <router-view></router-view>
      </div>

      <script>
        @isset($data_server)
        const dataServer = {!! json_encode($data_server) !!};
        dataServer.pathDim = '/dim/public';
        dataServer.images = { technical_logo: "{{asset('img/logo.png')}}",  }
        @endisset
      </script> 
      <script src="{{asset('js/app.js')}}"></script> 

    </body>
</html>