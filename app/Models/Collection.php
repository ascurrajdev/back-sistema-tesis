<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collection extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    public function details(){
        return $this->hasMany(CollectionDetail::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
