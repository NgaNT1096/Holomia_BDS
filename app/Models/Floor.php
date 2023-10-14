<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    use HasFactory;
    protected $table = 'floors';
    protected $fillable = ['id', 'name','image','block_id'];
    public function block()
    {
        return $this->belongsTo(Project::class,'block_id');
    }
    public function apartment()
    {
        return $this->hasMany(Apartment::class,'apartment_id');
    }
}
