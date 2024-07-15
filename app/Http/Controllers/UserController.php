<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use app\Rules\DueAmountRule;
use App\Models\Transaction;
use DB;


class UserController extends Controller
{
    public function showRegistrationForm()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'introduction' => 'nullable|string',
            'deposit' => 'required|numeric',
            'total_confirmed_amount' => 'required|numeric',
            'currency' => 'required|in:INR,USD,AUD',
            'status' => 'required|boolean',
            'due_date' => 'required|date',
        ]);

        User::create($validatedData);

        return response()->json(['message' => 'Transaction created successfully.']);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'introduction' => 'nullable|string',
            'deposit' => 'required|numeric',
            'total_confirmed_amount' => 'required|numeric',
            'currency' => 'required|in:INR,USD,AUD',
            'status' => 'required|boolean',
            'due_date' => 'required|date',
        ]);

        $user = User::findOrFail($id);
        $user->update($validatedData);

        return redirect()->route('data-table.index')->with('success', 'User updated successfully!');
    }

    public function destroy($id)
{
    try {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully.']);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Failed to delete user.']);
    }
}

    public function index()
    {
        $users = User::with(['transactions' => function($query) {
            $query->select('user_id', DB::raw('SUM(amount) as total_paid'), 'currency')
                  ->groupBy('user_id', 'currency');
        }])->get();

        return view('user.index', compact('users'));
    }
}
