<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ConsignerController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\BrokerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ConsignmentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ImportCsvController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\API\ReceiveAddressController;

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
Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/', function () {
    if(Auth::check())
    {
       $userrole = Auth::user()->role_id;
        if($userrole == 1){
            return redirect('/admin/dashboard');
        }
        else if($userrole == 2) {
            return redirect('/branch-manager/dashboard');
        }
        else if($userrole == 3) {
            return redirect('/regional-manager/dashboard');
        }
        else if($userrole == 4) {
            return redirect('/branch-user/dashboard');
        }
        else if($userrole == 5) {
            return redirect('/account-manager/dashboard');
        }
        else if($userrole == 6) {
            return redirect('/client-account/dashboard');
        }
    }
   else
    {
      return view('auth.login');
    }
});

Route::get('qrcode', function () {
    return QrCode::size(300)->generate('A basic example of QR code!');
});

// Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('logout', [LoginController::class, 'logout']);

Route::group(['prefix'=>'admin', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);
    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    // Route::resource('brokers', BrokerController::class);
    // Route::post('brokers/update-broker', [BrokerController::class, 'updateBroker']);
    // Route::post('brokers/delete-broker', [BrokerController::class, 'deleteBroker']);
    // Route::post('/brokers/delete-brokerimage', [BrokerController::class, 'deletebrokerImage']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::post('/vehicles/delete-rcimage', [VehicleController::class, 'deletercImage']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::any('clist', [ConsignmentController::class, 'consignment_list']);
    //Test Routes 
    Route::any('testview', [ConsignmentController::class, 'testview']);
    Route::any('test', [ConsignmentController::class, 'test']);
    // Test Routes 
    Route::get('unverified-list', [ConsignmentController::class, 'unverifiedList']);
    Route::any('update_unverifiedLR', [ConsignmentController::class, 'updateUnverifiedLr']);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::get('transaction-sheet', [ConsignmentController::class, 'transactionSheet']);
    Route::any('view-transactionSheet/{id}', [ConsignmentController::class, 'getTransactionDetails']);
    Route::any('print-transaction/{id}', [ConsignmentController::class, 'printTransactionsheet']);
    Route::any('print-sticker/{id}', [ConsignmentController::class, 'printSticker']);
    Route::any('update-edd', [ConsignmentController::class, 'updateEDD']);
    Route::any('create-drs', [ConsignmentController::class, 'CreateEdd']);
    Route::any('update-suffle', [ConsignmentController::class, 'updateSuffle']);
    Route::any('view-draftSheet/{id}', [ConsignmentController::class, 'view_saveDraft']);
    Route::any('update-delivery/{id}', [ConsignmentController::class, 'updateDelivery']);
    Route::any('update-delivery-status', [ConsignmentController::class, 'updateDeliveryStatus']);
    Route::any('consignment-report', [ConsignmentController::class, 'consignmentReports']);
    Route::any('update-delivery-date', [ConsignmentController::class, 'updateDeliveryDateOneBy']);
    Route::any('remove-lr', [ConsignmentController::class, 'removeLR']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);
    Route::any('get-delivery-dateLR', [ConsignmentController::class, 'getDeleveryDateLr']);
    Route::any('update-lrstatus', [ConsignmentController::class, 'updateLrStatus']);

    Route::resource('orders', OrderController::class);
    Route::post('/orders/update-order', [OrderController::class, 'updateOrder']);

    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);
    // Route::any('locations/delete-location', [LocationController::class, 'deleteLocation']);

    Route::get('bulk-import', [ImportCsvController::class, 'getBulkImport']);
    Route::post('consignees/upload_csv', [ImportCsvController::class, 'uploadCsv']); 

    // Route::get('settings/branch-address', [SettingController::class, 'getbranchAddress']);
    Route::any('settings/branch-address', [SettingController::class, 'updateBranchadd']);

    Route::get('/sample-consignees',[ImportCsvController::class, 'consigneesSampleDownload']);
    Route::get('/sample-consigner',[ImportCsvController::class, 'consignerSampleDownload']);
    Route::get('/sample-vehicle',[ImportCsvController::class, 'vehicleSampleDownload']);
    Route::get('/sample-driver',[ImportCsvController::class, 'driverSampleDownload']);
    Route::get('/sample-zone',[ImportCsvController::class, 'zoneSampleDownload']);

    Route::resource('clients', ClientController::class);
    Route::post('/clients/update-client', [ClientController::class, 'UpdateClient']);
    Route::get('reginal-clients', [ClientController::class, 'regionalClients']);
    Route::post('/clients/delete-client', [ClientController::class, 'deleteClient']);
    
});

