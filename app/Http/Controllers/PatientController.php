<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Prescription;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
class PatientController extends Controller
{
     /**
    * The class instance
    */
   public function __construct()
   {
     $this->middleware(['auth','role:student|non student']);
    }

     /**
    * showing category
    */
   public function create(){

     $total_item=\Cart::getContent()->count();
       $drugs=Drug::where('availability',1)->orderBy('name')->paginate(4);
       return view('pages.patient.drugs',compact('drugs','total_item'));
   }


   public function addCart(Request $request){
    $drug=Drug::find($request->drug_id);
   
       \Cart::add([
        'id'=>$drug->id,
        'name'=>$drug->drugName(),
        'price'=>$drug->price,
        'quantity'=>$request->quantity,
        'attributes' => array(
            'image' => $drug->image,
        )
       ]);
       return response()->json([
        'status' => true,
        'total_item' =>\Cart::getContent()->count()
    ],200);
      
   }


   public function cartList(){
    $carts = \Cart::getContent();
    $total=\Cart::getTotal();
    $prescriptions=Prescription::where('patient_id',auth()->user()->id)->latest()->get();
    return view('pages.patient.cart',compact('carts','total','prescriptions'));
   }

   public function removeCart(Request $request)
   {
       \Cart::remove($request->id);
       return redirect()->route('patient.cart');
   }

 public function saveOrder(Request $request){
    $validate=Validator::make($request->all(),[
        'address' => ['required','string'],
        'prescription' => ['required'],
       ], 
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}
$carts = \Cart::getContent();
$previous_order=Order::orderBy('id','desc')->first();
$invoice_start=1000;

if(is_null($previous_order)){
  $invoice_no=$invoice_start;
}
else{
  $invoice_no=$previous_order->invoice_no + 1;
}
$tracking_no=str_shuffle('012345').mt_rand(99,9999);
$total=\Cart::getTotal();

if(auth()->user()->roles->pluck('name')[0]=="student" && $total < 15000){
  $order=Order::create(
    [
        'invoice_no'=>$invoice_no,
        'tracking_no'=>$tracking_no,
        'user_id'=>auth()->user()->id,
        'total'=>$total,
        'payment_status'=>'paid',
        'delivery_address'=>$request->address,
        'prescription_id'=>$request->prescription
    ]
);
}
else{
$order=Order::create(
    [
        'invoice_no'=>$invoice_no,
        'tracking_no'=>$tracking_no,
        'user_id'=>auth()->user()->id,
        'total'=>$total,
        'delivery_address'=>$request->address,
        'prescription_id'=>$request->prescription
    ]
);
}
foreach($carts as $cart){
    OrderItem::create(
        [
            'order_id'=>$order->id,
            'drug_id'=>$cart->id,
            'quantity'=>$cart->quantity,
            'price'=>$cart->price
        ]
    );
    $drug=Drug::find($cart->id);
    $drug->quantity=$drug->quantity - $cart->quantity;
    $drug->save();
}

\Cart::clear();

Alert::success('', 'Order Sent');
return redirect()->route('patient.orders');
 }

 public function appointment(){
  
$appointments=Appointment::where('user_id',auth()->user()->id)->latest()->get();
$doctors=User::whereHas('roles',function($query){
  $query->whereIn('name',['doctor']);
  })->latest()->get();
return view('pages.patient.appointments',compact('appointments','doctors'));
 }

 public function prescription(){
  $prescriptions=Prescription::where('patient_id',auth()->user()->id)->latest()->get();
  return view('pages.patient.prescriptions',compact('prescriptions'));
   }

 public function bookAppointment(Request $request){

  $validate=Validator::make($request->all(),[
    'doctor' => ['required'],
    'appointment_date'=>['required','date']
     ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$user_id=auth()->user()->id;

Appointment::create([
  'user_id'=>$user_id,
  'doctor_id'=>$request->doctor,
  'booking_date'=>$request->appointment_date,
]);

$doctor=User::find($request->doctor);
$message=ucwords(auth()->user()->name)." with patient number ".auth()->user()->patient_no." has booked an appointment with you  on ".date('d-m-Y H:i a',strtotime($request->appointment_date));
$doctor->notify(new AppointmentNotification($message));

Alert::success('', 'Appointment Booked');
return back();
 }


}
