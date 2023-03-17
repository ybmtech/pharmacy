<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
class SupplierController extends Controller
{

      /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth','role:admin|pharmacist']);
     }

      /**
     * showing supplier
     */
    public function create(){

        $suppliers=Supplier::latest()->get();
        return view('pages.admin.supplier',compact('suppliers'));
    }

  /**
     * showing edit supplier
     */
   public function show($id){
    $slash_id_prefix=substr($id,5);
      $supplier_id=substr($slash_id_prefix,0,-4);
      $supplier=Supplier::where('id',$supplier_id)->firstOrFail();
       return view('pages.admin.edit-supplier',compact('supplier'));
   }

    /**
     * add supplier
     */
    public function store(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'address'=>['required','string'],
        'email' => ['required', 'string', 'email', 'max:255'],
       ], 
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

   $supplier=Supplier::create([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'address'=>$request->address,
   ]);


   if($supplier){
  Alert::success('', 'Supplier Added Successfully');
  return back();
    }

    Alert::info('', 'Fail to add supplier');
    return back();
}

     /**
     * edit supplier
     */
    public function edit(Request $request){
      $validate=Validator::make($request->all(),[
        'supplier_id'=>['required'],
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'address'=>['required','string'],
        'email' => ['required', 'string', 'email', 'max:255'],
         ], 
         [
          'supplier_id.required'=>'Wrong Supplier'
         ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->supplier_id,5);
$supplier_id=substr($slash_id_prefix,0,-4);

$supplier=Supplier::find($supplier_id);

if(is_null($supplier)){
   Alert::info('','Supplier not found');
   return back(); 
}

   $update_supplier=Supplier::where('id',$supplier_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'address'=>$request->address,
   ]);


   if($update_supplier){
  Alert::success('', 'Supplier record updated');
  return redirect()->route('suppliers');
    }

    Alert::info('', 'Fail to update supplier');
    return redirect()->route('suppliers');
}

     
 /**
     * delete supplier
     */

     public function destroy(Request $request){

      $validate=Validator::make($request->all(),[
        'supplier_id' => ['required'],
           ], 
           [
            'supplier_id.required'=>'Wrong Supplier'
           ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->supplier_id,5);
$supplier_id=substr($slash_id_prefix,0,-4);

$supplier=Supplier::find($supplier_id);
if(is_null($supplier)){
   Alert::info('','Supplier not found');
   return back(); 
}
//delete supplier

$delete_supplier=$supplier->delete();

if($delete_supplier){
   Alert::success('','Deleted');
   return back(); 

}
Alert::info('','Fail to delete');
return back();

     }

}
