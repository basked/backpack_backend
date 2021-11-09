<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Group extends Model
{
    use HasApiTokens, HasFactory;

    protected $fillable = ['id', 'name', 'slug', 'is_active'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
