<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{
    use HasFactory;
    protected $table = 'apartments';
    protected $fillable = ['id', 'name','code','description','acreage','price','direction','numberOfBedRooms','	numberOfBathrooms','floor_id','project_id','user_id','category_id'];
    public function projects()
    {
        return $this->belongsTo(Project::class,'project_id');
    }
    public function floor()
    {
        return $this->belongsTo(Floor::class,'floor_id');
    }
    public function category()
    {
        return $this->belongsTo(ApartmentCategory::class,'category_id');
    }
}
