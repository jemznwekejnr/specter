<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\PVController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccessController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PdfController;


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
    return view('auth.login');
});

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');*/

Route::get('/dashboard', [HomeController::class, 'dashboard']);

require __DIR__.'/auth.php';

/*************************** Profile Controller ********************************/

Route::get('/createstaff', [ProfileController::class, 'createstaff']);

Route::get('/profilepics', [ProfileController::class, 'profilepics']);

Route::get('/addsignature', [ProfileController::class, 'addsignature']);

Route::get('/designations', [ProfileController::class, 'designations']);

Route::get('/showdesignations', [ProfileController::class, 'showdesignations']);

Route::get('/departments', [ProfileController::class, 'departments']);

Route::get('/deletedepartment', [ProfileController::class, 'deletedepartment']);

Route::get('/deletedesignation', [ProfileController::class, 'deletedesignation']);

Route::post('/submitdepartment', [ProfileController::class, 'submitdepartment']);

Route::get('/offices', [ProfileController::class, 'offices']);

Route::get('/deleteoffice', [ProfileController::class, 'deleteoffice']);

Route::get('/banks', [ProfileController::class, 'banks']);

Route::get('/deletebank', [ProfileController::class, 'deletebank']);

Route::get('/staffprofile', [ProfileController::class, 'staffprofile']);

Route::post('/submitdesignation', [ProfileController::class, 'submitdesignation']);

Route::post('/submitoffices', [ProfileController::class, 'submitoffices']);

Route::post('/submitbank', [ProfileController::class, 'submitbank']);

Route::post('/submitstaff', [ProfileController::class, 'submitstaff']);

Route::post('/submitpics', [ProfileController::class, 'submitpics']);

Route::post('/submitsignature', [ProfileController::class, 'submitsignature']);

Route::get('/editstaff', [ProfileController::class, 'editstaff']);

Route::get('/convertuser', [ProfileController::class, 'convertuser']);

Route::post('/submiteditstaff', [ProfileController::class, 'submiteditstaff']);

Route::get('/stafftable', [ProfileController::class, 'stafftable']);

Route::get('/usertable', [ProfileController::class, 'usertable']);

Route::get('/userprofile', [ProfileController::class, 'userprofile']);

Route::post('/submitedituser', [ProfileController::class, 'submitedituser']);

Route::get('/updateprofile', [ProfileController::class, 'updateprofile']);

Route::post('/submitupdateprofile', [ProfileController::class, 'submitupdateprofile']);

Route::get('/uploadmypics', [ProfileController::class, 'uploadmypics']);

Route::get('/uploadmysignature', [ProfileController::class, 'uploadmysignature']);

Route::post('/submitmypics', [ProfileController::class, 'submitmypics']);

Route::post('/submitmysignature', [ProfileController::class, 'submitmysignature']);

Route::get('/changepassword', [ProfileController::class, 'changepassword']);

Route::post('/submitpassword', [ProfileController::class, 'submitpassword']);

Route::get('/companyinfo', [ProfileController::class, 'companyinfo']);

Route::post('/submitinfo', [ProfileController::class, 'submitinfo']);

Route::get('/deleteinfo', [ProfileController::class, 'deleteinfo']);


/*************************** Memo Controller *************************************/

Route::get('/creatememo', [MemoController::class, 'creatememo']);

Route::get('/memodetails', [MemoController::class, 'memodetails']);

Route::get('/memoinbox', [MemoController::class, 'memoinbox']);

Route::get('/sentmemo', [MemoController::class, 'sentmemo']);

Route::get('/allmemo', [MemoController::class, 'allmemo']);

Route::post('/submitmemo', [MemoController::class, 'submitmemo']);

Route::post('/memoreaction', [MemoController::class, 'memoreaction']);

Route::post('/submiteditmemo', [MemoController::class, 'submiteditmemo']);

Route::get('/editmemo', [MemoController::class, 'editmemo']);


/**************************** PV Controller **************************************/

Route::get('/paymentvoucher', [PVController::class, 'paymentvoucher']);

Route::get('/pvdetails', [PVController::class, 'pvdetails']);

