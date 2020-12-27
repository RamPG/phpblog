<?php

namespace App\Models;

use App\Http\Requests\UserRegisterRequest;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TempEmail extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function createTempEmail($newEmail, $id)
    {
        return self::create([
            'user_id' => $id,
            'new_email' => $newEmail,
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
    }

    public function updateTempEmail($newEmail)
    {
        return $this->update([
            'new_email' => $newEmail,
            'token' => Str::uuid(),
            'expires_at' => Carbon::now()->addHours(3),
        ]);
    }

    protected $fillable = ['user_id', 'new_email', 'token', 'expires_at'];
}
