<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function users(){
        return $this->hasMany(User::class,'role_id');
    }

    protected $casts = [
        'abilities' => 'array'
    ];
}
