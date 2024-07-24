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
        $users = User::whereNull('deleted_at')
            ->orderBy('created_at', 'asc')
            ->get();
        return response()->json($users);
    }
    public function get_user($id)
    {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found!'], 404);
        }
    }

    function add_user()
    {
        return view('create-user');
    }
    function create_user(Request $request)
    {
        Validator::extend('checkPhone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(84|0[3|5|7|8|9])[0-9]{8}$/', $value);
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
        return response()->json(['success' => 'User created successfully']);
    }

    public function edit_user(Request $request, $id)
    {
        // Find the user by ID
        $user = User::find($id);

        // Check if user exists
        if (!$user) {
            // Return JSON response indicating the user was not found
            return response()->json(['error' => 'User not found!', 'id ' => $id], 404);
        }

        Validator::extend('checkPhone', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(84|0[3|5|7|8|9])[0-9]{8}$/', $value);
        });

        Validator::extend('checkPassword', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{5,}$/', $value);
        });

        // Create the validation rules array
        $rules = [];
        $messages = [];

        if ($request->filled('edit_name')) {
            $rules['edit_name'] = 'min:3|max:10|alpha_num';
            $messages['edit_name.min'] = 'Please enter at least 3 characters';
            $messages['edit_name.max'] = 'Please enter a maximum of 11 characters';
            $messages['edit_name.alpha_num'] = 'Enter only alphanumeric characters';
        }

        if ($request->filled('edit_email')) {
            $rules['edit_email'] = 'email|unique:users,email,' . $id;
            $messages['edit_email.email'] = 'Please enter a valid email address';
            $messages['edit_email.unique'] = 'Email already in use!';
        }

        if ($request->filled('edit_phone_number')) {
            $rules['edit_phone_number'] = 'checkPhone';
            $messages['edit_phone_number.checkPhone'] = 'Please enter a valid phone number';
        }

        if ($request->filled('edit_password')) {
            $rules['edit_password'] = 'min:5|checkPassword';
            $messages['edit_password.min'] = 'Your password must be at least 5 characters long';
            $messages['edit_password.checkPassword'] = 'Password must be at least 5 characters long, contain one uppercase letter, one lowercase letter, one number, and one special symbol';
        }

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update user properties
        if ($request->filled('edit_name')) {
            $user->name = $request->input('edit_name');
        }

        if ($request->filled('edit_email')) {
            $user->email = $request->input('edit_email');
        }

        if ($request->filled('edit_phone_number')) {
            $user->phone_number = $request->input('edit_phone_number');
        }

        // Check if password is provided and update if necessary
        if ($request->filled('edit_password')) {
            $user->password = bcrypt($request->input('edit_password'));
        }

        // Save the updated user
        $user->save();

        // Return success message
        return response()->json(['success' => 'User updated successfully!']);
    }




    function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/admin/employees')->withErrors(['error' => 'User not found!']);
        }
        $user->deleted_at = now();
        $user->save();
           return response()->json(['success' => 'User deleted successfully!']);
        // return redirect('/admin/employees')->with('success', 'User deleted successfully!');
    }
}
