<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
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
     * Set profile image name and save.
     * 
     * @param string $newImage
     */
    public function updateImage(string $newImage): void
    {
        $this->image = $newImage;
        $this->save();
    }

    /**
     * Set profile description and save.
     * 
     * @param string $newDescription
     */
    public function updateDescription(string $newDescription): void
    {
        $this->description = $newDescription;
        $this->save();
    }

    /**
     * Set profile image name and description and save.
     * 
     * @param string $newImage
     * @param string $newDescription
     */
    public function updateImageAndDescription(string $newImage, string $newDescription): void
    {
        $this->image = $newImage;
        $this->description = $newDescription;
        $this->save();
    }
}
