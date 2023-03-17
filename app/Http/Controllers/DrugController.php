<?php

namespace App\Http\Controllers;

use App\Models\Drug;
use App\Models\DrugCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DrugController extends Controller
{
      /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth','role:admin|pharmacist']);
     }


      /**
     * showing drug
     */
    public function create(){

        $drugs=Drug::latest()->get();
        $suppliers=Supplier::all();
        $categories=DrugCategory::all();
        return view('pages.admin.drug',compact('drugs','suppliers','categories'));
    }


    /**
     * showing expire drugs
     */
    public function expireDrug(){

      $drugs=Drug::where('expire_date','<=',now())->orderBy('expire_date')->get();
    
      return view('pages.admin.expired-drugs',compact('drugs'));
  }

    /**
     * showing edit drug
     */
   public function show($id){
    $slash_id_prefix=substr($id,5);
      $drug_id=substr($slash_id_prefix,0,-4);
      $drug=Drug::where('id',$drug_id)->firstOrFail();
      $suppliers=Supplier::all();
      $categories=DrugCategory::all();
       return view('pages.admin.edit-drug',compact('drug','suppliers','categories'));
   }


     /**
     * add drug
     */
    public function store(Request $request){
        $validate=Validator::make($request->all(),[
          'name' => ['required','string','max:200'],
          'manufacturer'=>['required','string'],
          'quantity'=>['required','numeric'],
          'price'=>['required','numeric'],
          'dosage' => ['required', 'string'],
          'side_effect' => ['required', 'string'],
          'expire_date' => ['required', 'date'],
          'supplier_id' => ['required'],
          'availability' => ['required'],
          'category_id' => ['required'],
          'image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
         ], 
  );
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }

  if($request->hasFile('image')){
    $image=$request->file('image');
    $image_name=$image->getClientOriginalName();
    $destinationPath=public_path('/images');
    $image->move($destinationPath,$image_name);
  }

  $user_id=auth()->user()->id;
  $validated = $validate->validated();
  $validated['user_id']=$user_id;
  $validated['image']=$image_name;
  $validated['restock_level']=1;
   

     $drug=Drug::create($validated);
  
  
     if($drug){
    Alert::success('', 'Drug Added Successfully');
    return back();
      }
  
      Alert::info('', 'Fail to add drug');
      return back();
  }

/**
     * edit drug
     */
    public function edit(Request $request){

      if($request->hasFile('image')){
        $validate=Validator::make($request->all(),[
          'drug_id'=>['required'],
          'supplier_id' => ['required'],
          'category_id' => ['required'],
          'name' => ['required','string','max:200'],
          'quantity'=>['required','numeric'],
          'manufacturer'=>['required','string','max:20'],
          'price'=>['required','numeric'],
          'dosage' => ['required', 'string'],
          'side_effect' => ['required', 'string'],
          'expire_date' => ['required', 'date'],
          'availability' => ['required'],
          'image'=>'required|image|mimes:jpg,jpeg,png|max:2048',
           ], 
           [
            'drug_id.required'=>'Wrong Drug'
           ]
  );
      }
      else{
        $validate=Validator::make($request->all(),[
          'drug_id'=>['required'],
          'supplier_id' => ['required'],
          'category_id' => ['required'],
          'name' => ['required','string','max:200'],
          'quantity'=>['required','numeric'],
          'manufacturer'=>['required','string','max:20'],
          'price'=>['required','numeric'],
          'dosage' => ['required', 'string'],
          'availability' => ['required'],
          'side_effect' => ['required', 'string'],
          'expire_date' => ['required', 'string'],
           ], 
           [
            'drug_id.required'=>'Wrong Drug'
           ]
  );
      }
       
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }
  
  $slash_id_prefix=substr($request->drug_id,5);
  $drug_id=substr($slash_id_prefix,0,-4);
  
  $drug=Drug::find($drug_id);
  
  if(is_null($drug)){
     Alert::info('','Drug not found');
     return back(); 
  }
  
  $validated = $validate->validated();
  unset($validated['drug_id']);
  
      $update_drug=Drug::where('id',$drug_id)->update($validated);
  
  
     if($update_drug){
    Alert::success('', 'Drug record updated');
    return redirect()->route('drugs');
      }
  
      Alert::info('', 'Fail to update drug');
      return redirect()->route('drugs');
  }
  

  /**
       * restock drug
       */
  
       public function restock(Request $request){
  
        $validate=Validator::make($request->all(),[
          'drug_id' => ['required'],
          'quantity' => ['required'],
             ], 
             [
              'drug_id.required'=>'Wrong Drug'
             ]
  );
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }
  
  $slash_id_prefix=substr($request->drug_id,5);
  $drug_id=substr($slash_id_prefix,0,-4);
  
  $drug=Drug::find($drug_id);
  if(is_null($drug)){
     Alert::info('','Drug not found');
     return back(); 
  }
  //restock drug
  $drug->quantity=$drug->quantity + $request->quantity;
  $drug->restock_level=$drug->restock_level + 1;
  $drug->updated_at=now();
  $restock_drug=$drug->save();
  
  if($restock_drug){
     Alert::success('','Drug Restocked');
     return back(); 
  
  }
  Alert::info('','Fail to restock');
  return back();
  
       }

       
   /**
       * delete drug
       */
  
       public function destroy(Request $request){
  
        $validate=Validator::make($request->all(),[
          'drug_id' => ['required'],
             ], 
             [
              'drug_id.required'=>'Wrong Drug'
             ]
  );
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }
  
  $slash_id_prefix=substr($request->drug_id,5);
  $drug_id=substr($slash_id_prefix,0,-4);
  
  $drug=Drug::find($drug_id);
  if(is_null($drug)){
     Alert::info('','Drug not found');
     return back(); 
  }
  //delete supplier
  
  $delete_drug=$drug->delete();
  
  if($delete_drug){
     Alert::success('','Deleted');
     return back(); 
  
  }
  Alert::info('','Fail to delete');
  return back();
  
       }


}
