<!-- resources/views/transaction/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Transaction Data</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Amount</th>
                    <th>Currency</th>
                    <th>Status</th>
                    <th>Pay Method</th>
                    <th>Date & Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->user_id }}</td>
                    <td>{{ $transaction->amount }}</td>
                    <td>{{ $transaction->currency }}</td>
                    <td>{{ $transaction->status ? 'Completed' : 'Pending' }}</td>
                    <td>{{ $transaction->paymethod }}</td>
                    <td>{{ $transaction->datetime }}</td>
                    <td>
                        <a href="{{ route('transaction.edit', $transaction->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('transaction.delete', $transaction->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
