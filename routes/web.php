<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\ConsigneeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\ShipperController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\FilesUploadController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\ChromePolicyController;
use App\Http\Controllers\LoadImportController;

/*---------- Admin -------------*/  

Route::get('/carrierdata', [ChromePolicyController::class, 'carrierdata']);
Route::get('/loads/import', [LoadImportController::class, 'showForm']);
Route::post('/loads/import', [LoadImportController::class, 'import'])->name('loads.import');

Route::get('/chrome/token', [ChromePolicyController::class, 'showToken']);

Route::get('/correct_data', [AdminController::class, 'correct_data'])->name('correct_data');
Route::get('/backup-database', [BackupController::class, 'backup'])->name('backup.database');

Route::get('/', [LoginController::class, 'index'])->name('login');

Route::Post('/loginuser', [LoginController::class, 'loginuser'])->name('loginuser');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('custom.auth')->group(function () {

    Route::get('admin/broker-users', [AdminController::class, 'users'])->name('broker_users');
    Route::get('admin/account-users', [AdminController::class, 'account_users'])->name('account_users');
    Route::get('admin/admin-users', [AdminController::class, 'admin_users'])->name('admin_users');
	
	 Route::get('admin/broker_users_search', [AdminController::class, 'broker_users_search'])->name('broker_users_search');
    Route::get('admin/account_users_search', [AdminController::class, 'account_users_search'])->name('account_users_search');
    Route::get('admin/admins_users_search', [AdminController::class, 'admins_users_search'])->name('admins_users_search');
	Route::put('admin/users/update/{id}', [AdminController::class, 'updateusers'])->name('admin_update_user');
	
	Route::get('admin/get-related-users/{office_id}', [AdminController::class, 'getByOffice']);
	Route::get('admin/get-related-by-manager/{manager_id}', [AdminController::class, 'getByManager']);
	Route::get('admin/get-related-by-tl/{tl_id}', [AdminController::class, 'getByTeamLeader']);




    Route::post('admin/update-status', [AdminController::class, 'updatestatus'])->name('updatestatus');
    
    Route::get('admin/add_user', [AdminController::class, 'add_user'])->name('add_new_users');
    Route::post('admin/create-user', [AdminController::class, 'createuser'])->name('createuser');
    Route::post('admin/edit-user', [AdminController::class, 'edituser'])->name('edituser');
    Route::post('admin/delete-user/{id}', [AdminController::class, 'delete_user'])->name('delete_user');

    Route::get('admin/create-load', [AdminController::class, 'create_load'])->name('create_load');
    Route::get('admin/get-manager/{id}', [AdminController::class, 'get_manager_by_departmentid'])->name('get_manager_by_departmentid');
    Route::get('admin/get-tl/{id}', [AdminController::class, 'get_tl_by_managerid'])->name('get_tl_by_managerid');

    Route::get('admin/department', [AdminController::class, 'department'])->name('department');
    Route::post('admin/store-department', [AdminController::class, 'store_department'])->name('store_department');
    Route::post('admin/update-department/{id}', [AdminController::class, 'update_department'])->name('update_department');
    Route::post('admin/delete-department/{id}', [AdminController::class, 'delete_department'])->name('delete_department');

    Route::get('admin/manager', [AdminController::class, 'manager'])->name('manager');
    Route::post('admin/store-manager', [AdminController::class, 'store_manager'])->name('store_manager');
    Route::post('admin/update-manager/{id}', [AdminController::class, 'update_manager'])->name('update_manager');
    Route::post('admin/delete-manager/{id}', [AdminController::class, 'delete_manager'])->name('delete_manager');

    Route::get('admin/office', [AdminController::class, 'office'])->name('office');
    Route::post('admin/store-office', [AdminController::class, 'store_office'])->name('store_office');
    Route::post('admin/update-office/{id}', [AdminController::class, 'update_office'])->name('update_office');
    Route::post('admin/delete-office/{id}', [AdminController::class, 'delete_office'])->name('delete_office');

    Route::get('admin/team_leader', [AdminController::class, 'teamleader'])->name('team_leader');
    Route::post('admin/store-teamleader', [AdminController::class, 'store_teamleader'])->name('store_teamleader');
    Route::post('admin/update-teamleader/{id}', [AdminController::class, 'update_teamleader'])->name('update_teamleader');
    Route::post('admin/delete-teamleader/{id}', [AdminController::class, 'delete_teamleader'])->name('delete_teamleader');

    Route::get('admin/status_type', [AdminController::class, 'statustype'])->name('status_type');
    Route::post('admin/store-statustype', [AdminController::class, 'store_statustype'])->name('store_statustype');
    Route::post('admin/update-statustype/{id}', [AdminController::class, 'update_statustype'])->name('update_statustype');
    Route::post('admin/delete-statustype/{id}', [AdminController::class, 'delete_statustype'])->name('delete_statustype');

    Route::get('admin/shipment_type', [AdminController::class, 'shipmenttype'])->name('shipment_type');
    Route::post('admin/store-shipmenttype', [AdminController::class, 'store_shipmenttype'])->name('store_shipmenttype');
    Route::post('admin/update-shipmenttype/{id}', [AdminController::class, 'update_shipmenttype'])->name('update_shipmenttype');
    Route::post('admin/delete-shipmenttype/{id}', [AdminController::class, 'delete_shipmenttype'])->name('delete_shipmenttype');

    Route::get('admin/equipment_type', [AdminController::class, 'equipmenttype'])->name('equipment_type');
    Route::post('admin/store-equipmenttype', [AdminController::class, 'store_equipmenttype'])->name('store_equipmenttype');
    Route::post('admin/update-equipmenttype/{id}', [AdminController::class, 'update_equipmenttype'])->name('update_equipmenttype');
    Route::post('admin/delete-equipmenttype/{id}', [AdminController::class, 'delete_equipmenttype'])->name('delete_equipmenttype');

    Route::get('admin/country', [AdminController::class,'country'])->name('country');
    Route::post('admin/country-add', [AdminController::class, 'countryCreate'])->name('country.create');
    Route::delete('admin/country-delete/{id}', [AdminController::class, 'deleteCountry'])->name('country.delete');
    Route::put('admin/country-update/{id}', [AdminController::class, 'update'])->name('country.update');

    Route::get('admin/state', [AdminController::class, 'state'])->name('state');
    Route::post('admin/state/create', [AdminController::class, 'statestore'])->name('state.create');
    Route::put('admin/state-update/{id}', [AdminController::class, 'stateupdate'])->name('state.update');
    Route::delete('admin/state/delete/{id}', [AdminController::class, 'statedestroy'])->name('state.delete');

    Route::get('/account/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('account/update-profile', [AdminController::class, 'update_profile'])->name('update_profile');
    Route::post('admin/change-password', [AdminController::class, 'change_password'])->name('change_password.auth');
    Route::post('admin/update-password', [AdminController::class, 'update_password'])->name('update_password');
    Route::post('admin/admin-update-password/{id}', [AdminController::class, 'admin_update_password'])->name('admin_update_password');


    Route::get('admin/permissions', [RolesController::class, 'permissions'])->name('permissions');
    Route::post('admin/create-permissions', [RolesController::class, 'create_permissions'])->name('create_permissions');

    Route::get('admin/roles', [RolesController::class, 'roles'])->name('roles');
    Route::post('admin/role-create', [RolesController::class, 'role_create'])->name('role_create');
    Route::get('admin/role-edit/{id}', [RolesController::class, 'role_edit'])->name('role_edit');
    Route::post('admin/role-update/{id}', [RolesController::class, 'role_update'])->name('role_update');

    Route::get('admin/admin_home', [AdminController::class, 'home'])->name('admin_home');
	 Route::get('admin/search_by_filter', [AdminController::class, 'search_by_filter'])->name('search_by_filter');

    Route::get('admin/all_search', [AdminController::class, 'all_search'])->name('all_search');
    Route::get('admin/open_search', [AdminController::class, 'open_search'])->name('open_search');
    Route::get('admin/delivered_search', [AdminController::class, 'delivered_search'])->name('delivered_search');
    Route::get('admin/complete_search', [AdminController::class, 'complete_search'])->name('complete_search');
    Route::get('admin/invoice_search', [AdminController::class, 'invoice_search'])->name('invoice_search');
    Route::get('admin/invoice_paid_search', [AdminController::class, 'invoice_paid_search'])->name('invoice_paid_search');

    Route::get('admin/admin-download/carrier/pdf/{id}', [AdminController::class, 'adminRcDownload'])->name('admin.rc.download.pdf'); 
    Route::get('admin/admin-download/shipper/pdf/{id}', [AdminController::class, 'adminShipperRcDownload'])->name('admin.shipper.rc.download.pdf');

    Route::get('admin/all_data',[AdminController::class, 'all_data'] )->name('all_data');

    Route::get('admin/customer_search',[AdminController::class, 'customer_search'] )->name('customer_search');
	
    Route::get('admin/carrier_search',[AdminController::class, 'carrier_search'] )->name('carrier_search');
    Route::get('admin/consignee_search',[AdminController::class, 'consignee_search'] )->name('consignee_search');
    Route::get('admin/shipper_search',[AdminController::class, 'shipper_search'] )->name('shipper_search');
    Route::get('admin/load_search',[AdminController::class, 'load_search'] )->name('load_search');
    Route::get('admin/ip-config',[AdminController::class, 'ipconfigcreate'] )->name('ip.config.create');
    Route::post('admin/ip-config-store', [AdminController::class, 'ipStore'])->name('ip.config.store');
    Route::put('admin/ip-config-update/{id}', [AdminController::class, 'ipUpdate'])->name('ip.config.update');
    Route::delete('admin/ip-config-delete/{id}', [AdminController::class, 'ipDelete'])->name('ip.config.delete');

    Route::get('admin/download/carrier/pdf/{id}', [AdminController::class, 'adminRcDownload'])->name('admin.rc.download.pdf');
    Route::get('admin/download/shipper/pdf/{id}', [AdminController::class, 'adminShipperRcDownload'])->name('admin.shipper.rc.download.pdf');
    Route::get('admin/load/edit/{id}', [AdminController::class, 'loadEdit'])->name('load.edit');
    Route::post('admin/load/update/{id}', [AdminController::class, 'loadUpdate'])->name('load.update');
    Route::get('admin/it/hardware', [AdminController::class, 'it_hardware'])->name('it.hardware');
    Route::post('admin/ticket/update-status', [AdminController::class, 'updateTicketStatus'])->name('ticket.update.status');
Route::get('admin/ticket/count', [AdminController::class, 'ticketCount'])
    ->name('ticket.count');

	
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/its_data', function () {
        return view('admin.its');
    })->name('its_data');
    
	Route::get('admin/activity_logs', [AdminController::class, 'allLogs'])->name('activity_logs');

    /*---------- Accounts -------------*/
    Route::post('account/load/update/{id}', [AdminController::class, 'loadUpdate'])->name('load.update');
    Route::get('account/load/edit/{id}', [AdminController::class, 'loadEdit'])->name('load.edit');
    Route::post('/account/send-mail', [MailController::class, 'send'])->name('send.mail');

    Route::get('account/customer-info/{id}', [AccountController::class, 'getCustomerInfo'])->name('customer.info');
Route::get('account/carrier-info/{id}', [AccountController::class, 'getCarrierInfo'])->name('carrier.info');

    Route::Post('account/loads-pi', [AccountController::class, 'loadspi'])->name('loads-pi');
    Route::Post('account/loads-multipal-invoice', [AccountController::class, 'loadsMultipalInvoice'])->name('loads-multipal-invoice');
    
    Route::get('account/account-manager', [AccountController::class, 'account_manager'])->name('account_manager');

    Route::get('account/accounting', [AccountController::class, 'accounting'])->name('accounting');
	Route::get('account/broker-public-doc/{id}', [AccountController::class, 'accountingCompletedPublicDoc'])->name('CompletedPublicDoc');
    Route::get('account/accounting_open_search', [AccountController::class, 'accounting_open_search'])->name('accounting_open_search');
    Route::get('account/accounting_completed_search', [AccountController::class, 'accounting_completed_search'])->name('accounting_completed_search');
    Route::get('account/accounting_invoiced_search', [AccountController::class, 'accounting_invoiced_search'])->name('accounting_invoiced_search');
    Route::get('account/accounting_invoiced_paid_search', [AccountController::class, 'accounting_invoiced_paid_search'])->name('accounting_invoiced_paid_search');
	
    Route::get('account/load_search_by_load', [AccountController::class, 'load_search_by_load'])->name('load_search_by_load');
	
    Route::get('account/compliance', [AccountController::class, 'compliance'])->name('compliance');
    Route::get('account/carrier-block', [AccountController::class, 'carrier_block'])->name('carrier_block');
    Route::get('account/compliance-search-mc', [AccountController::class, 'compliance_search_mc'])->name('compliance_search_mc');
    Route::get('account/compliance-search-cpr', [AccountController::class, 'compliance_search_cpr'])->name('compliance_search_cpr');
    Route::post('account/save-rate-checks', [AccountController::class, 'saverateChecks'])->name('saverateChecks');
    Route::get('account/reporting', [AccountController::class, 'reporting'])->name('reporting');
	Route::get('account/get-related-agent/{office_id}', [AccountController::class, 'getByOfficereporting']);
	Route::get('account/credit', [AccountController::class, 'credit'])->name('credit');
    Route::get('account/report_carrier_search', [AccountController::class, 'report_carrier_search'])->name('report_carrier_search');
    Route::get('account/report_customer_search', [AccountController::class, 'report_customer_search'])->name('report_customer_search');
    Route::get('account/report_customer_detail_search', [AccountController::class, 'report_customer_detail_search'])->name('report_customer_detail_search');
    Route::get('account/report_dispatcher_search', [AccountController::class, 'report_dispatcher_search'])->name('report_dispatcher_search');
    Route::get('account/report_load_search', [AccountController::class, 'report_load_search'])->name('report_load_search');
    Route::get('account/report_sales_rep_search', [AccountController::class, 'report_sales_rep_search'])->name('report_sales_rep_search');
    Route::get('account/report_load_completed_log_search', [AccountController::class, 'report_load_completed_log_search'])->name('report_load_completed_log_search');
    Route::get('account/report_limit_search', [AccountController::class, 'report_limit_search'])->name('report_limit_search');
    Route::get('account/report_aging_search', [AccountController::class, 'report_aging_search'])->name('report_aging_search');
    
    Route::get('account/vendor-system', [AccountController::class, 'vendor_system'])->name('vendor_system');
    Route::get('account/vendor-search', [AccountController::class, 'vendor_search'])->name('vendor_search');
    Route::get('account/carrier-search', [AccountController::class, 'carrier_search'])->name('carrier_search');
    Route::post('account/update-invoice-through', [AccountController::class, 'carrierupdateInvoiceThrough'])->name('update.invoice.through');
    Route::get('account/carrier-verification', [AccountController::class, 'carrier_verification'])->name('carrier_verification');
    Route::post('account/carrier-verification/save', [AccountController::class, 'carrier_verification_save'])->name('carrier.verification.save');

    Route::post('account/carrier/verification/files', [AccountController::class, 'carrierverificationgetFiles'])->name('carrier.verification.files');

    Route::delete('/carrier-bank-doc/{id}', [AccountController::class, 'deleteDoc'])->name('carrier.bank.doc.delete');
    Route::post('/account/delete-carrier-file', [AccountController::class, 'deleteCarrierFile'])->name('delete.carrier.file');

    Route::post('account/quick_pay', [AccountController::class, 'quick_pay'])->name('quick_pay');
    Route::post('account/payment_method', [AccountController::class, 'payment_method'])->name('payment_method');
    Route::post('account/ready_to_pay', [AccountController::class, 'ready_to_pay'])->name('ready_to_pay');
    Route::post('account/update-carrier-due-date', [AccountController::class, 'updateLoadDate'])->name('updateLoadDate');
    Route::post('account/uploadCarrierDocs', [AccountController::class, 'uploadCarrierDocs'])->name('uploadCarrierDocs');
    Route::post('account/get-files', [AccountController::class, 'getFiles'])->name('get.files');
    Route::post('account/delete-carrier-doc', [AccountController::class, 'deleteCarrierDoc'])->name('delete.carrier.doc');

    Route::post('account/mc-chcek', [AccountController::class, 'mc_check'])->name('mc_check');
	Route::post('account/mc-setup', [AccountController::class, 'mc_setup'])->name('mc_setup');
    Route::post('account/cpr-check', [AccountController::class, 'cpr_check'])->name('cpr_check');
    Route::post('account/macro', [AccountController::class, 'macro'])->name('macro');
    Route::post('account/macro', [AccountController::class, 'macro'])->name('macro');
    Route::post('account/no_of_macro', [AccountController::class, 'no_of_macro'])->name('no_of_macro');
	Route::get('account/get-states/{country_id}', [CustomerController::class, 'getStates']);
    Route::get('account/edit-customer/{id}', [AccountController::class, 'editCustomer'])->name('edit.customer');
    Route::put('account/update-customer/{id}', [AccountController::class, 'accountupdateCustomer'])->name('update.customer');

    Route::post('account/save-internal-notes', [AccountController::class, 'saveInternalNotes']);

    Route::post('account/update-invoice-status/{id}', [AccountController::class, 'updateInvoiceStatus'])->name('update.invoice.status');

    Route::post('account/update-invoice-status-as-paid-record/{id}', [AccountController::class, 'updateInvoiceStatusAsPaidRecord'])->name('update.invoice.status.as.paid.record');
    Route::post('account/update-invoice-status-as-short/{id}', [AccountController::class, 'updateInvoiceStatusAsShort'])->name('update.invoice.status.as.short');

    Route::post('account/load/update-receiving-amount', [AccountController::class, 'updateReceivingAmount'])->name('load.updateReceivingAmount');

Route::post('account/load/update-adv-receiving-amount', [AccountController::class, 'updateadvReceivingAmount'])->name('load.updateadvReceivingAmount');

Route::post('account/load/update-remaining-amount', [AccountController::class, 'updateRemainingAmount'])->name('load.updateRemainingAmount');

    Route::get('account/print-invoice/{id}', [AccountController::class, 'printInvoice'])->name('print.invoice');

    Route::get('account/invoices/{id}/print/paid', [AccountController::class, 'printInvoicePaid'])->name('invoices.print.print');

    Route::get('account/invoice/{loadNumber}', [AccountController::class, 'printInvoice'])->name('invoice.print');

    Route::put('account/update-invoice-status-as-back-complete/{id}', [AccountController::class, 'markAsBackCompleteRecord']);

    Route::post('account/update-invoice-status-as-back-invoice/{id}', [AccountController::class, 'markAsBackInvoiceRecord']);
    Route::post('account/carrier/mark-paid', [AccountController::class, 'markCarrierAsPaid'])->name('carrier.mark.paid');
    Route::get('account/load/get-files/{id}', [AccountController::class, 'getCarrierFiles']);
    Route::post('account/load/delete-file', [AccountController::class, 'deleteCarrierFile'])->name('load.delete.file');
    Route::get('account/accounts/view-loads-detail/{id}', [AccountController::class, 'viewLoadDetail'])->name('accounts.view_loads_detail');

    Route::post('account/setup-carrier', [AccountController::class, 'setupCarrier'])->name('setupCarrier');
    Route::post('account/carrier/setup-update', [AccountController::class, 'updateCarrierSetup'])->name('carrier.setup.update');
	
	//admin sheets
		Route::get('account/loadsExcel/{id}', [AccountController::class, 'loadsExcel'])->name('loadsExcel');
		Route::get('account/loadsPdf/{id}', [AccountController::class, 'loadsPdf'])->name('loadsPdf');
		
		Route::get('account/allloadsPdf/{id}', [AccountController::class, 'allloadsPdf'])->name('allloadsPdf');
		Route::get('account/allloadsExcel/{id}', [AccountController::class, 'allloadsExcel'])->name('allloadsExcel');
		 
		
		//complianceloads sheets
		Route::get('account/allcomplianceloadsPdf/{id}', [AccountController::class, 'allcomplianceloadsPdf'])->name('allcomplianceloadsPdf');
		Route::get('account/allcomplianceloadsExcel/{id}', [AccountController::class, 'allcomplianceloadsExcel'])->name('allcomplianceloadsExcel');
		
		//accounts sheets
		Route::get('account/allaccountingloadsPdf/{id}', [AccountController::class, 'allaccountingloadsPdf'])->name('allaccountingloadsPdf');
		Route::get('account/allaccountingloadsExcel/{id}', [AccountController::class, 'allaccountingloadsExcel'])->name('allaccountingloadsExcel');

		Route::get('account/allaccountmangerloadsPdf/{id}', [AccountController::class, 'allaccountmangerloadsPdf'])->name('allaccountmangerloadsPdf');
		Route::get('account/allaccountmangerloadsExcel/{id}', [AccountController::class, 'allaccountmangerloadsloadsExcel'])->name('allaccountmangerloadsloadsExcel');
		
		Route::get('account/CreditReportingExcel', [AccountController::class, 'CreditReportingExcel'])->name('CreditReportingExcel');
		Route::get('account/customerReportingExcell', [AccountController::class, 'customerReportingExcell'])->name('customerReportingExcell');
		Route::get('account/customerDetailsReportingExcell', [AccountController::class, 'customerDetailsReportingExcell'])->name('customerDetailsReportingExcell');
		Route::get('account/dispatcherReportingExcell', [AccountController::class, 'dispatcherReportingExcell'])->name('dispatcherReportingExcell');
		Route::get('account/loadsDetailsReportingExcell', [AccountController::class, 'loadsDetailsReportingExcell'])->name('loadsDetailsReportingExcell');
		Route::get('account/salesReportingExcell', [AccountController::class, 'salesReportingExcell'])->name('salesReportingExcell');
		Route::get('account/loadCompleteReportingExcel', [AccountController::class, 'loadCompleteReportingExcel'])->name('loadCompleteReportingExcel');
		Route::get('account/CarrierReportingExcel', [AccountController::class, 'CarrierReportingExcel'])->name('CarrierReportingExcel');
		Route::get('account/agingReportingExcel', [AccountController::class, 'agingReportingExcel'])->name('agingReportingExcel');
		Route::get('account/limitReportingExcel', [AccountController::class, 'limitReportingExcel'])->name('limitReportingExcel');
        Route::post('account/loads/search-invoice', [AccountController::class, 'searchLoadsOnInvoice'])->name('loads.search.invoice');

        Route::post('account/invoice/upload-document', [AccountController::class, 'uploadmailDocument'])->name('mail.upload.document');
        Route::post('account/customer/update-prepayment', [AccountController::class, 'updatePrePayment'])->name('customer.update.prepayment');
        Route::post('account/vendorsystem/internalnotes',[AccountController::class, 'updateVendorInternalNotes'])->name('vendorsystem.internalnotes');
        Route::post('account/vendorsystem/getnotes', [AccountController::class, 'getVendorNotes']);
        Route::get('account/customerApprovalFormadmin', [AccountController::class, 'customerApprovalFormAdmin'])->name('customer.approval.form.admin');
        Route::post('account/customer/approval/update-status', [AccountController::class, 'customerApprovalupdateStatus'])->name('customerApproval.updateStatus');
        Route::get('account',[AccountController::class, 'customerApprovalFormExcel'])->name('customer.approval.excel');
        Route::get('account/get-credit-files',[AccountController::class, 'creditdocsgetFiles'])->name('get.files.customer.approval.docs');
        Route::post('account/credit-application/upload/{id}',[AccountController::class, 'uploadCreditDocs'])->name('credit.upload.docs');
        Route::get('account/get-credit-files',[AccountController::class, 'creditdocsgetFiles'])->name('get.files.customer.approval.docs');
        Route::post('account/credit-application/upload/{id}',[AccountController::class, 'uploadCreditDocs'])->name('credit.upload.docs');
        Route::post('account/factoring/add', [AccountController::class, 'factoring_add'])->name('factoring.add');
        Route::get('account/factoring', [AccountController::class, 'factoring'])->name('factoring.show');
        Route::post('account/factoring/update/{id}', [AccountController::class, 'factoring_update'])->name('factoring.update');
        Route::delete('account/factoring/delete/{id}', [AccountController::class, 'factoring_delete'])->name('factoring.delete');
        Route::post('account/assign-customer', [AccountController::class, 'assignCustomer'])->name('assign.customer');
    /*---------- Broker ----------*/

    Route::get('broker/home', function () {
        return view('home');
    })->name('home');
	
	Route::get('files/{filesId}/uploads', [FilesUploadController::class, 'index'])->name('files.upload');
	Route::post('files/{filesId}/uploads', [FilesUploadController::class, 'uploadFiles'])->name('files.upload.post');
	Route::get('files/get-files/{recordId}', [FilesUploadController::class, 'getFiles']);
	Route::post('files/delete-file', [FilesUploadController::class, 'deleteFile']);
	Route::get('files/show-form/{recordId}', [FilesUploadController::class, 'showForm']);
	Route::post('files/merge-files', [FilesUploadController::class, 'mergeFiles'])->name('merge.files');
	Route::post('files/delete-file-broker', [FilesUploadController::class, 'deleteFilebroker'])->name('delete.file.broker');
	Route::post('files/move-to-private', [FilesUploadController::class, 'movefile'])->name('move.to.private');
    Route::get('/broker/profile', [AdminController::class, 'profile'])->name('profile');
    Route::post('broker/update-profile', [AdminController::class, 'update_profile'])->name('update_profile');
    Route::post('broker/change-password', [AdminController::class, 'change_password'])->name('change_password.auth');
    // routes/web.php
Route::post('broker/change-password', [AdminController::class, 'update_password'])
    ->name('change_password.auth');

    Route::post('broker/admin-update-password/{id}', [AdminController::class, 'admin_update_password'])->name('admin_update_password');
    Route::get('broker/customer', [CustomerController::class, 'index'])->name('customer');
	
    Route::post('broker/customer/create', [CustomerController::class, 'create'])->name('create.customer');
    Route::get('broker/customer/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
    Route::post('broker/customer/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
    Route::get('broker/customer/live-data', [CustomerController::class, 'liveCustomerData'])->name('customer.live');
	Route::get('broker/customer_search', [CustomerController::class, 'customer_search'])->name('customer_search');
	Route::get('broker/customer_search_user', [CustomerController::class, 'customer_search_user'])->name('customer_search_user');
	Route::post('broker/change-load-status', [LoadController::class, 'load_status_update']);
  
    Route::get('broker/shipper', [ShipperController::class, 'index'])->name('shipper');
    Route::post('broker/shipper_insert', [ShipperController::class, 'create'])->name('shipper.insert');
    Route::put('broker/shipper/{id}',     [ShipperController::class, 'update'])->name('shipper.update');
    Route::delete('broker/shipper/{id}',  [ShipperController::class, 'destroy'])->name('shipper.destroy');
	
	Route::get('broker/shipper_search', [ShipperController::class, 'shipper_search'])->name('shipper_search');
	Route::get('broker/shipper_search_user', [ShipperController::class, 'shipper_search_user'])->name('shipper_search_user');

    Route::get('broker/carrier', [CarrierController::class, 'index'])->name('carrier');
    Route::Post('broker/create/carrier', [CarrierController::class,'create'])->name('carrier.create');
    Route::get('broker/carrier/{id}/edit', [CarrierController::class, 'edit'])->name('carrier.edit');
    Route::put('broker/carrier/{id}', [CarrierController::class, 'update'])->name('carrier.update');
    Route::delete('broker/carrier/{id}', [CarrierController::class, 'destroy'])->name('carrier.destroy');
    Route::get('broker/my-carrier-search', [CarrierController::class,'mycarriersearch']);
    Route::get('broker/all-carrier-search', [CarrierController::class,'allcarriersearch']);
    Route::get('broker/Consignee', action: [ConsigneeController::class, 'index'])->name('Consignee');
    Route::post('broker/consignee-data', [ConsigneeController::class, 'create'])->name('consignee.store');
    Route::put('broker/consignee-data/{id}', [ConsigneeController::class, 'update'])->name('consignee.update');
    Route::delete('broker/consignee-data/{id}', [ConsigneeController::class, 'destroy'])->name('consignee.destroy');
	Route::get('broker/consignee_search', [ConsigneeController::class, 'consignee_search'])->name('consignee_search');
	Route::get('broker/consignee_search_user', [ConsigneeController::class, 'consignee_search_user'])->name('consignee_search_user');

    Route::get('broker/load', [LoadController::class, 'index'])->name('load');
	 Route::get('broker/load_search_by_user', [LoadController::class, 'load_search_by_user'])->name('load_search_by_user');
	
    Route::POST('broker/load-create', [LoadController::class, 'create'])->name('load.create');
    Route::get('broker/edit-load/{id}', [LoadController::class, 'editload'])->name('load.editload');
    Route::POST('/broker/load/update/{id}', [LoadController::class, 'BrokerLoadUpdate'])->name('broker.load.update');
	Route::post('broker/extract-do-data', [LoadController::class, 'extractDoData'])->name('extract.do.data');
    
    Route::get('broker/broker_all_load', [LoadController::class, 'broker_all_load'])->name('broker_all_load');
    Route::get('broker/broker_open_load', [LoadController::class, 'broker_open_load'])->name('broker_open_load');
    Route::get('broker/broker_delivered_load', [LoadController::class, 'broker_delivered_load'])->name('broker_delivered_load');
    Route::get('broker/broker_complete_load', [LoadController::class, 'broker_complete_load'])->name('broker_complete_load');
    Route::get('broker/broker_invoice_load', [LoadController::class, 'broker_invoice_load'])->name('broker_invoice_load');
    Route::get('broker/broker_paid_load', [LoadController::class, 'broker_paid_load'])->name('broker_paid_load');

    Route::get('broker/download/carrier/pdf/{id}', [AdminController::class, 'adminRcDownload'])->name('rc.download.pdf');
    Route::get('broker/download/shipper/pdf/{id}', [AdminController::class, 'adminShipperRcDownload'])->name('shipper.download.pdf');


    
    Route::get('broker/clone/load/{id}', [LoadController::class, 'cloneLoad'])->name('clone.load');
    Route::get('broker/fetch-consignee-details', [LoadController::class, 'fetchConsigneeDetails'])->name('fetch.consignee.details');
    Route::get('broker/fetch-shipper-details', [LoadController::class, 'fetchShipperDetails'])->name('fetch.shipper.details');
	Route::post('broker/fetch-carrier-details', [LoadController::class, 'fetchCarrierDetails'])->name('fetch.carrier.details');
    Route::get('/broker/load/{id}/bol/pdf', [LoadController::class, 'generateBolPdf'])->name('broker.load.bol.pdf');
    Route::post('/broker/load/{id}/bol/save', [LoadController::class, 'saveBolEditData'])->name('broker.load.bol.save');
    Route::post('/broker/load/{id}/bol/download', [LoadController::class, 'downloadBolPdf'])->name('broker.load.bol.download');
    Route::post('broker/fetch-carrier-suggestions', [LoadController::class, 'fetchCarrierSuggestions'])->name('fetch.carrier.suggestions');

    Route::get('remaing/check-remaing-limit', [LoadController::class, 'checkRemaingLimit'])->name('check.remaing.limit');
    Route::get('remaing/edit-check-remaing-limit', [LoadController::class, 'checkRemaingLimiteditload'])->name('edit.check.remaing.limit');
    Route::get('broker/raise/tickets', [LoadController::class, 'raiseTickets'])->name('broker.raise.tickets');
    Route::post('broker/raise-ticket', [LoadController::class, 'raiseTicketStore'])->name('broker.raise.ticket');
    Route::post('broker/pdf/extract', [LoadController::class, 'extractPdfData'])->name('pdf.extract');



    Route::get('broker/get-states/{country_id}', [CustomerController::class, 'getStates']);
    Route::get('broker/carrier-get-states/{country_id}', [CarrierController::class, 'getStatescarrier']);
    Route::get('broker/shipper-get-states/{country_id}', [ShipperController::class, 'getStatesshipper']);
    Route::get('broker/consignee-get-states/{country_id}', [ConsigneeController::class, 'getStatesconsignee']);
	
	
	Route::post('broker/customer/upload-remittance', [CustomerController::class, 'uploadRemittance']);
	Route::post('broker/customer/remittance/files', [CustomerController::class, 'remittanceFiles']);
	Route::post('broker/customer/remittance/delete', [CustomerController::class, 'deleteRemittanceFile']);
	Route::post('broker/customer/remittance/filter', [CustomerController::class, 'filterRemittanceFiles'])->name('customer.remittance.filter');
    Route::get('broker/customer/customerapprovalformbroker', [CustomerController::class, 'customerApprovalFormBroker'])->name('customer.approval.form.broker');
    Route::post('broker/customer-approval-form/store',[CustomerController::class, 'storeCustomerApprovalForm'])->name('customer.approval.store');

	Route::get('account/remittance', [AccountController::class, 'account_remittance'])->name('remittance');
	Route::post('account/customer/upload-remittance', [AccountController::class, 'accountuploadRemittance']);
	Route::post('account/customer/remittance/files', [AccountController::class, 'accountremittanceFiles']);
	Route::post('account/customer/remittance/delete', [AccountController::class, 'accountdeleteRemittanceFile']);
	Route::post('account/customer/remittance/filter', [AccountController::class, 'accountfilterRemittanceFiles'])->name('account.customer.remittance.filter');
	Route::get('account/customer_search', [AccountController::class, 'customer_search'])->name('customer_search');
    Route::get('account/cmt_Data', [AccountController::class, 'cmt_Data'])->name('cmt.data');

});
