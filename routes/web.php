<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AllTestsController;
use App\Http\Controllers\SingleTestController;
use App\Http\Controllers\ProfileTestController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SampleCollectionsController;
use App\Http\Controllers\SampleTypeController;
use App\Http\Controllers\LabUnitController;
use App\Http\Controllers\ParameterController;
use App\Http\Controllers\RejectReasonController;
use App\Http\Controllers\TestMethodController;
use App\Http\Controllers\OrganismSetupController;
use App\Http\Controllers\TestCategoryController;
use App\Http\Controllers\LotCodeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\IncomeCategoryController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\SensitivityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\AccessionAcknowledgeController;
use App\Http\Controllers\SampleRejectedController;
use App\Http\Controllers\PurchaseCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\FinanceInvoiceController;
use App\Http\Controllers\ClientPortalController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\TubeController;
use App\Http\Controllers\ContainerController;
use App\Http\Controllers\ItemPurchaseController;
use App\Http\Controllers\WareHouseController;
use App\Http\Controllers\RefundController;
use App\Http\Controllers\StockListController;
use App\Http\Controllers\LeadsController;
use App\Http\Controllers\LeadSourceController;
use App\Http\Controllers\LeadstatusController;
use App\Http\Controllers\LeadUpdateController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\ClientsController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificationController;

Route::post('update-notification', [NotificationController::class, 'update']);
Route::get('/notifications', [NotificationController::class, 'index']);
Route::get('admin/notifications/count', [AdminController::class, 'notificationsCount']);
Route::get('admin', [AdminController::class, 'adminPanel']);
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
 Route::post('testlist-view', [TestController::class, 'testlist_view']);
 Route::get('test-reports', [TestController::class, 'testreports']);
 Route::post('addtestresult', [TestController::class, 'addtestresult'])->name('addResult.post');
 Route::post('testdetails-view', [TestController::class, 'testdetails_view']);
 Route::get('test-result', [TestController::class, 'testview']);

