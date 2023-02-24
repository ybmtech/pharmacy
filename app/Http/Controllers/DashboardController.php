<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

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
     }


      /**
     * showing dashboard page
     */
    public function create(){
        return view('pages.dashboard');
    }

}
