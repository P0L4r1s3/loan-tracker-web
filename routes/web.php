<?php

use App\Http\Controllers\InterestRateController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publico
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Auth default
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {

    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('user.loan');

})->middleware('auth')->name('dashboard');


/*
|--------------------------------------------------------------------------
| Perfil
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->group(function(){

    Route::get('/admin/dashboard', function(){
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::resource('interest-rates', InterestRateController::class);
    Route::resource('commissions', CommissionController::class);

    Route::get('/admin/loans', [LoanController::class, 'index']);

    Route::post('/admin/loans/{loan}/approve', [LoanController::class, 'approve'])
        ->name('loans.approve');

    Route::post('/admin/loans/{loan}/reject', [LoanController::class, 'reject'])
        ->name('loans.reject');

    Route::get('/admin/payments', 
        [PaymentController::class, 'adminIndex']
    )->name('admin.payments');

    Route::patch('/admin/payments/{payment}/approve', 
        [PaymentController::class, 'approve']
    )->name('admin.payments.approve');

    Route::post('/admin/payments/{payment}/confirm',
        [App\Http\Controllers\PaymentController::class, 'confirm']
    )->name('admin.payment.confirm');

    Route::post('/admin/payments/{payment}/reject',
        [App\Http\Controllers\PaymentController::class, 'reject']
    )->name('admin.payment.reject');

    Route::get('/admin/receipt/{payment}', function(\App\Models\Payment $payment){
        return response()->file(storage_path('app/public/'.$payment->receipt));
    })->middleware(['auth','admin'])->name('admin.receipt');


});

/*
|--------------------------------------------------------------------------
| USUARIO NORMAL
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','user'])->group(function(){

    Route::get('/user/dashboard', function(){
        return view('user.loan');
    })->name('user.loan');

    Route::post('/loans/{loan}/payments',[PaymentController::class,'store']);
    Route::get('/loans/{loan}/payments',[PaymentController::class,'show']);
    Route::post('/loans', [LoanController::class,'store'])->name('loans.store');

    

    Route::post('/loans/{loan}/payments',[PaymentController::class,'store'])
    ->middleware('auth');

    Route::get('/payments/create', [PaymentController::class, 'create'])
    ->middleware('auth')
    ->name('payments.create');

    Route::post('/payments', [PaymentController::class, 'store'])
    ->middleware('auth')
    ->name('payments.store');

    Route::get('/user/loan', [LoanController::class, 'userLoan'])
    ->name('user.loan');

    Route::get('/user/receipt/{payment}', function(\App\Models\Payment $payment){

    // Seguridad: verificar que el pago pertenece al usuario autenticado
    if ($payment->loan->user_id !== auth()->id()) {
        abort(403);
    }

    return response()->file(storage_path('app/public/'.$payment->receipt));

})->name('user.receipt');


});


