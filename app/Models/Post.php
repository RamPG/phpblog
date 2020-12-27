<?php

namespace App\Models;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function createPost($requestData, $thumbnail)
    {
        return self::create([
            'title' => $requestData['title'],
            'slug' => Str::slug($requestData['title']),
            'description' => Helper::trimSpaceBeforeSpace($requestData['content'], 100),
            'content' => $requestData['content'],
            'thumbnail' => $thumbnail,
        ]);
    }

    public function updatePost($requestData, $thumbnail)
    {
        return $this->update([
            'title' => $requestData['title'],
            'slug' => Str::slug($requestData['title']),
            'description' => Helper::trimSpaceBeforeSpace($requestData['content'], 100),
            'content' => $requestData['content'],
            'thumbnail' => $thumbnail ? $thumbnail : $this->thumbnail,
        ]);
    }

    protected $fillable = ['title', 'content', 'description', 'thumbnail', 'slug'];
}
