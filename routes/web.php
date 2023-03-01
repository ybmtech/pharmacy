<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\SupplierController;
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
//delete admin user   
Route::delete('/delete', [UserController::class, 'destroy'])->name('delete.user');
//change user password
Route::put('/change-password', [UserController::class, 'changePassword'])->name('user.password');

//Profile  
Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
Route::put('/profile', [UserController::class, 'editProfile'])->name('general.profile.edit');

        //admin
        Route::group(['prefix'=>'admin','middleware'=>'role:admin'],function(){
          //admin dashboard
          Route::get('/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
     
          //user
          Route::group(['prefix'=>'user'],function(){
         Route::get('/', [UserController::class, 'create'])->name('users');
         Route::post('/', [UserController::class, 'store'])->name('user.add');
         Route::get('/edit/{id}', [UserController::class, 'show'])->name('user.show');
         Route::put('/edit', [UserController::class, 'edit'])->name('user.edit');

          });

   //supplier
   Route::group(['prefix'=>'supplier'],function(){
    Route::get('/', [SupplierController::class, 'create'])->name('suppliers');
    Route::post('/', [SupplierController::class, 'store'])->name('supplier.add');
    Route::get('/edit/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::put('/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::delete('/delete',[SupplierController::class, 'destroy'])->name('supplier.delete');

     });



        });

         //drug
   Route::group(['prefix'=>'drug','middleware'=>['role:admin|pharmacist']],function(){
    Route::get('/', [DrugController::class, 'create'])->name('drugs');
    Route::post('/', [DrugController::class, 'store'])->name('drug.add');
    Route::get('/edit/{id}', [DrugController::class, 'show'])->name('drug.show');
    Route::put('/edit', [DrugController::class, 'edit'])->name('drug.edit');
    Route::delete('/delete',[DrugController::class, 'destroy'])->name('drug.delete');

     });

        Route::group(['prefix'=>'pharmacy','middleware'=>'role:pharmacist'],function(){
    //pharmacy dashboard
    Route::get('/dashboard', [DashboardController::class, 'pharmacyDashboard'])->name('pharmacy.dashboard');
     
        });
    

      });

    
