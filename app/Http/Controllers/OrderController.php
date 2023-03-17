<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDriver;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
     /**
    * The class instance
    */
   public function __construct()
   {
     $this->middleware(['auth','role:student|non student'])->only(['patientOrder','handlePaymentGateway','patientPaymentHistory']);
     $this->middleware(['auth','role:admin|pharmacist'])->only(['adminOrder','setDeliveryFee','adminPaymentHistory']);
     $this->middleware(['auth','role:admin|pharmacist|driver'])->only(['changeOrderStatus']);
     $this->middleware(['auth','role:student|non student|admin|pharmacist|driver'])->only(['cancelOrder','invoice']);
    }


    public function patientOrder(){
        $user_id=auth()->user()->id;
    $orders=Order::where('user_id',$user_id)->latest()->get();
     return view('pages.patient.orders',compact('orders'));
    }

    public function driverOrder(){
      $driver_id=auth()->user()->id;
  $orders=User::find($driver_id)->driver_orders;
   return view('pages.driver.orders',compact('orders'));
  }

    public function adminOrder(){
    $orders=Order::latest()->get();
    $drivers=User::whereHas('roles',function($query){
        $query->whereIn('name',['driver']);
        })->latest()->get();
     return view('pages.admin.orders',compact('orders','drivers'));
    }

   public function cancelOrder(Request $request){
     
    Order::where('invoice_no',$request->invoice_no)->update([
        'status'=>'cancelled'
    ]);

    if(isset($request->admin)){
        $order=Order::where('invoice_no',$request->invoice_no)->first();
        $patient=User::find($order->user_id);
        $message="Dear ".ucwords($patient->name)." your order #".$request->invoice_no." has been cancelled by administrator";
         $patient->notify(new AppointmentNotification($message));
        
    }
    Alert::success('', 'Order Cancelled');
    return back();

   }

   Public function invoice($invoice){
   $order=Order::where('invoice_no',$invoice)->first();
   return view('pages.invoice',compact('order'));
   }


   public function setDeliveryFee(Request $request){
     
  $order=Order::findOrFail($request->order_id);
  $order->delivery_fee=$request->delivery_fee;
  $order->save();
        $patient=User::find($order->user_id);
        $message="Dear ".ucwords($patient->name)." your order #".$request->invoice_no." delivery fee is ₦".number_format($request->delivery_fee,2);
         $patient->notify(new AppointmentNotification($message));
        
    Alert::success('', 'Order Delivery Fee Set');
    return back();

   }

   public function changeOrderStatus(Request $request){
     
    $order=Order::findOrFail($request->order_id);
    $order->status=$request->status;
    $order->save();
          $patient=User::find($order->user_id);
          $message="Dear ".ucwords($patient->name)." your order #".$request->invoice_no." has been change to  ".$request->status." by administrator";
           $patient->notify(new AppointmentNotification($message));
          
      Alert::success('', 'Order status changed to '.$request->status);
      return back();
  
     }

     public function assignDriver(Request $request){
     
        $order_driver=OrderDriver::where('order_id',$request->order_id)->first();
        if(!is_null($order_driver)){
            Alert::info('', 'Order has already been assigned a driver');
          return back(); 
        }
        $order=Order::findOrFail($request->order_id);
         $patient=User::find($order->user_id);
    $message="Dear ".ucwords($patient->name)." your order #".$request->invoice_no." has been assign a driver to deliver your order";
    $patient->notify(new AppointmentNotification($message));
              
    OrderDriver::create([
        'order_id'=>$request->order_id,
        'driver_id'=>$request->driver
    ]);
          Alert::success('', 'Driver assigned successful');
          return back();
      
         }


         public function handlePaymentGateway(Request $request){

            $validate=Validator::make($request->all(),[
              'invoice_no'=>'required',
            ]
          );
          
          if($validate->fails()){
            Alert::info('', $validate->errors()->first());
            return back()->withErrors($validate)->withInput();
          }

          $order=Order::where('invoice_no',$request->invoice_no)->first();
          $email=auth()->user()->email;
          $id=auth()->user()->id;
          $amount_with_fee=$order['delivery_fee'] + $order['total'];
          $amount=$amount_with_fee * 100;
          $reference=time().random_int(9,9999);
          $redirect=url('paystack-callback');
           $url = "https://api.paystack.co/transaction/initialize";
            $token=config('app.paystack');
          
        try{
            $response = Http::withToken($token)->withHeaders([
              'accept' => 'application/json'
          ])->post($url, 
          [
            'email' =>$email,
            'amount' =>$amount,
          'reference' =>$reference,
          'callback_url'=>$redirect,
          'channels'=>['card'],
          'metadata'=>json_encode([
            'invoice_no'=>$request->invoice_no,
            'user_id'=>$id
          ])
          ]);
        
          if($response->status()==200){
            return redirect($response['data']['authorization_url']);
          }
          Alert::error('', 'Payment fail try again later');
          return back();
         
        
        }
        catch(Exception $e){

            Alert::info('', 'Please connect to internet');
            return back();
           
        }
          }

          public function paystackCallback(Request $request){
            $validate=Validator::make($request->all(),[
                'reference'=>'required',
            ]
            );
    
            if($validate->fails()){
                Alert::info('', $validate->errors()->first());
                return back();
              }
    
            $url = "https://api.paystack.co/transaction/verify/" . rawurlencode($request->reference);
            $token=config('app.paystack');
            
            try{
              $response = Http::withToken($token)->withHeaders([
              'accept' => 'application/json'
          ])->get($url);
    
          if($response->status()==200){
            if('success' == $response['data']['status']){
              $amount=$response['data']['amount'];
          $reference_id=$response['data']['reference'];
          $user_id=$response['data']['metadata']['user_id'];
        $invoice_no=$response['data']['metadata']['invoice_no'];
            }   
            
        $update_order=Order::where('invoice_no',$invoice_no)->update(['payment_status'=>'paid']);
       
        PaymentHistory::create(
          [
            'user_id'=>$user_id,
            'reference_no'=> $reference_id,
            'transaction_ref'=>$invoice_no,
            'amount'=> $amount,
        ]
        );
        Alert::success('', 'Payment was successful');
        return back();  
    
        }
              }
              catch(Exception $e){
                Alert::success('', 'Payment verification fail');
                return back();  
            }
        }

        public function patientPaymentHistory(){
          $histories=PaymentHistory::where('user_id',auth()->user()->id)->latest()->get();
          return view('pages.patient.payment-histories',compact('histories'));
        }

        public function adminPaymentHistory(){
          $histories=PaymentHistory::latest()->get();
          return view('pages.admin.payment-histories',compact('histories'));
        }
}
