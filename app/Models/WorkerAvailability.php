<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerAvailability extends Model
{
    use HasFactory;
     protected $fillable = ['worker_id', 'day', 'start_time', 'end_time'];

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }
}
