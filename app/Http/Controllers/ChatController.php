<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ChatController extends Controller
{
    //

    public function doctor($id=null){
          
        $patients=User::whereHas('roles',function($query){
            $query->whereIn('name',['student','non student']);
            })->latest()->get();
            if($id==null){
                $chats=[];
            }
            else{
        $chats=Chat::where('doctor_id',auth()->user()->id)->where('patient_id',$id)->get();  
     
            }
          return view('pages.doctor-chat',compact('patients','id','chats'));  
    }


    public function patient($id=null){
          
        $doctors=User::whereHas('roles',function($query){
            $query->whereIn('name',['doctor']);
            })->latest()->get();
            
            if($id==null){
                $chats=[];
            }
            else{
        $chats=Chat::where('patient_id',auth()->user()->id)->where('doctor_id',$id)->get();  
     
            }
          return view('pages.chat',compact('doctors','id','chats')); 
    }


    public function doctorSaveChat(Request $request){

        $validate=Validator::make($request->all(),[
            'message' => ['required','string'],
            'patient_id'=>['required']
           ], 
           [
            'patient_id.required'=>'Patient is not selected'
           ]
    );
    
    if($validate->fails()){
      Alert::info('', $validate->errors()->first());
      return back()->withErrors($validate)->withInput();
    }

    $validated = $validate->validated();
    $validated['doctor_id']=auth()->user()->id;
    $validated['sender_id']=auth()->user()->id;
    Chat::create( $validated);
    return back();

    }

    public function patientSaveChat(Request $request){

        $validate=Validator::make($request->all(),[
            'message' => ['required','string'],
            'doctor_id'=>['required']
           ], 
           [
            'doctor_id.required'=>'Doctor is not selected'
           ]
    );
    
    if($validate->fails()){
      Alert::info('', $validate->errors()->first());
      return back()->withErrors($validate)->withInput();
    }

    $validated = $validate->validated();
    $validated['patient_id']=auth()->user()->id;
    $validated['sender_id']=auth()->user()->id;
    Chat::create( $validated);
    return back();

    }


}
