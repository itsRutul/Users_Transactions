<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Rules\DueAmountRule;
class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'username',
        'amount',
        'currency',
        'status',
        'paymethod',
        'datetime',

    ];
    protected $table = 'transactions';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}

