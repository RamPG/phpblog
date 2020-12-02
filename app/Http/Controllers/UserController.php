<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSendEmailVerification;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registerForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:5',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'email_verify_code' => Str::random(10),
        ]);
        Auth::login($user);
        ProcessSendEmailVerification::dispatch($user);
        return redirect()->route('verifyEmailForm');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ], $request->input('remember-me'))) {
            if (Auth::user()->verified) {
                session()->flash('success', 'You are logged');
                return redirect()->home();
            } else {
                return redirect()->route('verifyEmailForm');
            }

        }
        return redirect()->back()->with('error', 'Incorrect login or password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->home();
    }

    public function show($id)
    {
        $user = User::find($id);
        $comments = Comment::where('user_id', '=', $id)->paginate(5);
        return view('user.show', compact('user', 'comments'));
    }

    public function verifyEmailForm()
    {
        return view('user.emailVerifyForm', ['email' => Auth::user()->email]);
    }

    public function verifyEmail(Request $request)
    {
        Auth::user()->update([
            'email_verified_at' => now(),
            'verified' => true,
        ]);
        session()->flash('success', 'Подтверждено');
        return redirect()->home();
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'avatar' => 'image',
            'name' => 'required|min:5|unique:users,name,' . $user->id,
        ]);
        $avatar = '';
        if ($request->hasFile('avatar')) {
            $folder = date('Y-m-d');
            $avatar = $request->file('avatar')->store("images/{$folder}");
        }
        $user->update([
            'avatar' => $avatar ? $avatar : $user->avatar,
            'name' => $request->input('name'),
        ]);
        return redirect()->route('user.show', ['user' => $user->id]);
    }

    public function changeEmailForm()
    {
        return view('user.changeEmailForm');
    }

    public function changeEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        $user = User::find(Auth::user()->id);
        $user->update([
            'email' => $request->input('email'),
            'email_verified_at' => NULL,
            'verified' => false,
            'email_verify_code' => Str::random(10),
        ]);
        ProcessSendEmailVerification::dispatch($user);
        return redirect()->route('verifyEmailForm');
    }
}
