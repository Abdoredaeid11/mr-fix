<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
      protected $fillable = [
        'from_user_id',
        'to_user_id',
        'rating',
        'comment',
        'request_id',
        // أي أعمدة تانية بتستخدمها
    ];
    
    protected static function booted()
{
    static::created(function ($review) {
        $toUser = $review->toUser;

        $averageRating = $toUser->reviewsReceived()->avg('rating');

$toUser->rate = min(round($averageRating, 1), 5);
        $toUser->save();
    });

    static::updated(function ($review) {
        $toUser = $review->toUser;

        $averageRating = $toUser->reviewsReceived()->avg('rating');

$toUser->rate = min(round($averageRating, 1), 5);
        $toUser->save();
    });

    static::deleted(function ($review) {
        $toUser = $review->toUser;

        $averageRating = $toUser->reviewsReceived()->avg('rating');

$toUser->rate = min(round($averageRating, 1), 5);
        $toUser->save();
    });
}

public function toUser()
{
    return $this->belongsTo(User::class, 'to_user_id');
}
    

}
