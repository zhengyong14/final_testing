<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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
//Route::middleware('auth:api')->get('/user', function (Request $request) {
 //   return $request->user();
//});


Route::post('login',[AuthController::class,'login']);
Route::post('signup',[AuthController::class,'signup']);
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});
Route::apiResource('customer', CustomerController::class)->middleware('auth:api');

Route::get('file-import-export', [UserController::class, 'fileImportExport']);
Route::post('file-import', [UserController::class, 'fileImport'])->name('file-import');
Route::post('delete', [UserController::class, 'delete'])->name('delete');
Route::view('file-delete','file-delete');
Route::get('file-export', [UserController::class, 'fileExport'])->name('file-export');