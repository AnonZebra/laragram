<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\PhotoComment;

class PhotoPost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'description',
        'image',
        'updated_at'
    ];

    /**
     * Get the photo post's associated user comments.
     */
    public function comments()
    {
        return $this->hasMany(PhotoComment::class);
    }
}
