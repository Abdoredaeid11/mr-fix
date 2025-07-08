<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

        public function category()
{
    return $this->belongsTo(Category::class);
}

public function requestsAsClient()
{
    return $this->hasMany(RequestModel::class, 'client_id');
}
public function addresses()
{
    return $this->hasMany(WorkerAddress::class, 'worker_id');
}
public function defaultAddress()
{
    return $this->hasOne(WorkerAddress::class, 'worker_id')
                ->where('defualt',1);
}
public function requestsAsProvider()
{
    return $this->hasMany(RequestModel::class, 'provider_id');
}

public function specialization()
{
    return $this->belongsTo(Specialization::class);
}
public function worker_profile(){
    return $this->hasOne(Worker::class);
}
public function kyc()
{
    return $this->hasOne(Kyc::class, 'worker_id');

}
public function specializations()
{
    return $this->belongsToMany(Specialization::class, 'specialization_user')
                ->withPivot('price')
                ->withTimestamps();
}
public function reviewsGiven()
{
    return $this->hasMany(Review::class, 'from_user_id');
}

// التقييمات اللي جت لي
public function reviewsReceived()
{
    return $this->hasMany(Review::class, 'to_user_id');
}

public function completedRequestsAsProvider()
{
    return $this->hasMany(RequestModel::class, 'provider_id')
                ->where('status', 'completed');
}
public function availabilities()
{
    return $this->hasMany(WorkerAvailability::class, 'worker_id');
}
public function availableTimes()
{
    return $this->hasMany(WorkerAvailability::class, 'worker_id');
}

}
