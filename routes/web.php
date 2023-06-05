<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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
Route::any("password", function(){
    abort(404);
});
Route::any("password/email", function(){
    abort(404);
});
Route::any("password/confirm", function(){
    abort(404);
});
Route::any("password/reset", function(){
    abort(404);
});
Route::any("register", function(){
    abort(404);
});

Route::get('forgot', [Controllers\Auth\LoginController::class,"forgotpassword"])->name('forgot');
Route::post('forgot', [Controllers\Auth\LoginController::class,"postforgotpassword"]);

Route::get('rp', [Controllers\Auth\LoginController::class,"resetpassword"])->name('resetpassword');


Route::get('passwordreset', [Controllers\Auth\LoginController::class,"changepassword"])->name('changepassword');
Route::post('passwordreset', [Controllers\Auth\LoginController::class,"postchangepassword"])->name('postchangepassword');

//ajax - ssa
Route::post('ssa', [Controllers\SSAController::class, "getSSA"])->name('ajax-ssa');

//javascript
Route::get('js/ssa', [Controllers\JavascriptController::class, "ssa"])->name('javascript.ssa');


Route::post("library/middle/list", [Controllers\LibraryController::class,"list"])->name("library.middle.list");
Route::post("library/api/list", [Controllers\LibraryController::class,"apiList"])->name("library.api.list");

Route::post("library/middle/upload", [Controllers\LibraryController::class,"upload"])->name("library.middle.upload");
Route::post("library/api/upload", [Controllers\LibraryController::class,"apiUpload"])->name("library.api.upload");

Route::post("library/api/preview", [Controllers\LibraryController::class,"apiPreview"])->name("library.api.preview");

Route::post("library/middle/delete", [Controllers\LibraryController::class,"delete"])->name("library.middle.delete");
Route::post("library/api/delete", [Controllers\LibraryController::class,"apiDelete"])->name("library.api.delete");


Route::group(['middleware' => ['auth']], function () {
    Route::get("library/preview", [Controllers\LibraryController::class,"preview"])->name("library.preview");

	Route::get('', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

	Route::get('vtc', [Controllers\ViewTodayCase::class, 'index'])->name("vtc.index");
    Route::get('vtc/{id}/aor', [Controllers\ViewTodayCase::class, 'aor'])->name("vtc.aor");

	Route::post('vtc/{id}/accept', [Controllers\ViewTodayCase::class, 'accept'])->name("vtc.accept");

    Route::get('cs/cancel', [Controllers\CaseSummaryController::class, 'cancel'])->name("cs.cancel");
	Route::get('cs/release', [Controllers\CaseSummaryController::class, 'release'])->name("cs.release");

	Route::resource('cs', Controllers\CaseSummaryController::class);
	Route::get('prevent', [Controllers\CaseSummaryController::class, 'prevent'])->name("cs.prevent");
	Route::get('accept', [Controllers\CaseSummaryController::class, 'accept'])->name("cs.accept");
	Route::get('onhand', [Controllers\CaseSummaryController::class, 'onhand'])->name("cs.onhand");
    Route::get('project', [Controllers\CaseSummaryController::class, 'project'])->name("cs.project");
    Route::get('cabling', [Controllers\CaseSummaryController::class, 'cabling'])->name("cs.cabling");
	Route::get('service', [Controllers\CaseSummaryController::class, 'service'])->name("cs.service");

	Route::get('cs/{id}/main',[Controllers\CaseSummaryController::class, 'checklistmain'])->name("cs.checklistmain");
	Route::get('cs/{id}/servicecheckin',[Controllers\CaseSummaryController::class, 'servicecheckin'])->name("cs.servicecheckin");
	Route::get('cs/{id}/servicedetails',[Controllers\CaseSummaryController::class, 'servicedetails'])->name("cs.servicedetails");


	Route::get('cs/{customer}/serviceorderlist',[Controllers\CaseSummaryController::class, 'serviceorderlist'])->name("cs.serviceorderlist");
	Route::get('cs/{customer}/equipmentlist',[Controllers\CaseSummaryController::class, 'equipmentlist'])->name("cs.equipmentlist");

	Route::get('cs/{id}/images',[Controllers\CaseSummaryController::class, 'images'])->name("cs.images");

    Route::post('/dropzone/images', [Controllers\DropzoneController::class,'uploadServiceOrderImage'])->name('dropzone.images.upload');
    Route::post('/dropzone/images/{id}/delete', [Controllers\DropzoneController::class,'deleteServiceOrderImage'])->name('dropzone.images.delete');
    Route::get('cs/{id}/imagesdetails',[Controllers\CaseSummaryController::class, 'imagesdetails'])->name("cs.imagesdetails");

    Route::post('library/ServiceOrderImages/{id}', [Controllers\LibraryController::class, 'showByServiceOrer'])->name("library.serviceorder.list");



	Route::post('cs/{id}/servicecheckinnow',[Controllers\CaseSummaryController::class, 'servicecheckinnow'])->name("cs.servicecheckinnow");


    Route::get('cs/{id}/items1',[Controllers\CaseSummaryController::class, 'items'])->name("cs.items1");


    Route::get('cs/{id}/items2',[Controllers\CaseSummaryController::class, 'itemssummary'])->name("cs.items2");

    Route::post('cs/{id}/itemssave',[Controllers\CaseSummaryController::class, 'itemssave'])->name("cs.itemssave");




	Route::post('cs/{id}/save', [Controllers\CaseSummaryController::class, 'save'])->name("cs.save");

	#Route::get('cs/{id}/cctvchecklist',[Controllers\CaseSummaryController::class, 'cctvchecklist'])->name("cs.cctvchecklist");
	Route::get('cs/{id}/signature', [Controllers\CaseSummaryController::class, 'signature'])->name("cs.signature");
	Route::post('cs/{id}/close', [Controllers\CaseSummaryController::class, 'close'])->name("cs.close");
	Route::post('cs/{id}/notclose', [Controllers\CaseSummaryController::class, 'notclose'])->name("cs.notclose");
	Route::post('cs/{id}/finish', [Controllers\CaseSummaryController::class, 'finish'])->name("cs.finish");

});
