<?php

namespace App\Models;

use App\Mail\PriceNotificationMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Mail;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'url',
        'price'
    ];
    public $timestamps = false;
    public function subscriptions(): BelongsToMany {
        return $this->belongsToMany(Subscription::class, 'product_subscription');
    }

    public function notifyAll(int $price) : void {
        $users = $this->subscriptions()->where('confirmed', true)->get();
        foreach ($users as $user) {
            error_log("Notifying {$user->email}");
            Mail::to($user->email)->send(new PriceNotificationMail($price));
        }
    }
}
