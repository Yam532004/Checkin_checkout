<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    function get_all_users()
    {
        $users = User::orderBy('created_at', 'asc')->get();
        return response()->json($users);
    }
    function add_user(){
        return view('create-user');
    }
    function create_user(Request $request)
    {
        Validator::extend('checkPhone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/([\+84|84|0]+(3|5|7|8|9|1[2|6|8|9]))+([0-9]{8})\b/', $value);
        });

        Validator::extend('checkPassword', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/', $value);
        });

        $validator =  Validator::make($request->all(), [
            'name' => 'required|min:3|max:10|alpha_num',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|checkPhone',
            'password' => 'required|min:5|checkPassword',
            'confirm_password' => 'required|same:password|checkPassword',
        ], [
            'name.required' => 'Please fill in your username',
            'name.min' => 'Please enter at least 3 characters',
            'name.max' => 'Please enter a maximum of 11 characters',
            'name.alpha_num' => 'Enter only alphanumeric characters',
            'email.required' => 'We need your email address to contact you',
            'email.email' => 'Please enter a valid email address',
            'email.unique' => 'Email already in use!',
            'phone_number.required' => 'Please provide your phone number',
            'phone_number.checkPhone' => 'Please enter a valid phone number',
            'password.required' => 'Please provide a password',
            'password.min' => 'Your password must be at least 5 characters long',
            'password.checkPassword' => 'Password must be at least 5 characters long, contain one uppercase letter, one lowercase letter, one number, and one special symbol',
            'confirm_password.required' => 'Please confirm your password',
            'confirm_password.same' => 'Please enter the same password as above',
            'confirm_password.checkPassword' => 'Password must be at least 5 characters long, contain one uppercase letter, one lowercase letter, one number, and one special symbol',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }


        // create user 
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->role = "user";
        $user->password =  bcrypt($request->password);
        $user->save();
        return response()->json(['success' => 'User created successfully!']);
    }
}
