<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenities extends Model
{
    use HasFactory;
    protected $table = 'amenities';
    protected $fillable = ['id', 'name','image'];
    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
}
