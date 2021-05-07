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

Route::post('login',[AuthController::class,'login']);
Route::post('signup',[AuthController::class,'signup']);
Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});
Route::apiResource('customer', CustomerController::class)->middleware('auth:api');
Route::get('file-import-export', [UserController::class, 'fileImportExport']);
Route::post('file-import', [UserController::class, 'fileImport'])->middleware('auth:api')->name('file-import');
Route::get('file-export', [UserController::class, 'fileExport'])->middleware('auth:api')->name('file-export');