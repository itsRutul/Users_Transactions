<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\User;
use Carbon\Carbon;

class DueAmountRule implements Rule
{
    protected $userId;
    protected $transactionDate;

    public function __construct($userId, $transactionDate)
    {
        $this->userId = $userId;
        $this->transactionDate = $transactionDate;
    }

    public function passes($attribute, $value)
    {
        $user = User::find($this->userId);
        if (!$user) {
            return false;
        }

        $totalPaid = $user->transactions->sum('amount') + $user->deposit;
        $dueAmount = $user->total_confirmed_amount - $totalPaid;

        $dueDate = Carbon::parse($user->due_date);
        $transactionDate = Carbon::parse($this->transactionDate);

        if ($transactionDate->gt($dueDate)) {
            $penaltyFee = $value * 0.10;
            $dueAmount += $penaltyFee;
        }

        return $value <= $dueAmount;
    }

    public function message()
    {
        $user = User::find($this->userId);
        if (!$user) {
            return "The user does not exist.";
        }

        $totalPaid = $user->transactions->sum('amount') + $user->deposit;
        $dueAmount = $user->total_confirmed_amount - $totalPaid;

        $dueDate = Carbon::parse($user->due_date);
        $transactionDate = Carbon::parse($this->transactionDate);

        if ($transactionDate->gt($dueDate)) {
            $penaltyFee = $value * 0.10;
            $dueAmount += $penaltyFee;
        }

        return "The entered amount is more than the due amount. Your due amount is {$dueAmount} {$user->currency}.";
    }
}
