<?php
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\RenderViews;

use App\Services\SageAPI;

use App\Models\Invoice;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/technical/test', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Technical
Route::get('/technical', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/account/settings', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/account/exit', [RenderViews::class, 'technicalAccountExit'])->middleware('wp.auth');

// Technical Customer
Route::get('/technical/customer/list', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Technical Lead
Route::get('/technical/{entityType}/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/{entityType}/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/{entityType}/profile/company/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/{entityType}/profile/contacts/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/{entityType}/profile/tracing/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/{entityType}/profile/invoice/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Technical Invoice
Route::get('/technical/invoice/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/invoice/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/invoice/create/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Technical tracing
Route::get('/technical/tracing/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/tracing/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/tracing/create/{entityId}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Technical Product
Route::get('/technical/products/activated', [RenderViews::class, 'technical'])->middleware('wp.auth');
Route::get('/technical/products/all', [RenderViews::class, 'technical'])->middleware('wp.auth');


// Esto es temporal, tony tendrá que hacer una función especifica
Route::get('/technical/invoice/pdf/{id}', function ($id) {

    if($id){
        $invoice = Invoice::find($id);

        if(!$invoice)
            return "No existe el archivo";

        $code = $invoice->code;
    }

    if(!Storage::disk('local')->exists('invoices/' . $code . '.pdf'))
    return "No existe el archivo";

    $path = storage_path('app/invoices/' . $code . '.pdf');
    $file = $code . '.pdf';

    $header = [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $file . '"'
    ];

    return response()->file($path, $header);

})->middleware('wp.auth');


// --------------------
// Route::get('/technical/comercial/clients', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/comercial/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/comercial/task', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/comercial/task/created', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Route::get('/technical/orders/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/orders/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/orders/{id}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Route::get('/technical/professional/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/professional/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/professional/{id}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Route::get('/technical/distributor/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/distributor/create', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/distributor/{id}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Route::get('/technical/credit-orders/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/credit-orders-resolved/list', [RenderViews::class, 'technical'])->middleware('wp.auth');
// Route::get('/technical/credit-orders/{id}', [RenderViews::class, 'technical'])->middleware('wp.auth');

// Despues del cambio de diseño
// Route::get('/technical/lead/{id}', [RenderViews::class, 'technical'])->middleware('wp.auth');



// Distributor
// Route::get('/distributor', [RenderViews::class, 'distributor'])->middleware('wp.auth');
// Route::get('/distributor/account/settings', [RenderViews::class, 'distributor'])->middleware('wp.auth');
// Route::get('/distributor/account/exit', [RenderViews::class, 'distributorAccountExit'])->middleware('wp.auth');

// Route::get('/distributor/professional/list', [RenderViews::class, 'distributor'])->middleware('wp.auth');
// Route::get('/distributor/professional/{id}', [RenderViews::class, 'distributor'])->middleware('wp.auth');


// // Profesional
// Route::get('/professional', [RenderViews::class, 'professional'])->middleware('wp.auth');
// Route::get('/professional/credits', [RenderViews::class, 'professional'])->middleware('wp.auth');
// Route::get('/professional/orders', [RenderViews::class, 'professional'])->middleware('wp.auth');
// Route::get('/professional/createorder', [RenderViews::class, 'professional'])->middleware('wp.auth');



// SAGE
Route::get('/sage/login', [SageAPI::class, 'login']);
