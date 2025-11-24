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
}