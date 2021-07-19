<?php

use App\Beneficiary;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BeneficiariesController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\VouchersController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\MandateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\IncomeController;
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

//Route::get('/dashboard', function () {
//  return view('main.dashboard');
//})->name('dashboard');
//
Route::get('/dashboard', [HomeController::class, "index"])->name('dashboard');

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


// Payments
Route::get('/payments', [PaymentsController::class, "index"])->name('payments');
Route::post('/update_payment/{id}', [PaymentsController::class, "update_payment"])->name('update_payment');
Route::post('/{id}/delete_payment', [PaymentsController::class, "delete_payment"])->name('delete_payment');


// Incomes
Route::get('/incomes', [IncomeController::class, "index"])->name('incomes');
Route::get('/add_income', [IncomeController::class, "show_add_income"])->name('show_add_income');
Route::post('/create_income', [IncomeController::class, "create_income"])->name('create_income');
Route::post('/upload_income_csv', [IncomeController::class, "importIncome"])->name('upload_income_csv');


Route::get('/mandates', [MandateController::class, "index"])->name('mandates');
Route::get('/create_mandate', [MandateController::class, "show_create_mandate"])->name('show_create_mandate');
Route::get('/mandate/{id}', [MandateController::class, "show_single_mandate"])->name('show_single_mandate');
Route::post('/create_cache_mandate', [MandateController::class, "create_cache_mandate"])->name('create_cache_mandate');
Route::post('/store_mandate', [MandateController::class, "store_mandate"])->name('store_mandate');
Route::post('/delete_mandate', [MandateController::class, "delete_local_mandate"])->name('delete_local_mandate');

//pdf's 
Route::get('pdf/voucher/{id}', [PdfController::class, "Create_pdf_voucher"])->name("create_pdf_voucher");
Route::get('pdf/mandate/{id}', [PdfController::class, "Create_pdf_mandate"])->name("create_pdf_mandate");
Route::get('pdf/mandate/', [PdfController::class, "mandate"])->name("mandate");
Route::get('pdf/cashbook/', [PdfController::class, "create_pdf_cashbook"])->name("create_pdf_cashbook");
Route::post('pdf/cash_book', [PdfController::class, "create_pdf_cashbook_range"])->name('create_pdf_cashbook_range');


//budgets
Route::get('/budgets', [BudgetController::class, "index"])->name('budgets');
Route::get('/add_budget', [BudgetController::class, "show_add_bud"])->name('show_add_budget');
Route::get('/{id}/edit_budget', [BudgetController::class, "show_edit_bud"])->name('show_edit_budget');
Route::post('/create_bud', [BudgetController::class, "create_bud"])->name('create_bud');
Route::post('/{id}/update_bud', [BudgetController::class, "update_bud"])->name('update_bud');
Route::post('/{id}/delete_bud', [BudgetController::class, "delete_bud"])->name('delete_bud');


//Reports
Route::get('/reports', [ReportsController::class, "index"])->name('reports');
Route::get('/single_report', [ReportsController::class, "single"])->name('single');
Route::post('/reports', [ReportsController::class, "generate_reports"])->name('generate_reports');


Auth::routes();
