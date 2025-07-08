<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestModel extends Model
{
    use HasFactory;
        protected $table = 'requests';
        protected $fillable = [
    'client_id',
    'provider_id',
    'category_id',
    'specialization_id', // لو عندك العمود ده
    'price',
    'note',
    'status',
    'scheduled_at', // لو بتستخدمه
];

    public function client()
{
    return $this->belongsTo(User::class, 'client_id');
}
public function specialization()
{
    return $this->belongsTo(Specialization::class);
}

public function provider()
{
    return $this->belongsTo(User::class, 'provider_id');
}

public function category()
{
    return $this->belongsTo(Category::class);
}

}
