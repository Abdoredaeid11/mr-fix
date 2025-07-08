<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kyc extends Model
{
    use HasFactory;
     protected $fillable = [
        'worker_id',
        'front_image',
        'back_image',
        'selfie_image',
        'status',
        'rejection_reason',
    ];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }




}
