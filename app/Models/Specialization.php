<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'category_id',
        'name_ar',
        'image',
        'description',
        
    ];
    public function category()
{
    return $this->belongsTo(Category::class);
}

public function users()
{
    return $this->hasMany(User::class);
}
public function requests()
{
    return $this->hasMany(RequestModel::class);
}
public function workers()
{
    return $this->belongsToMany(User::class, 'specialization_user')
                ->withPivot('price')
                ->withTimestamps()
                ->where('users.role', 'worker');
}

}
