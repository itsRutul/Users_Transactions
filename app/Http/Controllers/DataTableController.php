<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DataTableController extends Controller
{
    public function index()
    {
        // Retrieve users and transactions data
        $users = User::all();
        $transactions = Transaction::all();

        // Pass the data to the view
        return view('data-table', compact('users', 'transactions'));
    }
}

