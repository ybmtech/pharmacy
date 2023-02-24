<?php

namespace App\Http\Controllers;

use App\Models\LgaOfficer;
use App\Models\LocalGovernment;
use App\Models\LocalGovernmentUser;
use App\Models\PollingUnitUser;
use App\Models\User;
use App\Models\Ward;
use App\Models\WardUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    //
      /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth','role:super admin']);
     }

      /**
     * showing super admin, admin and generation situation room user page
     */
    public function showAdminUserPage(){

        $users=User::whereHas('roles',function($query){
        $query->whereIn('name',['super admin','admin','situation room']);
        })->latest()->get();
        return view('pages.admin.admins',compact('users'));
    }


     /**
     * showing edit super admin, admin and generation situation room user page
     */
    public function showAdminUserEditPage($id){
      $slash_id_prefix=substr($id,5);
      $user_id=substr($slash_id_prefix,0,-4);
      $user=User::with('roles')->where('id',$user_id)->firstOrFail();
      return view('pages.admin.edit-admin',compact('user'));

  }



     /**
     * showing local government officer page
     */
    public function showLgaOfficerPage(){

      $users=User::whereHas('roles',function($query){
      $query->whereIn('name',['lga coalation officer']);
      })->with('lgas')->latest()->get();

      $lgas=LocalGovernment::all();
      return view('pages.admin.lga-officer',compact('users','lgas'));
  }


   /**
   * showing edit local government officer page
   */
  public function showLgaOfficerEditPage($id){
    $slash_id_prefix=substr($id,5);
    $user_id=substr($slash_id_prefix,0,-4);
    $user=User::with('lgas')->where('id',$user_id)->firstOrFail();
    $lgas=LocalGovernment::all();
    return view('pages.admin.edit-lga-officer',compact('user','lgas'));

}



     /**
     * showing ward officer page
     */
    public function showWardOfficerPage(){

      $users=User::whereHas('roles',function($query){
      $query->whereIn('name',['ward officer']);
      })->with(['lgas','wards'])->latest()->get();

      $lgas=LocalGovernment::all();
      return view('pages.admin.ward-officer',compact('users','lgas'));
  }


   /**
   * showing edit ward officer page
   */
  public function showwardOfficerEditPage($id){
    $slash_id_prefix=substr($id,5);
    $user_id=substr($slash_id_prefix,0,-4);
    $user=User::with(['lgas','wards'])->where('id',$user_id)->firstOrFail();
    $lgas=LocalGovernment::all();
    return view('pages.admin.edit-ward-officer',compact('user','lgas'));

}


  /**
     * showing polling unit agent page
     */
    public function showAgentPage(){

      $users=User::whereHas('roles',function($query){
      $query->whereIn('name',['agent']);
      })->with(['lgas','wards','units'])->latest()->get();

      $lgas=LocalGovernment::all();
      return view('pages.admin.agent',compact('users','lgas'));
  }


   /**
   * showing edit polling unit agent page
   */
  public function showAgentEditPage($id){
    $slash_id_prefix=substr($id,5);
    $user_id=substr($slash_id_prefix,0,-4);
    $user=User::with(['lgas','wards','units'])->where('id',$user_id)->firstOrFail();
    $lgas=LocalGovernment::all();
    return view('pages.admin.edit-agent',compact('user','lgas'));

}

    /**
     * add super admin, admin and generation situation room user
     */
    public function addAdmin(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20','unique:users'],
        'user_type'=>['required','string'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250', 'unique:users'],
       'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
       'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(3)],
       ], 
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$password=Hash::make($request->password);

   $user=User::create([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'password'=>$password,
   ]);


   if($user){
  //assign role to user
  $user->assignRole($request->user_type);
  Alert::success('', 'User Registered Successfully');
  return back();
    }

    Alert::info('', 'Fail to register user');
    return back();
}


 /**
     * add local government coalition officer
     */
    public function addLgaOfficer(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20','unique:users'],
        'lga'=>['required','integer'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250', 'unique:users'],
       'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
       'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(3)],
       ], 
       [
        'lga.integer'=>'local government not found'
       ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$password=Hash::make($request->password);

   $user=User::create([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'password'=>$password,
   ]);


   if($user){
     //assign role to user
  $user->assignRole('lga coalation officer');
  //assign lga to user
  LocalGovernmentUser::create([
    'local_government_id'=>$request->lga,
    'user_id'=>$user->id,
  ]);
  Alert::success('', 'Lga Officer Registered Successfully');
  return back();
    }

    Alert::info('', 'Fail to register lga officer');
    return back();
}


  /**
     * edit super admin, admin and generation situation room user
     */
    public function editAdmin(Request $request){
      $validate=Validator::make($request->all(),[
        'user_id'=>['required'],
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'user_type'=>['required','string'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250'],
       'email' => ['required', 'string', 'email', 'max:255'],
         ], 
         [
          'user_id.required'=>'Wrong User'
         ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->user_id,5);
$user_id=substr($slash_id_prefix,0,-4);

$user=User::find($user_id);

if(is_null($user)){
   Alert::info('','User not found');
   return back(); 
}

   $update_user=User::where('id',$user_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
   ]);


   if($update_user){
  //sync role to user
  $user->syncRoles([$request->user_type]);
  Alert::success('', 'User record updated');
  return redirect()->route('admin.users');
    }

    Alert::info('', 'Fail to update user');
    return redirect()->route('admin.users');
}


/**
     * edit local government coalition
     */
    public function editLgaOfficer(Request $request){
      $validate=Validator::make($request->all(),[
        'user_id'=>['required'],
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'lga'=>['required','string'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250'],
       'email' => ['required', 'string', 'email', 'max:255'],
         ], 
         [
          'user_id.required'=>'Wrong Lga Officer',
          'lga.required'=>'local government is required'
         ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->user_id,5);
$user_id=substr($slash_id_prefix,0,-4);

$user=User::find($user_id);

if(is_null($user)){
   Alert::info('','Lga officer not found');
   return back(); 
}

   $update_user=User::where('id',$user_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
   ]);


   if($update_user){
  //sync  user local government
  $user->lgas()->sync([$request->lga]);
  Alert::success('', 'Lga officer record updated');
  return redirect()->route('lga.officers');
    }

    Alert::info('', 'Fail to update lga officer');
    return redirect()->route('lga.officers');
}


/**
     * add local government ward officer
     */
    public function addWardOfficer(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20','unique:users'],
        'lga'=>['required','integer'],
        'ward'=>['required','integer'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250', 'unique:users'],
       'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
       'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(3)],
       ], 
       [
        'lga.integer'=>'local government not found',
        'ward.integer'=>'ward not found',
       ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$password=Hash::make($request->password);

   $user=User::create([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'password'=>$password,
   ]);


   if($user){
     //assign role to user
  $user->assignRole('ward officer');

  //assign local government to user
  LocalGovernmentUser::create([
    'local_government_id'=>$request->lga,
    'user_id'=>$user->id,
  ]);

  //assign ward to user
  WardUser::create([
    'ward_id'=>$request->ward,
    'user_id'=>$user->id,
  ]);
  Alert::success('', 'Ward Officer Registered Successfully');
  return back();
    }

    Alert::info('', 'Fail to register ward officer');
    return back();
}

/**
     * edit local government ward officer
     */
    public function editWardOfficer(Request $request){
      $validate=Validator::make($request->all(),[
        'user_id'=>['required'],
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'lga'=>['required','integer'],
        'ward'=>['required','integer'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250'],
       'email' => ['required', 'string', 'email', 'max:255'],
        ], 
       [
        'user_id.required'=>'Wrong Lga Ward Officer',
        'lga.integer'=>'local government not found',
        'ward.integer'=>'ward not found',
       ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->user_id,5);
$user_id=substr($slash_id_prefix,0,-4);

$user=User::find($user_id);

if(is_null($user)){
   Alert::info('','Lga officer not found');
   return back(); 
}

   $update_user=User::where('id',$user_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
   ]);


   if($user){

    //sync  user local government
  $user->lgas()->sync([$request->lga]);

    //sync  user ward
    $user->wards()->sync([$request->ward]);

  Alert::success('', 'Ward Officer record updated');
  return redirect()->route('ward.officers');
    }

    Alert::info('', 'Fail to update ward officer');
    return redirect()->route('ward.officers');
}

/**
     * add polling unit agent
     */
    public function addUnitAgent(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20','unique:users'],
        'lga'=>['required','integer'],
        'ward'=>['required','integer'],
        'unit'=>['required','integer'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250', 'unique:users'],
       'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
       'password' => ['required', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()->symbols()->uncompromised(3)],
       ], 
       [
        'lga.integer'=>'local government not found',
        'ward.integer'=>'ward not found',
        'unit.integer'=>'unit not found',
       ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$password=Hash::make($request->password);

   $user=User::create([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
    'password'=>$password,
   ]);


   if($user){
     //assign role to user
  $user->assignRole('agent');

  //assign local government to user
  LocalGovernmentUser::create([
    'local_government_id'=>$request->lga,
    'user_id'=>$user->id,
  ]);

  //assign ward to user
  WardUser::create([
    'ward_id'=>$request->ward,
    'user_id'=>$user->id,
  ]);

  //assign unit to agent
  PollingUnitUser::create([
    'polling_unit_id'=>$request->unit,
    'user_id'=>$user->id,
  ]);
  Alert::success('', 'Polling Unit Agent Registered Successfully');
  return back();
    }

    Alert::info('', 'Fail to register polling unit agent');
    return back();
}

/**
     * edit polling unit agent
     */
    public function editUnitAgent(Request $request){
      $validate=Validator::make($request->all(),[
        'user_id'=>['required'],
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'lga'=>['required','integer'],
        'ward'=>['required','integer'],
        'unit'=>['required','integer'],
       //'email' => ['required', 'string', 'email:dns,strict,filter,spoof', 'max:250'],
       'email' => ['required', 'string', 'email', 'max:255'],
        ], 
       [
        'user_id.required'=>'Wrong polling unit agent',
        'lga.integer'=>'local government not found',
        'ward.integer'=>'ward not found',
        'unit.integer'=>'polling unit not found',
       ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->user_id,5);
$user_id=substr($slash_id_prefix,0,-4);

$user=User::find($user_id);

if(is_null($user)){
   Alert::info('','Polling Unit Agent not found');
   return back(); 
}

   $update_user=User::where('id',$user_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone,
    'email'=>$request->email,
   ]);


   if($user){

    //sync  user local government
  $user->lgas()->sync([$request->lga]);

    //sync  user ward
    $user->wards()->sync([$request->ward]);

      //sync  user unit
      $user->units()->sync([$request->unit]);

  Alert::success('', 'Polling Unit Agent record updated');
  return redirect()->route('agent.users');
    }

    Alert::info('', 'Fail to update polling unit agent');
    return redirect()->route('agent.users');
}

 /**
     * delete super admin, admin and generation situation room user
     */

     public function deleteAdminUser(Request $request){

      $validate=Validator::make($request->all(),[
        'user_id' => ['required'],
           ], 
           [
            'user_id.required'=>'Wrong User'
           ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}

$slash_id_prefix=substr($request->user_id,5);
$user_id=substr($slash_id_prefix,0,-4);

$user=User::find($user_id);
if(is_null($user)){
   Alert::info('','User not found');
   return back(); 
}
//delete user
$role= $user->getRoleNames()[0];
  $user->removeRole($role);
$delete_user=$user->delete();

if($delete_user){
   Alert::success('','Deleted');
   return back(); 

}
Alert::info('','Fail to delete');
return back();

     }



}
