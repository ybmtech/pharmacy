<?php

namespace App\Http\Controllers;

use App\Models\DrugCategory;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class DrugCategoryController extends Controller
{
    
     /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth','role:admin|pharmacist']);
     }

      /**
     * showing category
     */
    public function create(){

        $categories=DrugCategory::latest()->get();
        return view('pages.admin.drug-categories',compact('categories'));
    }

    /**
     * showing edit supplier
     */
   public function show($id){
    $slash_id_prefix=substr($id,5);
      $category_id=substr($slash_id_prefix,0,-4);
      $category=DrugCategory::where('id',$category_id)->firstOrFail();
       return view('pages.admin.edit-drug-category',compact('category'));
   }


    public function store(Request $request){
        $validate=Validator::make($request->all(),[
            'name' => ['required','string','max:200','unique:drug_categories'],
           ], 
    );
    
    if($validate->fails()){
      Alert::info('', $validate->errors()->first());
      return back()->withErrors($validate)->withInput();
    }
    
       $category=DrugCategory::create([
        'name'=>$request->name,
       ]);
    
    
       if($category){
      Alert::success('', 'Category Added Successfully');
      return back();
        }
    
        Alert::info('', 'Fail to add category');
        return back();
    }

/**
     * edit category
     */
    public function edit(Request $request){
        $validate=Validator::make($request->all(),[
          'category_id'=>['required'],
          'name' => ['required','string','max:200']
           ], 
           [
            'category_id.required'=>'Wrong Category'
           ]
  );
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }
  
  $slash_id_prefix=substr($request->category_id,5);
  $category_id=substr($slash_id_prefix,0,-4);
  
  $category=DrugCategory::findOrFail($category_id);
  
  
     $update_category=DrugCategory::where('id',$category_id)->update([
      'name'=>$request->name,
     ]);
  
  
     if($update_category){
    Alert::success('', 'Drug Category updated');
    return redirect()->route('drug.category');
      }
  
      Alert::info('', 'Fail to update supplier');
      return redirect()->route('drug.category');
  }
  
       
   /**
       * delete category
       */
  
       public function destroy(Request $request){
  
        $validate=Validator::make($request->all(),[
          'category_id' => ['required'],
             ], 
             [
              'category_id.required'=>'Wrong Category'
             ]
  );
  
  if($validate->fails()){
    Alert::info('', $validate->errors()->first());
    return back()->withErrors($validate)->withInput();
  }
  
  $slash_id_prefix=substr($request->category_id,5);
  $category_id=substr($slash_id_prefix,0,-4);
  
  $category=DrugCategory::findOrFail($category_id);
 
  
  $delete_category=$category->delete();
  
  if($delete_category){
     Alert::success('','Deleted');
     return back(); 
  
  }
  Alert::info('','Fail to delete');
  return back();
  
       }
  


}
