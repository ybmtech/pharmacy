<?php
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DrugCategoryController;
use App\Http\Controllers\DrugController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PatientController;
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



        });

         //supplier
   Route::group(['prefix'=>'supplier','middleware'=>['role:admin|pharmacist']],function(){
    Route::get('/', [SupplierController::class, 'create'])->name('suppliers');
    Route::post('/', [SupplierController::class, 'store'])->name('supplier.add');
    Route::get('/edit/{id}', [SupplierController::class, 'show'])->name('supplier.show');
    Route::put('/edit', [SupplierController::class, 'edit'])->name('supplier.edit');
    Route::delete('/delete',[SupplierController::class, 'destroy'])->name('supplier.delete');

     });

        //category
        Route::group(['prefix'=>'category','middleware'=>['role:admin|pharmacist']],function(){

        //drug category
          Route::get('/', [DrugCategoryController::class, 'create'])->name('drug.category');
    Route::post('/', [DrugCategoryController::class, 'store'])->name('drug.category.add');
    Route::get('/edit/{id}', [DrugCategoryController::class, 'show'])->name('drug.category.show');
    Route::put('/edit', [DrugCategoryController::class, 'edit'])->name('drug.category.edit');
    Route::delete('/delete',[DrugCategoryController::class, 'destroy'])->name('drug.category.delete');

        });
         //drug
   Route::group(['prefix'=>'drug','middleware'=>['role:admin|pharmacist']],function(){
    Route::get('/', [DrugController::class, 'create'])->name('drugs');
    Route::post('/', [DrugController::class, 'store'])->name('drug.add');
    Route::get('/edit/{id}', [DrugController::class, 'show'])->name('drug.show');
    Route::put('/edit', [DrugController::class, 'edit'])->name('drug.edit');
    Route::put('/restock', [DrugController::class, 'restock'])->name('drug.restock');
    Route::delete('/delete',[DrugController::class, 'destroy'])->name('drug.delete');
    Route::get('/expire-drugs', [DrugController::class, 'expireDrug'])->name('drugs.expired');
     });


     //complain
     Route::group(['prefix'=>'complains','middleware'=>['role:admin|pharmacist']],function(){
      Route::get('/', [ComplainController::class, 'adminComplain'])->name('admin.complains');
      Route::post('/', [ComplainController::class, 'adminComplainSave'])->name('admin.complain.reply');
     });  

     //Payment History
     Route::group(['prefix'=>'payment','middleware'=>['role:admin|pharmacist']],function(){
     Route::get('/histories', [OrderController::class, 'adminPaymentHistory'])->name('admin.payment.history');
     });
       //order admin/pharmacy
       Route::group(['prefix'=>'order','middleware'=>['role:admin|pharmacist']],function(){
          Route::get('/', [OrderController::class, 'adminOrder'])->name('admin.orders');
          Route::put('/delivery-fee', [OrderController::class, 'setDeliveryFee'])->name('admin.order.fee');
          Route::post('/assign-driver', [OrderController::class, 'assignDriver'])->name('admin.order.assign.driver');
      
        });

        Route::put('/order-status', [OrderController::class, 'changeOrderStatus'])->name('admin.order.status');
   

        Route::group(['prefix'=>'pharmacy','middleware'=>'role:pharmacist'],function(){
    //pharmacy dashboard
    Route::get('/dashboard', [DashboardController::class, 'pharmacyDashboard'])->name('pharmacy.dashboard');
    
        });

        Route::group(['prefix'=>'patient','middleware'=>'role:student|non student'],function(){
         //patient dashboard
     Route::get('/dashboard', [DashboardController::class, 'patientDashboard'])->name('patient.dashboard');
     Route::get('/drugs', [PatientController::class, 'create'])->name('patient.drug');
     Route::get('/cart', [PatientController::class, 'cartList'])->name('patient.cart');
     Route::post('/add-cart',[PatientController::class,'addCart'])->name('patient.add-cart');
     Route::delete('/remove-cart',[PatientController::class,'removeCart'])->name('patient.remove-cart');
     Route::post('/save-order',[PatientController::class,'saveOrder'])->name('patient.order.saved');
      Route::get('/orders',[OrderController::class,'patientOrder'])->name('patient.orders');
      Route::post('/order-payment',[OrderController::class,'handlePaymentGateway'])->name('patient.order.payment');
      Route::get('/appointments',[PatientController::class,'appointment'])->name('patient.appointments');
      Route::post('/appointments',[PatientController::class,'bookAppointment'])->name('patient.appointment.save');
      Route::get('/prescriptions',[PatientController::class,'prescription'])->name('patient.prescriptions');
      Route::get('/complains',[ComplainController::class,'patientComplain'])->name('patient.complains');
      Route::post('/complains',[ComplainController::class,'patientComplainSave'])->name('patient.complain.save');
      Route::get('/patient-histories', [OrderController::class, 'patientPaymentHistory'])->name('patient.payment.history');
    
    });

              Route::group(['prefix'=>'doctor','middleware'=>'role:doctor'],function(){
                //doctor dashboard
            Route::get('/dashboard', [DashboardController::class, 'doctorDashboard'])->name('doctor.dashboard');
            Route::get('/appointments', [DoctorController::class, 'appointment'])->name('doctor.appointments');
            Route::post('/appointments', [DoctorController::class, 'bookAppointment'])->name('doctor.appointment.book');
            Route::put('/change-appointment-status', [DoctorController::class, 'changeAppointmentStatus'])->name('doctor.appointment.status');
            Route::put('/change-appointment-date', [DoctorController::class, 'changeAppointmentDate'])->name('doctor.appointment.reschedule');
            Route::get('/prescriptions', [DoctorController::class, 'prescription'])->name('doctor.prescription');
            Route::post('/prescriptions', [DoctorController::class, 'savePrescription'])->name('doctor.prescription.save');
            Route::put('/edit-prescription', [DoctorController::class, 'editPrescription'])->name('doctor.prescription.edit');
          
                     });

                     Route::group(['prefix'=>'driver','middleware'=>'role:driver'],function(){
                      //doctor dashboard
                  Route::get('/dashboard', [DashboardController::class, 'driverDashboard'])->name('driver.dashboard');

                  Route::get('/orders', [OrderController::class, 'driverOrder'])->name('driver.orders');
                    
                           });
     
    //cancel order
    Route::put('/cancel-order',[OrderController::class,'cancelOrder'])->name('order.cancel');
    //order invoice
    Route::get('/order/{invoice}/invoice',[OrderController::class,'invoice'])->name('order.invoice');
     
    //Read notification
    Route::get('/read-notification/{notification_id}',[UserController::class,'notification'])->name('notification.read');

    //paytack callback
    Route::get('/paystack-callback',[OrderController::class,'paystackCallback'])->name('paystack.callback');
   
       Route::get('/chat/{id?}',[ChatController::class,'patient'])->name('patient.chat');
       Route::post('/chat',[ChatController::class,'patientSaveChat'])->name('patient.chat.save');

       Route::get('/doctor/chat/{id?}',[ChatController::class,'doctor'])->name('doctor.chat');
       Route::post('/doctor/chat',[ChatController::class,'doctorSaveChat'])->name('doctor.chat.save');

      });

    
     