Route::get('/allpvs', [PVController::class, 'allpvs']);

Route::post('submitpv', [PVController::class, 'submitpv']);

Route::post('submiteditpv', [PVController::class, 'submiteditpv']);

Route::post('submitpvstatus', [PVController::class, 'submitpvstatus']);

Route::get('editpv', [PVController::class, 'editpv']);

Route::get('sentpvs', [PVController::class, 'sentpvs']);


/*************************** Circular Controller *********************************/

Route::get('/createcircular', [CircularController::class, 'createcircular']);

Route::get('/circulardetails', [CircularController::class, 'circulardetails']);

Route::get('/listcirculars', [CircularController::class, 'listcirculars']);

Route::post('submitcircular', [CircularController::class, 'submitcircular']);

Route::post('submitcircularstatus', [CircularController::class, 'submitcircularstatus']);

Route::get('/mycirculars', [CircularController::class, 'mycirculars']);


/**************************** Role Privileges *************************************/

Route::get('/actions', [AccessController::class, 'actions']);

Route::get('/deleteaction', [AccessController::class, 'deleteaction']);

Route::post('/submiaction', [AccessController::class, 'submiaction']);

Route::get('/process', [AccessController::class, 'process']);

Route::get('/deleteprocess', [AccessController::class, 'deleteprocess']);

Route::post('/submitprocess', [AccessController::class, 'submitprocess']);

Route::get('/roles', [AccessController::class, 'roles']);

Route::get('/deleterole', [AccessController::class, 'deleterole']);

Route::post('/submitrole', [AccessController::class, 'submitrole']);

Route::get('/privileges', [AccessController::class, 'privileges']);

Route::post('/submitprivileges', [AccessController::class, 'submitprivileges']);


/**************************** Project Controller *************************************/

Route::get('/createproject', [ProjectController::class, 'createproject']);

Route::get('/projects', [ProjectController::class, 'projects']);

Route::get('/projectdetails', [ProjectController::class, 'projectdetails']);

Route::get('/addtask', [ProjectController::class, 'addtask']);

Route::post('/submitproject', [ProjectController::class, 'submitproject']);

Route::post('/submittask', [ProjectController::class, 'submittask']);

Route::get('/taskdetails', [ProjectController::class, 'taskdetails']);

Route::post('/submittaskupdate', [ProjectController::class, 'submittaskupdate']);

Route::get('/edittask', [ProjectController::class, 'edittask']);

Route::post('/submitedittask', [ProjectController::class, 'submitedittask']);

Route::get('/deletetask', [ProjectController::class, 'deletetask']);

Route::get('/editproject', [ProjectController::class, 'editproject']);

Route::post('/submiteditproject', [ProjectController::class, 'submiteditproject']);

Route::get('/deleteproject', [ProjectController::class, 'deleteproject']);

Route::get('/createinvoice', [ProjectController::class, 'createinvoice']);

Route::get('/getclientinfo', [ProjectController::class, 'getclientinfo']);

Route::post('/submitinvoice', [ProjectController::class, 'submitinvoice']);

Route::get('/allinvoices', [ProjectController::class, 'allinvoices']);

Route::get('/allreceipts', [ProjectController::class, 'allreceipts']);

Route::get('/invoicedetails', [ProjectController::class, 'invoicedetails']);

Route::get('/receiptdetails', [ProjectController::class, 'receiptdetails']);

Route::post('/submitinvoicestatus', [ProjectController::class, 'submitinvoicestatus']);

Route::get('/editinvoice', [ProjectController::class, 'editinvoice']);

Route::post('/submiteditinvoice', [ProjectController::class, 'submiteditinvoice']);

Route::get('/deleteinvoice', [ProjectController::class, 'deleteinvoice']);

/************************** PDF Controller ***********************************************/

Route::get('/viewPDF', [PdfController::class, 'viewPDF']);

Route::get('/invoicepdf', [PdfController::class, 'invoicepdf']);

Route::get('/qrcode', [PdfController::class, 'qrcode']);

Route::get('/receiptpdf', [PdfController::class, 'receiptpdf']);











