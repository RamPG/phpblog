<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TempPassword extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createTempPassword($newPassword, $id)
    {
        return self::create([
            'user_id' => $id,
            'new_password' => bcrypt($newPassword),
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
    }

    public function updateTempPassword($newPassword)
    {
        return $this->update([
            'new_password' => bcrypt($newPassword),
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
    }

    protected $fillable = ['user_id', 'new_password', 'token', 'expires_at'];
}
