<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GetController;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\CronController;
use App\Http\Controllers\LdapController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\LaphalController;
use App\Http\Controllers\ScoresController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\RecoveryController;
use App\Http\Controllers\SageFileController;
use App\Http\Controllers\SearcherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RecordingController;
use App\Http\Controllers\DataLoaderController;
use App\Http\Controllers\OutOfStockController;
use App\Http\Controllers\PermissionsController;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\OrderDisputeController;
use App\Http\Controllers\RecordingSearchController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    app()->setLocale(session()->get('locale', 'en'));

    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'Dashboard'], function (Request $request) {})->middleware(['auth', 'verified']);

//rutas accesibles solo para admins
//Route::group(['middleware' => ['role:Admin|SuperAdmin|It']], function () {

    Route::get('/admin/users', [UsersController::class, 'users'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/new-user', [UsersController::class, 'newUser'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/admin/create-user', [UsersController::class, 'createUser'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/edit-user/{id}', [UsersController::class, 'editUser'], function (Request $request, string $id) {})->middleware(['auth', 'verified']);
    Route::post('/admin/update-user', [UsersController::class, 'updateUser'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/admin/user-roles/{id}', [UsersController::class, 'userRoles'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
    Route::get('/admin/add-user-rol/{id}/rol/{role}', [UsersController::class, 'addUserRol'], function (Request $request, int $id, string $role) {})->middleware(['auth', 'verified']);
    Route::get('/admin/delete-user-rol/{id}/rol/{role}', [UsersController::class, 'deleteUserRol'], function (Request $request, int $id, string $role) {})->middleware(['auth', 'verified']);

    Route::get('/admin/roles', [RolesController::class, 'roles'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/new-rol', [RolesController::class, 'newRol'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/admin/create-rol', [RolesController::class, 'createRol'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/view-rol/{id}', [RolesController::class, 'viewRol'], function (Request $request, string $id) {})->middleware(['auth', 'verified']);
    Route::get('/admin/add-rol-perm/{id}/perm/{role}', [RolesController::class, 'addRolPerm'], function (Request $request, int $id, string $role) {})->middleware(['auth', 'verified']);
    Route::get('/admin/revoke-rol/{id}', [RolesController::class, 'revokeRol'], function (Request $request, string $id) {})->middleware(['auth', 'verified']);
    Route::get('/admin/view-rol-users/{id}', [RolesController::class, 'viewRolUsers'], function (Request $request, string $id) {})->middleware(['auth', 'verified']);
    Route::get('/admin/delete-rol-perm/{perm}/rol/{rol}', [RolesController::class, 'deleteRolPerm'], function (Request $request, int $perm, int $rol) {})->middleware(['auth', 'verified']);

    Route::get('/admin/permissions', [PermissionsController::class, 'permissions'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/new-permission', [PermissionsController::class, 'newPermission'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/admin/create-permission', [PermissionsController::class, 'createPermission'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/delete-permission/{id}/perm/{perm}', [PermissionsController::class, 'deletePermission'], function (Request $request, int $id, string $perm) {})->middleware(['auth', 'verified']);
    Route::get('/admin/view-perm-roles/{id}', [PermissionsController::class, 'viewPermRoles'], function (Request $request, string $id) {})->middleware(['auth', 'verified']);

    Route::get('/admin/permissions-table', [PermissionsController::class, 'permissionsTable'])->middleware(['auth', 'verified']);
    Route::post('/admin/savePermission', [PermissionsController::class, 'savePermission'])->name('savePermission');

//});

//Route::group(['middleware' => ['role:DataLoader|SuperAdmin|It']], function () {

    Route::get('/admin/dataloader/sage', [DataLoaderController::class, 'sage'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/admin/dataloader/send-sage', [DataLoaderController::class, 'sendSage'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/dataloader/gls', [DataLoaderController::class, 'gls'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/admin/dataloader/send-gls', [DataLoaderController::class, 'sendGls'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/admin/dataloader/proof', [DataLoaderController::class, 'proof'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/admin/dataloader/proof-upload', [DataLoaderController::class, 'proofUpload'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/dataloader/proof-delete', [DataLoaderController::class, 'proofDelete'], function (Request $request) {})->middleware(['auth', 'verified']);


    Route::post('/admin/dataloader/send-proof', [DataLoaderController::class, 'sendProof'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/dataloader/delete-proof/{id}', [DataLoaderController::class, 'deleteProofFile'], function (Request $request, int $id) {});
//});

//Route::group(['middleware' => ['role:Searcher|SuperAdmin|It']], function () {

    Route::get('/admin/searcher/main', [SearcherController::class, 'main'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/searcher/search', [SearcherController::class, 'search'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/admin/searcher/view-product/{id}', [SearcherController::class, 'viewProduct'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);

//});

// La saco porque me da problemas desde el email, cuando no esta logeado


//Route::group(['middleware' => ['role:Ticketing|SuperAdmin|It']], function () {

    Route::get('/ticketing', [TicketController::class, 'main'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/manage', [TicketController::class, 'manage'], function (Request $request) {})->middleware(['auth', 'verified'])->name('manage');
    Route::get('/ticketing/new-category', [TicketController::class, 'newCategory'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::post('/ticketing/create-category', [TicketController::class, 'createCategory'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/edit-category/{id}', [TicketController::class, 'editCategory'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
    Route::post('/ticketing/update-category', [TicketController::class, 'updateCategory'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/new-ticket', [TicketController::class, 'newTicket'], function (Request $request) {})->middleware(['auth', 'verified'])->name('newticket');
    Route::post('/ticketing/create-ticket', [TicketController::class, 'createTicket'], function (Request $request) {})->middleware(['auth', 'verified'])->name('createticket');

    Route::get('/ticketing/edit-ticket/{id}', [TicketController::class, 'editTicket'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
    Route::post('/ticketing/update-ticket', [TicketController::class, 'updateTicket'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/ticketing/new-status', [TicketController::class, 'newStatus'], function (Request $request) {})->middleware(['auth', 'verified'])->name('newstatus');
    Route::post('/ticketing/create-status', [TicketController::class, 'createStatus'], function (Request $request) {})->middleware(['auth', 'verified'])->name('createstatus');
    Route::get('/ticketing/edit-status/{id}', [TicketController::class, 'editStatus'], function (Request $request, int $id) {});
    Route::post('/ticketing/update-status', [TicketController::class, 'updateStatus'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/ticketing/delete-file/{id}', [TicketController::class, 'deleteFile'], function (Request $request, int $id) {});

    Route::any('/ticketing/search-ticket', [TicketController::class, 'searchTicket'], function (Request $request) {})->middleware(['auth', 'verified'])->name('manage');

    Route::get('/ticketing/dashboard-admin', [TicketController::class, 'dashboardAdmin'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::any('/ticketing/search-admin-ticket', [TicketController::class, 'searchAdminTicket'], function (Request $request) {})->middleware(['auth', 'verified'])->name('manage');
/*
    Route::get('/ticketing/dashboard-after-sales', [TicketController::class, 'dashboardAfterSales'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-logistics', [TicketController::class, 'dashboardLogistics'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-production', [TicketController::class, 'dashboardProduction'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-accounting', [TicketController::class, 'dashboardAccounting'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-legal', [TicketController::class, 'dashboardLegal'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/ticketing/dashboard-it', [TicketController::class, 'dashboardIT'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-litigation', [TicketController::class, 'dashboardLitigation'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/ticketing/dashboard-after-sales-new', [TicketController::class, 'dashboardAfterSalesNew'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-logistics-new', [TicketController::class, 'dashboardLogisticsNew'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/ticketing/dashboard-production-new', [TicketController::class, 'dashboardProductionNew'], function (Request $request) {})->middleware(['auth', 'verified']);
*/
    Route::get('/ticketing/department-dashboard/{department}', [TicketController::class, 'departmentDashboard'], function (Request $request, string $department) {})->middleware(['auth', 'verified']);

//});

    Route::get('/file-generator/ecommerce-sage', [SageFileController::class, 'ecommerceSage'], function (Request $request) {})->middleware(['auth', 'verified'])->name('ecommerceSage');
    Route::get('/file-generator/generate-sage-file', [SageFileController::class, 'generateSageFileFromEcommerce'], function (Request $request) {})->middleware(['auth', 'verified'])->name('generateSageFileFromEcommerce');
    Route::get('/file-generator/generate-sage-file-cron', [SageFileController::class, 'generateSageFileFromEcommerceCron'], function (Request $request) {})->middleware(['auth', 'verified'])->name('managenerateSageFileFromEcommerceCronge');


//Route::group(['middleware' => ['role:Scores|SuperAdmin|It']], function () {
    Route::get('/scoring/pharmacies', [ScoresController::class, 'pharmacies'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/scoring/pharmacy-scoring/{id}', [ScoresController::class, 'pharmacyScoring'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
    Route::post('/scoring/update-score-manual', [ScoresController::class, 'updateScore'], function (Request $request) {})->middleware(['auth', 'verified'])->name('manage');
    Route::any('/scoring/search', [ScoresController::class, 'search'], function (Request $request) {})->middleware(['auth', 'verified']);

    Route::get('/scoring/laboratories', [ScoresController::class, 'laboratories'], function (Request $request) {})->middleware(['auth', 'verified']);
    Route::get('/scoring/laboratory-change-status/{id}', [ScoresController::class, 'changeStatus'], function (Request $request, int $id) {})->middleware(['auth', 'verified'])->name('manage');
//});


Route::group(['middleware' => ['permission:Manage']], function () {

});

Route::group(['middleware' => ['role_or_permission:Manage']], function () {

});

// Web service for getting the pharmacy score
Route::get('/scoring/get-score/{pharmacy}', [ScoresController::class, 'getScore'], function (Request $request, int $pharmacy) {});

// Web service for updating score for pharmacy / laboratorie
Route::get('/scoring/update-score/pharmacy/{pharmacy}/laboratory/{laboratory}/score/{score}',
    [ScoresController::class, 'updateScoreForPharmacy'], function (Request $request, string $pharmacy, string $laboratory, string $score) {});

Route::get('/autocomplete-ordernum', [AutocompleteController::class, 'autocompleteOrderNum'], function (Request $request) {});
Route::get('/autocomplete-cip', [AutocompleteController::class, 'autocompleteCip'], function (Request $request) {});

Route::get('/get-order-num', [GetController::class, 'getOrderNum'], function (Request $request) {});
Route::get('/get-cip-from-order-id', [GetController::class, 'getCipFromOrderNum'], function (Request $request) {});

Route::get('/get-category-for-type', [GetController::class, 'getCategoryFromType'], function (Request $request) {});
Route::get('/get-status-for-category', [GetController::class, 'getStatusFromCategory'], function (Request $request) {});
Route::get('/get-level-1-for-status', [GetController::class, 'getLevel1forStatus'], function (Request $request) {});
Route::get('/get-level-2-for-level-1', [GetController::class, 'getLevel2forLevel1'], function (Request $request) {});
Route::get('/get-level-3-for-level-2', [GetController::class, 'getLevel3forLevel2'], function (Request $request) {});
Route::get('/get-level-4-for-level-3', [GetController::class, 'getLevel4forLevel3'], function (Request $request) {});
Route::get('/get-level-5-for-level-4', [GetController::class, 'getLevel5forLevel4'], function (Request $request) {});


Route::get('/get-orders-from-comandes', [CronController::class, 'getOrdersFromComandes'], function (Request $request) {});
Route::get('/get-orders-from-ecommerce', [CronController::class, 'getOrdersFromEcommerce'], function (Request $request) {});
Route::get('/get-orders-from-sage', [CronController::class, 'getOrdersFromSage'], function (Request $request) {});
Route::get('/get-orders-from-cmc', [CronController::class, 'getOrdersFromCMC'], function (Request $request) {});
Route::get('/get-recordings-from-hermes', [CronController::class, 'getRecordingsFroHermes'], function (Request $request) {});
Route::get('/index-recordings-from-hermes', [CronController::class, 'indexRecordingsFromHermes'], function (Request $request) {});
Route::get('/get-proof-of-delivery', [CronController::class, 'getProofOfDeliveries'], function (Request $request) {});
Route::get('/delete-temp-recordings', [CronController::class, 'deleteTempRecordings'], function (Request $request) {});
Route::get('/send-customer-accepts-mail', [CronController::class, 'sendCustomerAcceptsMail'], function (Request $request) {});
Route::get('/update-adare-clients', [CronController::class, 'updateAdareClients'], function (Request $request) {});
Route::get('/get-clients-from-ecommerce', [CronController::class, 'getClientsFromEcommerce'], function (Request $request) {});
Route::get('/update-product-discounts', [CronController::class, 'updateProductDiscounts'], function (Request $request) {});

Route::get('/order/view-order/{id}', [OrderController::class, 'viewOrder'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);

Route::get('/download-ticket/{id}', [DownloadController::class, 'getDownloadTicket'], function (Request $request, int $id) {})->name('download.ticket');

Route::get('/download-proof/{id}', [DownloadController::class, 'getDownloadProof'], function (Request $request, int $id) {})->name('download.proof');
Route::get('/file-proof/{id}', [DownloadController::class, 'getFileProof'], function (Request $request, int $id) {})->name('get.file.proof');

Route::get('/download-recording/{id}', [DownloadController::class, 'getDownloadRecording'], function (Request $request, int $id) {})->name('download.recording');
Route::get('/download-recording-search/{id}', [DownloadController::class, 'getDownloadRecordingSearch'], function (Request $request, int $id) {})->name('download.recording.search');

Route::get('/download-invoice/{id}/{name}/{type}', [DownloadController::class, 'getDownloadInvoice'], function (Request $request, int $id, string $name, string $type) {})->name('download.invoice');

Route::get('/ldapSynchronization', [LdapController::class, 'ldapSynchronization'])->name('ldapSynchronization');

// Documents
Route::get('/documents', [DocumentController::class, 'main'])->name('document.main')->middleware(['auth', 'verified']);
Route::get('/documents-active', [DocumentController::class, 'mainActive'])->name('document.mainActive')->middleware(['auth', 'verified']);
Route::get('/documents-new-document', [DocumentController::class, 'newDocument'])->name('document.new')->middleware(['auth', 'verified']);
Route::post('/documents-create-document', [DocumentController::class, 'createDocument'], function (Request $request) {})->name('document.create')->middleware(['auth', 'verified']);
Route::get('/documents-edit-document/{id}', [DocumentController::class, 'editDocument'], function (Request $request, int $id) {})->name('document.edit')->middleware(['auth', 'verified']);
Route::post('/documents-update-document', [DocumentController::class, 'updateDocument'], function (Request $request) {})->name('document.update')->middleware(['auth', 'verified']);
Route::any('/documents-search', [DocumentController::class, 'documentSearch'])->name('document.search')->middleware(['auth', 'verified']);

Route::get('/documents-delete-file/{id}', [DocumentController::class, 'deleteFile'], function (Request $request, int $id) {})->name('document.delete.file');

Route::get('/download-document/{id}', [DownloadController::class, 'getDownloadDocument'], function (Request $request, int $id) {})->name('download.document');

// Recordings
Route::get('/recordings-change-status/{record_id}/{order_id}', [RecordingController::class, 'RecordingsChangeStatus'], function (Request $request, int $record_id, int $order_id) {})->name('recording.change.status')->middleware(['auth', 'verified']);

// Out of stocks
Route::get('/products-out-of-stock', [OutOfStockController::class, 'productsOutOfStock'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/new-products-out-of-stock', [OutOfStockController::class, 'newProductsOutOfStock'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::post('/create-products-out-of-stock', [OutOfStockController::class, 'createProductsOutOfStock'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/edit-products-out-of-stock/{id}', [OutOfStockController::class, 'editProductsOutOfStock'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
Route::post('/update-products-out-of-stock', [OutOfStockController::class, 'updateProductsOutOfStock'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/delete-products-out-of-stock/{id}', [OutOfStockController::class, 'deleteProductsOutOfStock'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);

Route::get('/product-list/{search?}', [GetController::class, 'productList'], function (Request $request, ?string $search) {});

// Recording Search
Route::get('/recording-search/main', [RecordingSearchController::class, 'main'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::any('/recording-search/search', [RecordingSearchController::class, 'search'], function (Request $request) {})->middleware(['auth', 'verified']);

// Order Dispute
Route::get('/search-order-dispute/main', [OrderDisputeController::class, 'main'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/list-open', [OrderDisputeController::class, 'listOpen'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/list-closed', [OrderDisputeController::class, 'listClosed'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::post('/search-order-dispute/search', [OrderDisputeController::class, 'search'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::post('/search-order-dispute/search-list', [OrderDisputeController::class, 'searchList'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/save-dispute/{orderId}', [OrderDisputeController::class, 'saveDispute'], function (Request $request, int $orderId) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/tick/{id}', [OrderDisputeController::class, 'tick'], function (Request $request, int $id) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/status/{orderNum}/show/{status}', [OrderDisputeController::class, 'status'], function (Request $request, int $orderNum) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/view/{orderNum}', [OrderDisputeController::class, 'view'], function (Request $request, string $orderNum, string $status) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/qrcode/{orderNum}', [OrderDisputeController::class, 'generateQRCode'], function (string $orderNum) {})->middleware(['auth', 'verified']);
Route::get('/search-order-dispute/validate/{orderNum}', [OrderDisputeController::class, 'validateDispute'], function (string $orderNum) {})->middleware(['auth', 'verified']);

Route::get('/laphal/check-file', [LaphalController::class, 'main'])->middleware(['auth', 'verified']);
Route::post('/laphal/send-file', [LaphalController::class, 'sendFile'], function (Request $request) {})->middleware(['auth', 'verified']);

Route::get('/recovery/blocked-customers', [RecoveryController::class, 'blockedCustomers'])->middleware(['auth', 'verified']);
Route::post('/recovery/add-file', [RecoveryController::class, 'addFile'], function (Request $request) {})->middleware(['auth', 'verified']);
Route::post('/recovery/delete-file', [RecoveryController::class, 'deleteFile'], function (Request $request) {})->middleware(['auth', 'verified']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('language/{locale}', function ($locale) {
    App::setLocale($locale);
    session()->put('locale', $locale);

    return redirect()->back();
});

Route::get('/test-gls', [TestController::class, 'test'])->name('testGls');

Route::get('/end-of-day', [TestController::class, 'endOfDay'])->name('endOfDay');

Route::get('/get-parcels', [TestController::class, 'getParcels'])->name('getParcels');

Route::get('/get-pod', [TestController::class, 'getPod'])->name('getPod');






