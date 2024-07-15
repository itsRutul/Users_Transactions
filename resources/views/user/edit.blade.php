@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Edit User</h2>
    <form method="POST" action="{{ route('users.update', $user->id) }}">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="firstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $user->firstname }}" required>
        </div>
        <div class="mb-3">
            <label for="lastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $user->lastname }}" required>
        </div>
        <div class="mb-3">
            <label for="introduction" class="form-label">Introduction</label>
            <textarea class="form-control" id="introduction" name="introduction" required>{{ $user->introduction }}</textarea>
        </div>
        <div class="mb-3">
            <label for="deposit" class="form-label">Deposit</label>
            <input type="number" step="0.01" class="form-control" id="deposit" name="deposit" value="{{ $user->deposit }}">
        </div>
        <div class="mb-3">
            <label for="total_confirmed_amount" class="form-label">Deal Amount</label>
            <input type="number" step="0.01" class="form-control" id="total_confirmed_amount" name="total_confirmed_amount" value="{{ $user->total_confirmed_amount }}">
        </div>
        <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <select class="form-select" id="currency" name="currency" required>
                <option value="INR" {{ $user->currency == 'INR' ? 'selected' : '' }}>INR</option>
                <option value="USD" {{ $user->currency == 'USD' ? 'selected' : '' }}>USD</option>
                <option value="AUD" {{ $user->currency == 'AUD' ? 'selected' : '' }}>AUD</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status" required>
                <option value="1" {{ $user->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$user->status ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $user->due_date }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
