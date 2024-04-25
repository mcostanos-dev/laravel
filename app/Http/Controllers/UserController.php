<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    //Create an account view
    public function create(Request $request)
    {
        return view('users.register');
    }

    //Create an account
    public function store(Request $request)
    {
        $validatedFields = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'different:email', 'regex:/^(?=.*[a-zA-Z])[\w@#$%^&*()-+=~!]+$/'],
            'password_confirmation' => 'required|string|min:8',
        ]);

        //Hashed Password
        $validatedFields['password'] = bcrypt($validatedFields['password']);

        //Create user
        $user = User::create($validatedFields);

        auth()->login($user);

        return redirect('/')->with('message', 'Account created and logged in!');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/')->with('message', "You have been logged out");
    }

    public function login()
    {
        return view('users.login');
    }

    //Authenticate user
    public function authenticate(Request $request)
    {
        $validatedFields = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => 'required',
        ]);

        // Check if the 'remember' checkbox is checked
        $remember = $request->filled('remember') ? true : false;


        if (auth()->attempt($validatedFields, $remember)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'Successfully logged in!');
        }

        return back()->withErrors(['email' => 'The provided credentials do not match our records'])->onlyInput('email')->with('message', 'Please try again');
    }
}
