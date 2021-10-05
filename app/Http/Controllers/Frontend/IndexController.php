<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class IndexController extends Controller
{
    // Home Page view

    public function index(){
        return view('frontend.index');
    } // end method


    // User logout 
     public function UserLogout(){
        
        Auth::logout();
        return Redirect()->route('login');

     } // end method 


     // User Profile Update 
     public function UserProfileUpdate(){

        $id = Auth::user()->id;
        $user = User::find($id);

        return view('frontend.profile.user_profile_update', compact('user'));
     }// end mathod



      // user profile store    
    public function UserProfileStore(Request $request){

        $data = User::find(Auth::user()->id);
  
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone =$request->phone;
  
  
        if ($request->file('profile_photo_path')) {
          $file = $request->file('profile_photo_path');
          // for auto replace old img 
          @unlink(public_path('upload/users_images/'.$data->profile_photo_path));
          // end rep..
          $filename = date('YmdHi').$file->getClientOriginalName();
          $file->move(public_path('upload/users_images'),$filename);
          $data['profile_photo_path'] = $filename;
  
            }
            $data->save();
  
        // update notification
            $notification = array(
                'message' =>  ' Profile Update Sucessyfuly',
                'alert-type' => 'success'
            ); 
            return redirect()->route('dashboard')->with($notification);
       
  
  
      }// end method


         // user Password change
         public function UserChangePassword(){
            $id = Auth::user()->id;
            $user = User::find($id);
        return view('frontend.profile.user_password_change', compact('user'));
        }// end method
  


          // user password update
          public function UserPasswordUpdate(Request $request){

            $validateData = $request->validate([
                'oldpassword' => 'required',
                'password' => 'required|confirmed',
            ]);

            $hashedPassword = Auth::User()->password;
            if (Hash::check($request->oldpassword,$hashedPassword)) {
            $user = Auth::User();
            $user->password = Hash::make($request->password);
            $user->save();
            Auth::logout();

         // update sms
         $notification = array(
            'message' =>  ' User Password Update Sucessyfully',
            'alert-type' => 'success'
        ); 

            return redirect()->route('user.logout')->with($notification);

            }else{
                return redirect()->back();
            }


        } // end method




} // main end