Route::group(['prefix'=>'branch-manager', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::get('unverified-list', [ConsignmentController::class, 'unverifiedList']);
    Route::any('update_unverifiedLR', [ConsignmentController::class, 'updateUnverifiedLr']);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::get('transaction-sheet', [ConsignmentController::class, 'transactionSheet']);
    Route::any('view-transactionSheet/{id}', [ConsignmentController::class, 'getTransactionDetails']);
    Route::any('print-transaction/{id}', [ConsignmentController::class, 'printTransactionsheet']);
    Route::any('print-sticker/{id}', [ConsignmentController::class, 'printSticker']);
    Route::any('update-edd', [ConsignmentController::class, 'updateEDD']); 
    Route::any('create-drs', [ConsignmentController::class, 'CreateEdd']);
    Route::any('update-suffle', [ConsignmentController::class, 'updateSuffle']);
    Route::any('view-draftSheet/{id}', [ConsignmentController::class, 'view_saveDraft']);
    Route::any('update-delivery/{id}', [ConsignmentController::class, 'updateDelivery']);
    Route::any('update-delivery-status', [ConsignmentController::class, 'updateDeliveryStatus']);
    Route::any('consignment-report', [ConsignmentController::class, 'consignmentReports']);
    Route::any('update-delivery-date', [ConsignmentController::class, 'updateDeliveryDateOneBy']);
    Route::any('remove-lr', [ConsignmentController::class, 'removeLR']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);
    Route::any('bulklr-view', [ConsignmentController::class, 'BulkLrView']);
    Route::any('download-bulklr', [ConsignmentController::class, 'DownloadBulkLr']);

    Route::any('get-delivery-dateLR', [ConsignmentController::class, 'getDeleveryDateLr']);
    Route::any('update-lrstatus', [ConsignmentController::class, 'updateLrStatus']);

    Route::resource('orders', OrderController::class);

    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);

    Route::resource('clients', ClientController::class);

});
Route::group(['prefix'=>'regional-manager', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    // Route::resource('brokers', BrokerController::class);
    // Route::post('brokers/update-broker', [BrokerController::class, 'updateBroker']);
    // Route::post('brokers/delete-broker', [BrokerController::class, 'deleteBroker']);
    // Route::post('/brokers/delete-brokerimage', [BrokerController::class, 'deletebrokerImage']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::post('/vehicles/delete-rcimage', [VehicleController::class, 'deletercImage']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::get('unverified-list', [ConsignmentController::class, 'unverifiedList']);
    Route::any('update_unverifiedLR', [ConsignmentController::class, 'updateUnverifiedLr']);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::get('transaction-sheet', [ConsignmentController::class, 'transactionSheet']);
    Route::any('view-transactionSheet/{id}', [ConsignmentController::class, 'getTransactionDetails']);
    Route::any('print-sticker/{id}', [ConsignmentController::class, 'printSticker']);
    Route::any('print-transaction/{id}', [ConsignmentController::class, 'printTransactionsheet']);
    Route::any('update-edd', [ConsignmentController::class, 'updateEDD']);
    Route::any('create-drs', [ConsignmentController::class, 'CreateEdd']);
    Route::any('update-suffle', [ConsignmentController::class, 'updateSuffle']);
    Route::any('view-draftSheet/{id}', [ConsignmentController::class, 'view_saveDraft']);
    Route::any('update-delivery/{id}', [ConsignmentController::class, 'updateDelivery']);
    Route::any('update-delivery-status', [ConsignmentController::class, 'updateDeliveryStatus']);
    Route::any('consignment-report', [ConsignmentController::class, 'consignmentReports']);
    Route::any('update-delivery-date', [ConsignmentController::class, 'updateDeliveryDateOneBy']);
    Route::any('remove-lr', [ConsignmentController::class, 'removeLR']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);
    Route::any('get-delivery-dateLR', [ConsignmentController::class, 'getDeleveryDateLr']);
    Route::any('update-lrstatus', [ConsignmentController::class, 'updateLrStatus']);

    Route::resource('orders', OrderController::class);

    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);
    // Route::any('locations/delete-location', [LocationController::class, 'deleteLocation']);

    Route::get('bulk-import', [ImportCsvController::class, 'getBulkImport']);
    Route::post('consignees/upload_csv', [ImportCsvController::class, 'uploadCsv']); 

    // Route::get('settings/branch-address', [SettingController::class, 'getbranchAddress']);
    Route::any('settings/branch-address', [SettingController::class, 'updateBranchadd']);

    Route::get('/sample-consignees',[ImportCsvController::class, 'consigneesSampleDownload']);
    Route::get('/sample-consigner',[ImportCsvController::class, 'consignerSampleDownload']);
    Route::get('/sample-vehicle',[ImportCsvController::class, 'vehicleSampleDownload']);
    Route::get('/sample-driver',[ImportCsvController::class, 'driverSampleDownload']);

    Route::resource('clients', ClientController::class);

    
});
Route::group(['prefix'=>'branch-user', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    // Route::resource('brokers', BrokerController::class);
    // Route::post('brokers/update-broker', [BrokerController::class, 'updateBroker']);
    // Route::post('brokers/delete-broker', [BrokerController::class, 'deleteBroker']);
    // Route::post('/brokers/delete-brokerimage', [BrokerController::class, 'deletebrokerImage']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::post('/vehicles/delete-rcimage', [VehicleController::class, 'deletercImage']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::get('unverified-list', [ConsignmentController::class, 'unverifiedList']);
    Route::any('update_unverifiedLR', [ConsignmentController::class, 'updateUnverifiedLr']);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::get('transaction-sheet', [ConsignmentController::class, 'transactionSheet']);
    Route::any('view-transactionSheet/{id}', [ConsignmentController::class, 'getTransactionDetails']);
    Route::any('print-sticker/{id}', [ConsignmentController::class, 'printSticker']);
    Route::any('print-transaction/{id}', [ConsignmentController::class, 'printTransactionsheet']);
    Route::any('update-edd', [ConsignmentController::class, 'updateEDD']);
    Route::any('create-drs', [ConsignmentController::class, 'CreateEdd']);
    Route::any('update-suffle', [ConsignmentController::class, 'updateSuffle']);
    Route::any('view-draftSheet/{id}', [ConsignmentController::class, 'view_saveDraft']);
    Route::any('update-delivery/{id}', [ConsignmentController::class, 'updateDelivery']);
    Route::any('update-delivery-status', [ConsignmentController::class, 'updateDeliveryStatus']);
    Route::any('consignment-report', [ConsignmentController::class, 'consignmentReports']);
    Route::any('update-delivery-date', [ConsignmentController::class, 'updateDeliveryDateOneBy']);
    Route::any('remove-lr', [ConsignmentController::class, 'removeLR']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);
    Route::any('get-delivery-dateLR', [ConsignmentController::class, 'getDeleveryDateLr']);
    Route::any('update-lrstatus', [ConsignmentController::class, 'updateLrStatus']);


    Route::resource('orders', OrderController::class);

    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);
    // Route::any('locations/delete-location', [LocationController::class, 'deleteLocation']);

    Route::get('bulk-import', [ImportCsvController::class, 'getBulkImport']);
    Route::post('consignees/upload_csv', [ImportCsvController::class, 'uploadCsv']); 

    // Route::get('settings/branch-address', [SettingController::class, 'getbranchAddress']);
    Route::any('settings/branch-address', [SettingController::class, 'updateBranchadd']);

    Route::get('/sample-consignees',[ImportCsvController::class, 'consigneesSampleDownload']);
    Route::get('/sample-consigner',[ImportCsvController::class, 'consignerSampleDownload']);
    Route::get('/sample-vehicle',[ImportCsvController::class, 'vehicleSampleDownload']);
    Route::get('/sample-driver',[ImportCsvController::class, 'driverSampleDownload']);

    Route::resource('clients', ClientController::class);

    
});

