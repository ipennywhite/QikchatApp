<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    // Define the fillable attributes for mass assignment
    protected $fillable = [
        'name',
        'slug',
    ];
    // Define the relationship between Category and Chat models
    public function chats(){
        // A category can have many chats, so we define a one-to-many relationship
        return $this->hasMany(Chat::class);
    }
}
