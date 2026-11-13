<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'user_id',
        'category_id',
        'content'
    ];
    // Define the relationship between Chat and Category models
    public function user()
    {
        // A chat belongs to a user, so we define a many-to-one relationship
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        // A chat belongs to a category, so we define a many-to-one relationship
        return $this->belongsTo(Category::class);
    }   

}