Route::group(['prefix'=>'account-manager', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);

    
    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);

});
Route::group(['prefix'=>'client-account', 'middleware'=>['auth','PermissionCheck']], function()
{
    Route::resource('dashboard', DashboardController::class);
    Route::resource('/', DashboardController::class);

    Route::resource('users', UserController::class);
    Route::post('/users/update-user', [UserController::class, 'updateUser']);
    Route::post('/users/delete-user', [UserController::class, 'deleteUser']);

    Route::resource('branches', BranchController::class);
    Route::post('branches/update-branch', [BranchController::class, 'updateBranch']);
    Route::post('branches/delete-branch', [BranchController::class, 'deleteBranch']);
    Route::post('branches/delete-branchimage', [BranchController::class, 'deletebranchImage']);

    Route::resource('consigners', ConsignerController::class);
    Route::post('consigners/update-consigner', [ConsignerController::class, 'updateConsigner']);
    Route::post('consigners/delete-consigner', [ConsignerController::class, 'deleteConsigner']);
    Route::get('consigners/export/excel', [ConsignerController::class, 'exportExcel']);

    Route::resource('consignees', ConsigneeController::class);
    Route::post('consignees/update-consignee', [ConsigneeController::class, 'updateConsignee']);
    Route::post('consignees/delete-consignee', [ConsigneeController::class, 'deleteConsignee']);
    Route::get('consignees/export/excel', [ConsigneeController::class, 'exportExcel']);

    // Route::resource('brokers', BrokerController::class);
    // Route::post('brokers/update-broker', [BrokerController::class, 'updateBroker']);
    // Route::post('brokers/delete-broker', [BrokerController::class, 'deleteBroker']);
    // Route::post('/brokers/delete-brokerimage', [BrokerController::class, 'deletebrokerImage']);

    Route::resource('drivers', DriverController::class);
    Route::post('drivers/update-driver', [DriverController::class, 'updateDriver']);
    Route::post('drivers/delete-driver', [DriverController::class, 'deleteDriver']);
    Route::post('/drivers/delete-licenseimage', [DriverController::class, 'deletelicenseImage']);
    Route::get('drivers/export/excel', [DriverController::class, 'exportExcel']);

    Route::resource('vehicles', VehicleController::class);
    Route::post('vehicles/update-vehicle', [VehicleController::class, 'updateVehicle']);
    Route::post('vehicles/delete-vehicle', [VehicleController::class, 'deleteVehicle']);
    Route::post('/vehicles/delete-rcimage', [VehicleController::class, 'deletercImage']);
    Route::get('vehicles/export/excel', [VehicleController::class, 'exportExcel']);

    Route::resource('consignments', ConsignmentController::class);
    Route::get('unverified-list', [ConsignmentController::class, 'unverifiedList']);
    Route::any('update_unverifiedLR', [ConsignmentController::class, 'updateUnverifiedLr']);
    Route::post('consignments/update-consignment', [ConsignmentController::class, 'updateConsignment']);
    Route::post('consignments/delete-consignment', [ConsignmentController::class, 'deleteConsignment']);
    Route::post('consignments/get-consign-details', [ConsignmentController::class, 'getConsigndetails']);
    Route::get('consignments/{id}/print-view/{typeid}', [ConsignmentController::class, 'consignPrintview']);
    Route::get('transaction-sheet', [ConsignmentController::class, 'transactionSheet']);
    Route::any('view-transactionSheet/{id}', [ConsignmentController::class, 'getTransactionDetails']);
    Route::any('print-sticker/{id}', [ConsignmentController::class, 'printSticker']);
    Route::any('print-transaction/{id}', [ConsignmentController::class, 'printTransactionsheet']);
    Route::any('update-edd', [ConsignmentController::class, 'updateEDD']);
    Route::any('create-drs', [ConsignmentController::class, 'CreateEdd']);
    Route::any('update-suffle', [ConsignmentController::class, 'updateSuffle']);
    Route::any('view-draftSheet/{id}', [ConsignmentController::class, 'view_saveDraft']);
    Route::any('update-delivery/{id}', [ConsignmentController::class, 'updateDelivery']);
    Route::any('update-delivery-status', [ConsignmentController::class, 'updateDeliveryStatus']);
    Route::any('consignment-report', [ConsignmentController::class, 'consignmentReports']);
    Route::any('update-delivery-date', [ConsignmentController::class, 'updateDeliveryDateOneBy']);
    Route::any('get-delivery-datamodel', [ConsignmentController::class, 'getdeliverydatamodel']);
    Route::any('get-delivery-dateLR', [ConsignmentController::class, 'getDeleveryDateLr']);
    Route::any('update-lrstatus', [ConsignmentController::class, 'updateLrStatus']);
    Route::any('remove-lr', [ConsignmentController::class, 'removeLR']);


    Route::resource('locations', LocationController::class);
    Route::post('/locations/update', [LocationController::class, 'updateLocation']);
    Route::any('locations/get-location', [LocationController::class, 'getLocation']);
    // Route::any('locations/delete-location', [LocationController::class, 'deleteLocation']);

    Route::get('bulk-import', [ImportCsvController::class, 'getBulkImport']);
    Route::post('consignees/upload_csv', [ImportCsvController::class, 'uploadCsv']); 

    // Route::get('settings/branch-address', [SettingController::class, 'getbranchAddress']);
    Route::any('settings/branch-address', [SettingController::class, 'updateBranchadd']);

    Route::get('/sample-consignees',[ImportCsvController::class, 'consigneesSampleDownload']);
    Route::get('/sample-consigner',[ImportCsvController::class, 'consignerSampleDownload']);
    Route::get('/sample-vehicle',[ImportCsvController::class, 'vehicleSampleDownload']);
    Route::get('/sample-driver',[ImportCsvController::class, 'driverSampleDownload']);

    Route::resource('clients', ClientController::class);
    
});

Route::middleware(['auth'])->group(function () {
    Route::get('/get_drivers', [VehicleController::class, 'getDrivers']);
    Route::get('/get_consigners', [ConsignmentController::class, 'getConsigners']);
    Route::get('/get_consignees', [ConsignmentController::class, 'getConsignees']);

    Route::get('/get_regclients', [UserController::class, 'regClients']);
    Route::get('/get_locations', [ConsignerController::class, 'regLocations']);
    Route::any('/get-address-by-postcode', [ConsignerController::class, 'getPostalAddress']);

});

Route::get('/forbidden-error', [DashboardController::class, 'ForbiddenPage']);
Route::post('webhook', [ConsignmentController::class, 'handle']);



