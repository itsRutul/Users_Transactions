<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator; 
use app\Rules\DueAmountRule;
use app\Http\Controllers\TransactionController;

class AppServiceProvider extends ServiceProvider
{
   
    public function boot()
    {
        Validator::extend('due_amount', function ($attribute, $value, $parameters, $validator) {
            $userId = $parameters[0];
            return (new DueAmountRule($userId))->passes($attribute, $value);
        });
    
        Validator::replacer('due_amount', function ($message, $attribute, $rule, $parameters) {
            $userId = $parameters[0];
            return str_replace(':due_amount', (new DueAmountRule($userId))->message(), $message);
        });
    }
    
}
