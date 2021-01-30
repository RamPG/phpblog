<?php

namespace App\Models;

use App\Http\Requests\UserRegisterRequest;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * @var mixed
     */

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tempEmail()
    {
        return $this->hasOne(TempEmail::class);
    }

    public function tempPassword()
    {
        return $this->hasOne(TempPassword::class);
    }

    public static function createUser(UserRegisterRequest $request)
    {
        return self::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
    }

    public function updatePassword($password)
    {
        return $this->update([
            'password' => $password,
        ]);
    }

    public function updateEmail($email)
    {
        return $this->update([
            'email' => $email,
            'email_verified_at' => Carbon::now(),
            'is_verified' => true,
        ]);
    }


    public function changeIsVerifiedField($isVerified)
    {
        return $this->update([
            'is_verified' => $isVerified,
        ]);
    }

    public function updateUser($name, $avatar)
    {
        return $this->update([
            'avatar' => $avatar ? $avatar : $this->avatar,
            'name' => $name,
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'is_verified',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
