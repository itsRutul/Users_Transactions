@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Add Transaction for {{ $user->firstname }} {{ $user->lastname }}</h2>
    <form method="POST" action="{{ route('transactions.storetransaction', $user->id) }}">
        @csrf
        <div class="mb-3">
            <label for="amount" class="form-label">Amount</label>
            <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select class="form-select" id="type" name="type" required>
                <option value="credit">Credit</option>
                <option value="debit">Debit</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label">Date</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Transaction</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('user_id').addEventListener('change', function() {
            var selectedUser = this.options[this.selectedIndex];
            var currency = selectedUser.getAttribute('data-currency');
            document.getElementById('currency').value = currency;
        });

        document.getElementById('submitButton').addEventListener('click', function() {
            var amountInput = document.getElementById('amount');
            var selectedUserId = document.getElementById('user_id').value;
            var dueAmounts = {!! json_encode($dueAmounts) !!}; // Pass due amounts array from the controller
            var dueAmount = dueAmounts[selectedUserId] || 0;
            var enteredAmount = parseFloat(amountInput.value);

            if (enteredAmount > dueAmount) {
                alert('Entered amount is greater than due amount. Your due amount is ' + dueAmount);
            } else {
                document.getElementById('transactionForm').submit();
            }
        });
    </script>
@endsection

