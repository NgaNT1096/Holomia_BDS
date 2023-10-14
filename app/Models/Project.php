<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $table = 'projects';
    protected $fillable = ['id', 'name', 'acreage', 'state', 'category_projects_id ','inverstor_id'];

    public function category()
    {
        return $this->belongsTo(category_project::class, 'category_projects_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'inverstor_id');
    }
    public function address()
    {
        return $this->hasOne(AddressProject::class, 'project_id');
    }
    public function amentities()
    {
        return $this->hasMany(Amenities::class, 'project_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'project_id');
    }
    public function brochure()
    {
        return $this->hasMany(Brochure::class, 'project_id');
    }
    public function block()
    {
        return $this->hasMany(Block::class, 'project_id');
    }

}
