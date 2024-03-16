<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'confirmation_token'
    ];
    public $timestamps = false;
    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'product_subscription');
    }
}
