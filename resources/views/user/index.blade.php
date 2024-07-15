<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Data Table</title>
</head>
<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group w-50">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Search">
            </div>
            <a href="{{ route('register.show') }}" class="btn btn-primary">Add Customer</a>
        </div>
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>NAME</th>
                    <th>DESCRIPTION</th>
                    <th>PAID</th>
                    <th>DUE</th>
                    <th>DEPOSIT</th>
                    <th>STATUS</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>{{ $user->firstname }} {{ $user->lastname }}<br><small>{{ $user->id }}</small></td>
                    <td>{{ \Illuminate\Support\Str::limit($user->introduction, 30, '...') }}</td>
                    <td>
                        @php
                            $totalPaid = $user->transactions->sum('amount') + $user->deposit;
                        @endphp
                        {{ $totalPaid }} {{ $user->currency }}
                    </td>
                    <td class="{{ $user->due < 0 ? 'text-danger' : 'text-success' }}">
                        @php
                            $totalPaid = $user->transactions->sum('amount') + $user->deposit;
                            $dueAmount = $user->total_confirmed_amount - $totalPaid;
                        @endphp
                        {{ $dueAmount }} {{ $user->currency }}
                    </td>
                    <td>{{ $user->deposit }} {{ $user->currency }}</td>
                    <td>
                        <span class="badge bg-{{ $user->status ? 'primary' : 'secondary' }}">{{ $user->status ? 'ACTIVE' : 'INACTIVE' }}</span>
                    </td>
                    <td>
                        <a href="{{ route('user.edit', $user->id) }}" class="me-2" title="Edit"><i class="bi bi-pencil"></i></a>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-link p-0" title="Delete"><i class="bi bi-trash"></i></button>
                        </form>
                        <!-- Corrected link with proper route parameter -->
                        <a href="{{ route('transaction.create', ['user' => $user->id]) }}" title="Add Transaction"><i class="bi bi-wallet2"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between mt-3">
            <small>page 1</small>
            
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
