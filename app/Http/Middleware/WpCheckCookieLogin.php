<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\Professional;
use App\Models\Distributor;
use App\Models\Technical;
use App\Models\User;

use App\Services\GetData;

class WpCheckCookieLogin
{
   /**
    * Handle an incoming request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \Closure  $next
    * @return mixed
    */
   static public function handle(Request $request, Closure $next)
   {

      // Get the value of the array that starts with wordpress_logged_in
      $wordpress_logged_in = array_values(array_filter($_COOKIE, function ($key) {
         return strpos($key, 'wordpress_logged_in') === 0;
      }, ARRAY_FILTER_USE_KEY));

      // Check $wordpress_logged_in empty
      if (empty($wordpress_logged_in)) {
         abort(403, 'Acceso no autorizado');
      }

      // Request edpoint check is login or not send param wordpress_logged_in
      $response = \Http::post(config('global.base_url') . 'wp-json/user/islogin', [
         'wordpress_logged_in' => $wordpress_logged_in[0]
      ]);

      $data = $response->json();

      $uri = $request->route()->uri;

      if (!$response->successful() || !$data['islogin'] || strpos($uri, $data['user']['rol'] ) === false ) {

         abort(403, 'Acceso no autorizado');

      }

      $auth = null;

      if($data['user']['rol'] == 'technical'){

         $auth = User::where('name', $data['user']['user_login'])
         ->orWhere('email', $data['user']['user_email'])
         ->first();

         $user = User::where('email', 'admin@test.es')->first();
         $token = $user->createToken('auth_token')->plainTextToken;
         $auth->token = $token;

      }

      if($data['user']['rol'] == 'professional'){

         $auth = Professional::where('user', $data['user']['user_login'])
         ->orWhere('email', $data['user']['user_email'])
         ->first();

         // Check if user is active
         if($auth->state != 1 && $auth->state != '1'){
            abort(403, 'Tu cuenta esta desactivada, contacta con ayuda@dimspainfiles.es');
         }
         
         $checkCredits = new GetData();
         $auth->credits = $checkCredits->getCredits($auth);

      }

      if($data['user']['rol'] == 'distributor'){

         $auth = Distributor::where('user', $data['user']['user_login'])
         ->orWhere('email', $data['user']['user_email'])
         ->first();

         // Check if user is active
         if($auth->state != 1 && $auth->state != '1'){
            abort(403, 'Tu cuenta esta desactivada, contacta con ayuda@dimspainfiles.es');
         }

         $checkCredits = new GetData();
         $auth->credits = $checkCredits->getCredits($auth);         
         
      }

      if(empty($auth)){
         abort(403, 'Usuario no dado de alta en dim');
      }

      $input = $request->all();
      $input["auth"] = $auth;
      $request->replace($input);

      return $next($request);

   }

}
