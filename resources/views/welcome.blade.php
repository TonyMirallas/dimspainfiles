<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dimsport</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="{{asset('img/favicon.png')}}">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">


  </head>
  <body>

    <div id="app">
      
      <a href="https://dimspainfiles.es/dim/public/technical"> comercial </a>
      <a href="https://dimspainfiles.es/dim/public/technical"> técnico </a>

    </div>
    <style>

        #app{
          background-color: #1a202c;
          height: 100vh;
          width: 100vw;
          display: flex;
          justify-content: center;
          align-items: center;
        }

        a{
          color: wheat;
          font-size: 20px;
          padding: 20px;
          text-transform: uppercase;
        }

        a:hover{
          color: #ffc107;
        }

    </style>


  </body>
</html>