<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('payments', 'PaymentApiController');
Route::get('payments/{payment}/list-methods', 'PaymentApiController@listMethods')
    ->name('payments.list-methods');
Route::post('payments/{payment}/choose-method', 'PaymentApiController@chooseMethod')
    ->name('payments.choose-method');