/* LOGIN AND DASHBOARD SECTION STARTS HERE */
Route::get('/', [LoginController::class, 'index'])->name('login');
//Route::post('post-login', [LoginController::class, 'postLogin'])->name('login.post'); 
Route::post('/', [LoginController::class, 'postLogin'])->name('login.post'); 
Route::get('dashboard', [LoginController::class, 'dashboard']); 
Route::get('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('change-password', [ChangePasswordController::class, 'index'])->name('password.change');
Route::patch('store', [ChangePasswordController::class, 'store'])->name('password.update');


Route::get('profile_edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
Route::put('profile_edit', [AdminProfileController::class, 'update'])->name('admin.profile.update');


/* LOGIN AND DASHBOARD SECTION ENDS HERE */

/* EXPENSE SECTION STARTS HERE */
Route::get('delete-expense/{id}', [ExpenseController::class, 'delete_expense']);
Route::post('expense-add', [ExpenseController::class, 'expenseadd'])->name('addexpense.add');
Route::get('expense-list', [ExpenseController::class, 'expenselist']);
Route::post('view-edit-expense', [ExpenseController::class, 'editexpense']);
Route::post('view-expense', [ExpenseController::class, 'viewexpense']);
/* EXPENSE SECTION ENDS HERE */

/* DEPARTMENT / DESIGNATION SECTION STARTS HERE */
Route::get('departments',[DepartmentController::class,'viewdepartment']);
Route::get('add-department',[DepartmentController::class,'viewadddepartment']);
Route::post('add-department',[DepartmentController::class,'adddepartment'])->name('department.add');

Route::get('edit-department/{id}', [DepartmentController::class, 'editdepartment']);
Route::post('edit-department/{id}', [DepartmentController::class, 'updatedepartment']);
Route::get('block-designation/{id}', [DepartmentController::class, 'blockdesignation']);
Route::get('unblock-designation/{id}', [DepartmentController::class, 'unblockdesignation']);
/* DEPARTMENT / DESIGNATION SECTION ENDS HERE */

/* STAFF SECTION STARTS HERE*/ 
Route::get('staffs',[StaffController::class,'viewstaff']);
Route::post('documentadd', [StaffController::class, 'adddocuments']);
Route::post('edit-staff/documentadd', [StaffController::class, 'adddocuments']);
Route::post('documentdelete', [StaffController::class, 'deletedocuments']);
Route::post('edit-staff/documentremove', [StaffController::class, 'deletedocuments']);
Route::post('designation',[StaffController::class,'designationdropdown']);
Route::get('add-staff',[StaffController::class,'viewaddstaff']);
Route::post('add-staff',[StaffController::class,'addstaff'])->name('staff.add');
Route::post('proof',[StaffController::class,'proofview']);
Route::get('block-staff/{id}', [StaffController::class, 'blockstaff']);
Route::get('unblock-staff/{id}', [StaffController::class, 'unblockstaff']);

Route::get('edit-staff/{id}', [StaffController::class, 'editstaff']);
Route::post('edit-staff/{id}', [StaffController::class, 'updatestaff']);
Route::post('authupdate', [StaffController::class, 'changestaffpassword']);
Route::post('branch-view', [StaffController::class, 'branchview']);
Route::post('branch-view-edit', [StaffController::class, 'branchviewedit'])->name('branchstaff.edit');

Route::get('user_role',[StaffController::class,'viewAddUserRole']);
Route::get('user-role-list',[StaffController::class,'viewUserRole']);
Route::post('add-user_role',[StaffController::class,'addUserRole'])->name('user_role.add');
Route::get('edit-user_role/{id}', [StaffController::class, 'edituserrole']);
Route::post('edit-user_role/{id}', [StaffController::class, 'updateuserrole']);
Route::get('block-userrole/{id}', [StaffController::class, 'blockuserrole']);
Route::get('unblock-userrole/{id}', [StaffController::class, 'unblockuserrole']);
Route::get('permission-staff/{id}', [StaffController::class, 'permission']);
/* STAFF SECTION ENDS HERE */ 


 /* TESTS SECTION STARTS HERE */
Route::get('alltest',[AllTestsController::class,'testsview']);
Route::get('singletest',[AllTestsController::class,'singletestsview']);
Route::get('profiletest',[AllTestsController::class,'profiletestsview']);
Route::get('add-single-test',[AllTestsController::class,'viewaddsingletest']);
Route::post('rangesadd', [AllTestsController::class, 'addranges']);
Route::post('editsingletes', [AllTestsController::class, 'viewtest'])->name('test.viewSingle');
Route::post('edit-range-method', [AllTestsController::class, 'rangeedit'])->name('range.edit');
Route::post('add-single-test',[AllTestsController::class,'addsingletest'])->name('singletest.add');
Route::post('normalrangedelete', [AllTestsController::class, 'deletenormalrange']);
Route::post('normalrangeview', [AllTestsController::class, 'viewnormalrange']);
Route::post('update-singletest/normalrangedelete', [AllTestsController::class, 'deletenormalrange']);
Route::post('update-singletest/rangesadd', [AllTestsController::class, 'addranges']);
Route::get('update-singletest/{id}', [AllTestsController::class, 'updatesingletest']);
Route::post('edit-singletest/{id}', [AllTestsController::class, 'updatesingletestpost']);
Route::post('updateNormalRange', [AllTestsController::class, 'updateNormalRangeList'])->name('updateNormalRange');
Route::post('updateRangeList', [AllTestsController::class, 'updateRangeList'])->name('updateRangeList');

Route::get('block-singletest/{id}', [AllTestsController::class, 'blocksingletest']);
Route::get('unblock-singletest/{id}', [AllTestsController::class, 'singletestunblock']);


Route::get('add-profile-test',[AllTestsController::class,'addprofiletestview']);
Route::post('add-profile-test',[AllTestsController::class,'addprofiletest'])->name('profiletest.add');
Route::post('additionaltestadd', [AllTestsController::class, 'addadditionaltestprofile']);
Route::post('singletestview', [AllTestsController::class, 'viewsingletests']);
Route::get('update-profiletest/{id}', [AllTestsController::class, 'updateprofiletest']);
Route::post('edit-profiletest/{id}', [AllTestsController::class, 'updateprofiletestpost']);

Route::get('block-profiletest/{id}', [AllTestsController::class, 'blockprofiletest']);
Route::get('unblock-profiletest/{id}', [AllTestsController::class, 'profiletestunblock']);



/* TEST SECTION ENDS HERE */

/* FORGOT PASSWORD SECTION STARTS HERE */
/* Route::get('forgot-password', [ForgotPasswordController::class, 'viewforgotpassword']);
Route::post('forgot-password', [ForgotPasswordController::class, 'postforgotpassword']);
Route::get('confirm-password', [ForgotPasswordController::class, 'viewconfirmpassword']);
Route::post('confirm-password', [ForgotPasswordController::class, 'updatepassword']);
 Route::post('forgotpasswordadd', [ForgotPasswordController::class, 'postforgotpassword']); */
 
 Route::get('forgot-password', [ForgotPasswordController::class, 'viewforgotpassword']);
 //Route::post('forgotpasswordadd', [ForgotPasswordController::class, 'postforgotpassword']); 
 Route::post('forgotpasswordadd', [ForgotPasswordController::class, 'sendOtpEmail']); 
 Route::get('verify_otp', [ForgotPasswordController::class, 'verify_otp']); 
  Route::post('verify_otp_num', [ForgotPasswordController::class, 'verify_otp_num']); 
//Route::post('forgot.password.add', 'ForgotPasswordController@postforgotpassword');
Route::get('confirm-password', [ForgotPasswordController::class, 'viewconfirmpassword']);
Route::post('confirm-password', [ForgotPasswordController::class, 'updatepassword']);
/* FORGOT PASSWORD SECTION ENDS HERE */

/* REGISTRATION STARTS HERE */ 
Route::get('registration', [RegistrationController::class, 'newregistration']);
Route::post('registration', [RegistrationController::class, 'addregistration'])->name('registration.add');
Route::post('custdocumentadd', [RegistrationController::class, 'customeradddocuments'])->name('customerDoc.add');
Route::post('custdocumentdelete', [RegistrationController::class, 'customerdeletedocuments']);
Route::post('searchresult', [RegistrationController::class, 'searchresult'])->name('autocomplete.searchresult');
Route::post('testslistresult', [RegistrationController::class, 'testslistresult'])->name('autocomplete.testslistresult');

Route::post('customerdetailsearch', [RegistrationController::class, 'customerdetailsearch'])->name('autocomplete.customerdata');

Route::post('customernamesearch', [RegistrationController::class, 'customernamesearch'])->name('autocomplete.customername');
Route::post('customerphonesearch', [RegistrationController::class, 'customerphonesearch'])->name('autocomplete.phone');
Route::post('customeriqamasearch', [RegistrationController::class, 'customeriqamasearch'])->name('autocomplete.iqama');
Route::post('viewpreviousinvoice', [RegistrationController::class, 'viewpreviousinvoice'])->name('autocomplete.viewinvoice');
Route::post('autocompleteregistration', [RegistrationController::class, 'autocompleteregistration'])->name('autocomplete.registration');
Route::post('addtoregister', [RegistrationController::class, 'addtoregister'])->name('autocomplete.addtoregister');
//sm 
Route::post('doc.editview', [RegistrationController::class, 'viewdocdetails'])->name('doc.editview');
Route::post('doc.edit', [RegistrationController::class, 'docedit'])->name('doc-edit-vw');
Route::post('doc.Regedit', [RegistrationController::class, 'docregedit'])->name('doc-regedit-vw');
Route::post('view-test', [RegistrationController::class, 'viewdoc'])->name('doc.view');

Route::post('proofreg',[RegistrationController::class,'proofreg']);
Route::get('registration.list', [RegistrationController::class, 'registrationlist']);
Route::get('edit-registration/{id}', [RegistrationController::class, 'editregistration']);
Route::post('update-registration/{id}', [RegistrationController::class, 'updateregistration']); 
Route::get('delete-registration/{id}', [RegistrationController::class, 'deleteregistration']);
Route::post('delete_documents', [RegistrationController::class, 'delete_documents']);
Route::post('search.list', [RegistrationController::class, 'searchlist'])->name('searchlist');

Route::get('registerinvoice/{registrationlastid}', [RegistrationController::class, 'invoicelist']);
/* REGISTRATION ENDS HERE */

// TAX STARTS HERE
Route::get('tax', [TaxController::class, 'listtax']);
Route::get('add-tax', [TaxController::class, 'viewaddtax']);
Route::post('add-tax',[TaxController::class,'addtax'])->name('tax.add');
Route::get('edit-tax/{id}', [TaxController::class, 'viewedittax']);
Route::post('edit-tax/{id}', [TaxController::class, 'edittax']);
Route::get('block-tax/{id}', [TaxController::class, 'blocktax']);
Route::get('unblock-tax/{id}', [TaxController::class, 'unblocktax']);
// TAX ENDS HERE 

//SAMPLE COLLECTION STARTS HERE 
Route::get('sample',[SampleCollectionsController::class,'viewsamplecollections']);
Route::post('sample', [SampleCollectionsController::class, 'searchsamplecollection'])->name('samplecollection.search');
Route::post('sample-add', [SampleCollectionsController::class, 'updateviewsamplecollections'])->name('samplecollection.add');
Route::post('viewnote',[SampleCollectionsController::class,'updateviewdetails'])->name('samplecollection.view');
Route::post('sample-view', [SampleCollectionsController::class, 'samplecollectionupdate']);
Route::post('update-status', [SampleCollectionsController::class, 'updateDatabase'])->name('update-database');
Route::post('update-status-only', [SampleCollectionsController::class, 'updateDatabaseStatus'])->name('update-database-status');
// SAMPLE COLLECTION ENDS HERE


//SAMPLE REJECTION STARTS HERE 
Route::get('sample-rejection',[SampleRejectedController::class,'viewsamplerejected']);
Route::post('sample-rejection-view', [SampleRejectedController::class, 'samplerejectionpopupview']);
/*Route::post('sample', [SampleCollectionsController::class, 'updateviewsamplecollections'])->name('samplecollection.add');
Route::post('viewnote',[SampleCollectionsController::class,'updateviewdetails'])->name('samplecollection.view');
Route::post('sample-view', [SampleCollectionsController::class, 'samplecollectionupdate']);*/
// SAMPLE REJECTION ENDS HERE


//SAMPLE COLLECTION STARTS HERE 
Route::get('accession-acknowledge',[AccessionAcknowledgeController::class,'viewaccessionacknowledge']);
Route::post('accession-acknowledge', [AccessionAcknowledgeController::class, 'updateaccessionacknowledge']);
Route::post('accession-acknowledge-status', [AccessionAcknowledgeController::class, 'updateAccessionacknowledgeStatus'])->name('update-acknow-status');
Route::post('accession-acknowledge-view', [AccessionAcknowledgeController::class, 'accessionacknowledgepopupview']);

Route::post('accessionacknowledge.search', [AccessionAcknowledgeController::class, 'searchaccessionacknowledge'])->name('searchaccessionacknowledge');
//Route::post('viewnote',[SampleCollectionsController::class,'updateviewdetails'])->name('samplecollection.view');
//Route::post('sample-view', [SampleCollectionsController::class, 'samplecollectionupdate']);
// SAMPLE COLLECTION ENDS HERE


// SAMPLE TYPE STARTS HERE 
Route::get('sample-type',[SampleTypeController::class,'sampletypeview']);
Route::post('sample-type', [SampleTypeController::class, 'sampletypeadd'])->name('sampletype.add');
Route::post('edit-sample-type', [SampleTypeController::class, 'sampletypeedit'])->name('sampletype.edit');
Route::post('view-sample-type', [SampleTypeController::class, 'editsampleview']);
Route::get('block-sample-type/{id}', [SampleTypeController::class, 'block']);
Route::get('unblock-sample-type/{id}', [SampleTypeController::class, 'unblock']);

// SAMPLE TYPE ENDS HERE 

// LAB UNIT SETUP STARTS HERE 
Route::get('lab-unit',[LabUnitController::class,'labunitview']);
Route::post('lab-unit', [LabUnitController::class, 'labunitadd'])->name('labunit.add');
Route::post('edit-lab-unit', [LabUnitController::class, 'labunitedit'])->name('labunit.edit');
Route::post('view-lab-unit', [LabUnitController::class, 'editlabunitview']);
Route::get('block-lab-unit/{id}', [LabUnitController::class, 'block']);
Route::get('unblock-lab-unit/{id}', [LabUnitController::class, 'unblock']);
// LAB UNIT SETUP ENDS HERE 


// REJECT REASON SETUP STARTS HERE 
Route::post('reject-reasons', [RejectReasonController::class, 'rejectreasonadds'])->name('rejectreasonList.add');
Route::get('reject-reason',[RejectReasonController::class,'rejectreasonview']);
//Route::post('reject-reason', [RejectReasonController::class, 'rejectreasonadd'])->name('rejectreasonList.add');

Route::post('edit-reject-reason', [RejectReasonController::class, 'rejectreasonedit'])->name('rejectreason.edit');
Route::post('view-reject-reason', [RejectReasonController::class, 'editrejectreasonview']);
Route::get('block-reject-reason/{id}', [RejectReasonController::class, 'block']);
Route::get('unblock-reject-reason/{id}', [RejectReasonController::class, 'unblock']);


Route::post('reject-reason', [RejectReasonController::class, 'rejectreasonadd_new'])->name('rejectreasonnew.add');
// REJECT REASON SETUP ENDS HERE 

// PARAMETER SETUP STARTS HERE 
Route::get('parameter-setup',[ParameterController::class,'parameterview']);
Route::post('parameter-setup', [ParameterController::class, 'parameteradd'])->name('parameter.add');
Route::get('add-parameter',[ParameterController::class,'addparameter']);
Route::get('edit-parameter/{id}', [ParameterController::class, 'editparameterview']);
Route::post('parameter-edit', [ParameterController::class, 'parameteredit'])->name('parameter.edit');
Route::post('view-parameter', [ParameterController::class, 'viewparameter']);
Route::post('refdelete', [ParameterController::class, 'referencerangedelete']);
Route::get('block-parameter/{id}', [ParameterController::class, 'block']);
Route::get('unblock-parameter/{id}', [ParameterController::class, 'unblock']);
// PARAMETER SETUP ENDS HERE 

// 

// TEST METHOD STARTS HERE 
Route::get('test-method',[TestMethodController::class,'testmethodview']);
Route::post('test-method', [TestMethodController::class, 'testmethodadd'])->name('testmethod.add');
Route::post('edit-test-method', [TestMethodController::class, 'testmethodedit'])->name('testmethod.edit');
Route::post('view-test-method', [TestMethodController::class, 'edittestmethodview']);
Route::get('block-test-method/{id}', [TestMethodController::class, 'block']);
Route::get('unblock-test-method/{id}', [TestMethodController::class, 'unblock']);
// TEST METHOD ENDS HERE 


// ORGANISM SETUP STARTS HERE 
Route::get('organism-setup',[OrganismSetupController::class,'organismsetupview']);
Route::post('organism-setup', [OrganismSetupController::class, 'organismsetupadd'])->name('organism.add');
Route::post('edit-organism-setup', [OrganismSetupController::class, 'organismsetupedit'])->name('organism.edit');
Route::post('view-organism-setup', [OrganismSetupController::class, 'editorganismsetupview']);
Route::get('block-organism-setup/{id}', [OrganismSetupController::class, 'block']);
Route::get('unblock-organism-setup/{id}', [OrganismSetupController::class, 'unblock']);
// ORGANISM SETUP ENDS HERE 


// TEST CATEGORY STARTS HERE 
Route::get('test-category',[TestCategoryController::class,'testcategoryview']);
Route::post('test-category', [TestCategoryController::class, 'testcategoryadd'])->name('testcategory.add');
Route::post('edit-test-category', [TestCategoryController::class, 'testcategoryedit'])->name('testcategory.edit');
Route::post('view-test-category', [TestCategoryController::class, 'edittestcategoryview']);
Route::post('test-category-order-update', [TestCategoryController::class, 'orderingupdate']);
Route::get('block-test-category/{id}', [TestCategoryController::class, 'block']);
Route::get('unblock-test-category/{id}', [TestCategoryController::class, 'unblock']);
// TEST CATEGORY ENDS HERE 

// LOT CODE STARTS HERE 
Route::get('lot-code',[LotCodeController::class,'lotcodeview']);
Route::post('lot-code', [LotCodeController::class, 'lotcodeadd'])->name('lotcode.add');
Route::post('edit-lot-code', [LotCodeController::class, 'lotcodeedit'])->name('lotcode.edit');
Route::post('view-lot-code', [LotCodeController::class, 'editlotcodeview']);
Route::get('block-lot-code/{id}', [LotCodeController::class, 'block']);
Route::get('unblock-lot-code/{id}', [LotCodeController::class, 'unblock']);

// LOT CODE ENDS HERE 

// PAYMENT METHOD STARTS HERE 
Route::get('payment-method',[PaymentMethodController::class,'paymentmethodview']);
Route::post('payment-method', [PaymentMethodController::class, 'paymentmethodadd'])->name('paymentmethod.add');
Route::post('edit-payment-method', [PaymentMethodController::class, 'paymentmethodedit'])->name('paymentmethod.edit');
Route::post('view-payment-method', [PaymentMethodController::class, 'editpaymentmethodview']);
Route::get('block-payment-method/{id}', [PaymentMethodController::class, 'block']);
Route::get('unblock-payment-method/{id}', [PaymentMethodController::class, 'unblock']);
// PAYMENT METHOD ENDS HERE 

// INCOME CATEGORY STARTS HERE 
Route::get('income-category',[IncomeCategoryController::class,'incomecategoryview']);
Route::post('income-category', [IncomeCategoryController::class, 'incomecategoryadd'])->name('incomecategory.add');
Route::post('edit-income-category', [IncomeCategoryController::class, 'incomecategoryedit'])->name('incomecategory.edit');
Route::post('view-income-category', [IncomeCategoryController::class, 'editincomecategoryview']);
Route::get('block-income-category/{id}', [IncomeCategoryController::class, 'block']);
Route::get('unblock-income-category/{id}', [IncomeCategoryController::class, 'unblock']);
// INCOME CATEGORY ENDS HERE 

// EXPENSE CATEGORY STARTS HERE 
Route::get('expense-category',[ExpenseCategoryController::class,'expensecategoryview']);
Route::post('expense-category', [ExpenseCategoryController::class, 'expensecategoryadd'])->name('expensecategory.add');
Route::post('edit-expense-category', [ExpenseCategoryController::class, 'expensecategoryedit'])->name('expensecategory.edit');
Route::post('view-expense-category', [ExpenseCategoryController::class, 'editexpensecategoryview']);
Route::get('block-expense-category/{id}', [ExpenseCategoryController::class, 'block']);
Route::get('unblock-expense-category/{id}', [ExpenseCategoryController::class, 'unblock']);
// EXPENSE CATEGORY ENDS HERE 

// SENSITIVITY STARTS HERE 
Route::get('sensitivity',[SensitivityController::class,'sensitivityview']);
Route::post('sensitivity', [SensitivityController::class, 'sensitivityadd'])->name('sensitivity.add');
Route::post('edit-sensitivity', [SensitivityController::class, 'sensitivityedit'])->name('sensitivity.edit');
Route::post('view-sensitivity', [SensitivityController::class, 'editsensitivityview']);
Route::get('block-sensitivity/{id}', [SensitivityController::class, 'block']);
Route::get('unblock-sensitivity/{id}', [SensitivityController::class, 'unblock']);

// SENSITIVITY ENDS HERE 
Route::get('refund', [RefundController::class, 'refundlist']); 
 Route::post('refundpaymentadd', [RefundController::class, 'addrefund']);  
// INVOICE LIST STARTS HERE
Route::get('invoice-list',[InvoiceController::class,'invoicelistview']);
Route::post('view-invoice', [InvoiceController::class, 'viewinvoicelist']);
Route::post('view-payment', [InvoiceController::class, 'viewpayment']);
Route::post('update-payment', [InvoiceController::class, 'paymentupdate'])->name('payment.update');
Route::post('invoice-list', [InvoiceController::class, 'searchinvoicelist'])->name('payment.search');
Route::post('invoicepay-view', [InvoiceController::class, 'invoicepay_view']);

Route::post('invoicerefund-view', [InvoiceController::class, 'invoice_refundview']);
// INVOICE LIST ENDS HERE


// FINANCE INVOICE LIST STARTS HERE
Route::get('invoice-finance',[FinanceInvoiceController::class,'financeinvoicelistview']);
Route::post('view-invoice-finance', [FinanceInvoiceController::class, 'financeviewinvoicelist']);
Route::post('view-payment-finance', [FinanceInvoiceController::class, 'financeviewpayment']);
Route::post('update-payment-finance', [FinanceInvoiceController::class, 'financepaymentupdate'])->name('financepayment.update');
// FINANCE INVOICE LIST ENDS HERE

// COUNTRY STARTS HERE 
Route::get('country',[CountryController::class,'countryview']);
Route::post('country', [CountryController::class, 'countryadd'])->name('country.add');
Route::post('edit-country', [CountryController::class, 'countryedit'])->name('country.edit');
Route::post('view-country', [CountryController::class, 'editcountryview']);
Route::get('block-country/{id}', [CountryController::class, 'block']);
Route::get('unblock-country/{id}', [CountryController::class, 'unblock']);
// COUNTRY ENDS HERE 

// STATE STARTS HERE 
Route::get('state',[StateController::class,'stateview']);
Route::post('state', [StateController::class, 'stateadd'])->name('state.add');
Route::post('edit-state', [StateController::class, 'stateedit'])->name('state.edit');
Route::post('view-state', [StateController::class, 'editstateview']);
Route::get('block-state/{id}', [StateController::class, 'block']);
Route::get('unblock-state/{id}', [StateController::class, 'unblock']);
// STATE ENDS HERE 


// CITY STARTS HERE 
Route::get('city',[CityController::class,'cityview']);
Route::post('city', [CityController::class, 'cityadd'])->name('city.add');
Route::post('edit-city', [CityController::class, 'cityedit'])->name('city.edit');
Route::post('view-city', [CityController::class, 'editcityview']);
Route::post('load-state', [CityController::class, 'loadstate']); 
Route::get('block-city/{id}', [CityController::class, 'block']);
Route::get('unblock-city/{id}', [CityController::class, 'unblock']);
// CITY ENDS HERE


// BRANCH STARTS HERE 
Route::get('branch',[BranchController::class,'branchview']);
Route::post('branch', [BranchController::class, 'branchadd'])->name('branch.add');
Route::post('edit-branch', [BranchController::class, 'branchedit'])->name('branch.edit');
Route::post('view-branch', [BranchController::class, 'editbranchview']);
Route::post('load-state-branch', [BranchController::class, 'loadstate']); 
Route::post('load-city-branch', [BranchController::class, 'loadcity']); 
Route::get('block-branch/{id}', [BranchController::class, 'block']);
Route::get('unblock-branch/{id}', [BranchController::class, 'unblock']);
// BRANCH ENDS HERE 

// PURCHASE CATEGORY STARTS HERE
Route::get('purchase-category',[PurchaseCategoryController::class,'viewpurchasecategory']);
Route::post('purchase-category',[PurchaseCategoryController::class,'addcategory'])->name('purchase.category');
Route::post('view-purchase-category',[PurchaseCategoryController::class,'editpurchasecategoryview'])->name('purchase.view');
Route::post('purchase-category-edit',[PurchaseCategoryController::class,'purchasecategoryedit'])->name('purchase.edit');
Route::get('block-purchase-category/{id}',[PurchaseCategoryController::class, 'block']);
Route::get('unblock-purchase-category/{id}',[PurchaseCategoryController::class, 'unblock']);
// PURCHASE CATEGORY ENDS HERE


// PURCHASE SUBCATEGORY STARTS HERE
 Route::post('purchase-subcategory',[PurchaseCategoryController::class,'addsubcategory'])->name('purchase.subcategory'); 
 Route::post('view-purchase-subcategory',[PurchaseCategoryController::class,'editpurchasesubcategoryview'])->name('purchase.subcatview');
 Route::post('purchase-subcategory-edit',[PurchaseCategoryController::class,'purchasesubcategoryedit'])->name('purchase.subedit');
 Route::get('block-purchase-subcategory/{id}',[PurchaseCategoryController::class, 'blocksubcat']);
 Route::get('unblock-purchase-subcategory/{id}',[PurchaseCategoryController::class, 'unblocksubcat']);
// PURCHASE SUBCATEGORY ENDS HERE

// MASTER CLIENTS STARTS HERE
Route::get('master-clients-test-price',[ClientsController::class,'showMasterClientTestPrice']);
Route::get('master-clients',[ClientsController::class,'viewclients']);
Route::post('master-clients',[ClientsController::class,'addclients'])->name('master.client');
Route::post('view-clients',[ClientsController::class,'editClientview'])->name('client.view');
Route::post('clients-edit',[ClientsController::class,'clientedit'])->name('client.edit');
Route::get('block-clients/{id}',[ClientsController::class, 'blockClient']);
Route::get('unblock-clients/{id}',[ClientsController::class, 'unblockClient']);
Route::get('update_test_prices/{id}',[ClientsController::class, 'showUpdatePricesForm']);
Route::post('update_test_price',[ClientsController::class,'updatePrices'])->name('update-prices.submit'); 
Route::post('update_test_price_all',[ClientsController::class,'updatePricesAll'])->name('update-prices_all.submit'); 
// MASTER BRAND ENDS HERE


// MASTER BRAND STARTS HERE
Route::get('master-brand',[BrandController::class,'viewmasterbrand']);
Route::post('master-brand',[BrandController::class,'addbrand'])->name('master.brand');
Route::post('view-master-brand',[BrandController::class,'editbrandview'])->name('brand.view');
Route::post('master-brand-edit',[BrandController::class,'brandedit'])->name('brand.edit');
Route::get('block-master-brand/{id}',[BrandController::class, 'blockbrand']);
Route::get('unblock-master-brand/{id}',[BrandController::class, 'unblockbrand']);
// MASTER BRAND ENDS HERE


// MASTER UNIT STARTS HERE
Route::get('master-unit',[UnitController::class,'viewmasterunit']);
Route::post('master-unit',[UnitController::class,'addunit'])->name('master.unit');
Route::post('view-master-unit',[UnitController::class,'editunitview'])->name('unit.view');
Route::post('master-unit-edit',[UnitController::class,'unitedit'])->name('unit.edit');
Route::get('block-master-unit/{id}',[UnitController::class, 'blockunit']);
Route::get('unblock-master-unit/{id}',[UnitController::class, 'unblockunit']);
// MASTER UNIT ENDS HERE


// MASTER SUPPLIER STARTS HERE
//Route::get('master-supplier',[SupplierController::class,'cityview']);
Route::get('master-supplier',[SupplierController::class,'viewmastersupplier']);
Route::post('master-supplier',[SupplierController::class,'addsupplier'])->name('master.supplier');
Route::post('view-master-supplier',[SupplierController::class,'editsupplierview']);
Route::post('master-supplier-edit',[SupplierController::class,'supplieredit'])->name('supplier.edit');
Route::post('load-state',[SupplierController::class,'loadstate']);
Route::post('load-city',[SupplierController::class,'loadcity']);
Route::get('block-master-supplier/{id}',[SupplierController::class, 'blocksupplier']);
Route::get('unblock-master-supplier/{id}',[SupplierController::class, 'unblocksupplier']);
Route::post('supplierview',[SupplierController::class, 'supplierview']);
// MASTER SUPPLIER ENDS HERE

// CLIENT PORTAL STARTS HERE
Route::get('client-portal',[ClientPortalController::class,'clientportalview']);
Route::post('view-client', [ClientPortalController::class, 'viewclientdetails']);
// CLIENT PORTAL ENDS HERE


//RECEIPT STARTS HERE
Route::get('receipt-list',[ReceiptController::class,'receiptlistview']);
Route::post('view-receipt', [ReceiptController::class, 'viewrecepits']);
Route::post('receipt-list', [ReceiptController::class, 'searchreceiptlist'])->name('receipt.search');
// RECEIPT ENDS HERE

//LOG ACTIVITY OR AUDIT TRAIL STARTS HERE
Route::get('audit-trail',[AuditTrailController::class,'audittraillist']);
Route::post('view-audit-trail', [AuditTrailController::class, 'viewaudittrail']);
//LOG ACTIVITY OR AUDIT TRAIL ENDS HERE

//MACHINE MASTER STARTS HERE
Route::get('machine',[MachineController::class,'machinelist']);
Route::post('machine', [MachineController::class, 'machineadd'])->name('machine.add');
Route::post('view-machine', [MachineController::class, 'viewmachine'])->name('machine.view');
Route::post('edit-machine', [MachineController::class, 'machineedit'])->name('machine.edit');
Route::get('block-machine/{id}', [MachineController::class, 'block']);
Route::get('unblock-machine/{id}', [MachineController::class, 'unblock']);
//MACHINE MASTER ENDS HERE

//TUBE MASTER STARTS HERE
Route::get('tube',[TubeController::class,'tubelist']);
Route::post('tube', [TubeController::class, 'tubeadd'])->name('tube.add');
Route::post('view-tube', [TubeController::class, 'viewtube'])->name('tube.view');
Route::post('edit-tube', [TubeController::class, 'tubeedit'])->name('tube.edit');
Route::get('block-tube/{id}', [TubeController::class, 'block']);
Route::get('unblock-tube/{id}', [TubeController::class, 'unblock']);
//TUBE MASTER ENDS HERE

//CONTAINER MASTER STARTS HERE
Route::get('container',[ContainerController::class,'containerlist']);
Route::post('container', [ContainerController::class, 'containeradd'])->name('container.add');
Route::post('view-container', [ContainerController::class, 'viewcontainer'])->name('container.view');
Route::post('edit-container', [ContainerController::class, 'containeredit'])->name('container.edit');
Route::get('block-container/{id}', [ContainerController::class, 'block']);
Route::get('unblock-container/{id}', [ContainerController::class, 'unblock']);
//CONTAINER MASTER ENDS HERE


// PURCHASE LIST STARTS HERE
Route::get('item-purchase-list',[ItemPurchaseController::class,'viewitemlist']);
Route::get('add-purchase-item',[ItemPurchaseController::class,'viewadditempurchase']);
Route::get('edit-purchase-item/{id}', [ItemPurchaseController::class, 'editpurchase']);
Route::post('add-purchase-item',[ItemPurchaseController::class,'additempurchase'])->name('purchase.add');
Route::post('load-subcategory',[ItemPurchaseController::class,'loadsubcategory']);
Route::post('update-purchase-item', [ItemPurchaseController::class, 'updatepurchase']);
Route::post('load-subcat-edit',[ItemPurchaseController::class,'loadsubcategoryedit']);
Route::post('purchaseview', [ItemPurchaseController::class, 'purchaseview']);
// PURCHASE LIST ENDS HERE


// WAREHOUSE STARTS HERE 
Route::get('warehouse',[WareHouseController::class,'viewmasterwarehouse']);
Route::post('warehouse',[WareHouseController::class,'addwarehouse'])->name('master.warehouse');
Route::post('view-master-warehouse',[WareHouseController::class,'editwarehouseview']);
Route::post('master-warehouse-edit',[WareHouseController::class,'warehouseedit'])->name('warehouse.edit');
Route::post('load-state',[WareHouseController::class,'loadstate']);
Route::post('load-city',[WareHouseController::class,'loadcity']);
Route::get('block-master-warehouse/{id}',[WareHouseController::class, 'blockwarehouse']);
Route::get('unblock-master-warehouse/{id}',[WareHouseController::class, 'unblockwarehouse']);
Route::post('warehouseview', [WareHouseController::class, 'warehouseview']);
// WAREHOUSE ENDS HERE 

/*
Route::get('test-result', function () {
    return view('testresult');
});


Route::get('invoice-list', function () {
    return view('invoicelist');
});
*/

//Refund refundpayment.add  
//  Route::get('refund', [RefundController::class, 'refundlist']); 
//  Route::post('refundpaymentadd', [RefundController::class, 'addrefund']);  

Route::get('refunds', function () {
    return view('refund1');
});
 /*
Route::get('client-portal', function () {
    return view('clientportal');
});
*/
Route::get('referral-acknowledgement', function () {
    return view('referral-acknowledgement-portal');
});

// Route::get('call-center', function () {
//     return view('callcenter');
// });



// LEAD CONTROLLER STARTS HERE
Route::get('add-lead',[LeadsController::class,'viewaddlead']); 
Route::get('list-lead',[LeadsController::class,'viewleadlist']); 
Route::post('add-lead',[LeadsController::class,'addlead'])->name('lead.add');
Route::get('edit-lead/{id}', [LeadsController::class, 'editlead']);
Route::post('update-lead', [LeadsController::class, 'updatelead']);
Route::post('leadview', [LeadsController::class, 'leadview']);
Route::post('lead-view', [LeadsController::class, 'leadcollectionupdate']);
Route::get('block-lead/{id}',[LeadsController::class, 'blocklead']);
Route::get('unblock-lead/{id}',[LeadsController::class, 'unblocklead']);
Route::post('updateaction-lead',[LeadUpdateController::class,'addupdatelead'])->name('updateaction.lead');
// LEAD CONTROLLER STARTS HERE




// MASTER LEADSOURCE STARTS HERE
Route::get('master-leadsource',[LeadSourceController::class,'viewmasterleadsource']);
Route::post('master-leadsource',[LeadSourceController::class,'addleadsource'])->name('master.leadsource');
Route::post('view-master-leadsource',[LeadSourceController::class,'editleadsourceview'])->name('leadsource.view');
Route::post('master-leadsource-edit',[LeadSourceController::class,'leadsourceedit'])->name('leadsource.edit');
Route::get('block-master-leadsource/{id}',[LeadSourceController::class, 'blockleadsource']);
Route::get('unblock-master-leadsource/{id}',[LeadSourceController::class, 'unblockleadsource']);
// MASTER LEADSOURCE ENDS HERE


// MASTER LEADSTATUS STARTS HERE
Route::get('master-leadstatus',[LeadstatusController::class,'viewmasterleadstatus']);
Route::post('master-leadstatus',[LeadstatusController::class,'addleadstatus'])->name('master.leadstatus');
Route::post('view-master-leadstatus',[LeadstatusController::class,'editleadstatusview'])->name('leadstatus.view');
Route::post('master-leadstatus-edit',[LeadstatusController::class,'leadstatusedit'])->name('leadstatus.edit');
Route::get('block-master-leadstatus/{id}',[LeadstatusController::class, 'blockleadstatus']);
Route::get('unblock-master-leadstatus/{id}',[LeadstatusController::class, 'unblockleadstatus']);
// MASTER LEADSTATUS ENDS HERE


Route::get('purchase-list', function () {
    return view('purchaselist');
});



// STOCK LIST STARTS HERE
Route::get('stock-list',[StockListController::class,'viewstocklist']); 
Route::get('add-stock-list',[StockListController::class,'viewaddstock']);
Route::post('add-stock-list',[StockListController::class,'addstock'])->name('stock.add');
Route::post('stockview', [StockListController::class, 'stockview']);
// STOCK LIST ENDS HERE



// INSURANCE START
Route::get('Insurance',[InsuranceController::class,'viewinsurancelist']);
Route::get('insurancelist',[InsuranceController::class,'viewinsurancelist'])->name('master.insuranceList');
Route::post('addinsurance',[InsuranceController::class,'addinsurance'])->name('master.insurance');

Route::get('block-insurance/{id}', [InsuranceController::class, 'block']);
Route::get('unblock-insurance/{id}', [InsuranceController::class, 'unblock']);

Route::post('view-master-insurance',[InsuranceController::class,'editinsuranceview']);
Route::post('master-insurance-edit',[InsuranceController::class,'insuranceedit'])->name('insurance.edit');
// INSURANCE END










Route::get('add-purchase', function () {
    return view('addpurchase');
});

Route::get('menu', function () {
    return view('menu');
});


Route::get('testing', function () {
    return view('testing');
});







