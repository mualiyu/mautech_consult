<?php

use App\Beneficiary;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\PaymentsController;

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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('main.dashboard');
})->name('dashboard');

Route::get('/beneficiaries', [BeneficiariesController::class, "index"])->name('beneficiaries');
Route::get('/add_beneficiary', [BeneficiariesController::class, "show_add_ben"])->name('show_add_beneficiary');
Route::get('/{id}/edit_beneficiary', [BeneficiariesController::class, "show_edit_ben"])->name('show_edit_beneficiary');
Route::post('/create_ben', [BeneficiariesController::class, "create_ben"])->name('create_ben');
Route::post('/{id}/update_ben', [BeneficiariesController::class, "update_ben"])->name('update_ben');
Route::post('/{id}/delete_ben', [BeneficiariesController::class, "delete_ben"])->name('delete_ben');

Route::get('/taxes', [TaxController::class, "index"])->name('taxes');
Route::get('/add_tax', [TaxController::class, "show_add_tax"])->name('show_add_tax');
Route::get('/{id}/edit_tax', [TaxController::class, "show_edit_tax"])->name('show_edit_tax');
Route::post('/create_tax', [TaxController::class, "create_tax"])->name('create_tax');
Route::post('/{id}/update_tax', [TaxController::class, "update_tax"])->name('update_tax');
Route::post('/{id}/delete_tax', [TaxController::class, "delete_tax"])->name('delete_tax');

Route::get('/vouchers', [VouchersController::class, "index"])->name('vouchers');
Route::get('/voucher/{id}', [VouchersController::class, "show_single_voucher"])->name('show_single_voucher');
Route::post('delete_voucher/{id}', [VouchersController::class, "delete_voucher_db"])->name('delete_voucher');
Route::get('/create_voucher', [VouchersController::class, "show_create_voucher"])->name('show_create_voucher');
Route::post('/create_payment', [VouchersController::class, "create_payments"])->name('create_payments');
Route::post('/{id}/delete_payment_from_local', [VouchersController::class, "delete_payment_from_local"])->name('delete_payment_from_local');
Route::post('/create_voucher_and_payments', [VouchersController::class, "create_voucher_and_payments"])->name('create_voucher_and_payments');

Route::get('/payments', [PaymentsController::class, "index"])->name('payments');
Route::get('/{id}/edit_payment', [PaymentsController::class, "show_edit_payment"])->name('show_edit_payment');
Route::post('/{id}/update_payment', [PaymentsController::class, "update_payment"])->name('update_payment');
Route::post('/{id}/delete_payment', [PaymentsController::class, "delete_payment"])->name('delete_payment');

Auth::routes();
