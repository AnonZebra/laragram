<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PhotoComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get the user that posted the comment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
