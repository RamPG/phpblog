<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserChangeEmailRequest;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Jobs\ProcessSendEmailVerification;
use App\Jobs\ProcessSendPasswordVerification;
use App\Models\Comment;
use App\Models\TempEmail;
use App\Models\TempPassword;
use App\Services\Contracts\FileServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(FileServiceInterface $fileService, UserServiceInterface $userService)
    {
        $this->fileService = $fileService;
        $this->userService = $userService;
    }

    public function registerForm()
    {
        return view('user.register');
    }

    public function register(UserRegisterRequest $request)
    {
        $user = User::createUser($request);
        Auth::login($user);
        $tempEmail = TempEmail::createTempEmail($request->input('email'), $user->id);
        ProcessSendEmailVerification::dispatch($tempEmail);
        return redirect()->route('verifyEmailPage');
    }

    public function loginForm()
    {
        return view('user.login');
    }

    public function login(UserLoginRequest $request)
    {
        return $this->userService->loginAttempt($request->all()) ?
            redirect()->home()->with('success', 'You are logged')
            :
            redirect()->back()->with('error', 'Incorrect login or password');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->home();
    }

    public function show($id)
    {
        $user = User::find($id);
        $comments = Comment::where('user_id', '=', $id)->with('post')->paginate(5);
        return view('user.show', compact('user', 'comments'));
    }

    public function verifyEmailPage()
    {
        return view('user.emailVerifyPage');
    }

    public function verifyEmail(Request $request)
    {
        $tempEmail = TempEmail::where('token', $request->route('token'))->firstOrFail();
        if (($tempEmail->expires_at >= Carbon::now())) {
            $tempEmail->user->updateEmail($tempEmail->new_email);
            return redirect()->home()->with('success', 'Подтверждено');
        }
        return redirect('changeEmailForm')->with('error', 'Срок активации истек');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', ['user' => $user]);
    }

    public function update(UserUpdateRequest $request)
    {
        $user = Auth::user();
        $requestData = $request->all();
        $avatar = $this->fileService->handleUploadedImage($requestData, 'avatar');
        $user->updateUser($requestData['name'], $avatar);
        return redirect()->route('user.show', ['user' => $user->id]);
    }

    public function changeEmailForm()
    {
        return view('user.changeEmailForm');
    }

    public function changeEmail(UserChangeEmailRequest $request)
    {
        $user = Auth::user();
        $tempEmail = TempEmail::where('user_id', $user->id)->first();
        if ($tempEmail) {
            if ($tempEmail->expires_at <= Carbon::now()) {
                $tempEmail->updateTempEmail($request->input('email'));
            } else {
                return redirect()->back()->with('error', 'Вы уже меняли почту в течении 3 часов.');
            }
        } else {
            $tempEmail = TempEmail::createTempEmail($request->input('email'), $user->id);
        }
        $user->changeIsVerifiedField(false);
        ProcessSendEmailVerification::dispatch($tempEmail);
        return redirect()->route('verifyEmailPage');
    }

    public function changePasswordForm()
    {
        return view('user.changePasswordForm');
    }

    public function changePassword(UserChangePasswordRequest $request)
    {
        $password = $request->input('password');
        $newPassword = $request->input('new_password');
        $user = Auth::user();
        if (Hash::check($password, $user->password)) {
            $tempPassword = TempPassword::where('user_id', $user->id)->first();
            if ($tempPassword) {
                if ($tempPassword->expires_at <= Carbon::now()) {
                    $tempPassword->updateTempPassword($newPassword);
                }
                return redirect()->back()->with('error', 'Вы уже меняли пароль в течении 24 часов.');

            } else {
                $tempPassword = TempPassword::createTempPassword($newPassword, $user->id);
            }
            ProcessSendPasswordVerification::dispatch($tempPassword);
            return redirect()->route('verifyPasswordPage');
        }
        return redirect()->back()->with('error', 'Неправильно введен текущий пароль');

    }

    public function verifyPasswordPage()
    {
        return view('user.passwordVerifyPage');
    }

    public function verifyPassword(Request $request)
    {
        $tempPassword = TempPassword::where('token', $request->route('token'))->firstOrFail();
        if ($tempPassword->expires_at >= Carbon::now()) {
            $tempPassword->user->updatePassword($tempPassword->new_password);
            return redirect()->home()->with('Пароль обновлен');
        }
        return redirect()->route('changePasswordForm')->with('error', 'Срок активации истек');
    }
}
