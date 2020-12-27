<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use App\Models\User;

class Comment extends Model
{
    use HasFactory;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateComment($content)
    {
        return $this->update([
            'content' => $content
        ]);
    }

    public static function createComment($requestData, $id)
    {
        return self::create([
            'content' => $requestData['content'],
            'user_id' => $id,
            'post_id' => $requestData['post_id']
        ]);
    }

    protected $fillable = ['content', 'user_id', 'post_id'];
}
