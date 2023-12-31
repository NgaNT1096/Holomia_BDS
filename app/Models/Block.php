<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use HasFactory;
    protected $table = 'blocks';
    protected $fillable = ['id', 'name','image'];
    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function floors()
    {
        return $this->hasMany(Floor::class,'floor_id');
    }
}
