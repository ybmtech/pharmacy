<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FederalContituencyResultController;
use App\Http\Controllers\GeneralResultController;
use App\Http\Controllers\GubernatorialResultController;
use App\Http\Controllers\IncidenceController;
use App\Http\Controllers\PartyController;
use App\Http\Controllers\PresidentialResultController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SenatorialResultController;
use App\Http\Controllers\StateContituencyResultController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',function(){

return view('pages.index');

});

Route::middleware('guest')->group(function () {

   Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.store');
});

Route::middleware('auth')->group(function () {

    //logout
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

        //admin dashboard
      Route::get('/dashboard', [DashboardController::class, 'create'])->name('admin.dashboard');
      });

    
