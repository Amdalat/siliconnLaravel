<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed|string',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }

        $formFields = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ];

        $user = User::create($formFields);

        if ($user) {
            auth()->login($user);
            return redirect()->back()->with('success', 'Logged in');
        }else {
            return redirect()->back()->with('error', 'Couldn\'t log in');
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed|string',
        ]);
        if($validator->fails()){
            return redirect()->back()->withInput()->withErrors($validator->errors());
        }
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('success', 'logged out successfully');
    }
}
