<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;

use App\Http\Controllers\CRM\UserController;
use App\Http\Controllers\CRM\SageController;
use App\Http\Controllers\CRM\LeadController;
use App\Http\Controllers\CRM\CustomerController;
use App\Http\Controllers\CRM\ProductController;
use App\Http\Controllers\CRM\InvoiceController;
use App\Http\Controllers\CRM\TaskController;

use App\Http\Controllers\CRM\AuthController;

use App\Mail\SendInvoice;

use Illuminate\Support\Facades\Crypt;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

// Globals
Route::get('/v1/get-data', [TechnicalController::class, 'getData']);

// Technicals
Route::get('/v1/get-technicals', [TechnicalController::class, 'getTechnicals']);

Route::get('/v1/get-technical', [TechnicalController::class, 'getTechnical']);

Route::post('/v1/post-technical', [TechnicalController::class, 'postTechnical']);

// Professional
Route::get('/v1/get-professionals', [ProfessionalController::class, 'getProfessionals']);

Route::get('/v1/get-professional', [ProfessionalController::class, 'getProfessional']);

Route::get('/v1/get-professional-files', [ProfessionalController::class, 'getProfessionalFiles']);

Route::post('/v1/post-professional', [ProfessionalController::class, 'postProfessional']);

Route::post('/v1/update-professional', [ProfessionalController::class, 'updateProfessional']);


// Distributor
Route::get('/v1/get-distributors', [DistributorController::class, 'getDistributors']);

Route::get('/v1/get-distributor', [DistributorController::class, 'getDistributor']);

Route::get('/v1/get-distributor-professionals', [DistributorController::class, 'getDistributorProfessionals']);

Route::post('/v1/post-distributor', [DistributorController::class, 'postDistributor']);

Route::post('/v1/update-distributor', [DistributorController::class, 'updateDistributor']);

// Payment
Route::get('/v1/get-payments', [PaymentController::class, 'getPayments']);

Route::get('/v1/get-payment', [PaymentController::class, 'getPayment']);

Route::post('/v1/post-payment', [PaymentController::class, 'postPayment']); // Nuevo pago sin order (Para paquetes de créditos y Distributors)

Route::post('/v1/update-payment', [PaymentController::class, 'updatePayment']); // Actualizar pago { id, status = ['Processing', 'Completed', 'Refunded', 'Canceled', 'Pending', 'Requested', 'Accepted'] }

Route::post('/v1/refund-payment', [PaymentController::class, 'refundPayment']); // Esta es la de devolución { id }

// Order
Route::get('/v1/get-orders', [OrderController::class, 'getOrders']);

Route::get('/v1/get-order', [OrderController::class, 'getOrder']);

Route::get('/v1/get-order-professional', [OrderController::class, 'getOrdersByProfessional']);

Route::post('/v1/post-order', [OrderController::class, 'postOrder']); // Nueva orden con todos los datos de order y payment (la antigua postPayment)
Route::post('/v1/post-order-file-upload', [OrderController::class, 'fileUploadFPF']); 
Route::get('/v1/post-order-file-download/{professional_id}/{file_name}', [OrderController::class, 'fileDownloadFPF']); 

Route::post('/v1/update-order', [OrderController::class, 'updateOrderStatus']); // id orden - status - id technical

/* CRM */

// Users
Route::get('/v1/get-users', [UserController::class, 'getUsers']);
Route::get('/v1/get-user', [UserController::class, 'getUser']);

// Customers
Route::get('/v1/get-customer', [CustomerController::class, 'getCustomer']); 
Route::get('/v1/get-customers', [CustomerController::class, 'getCustomers']); 
Route::post('/v1/post-customer', [CustomerController::class, 'postCustomer']); 
Route::delete('/v1/delete-customer', [CustomerController::class, 'deleteCustomer']); 
Route::post('/v1/post-contact-customer', [CustomerController::class, 'postContactCustomer']); 
Route::post('/v1/put-customer', [CustomerController::class, 'putCustomer']); 
Route::post('/v1/put-contact', [CustomerController::class, 'putContact']); 
Route::get('/v1/get-customer-product', [CustomerController::class, 'getCustomerProduct']); 

// Products
Route::get('/v1/get-product', [ProductController::class, 'getProduct']); 
Route::get('/v1/get-products', [ProductController::class, 'getProducts']); 

// Invoices
Route::get('/v1/get-invoice', [InvoiceController::class, 'getInvoice']); 
Route::get('/v1/get-invoices', [InvoiceController::class, 'getInvoices']); 
Route::post('/v1/post-invoice', [InvoiceController::class, 'postInvoice']); 
Route::post('/v1/put-invoice', [InvoiceController::class, 'putInvoice']); 
Route::post('/v1/view-pdf', [InvoiceController::class, 'viewPdf']); 
Route::get('/v1/view-pdf-test', [InvoiceController::class, 'viewPdfTest']); 
Route::post('/v1/send-email', [InvoiceController::class, 'sendEmail']); 

// Tasks
Route::get('/v1/get-task', [taskController::class, 'getTask']); 
Route::get('/v1/get-tasks', [taskController::class, 'getTasks']); 
Route::post('/v1/post-task', [taskController::class, 'postTask']); 
Route::post('/v1/put-task', [taskController::class, 'putTask']); 

// Funcionalities
Route::post('/v1/import-csv', [CustomerController::class, 'importCSV']); 

/* Sage */

// Token and Health
Route::get('/v1/sage-token', [SageController::class, 'token']);
Route::get('/v1/sage-health', [SageController::class, 'health']);

// Sage
Route::get('/v1/sage-customers', [SageController::class, 'customers']);

// Products
Route::get('/v1/sage-products', [SageController::class, 'products']);
Route::get('/v1/sage-stock', [SageController::class, 'stock']);

});

/* Authenticate */
Route::post('/v1/register', [AuthController::class, 'register'])->name('register');
Route::post('/v1/login', [AuthController::class, 'login'])->name('login');
Route::get('/v1/unauthenticated', [AuthController::class, 'unauthenticated'])->name('unauthenticated');
Route::get('/v1/test-token', [AuthController::class, 'testToken']);

