<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSubscription extends Model
{
    use HasFactory;

    protected $table = 'product_subscription';
    public $timestamps = false;
}
