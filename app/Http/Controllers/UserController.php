<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register/Create Form
    public function create() {
        return view('users.register');
    }
    // Create New User
    public function store(Request $request) {
        $formFields = $request->validate([
            // validation of form fields (submission)
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            // the 'confirmed' field will match another field with the same name "password" with _confirmation, 
            // as in 'password_confirmation' in users/register, a laravel convention
            'password' => 'required|confirmed|min:6'
        ]);

        // Hash password (never store a plain text password), use bcrypt (whatever that is)
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User (User is the model)
        $user = User::create($formFields);

        // Automatically Login
        auth()->login($user);

        return redirect('/')->with('message', 'User created and logged in');
    }
    // logout user
    public function logout(Request $request) {
        // removes the authentication info from the user session so other requests are not authenticated
        auth()->logout();
        // invalidate the user's session and regenerate their csrf token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }
    // show login form
    public function login() {
        return view('users.login');
    }
    // authenticate user, trying the request helper here instead -> request()
    public function authenticate() {
        $formFields = request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);
        // attempt to log the user in
        if(auth()->attempt($formFields)) {
            // regenerate a session id
            request()->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in');
            // Else. You don't want to say invalid email or password,
            // This could cause a security issue, just have one generic credential error message
        }
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }
}
