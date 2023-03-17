<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Complain;
use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderDriver;
use App\Models\Prescription;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    //
      /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth']);
       $this->middleware(['role:admin'])->only(['adminDashboard']);
       $this->middleware(['role:pharmacist'])->only(['pharmacyDashboard']);
       $this->middleware(['role:student|non student'])->only(['patientDashboard']);
     }


      /**
     * showing admin dashboard page
     */
    public function adminDashboard(){
      $drugs=Drug::count();
      $users=User::count();
      $orders=Order::count();
      $complains=Complain::count();
      $expired_drugs=Drug::where('expire_date','<=',now())->orderBy('expire_date')->count();

        return view('pages.admin.dashboard',compact('users','drugs','orders','complains','expired_drugs'));
    }

     /**
     * showing pharmacy dashboard page
     */
    public function pharmacyDashboard(){
      $drugs=Drug::count();
      $orders=Order::count();
      $complains=Complain::count();
      $expired_drugs=Drug::where('expire_date','<=',now())->orderBy('expire_date')->count();

        return view('pages.pharmacy.dashboard',compact('drugs','orders','complains','expired_drugs'));
    }

    /**
     * showing patient dashboard page
     */
    public function patientDashboard(){
        $orders=Order::where('user_id',auth()->user()->id)->count();
        $complains=Complain::where('user_id',auth()->user()->id)->count();
        $appointments=Appointment::where('user_id',auth()->user()->id)->count();
        $cart_items=\Cart::getContent()->count();
        return view('pages.patient.dashboard',compact('orders','complains','cart_items','appointments'));
    }
      /**
     * showing doctor dashboard page
     */
    public function doctorDashboard(){
      $appointments=Appointment::where('doctor_id',auth()->user()->id)->count();
      $prescriptions=Prescription::where('doctor_id',auth()->user()->id)->count();
      return view('pages.doctor.dashboard',compact('appointments','prescriptions'));
  }

    /**
     * showing driver dashboard page
     */
    public function driverDashboard(){
      $orders=OrderDriver::where('driver_id',auth()->user()->id)->count();
      return view('pages.driver.dashboard',compact('orders'));
  }

}
