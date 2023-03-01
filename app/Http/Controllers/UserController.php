<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
      /**
     * The class instance
     */
    public function __construct()
    {
       $this->middleware(['auth','role:admin']);
     }

      /**
     * showing users
     */
    public function create(){

        $users=User::latest()->get();
        $roles=Role::all();
        return view('pages.admin.users',compact('users','roles'));
    }

  /**
     * showing edit user
     */
   public function show($id){
    $slash_id_prefix=substr($id,5);
      $user_id=substr($slash_id_prefix,0,-4);
      $user=User::with('roles')->where('id',$user_id)->firstOrFail();
      $roles=Role::all();
       return view('pages.admin.edit-user',compact('user','roles'));
   }


    /**
     * showing profile
     */
    public function profile(){
      
    return view('pages.profile');

     }

    /**
     * add users
     */
    public function store(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20'],
        'user_type'=>['required','string'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
       'password' => ['required', 'confirmed', Rules\Password::min(8)],
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


    public function changePassword(Request $request){

      $validate=Validator::make($request->all(),[
        'password' => ['required', 'confirmed', Rules\Password::min(8)],
           ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}


$user_id=auth()->user()->id;

$user=User::find($user_id);
if(is_null($user)){
   Alert::info('','User not found');
   return back(); 
}
$password=Hash::make($request->password);
$user->password=$password;
$user->save();
if($user){
   Alert::success('','Password Changed');
   return back(); 

}
Alert::info('','Fail to change password');
return back();

     }


     /**
     * edit user
     */
    public function edit(Request $request){
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
  return redirect()->route('users');
    }

    Alert::info('', 'Fail to update user');
    return redirect()->route('users');
}

     

     /**
     * edit admin profile
     */
    public function editProfile(Request $request){
      $validate=Validator::make($request->all(),[
        'name' => ['required','string','max:200'],
        'phone'=>['required','string','max:20']
         ]
);

if($validate->fails()){
  Alert::info('', $validate->errors()->first());
  return back()->withErrors($validate)->withInput();
}


$user_id=auth()->user()->id;



   $update_user=User::where('id',$user_id)->update([
    'name'=>$request->name,
    'phone'=>$request->phone
   ]);


   if($update_user){

  Alert::success('', 'Profile updated');
  return back();
    }

    Alert::info('', 'Fail to update profile');
    return back();
}

 /**
     * delete user
     */

     public function destroy(Request $request){

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
