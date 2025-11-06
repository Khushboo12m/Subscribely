<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
    'service_name',
    'category',
    'amount',
    'billing_cycle',
    'next_renewal_date',
    'notification_email',
    'user_id', 

];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

        public static function categories()
    {
        return config('subscribely.categories', []);
    }

}
