<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function workers(){
        return $this->hasMany(Worker::class);
    }
    public function specializations()
{
    return $this->hasMany(Specialization::class);
}


}
