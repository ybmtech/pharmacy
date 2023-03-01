<?php

namespace App\Http\Controllers;

use App\Models\Drug;
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
     }


      /**
     * showing admin dashboard page
     */
    public function adminDashboard(){
      $drugs=Drug::count();
      $users=User::count();
      
        return view('pages.admin.dashboard',compact('users','drugs'));
    }

     /**
     * showing pharmacy dashboard page
     */
    public function pharmacyDashboard(){
      $drugs=Drug::count();
      
        return view('pages.pharmacy.dashboard',compact('drugs'));
    }

}
