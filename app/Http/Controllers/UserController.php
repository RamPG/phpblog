<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessSendEmailVerification;
use App\Jobs\ProcessSendPasswordVerification;
use App\Models\Comment;
use App\Models\TempEmail;
use App\Models\TempPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
            'email' => 'required|email|unique:users,email|unique:temp_emails,new_email',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        Auth::login($user);
        $tempEmail = TempEmail::create([
            'user_id' => $user->id,
            'new_email' => $request->input('email'),
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
        ProcessSendEmailVerification::dispatch($tempEmail);
        return redirect()->route('verifyEmailPage');
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
            if (Auth::user()->is_verified) {
                session()->flash('success', 'You are logged');
                return redirect()->home();
            } else {
                return redirect()->route('verifyEmailPage');
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

    public function verifyEmailPage()
    {
        return view('user.emailVerifyPage');
    }

    public function verifyEmail(Request $request)
    {
        $tempEmail = TempEmail::where('token', $request->route('token'))->first();
        if ($tempEmail) {
            if (($tempEmail->expires_at >= Carbon::now())) {
                $tempEmail->user->update([
                    'email' => $tempEmail->new_email,
                    'email_verified_at' => Carbon::now(),
                    'is_verified' => true,
                ]);
                $tempEmail->delete();
                session()->flash('success', 'Подтверждено');
                return redirect()->home();
            }
            $tempEmail->delete();
            return redirect()->route('changeEmailForm')->with('error', 'Срок активации прошел');
        }
        return redirect()->route('verifyEmailPage')->with('error', 'Неверный код активации/Срок активации прошел');

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
        if (Auth::user()->is_verified) {
            $request->validate([
                'email' => 'required|email|unique:users,email|unique:temp_emails,new_email,' . Auth::user()->id,
            ]);
        } else {
            $request->validate([
                'email' => 'required|email|unique:users,email,' . Auth::user()->id . '|unique:temp_emails,new_email,' . Auth::user()->id,
            ]);
        }
        $user = Auth::user();
        $tempEmail = TempEmail::where('user_id', $user->id)->first();
        if ($tempEmail) {
            if ($tempEmail->expires_at <= Carbon::now()) {
                $tempEmail->update([
                    'user_id' => $user->id,
                    'new_email' => $request->input('email'),
                    'token' => Str::uuid(),
                    'expires_at' => Carbon::now()->addHours(3),
                ]);
                ProcessSendEmailVerification::dispatch($tempEmail);
                return redirect()->route('verifyEmailPage');
            } else {
                return redirect()->back()->with('error', 'Вы уже меняли почту в течении 3 часов.');
            }
        }
        $tempEmail = TempEmail::create([
            'user_id' => $user->id,
            'new_email' => $request->input('email'),
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
        ProcessSendEmailVerification::dispatch($tempEmail);
        return redirect()->route('verifyEmailPage');
    }

    public function changePasswordForm()
    {
        return view('user.changePasswordForm');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:8',
            'new_password' => 'required|confirmed|min:8',
        ]);
        $password = $request->input('password');
        $newPassword = $request->input('new_password');
        $user = Auth::user();
        if (Hash::check($password, $user->password)) {
            if ($password !== $newPassword) {
                $tempPassword = TempPassword::where('user_id', $user->id)->first();
                if ($tempPassword) {
                    if ($tempPassword->expires_at <= Carbon::now()) {
                        $tempPassword->update([
                            'new_password' => bcrypt($newPassword),
                            'token' => Str::uuid(),
                            'expires_at' => Carbon::now()->addHours(24),
                        ]);
                        ProcessSendPasswordVerification::dispatch($tempPassword);
                        return redirect()->route('verifyPasswordPage');
                    }
                    return redirect()->back()->with('error', 'Вы уже меняли пароль в течении 24 часов.');

                }
                $tempPassword = TempPassword::create([
                    'user_id' => $user->id,
                    'new_password' => bcrypt($newPassword),
                    'token' => Str::uuid(),
                    'expires_at' => Carbon::now()->addHours(24)
                ]);
                ProcessSendPasswordVerification::dispatch($tempPassword);
                return redirect()->route('verifyPasswordPage');
            }
            dd('Старый и новый пароли совпадают');
            return redirect()->back()->with('error', 'Старый и новый пароли совпадают');
        }
        dd('Неправильно введен текущий пароль');
        return redirect()->back()->with('error', 'Неправильно введен текущий пароль');

    }

    public function verifyPasswordPage()
    {
        return view('user.passwordVerifyPage');
    }

    public function verifyPassword(Request $request)
    {
        $tempPassword = TempPassword::where('token', $request->route('token'))->first();
        if ($tempPassword) {
            if ($tempPassword->expires_at >= Carbon::now()) {
                $tempPassword->user->update([
                    'password' => $tempPassword->new_password
                ]);
                $tempPassword->delete();
                session()->flash('success', 'Пароль обновлен');
                return redirect()->home();
            }
            $tempPassword->delete();
            return redirect()->route('changePasswordForm')->with('error', 'Срок активации прошел');
        }
        return redirect()->route('verifyPasswordPage')->with('error', 'Неверный код активации/Срок активации прошел');
    }
}
