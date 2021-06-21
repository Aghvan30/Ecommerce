<?php

namespace App\Http\Controllers;
use App\Models\Country;
use Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function userLoginRegister(){
   return view('wayshop.users.login_register');
    }
    public function register(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $userCount=User::where('email',$data['email'])->count();
            if($userCount>0){
                return redirect()->back()->with('flash_message_error','Email is already exists');
            }else{
               //adding user in table
                $user = new User;
                $user->name =$data['name'];
                $user->email =$data['email'];
                $user->password =bcrypt($data['password']);
                $user->save();
                if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                    Session::put('frontSession',$data['email']);
                    return redirect('/cart');
                }
            }

        }
    }
    public function logout(){
        Session::forget('frontSession');
        Auth::logout();
        return redirect('/');
    }
    public function login(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
                Session::put('frontSession',$data['email']);
                return redirect('/cart');
            }else{
                return redirect()->back()->with('flash_message_error','Invalid username and password');
            }
        }
    }
    public function account(Request $request){
        return view('wayshop.users.account');
    }
    public function changePassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $old_pass = User::where('id',Auth::User()->id)->first();
            $current_pass = $data['current_pass'];
            if(Hash::check($current_pass,$old_pass->password)){
                $new_pass =bcrypt($data['new_pass']);
                User::where('id',Auth::User()->id)->update(['password'=>$new_pass]);
                return redirect()->back()->with('flash_message_success','Your Password is Changed Now!');
            }else{
                return redirect()->back()->with('flash_message_error','Old Password is Incorrect!');
            }
        }
      return view('wayshop.users.change_password');
    }
    public function changeAddress(Request $request){
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id);

        if($request->isMethod('post')){
            $data = $request->all();
            $users = User::find($user_id);
            $users->name = $data['name'];
            $users->address = $data['address'];
            $users->city = $data['city'];
            $users->state = $data['state'];
            $users->country = $data['country'];
            $users->pincode = $data['pincode'];
            $users->mobile = $data['mobile'];
            $users->save();
            return redirect()->back()->with('flash_message_success','Account Details Has Been Updated');

        }
        $countries = Country::get();
        return view('wayshop.users.change_address')->with(compact('countries','userDetails'));
    }
}
