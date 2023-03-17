<?php

namespace App\Http\Controllers;

use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ComplainController extends Controller
{

     /**
    * The class instance
    */
   public function __construct()
   {
     $this->middleware(['auth','role:student|non student'])->only(['patientComplain','patientComplainSave']);
     $this->middleware(['auth','role:admin|pharmacist'])->only(['adminComplain','adminComplainSave']);
    }


    public function patientComplain(){
  
        $complains=Complain::where('user_id',auth()->user()->id)->latest()->get();
        return view('pages.patient.complains',compact('complains'));
         }

         public function adminComplain(){
  
            $complains=Complain::latest()->get();
            return view('pages.admin.complains',compact('complains'));
             }


         public function patientComplainSave(Request $request){

            $validate=Validator::make($request->all(),[
                'message' => ['required','string']
               ], 
        );
        
        if($validate->fails()){
          Alert::info('', $validate->errors()->first());
          return back()->withErrors($validate)->withInput();
        }


        Complain::create([
            'user_id'=>auth()->user()->id,
            'message'=>$request->message,
        ]);

        Alert::success('', 'Complain Sent');
        return back();
   
         }

         public function adminComplainSave(Request $request){

            $validate=Validator::make($request->all(),[
                'message' => ['required','string'],
                'complain_id'=>['required']
               ], 
        );
        
        if($validate->fails()){
          Alert::info('', $validate->errors()->first());
          return back()->withErrors($validate)->withInput();
        }


        Complain::where('id',$request->complain_id)->update([
            'reply'=>$request->message,
            'status'=>'closed',
        ]);

        Alert::success('', 'Complain Replied');
        return back();
   
         }

}
