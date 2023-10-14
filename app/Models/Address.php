<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $table = 'addresses';
    protected $fillable = ['id', 'name'];
    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function user()
    {
        return $this->belongsTo(Address::class,'user_id');
    }
}
