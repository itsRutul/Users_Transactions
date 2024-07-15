<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'introduction',
        'deposit',
        'total_confirmed_amount',
        'currency',
        'status',
        'due_date',
        
    ];
    protected $table = 'users';
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
