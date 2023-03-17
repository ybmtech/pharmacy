<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DoctorController extends Controller
{
       /**
    * The class instance
    */
   public function __construct()
   {
     $this->middleware(['auth','role:doctor']);
    }


    public function appointment(){
        $appointments=Appointment::where('doctor_id',auth()->user()->id)->latest()->get();
        $patients=User::whereHas('roles',function($query){
          $query->whereIn('name',['student','non student']);
          })->latest()->get();
        return view('pages.doctor.appointments',compact('appointments','patients'));
         }

         public function prescription(){
            $prescriptions=Prescription::where('doctor_id',auth()->user()->id)->latest()->get();
            $patients=User::whereHas('roles',function($query){
              $query->whereIn('name',['student','non student']);
              })->latest()->get();
            return view('pages.doctor.prescriptions',compact('prescriptions','patients'));
             }

             public function bookAppointment(Request $request){

                $validate=Validator::make($request->all(),[
                  'patient' => ['required'],
                  'appointment_date'=>['required','date']
                   ]
              );
              
              if($validate->fails()){
                Alert::info('', $validate->errors()->first());
                return back()->withErrors($validate)->withInput();
              }
              
              $doctor_id=auth()->user()->id;
              
              Appointment::create([
                'user_id'=>$request->patient,
                'doctor_id'=>$doctor_id,
                'booking_date'=>$request->appointment_date,
                'booked_date'=>$request->appointment_date,
                'status'=>"approved"
              ]);
              
              $doctor=auth()->user();
              $patient=User::find($request->patient);
              $message="Dr ".ucwords($doctor->name)." has booked an appointment  for you on ".date('d-m-Y H:i a',strtotime($request->appointment_date));
              $patient->notify(new AppointmentNotification($message));
         
              Alert::success('', 'Appointment Booked');
              return back();
               }


               public function savePrescription(Request $request){

                $validate=Validator::make($request->all(),[
                  'patient' => ['required'],
                  'prescription'=>['required']
                   ]
              );
              
              if($validate->fails()){
                Alert::info('', $validate->errors()->first());
                return back()->withErrors($validate)->withInput();
              }
              
              $doctor_id=auth()->user()->id;
              
              Prescription::create([
                'patient_id'=>$request->patient,
                'doctor_id'=>$doctor_id,
                'prescription'=>$request->prescription,
                   ]);
              
              Alert::success('', 'Prescription Saved');
              return back();
               }


               public function editPrescription(Request $request){

                $validate=Validator::make($request->all(),[
                  'prescription_id' => ['required'],
                  'prescription'=>['required']
                ],
                [
                    'prescription_id.required'=>'prescription is required'
                ]
              );
              
              if($validate->fails()){
                Alert::info('', $validate->errors()->first());
                return back()->withErrors($validate)->withInput();
              }
              
                
              Prescription::where('id',$request->prescription_id)->update([
                'prescription'=>$request->prescription
              ]);
               
              Alert::success('', 'Prescription Updated');
              return back();
               }

         public function changeAppointmentStatus(Request $request){

            $validate=Validator::make($request->all(),[
                'appointment_id' => ['required'],
                'status'=>['required']
                 ]
            );
            
            if($validate->fails()){
              Alert::info('', $validate->errors()->first());
              return back()->withErrors($validate)->withInput();
            }

            if($request->status=="approved"){
                $appointment=Appointment::findOrFail($request->appointment_id);
                $appointment->status=$request->status;
                $appointment->booked_date=$appointment->booking_date;
                $appointment->save();
                  
            }
            else{
                $appointment=Appointment::findOrFail($request->appointment_id);
                $appointment->status=$request->status;
                  $appointment->save();
            }
            $doctor=auth()->user();
            $patient=User::find($appointment->user_id);
            $message="Your appointment with Dr ".ucwords($doctor->name)." has been ".$request->status;
            $patient->notify(new AppointmentNotification($message));
            Alert::success('', 'Appointment '.$request->status);
            return back(); 

         }

         public function changeAppointmentDate(Request $request){

            $validate=Validator::make($request->all(),[
                'appointment_id' => ['required'],
                'appointment_date'=>['required']
                 ]
            );
            
            if($validate->fails()){
              Alert::info('', $validate->errors()->first());
              return back()->withErrors($validate)->withInput();
            }

            $appointment=Appointment::findOrFail($request->appointment_id);
                $appointment->booked_date=$request->appointment_date;
                $appointment->save();

                $doctor=auth()->user();
                $patient=User::find($appointment->user_id);
                $message="Your appointment with Dr ".ucwords($doctor->name)." has been reschedule to ". date("d-m-Y",strtotime($request->appointment_date));
                $patient->notify(new AppointmentNotification($message));
            
            Alert::success('', 'Appointment Reschedule');
            return back(); 

         }

}
