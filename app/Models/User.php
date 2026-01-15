<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'surname', 'email', 'phone_number', 'password','role'];
    
    public function recipe()
    {
        return $this->hasMany(Recipe::class);
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\Favorite::class);
    }
    public function favoriteRecipies()
    {
        return $this->belongsTo(\App\Models\Recipe::class, 'favorites');
    }
}