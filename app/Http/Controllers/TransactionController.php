<?php
namespace App\Http\Controllers;

use App\Rules\DueAmountRule;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function create()
    {
        $users = User::all();
        $dueAmounts = [];

        foreach ($users as $user) {
            $totalPaid = $user->transactions->sum('amount');
            $dueAmounts[$user->id] = $user->total_confirmed_amount - $totalPaid;
        }

        return view('transactions.create', compact('users', 'dueAmounts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'amount' => 'required|numeric',
            'currency' => 'required|in:INR,USD,AUD',
            'status' => 'required|boolean',
            'datetime' => 'required|date',
        ]);

        $userId = $request->user_id;
        $transactionDate = $request->datetime;

        $dueAmountRule = new DueAmountRule($userId, $transactionDate);

        $request->validate([
            'amount' => ['required', 'numeric', $dueAmountRule],
        ]);

        $validatedData = $request->all();

        $user = User::findOrFail($validatedData['user_id']);
        $totalPaid = $user->transactions->sum('amount') + $user->deposit;
        $dueAmount = $user->total_confirmed_amount - $totalPaid;

        $dueDate = Carbon::parse($user->due_date);
        $transactionDate = Carbon::parse($validatedData['datetime']);

        if ($transactionDate->gt($dueDate)) {
            $penaltyFee = $validatedData['amount'] * 0.10;
            $dueAmount += $penaltyFee;

            Transaction::create([
                'user_id' => $user->id,
                'amount' => -$penaltyFee,
                'currency' => $user->currency,
                'status' => true,
                'datetime' => $transactionDate,
                'username' => $user->firstname . ' ' . $user->lastname,
                'description' => 'Late payment penalty fee',
            ]);
        }

        $validatedData['username'] = $user->firstname . ' ' . $user->lastname;
        Transaction::create($validatedData);

        return response()->json(['message' => 'Transaction created successfully.']);
        /* return redirect()->route('data-table.index')->with('success', 'Transaction created successfully.'); */

    }
        
}
    
    

   

