<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.9.1/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>Add New Transaction</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Add New Transaction</h2>
        <div id="successMessage" class="alert alert-success" style="display:none;"></div>
        <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        
        <form id="transactionForm" method="POST" action="{{ route('transactions.store') }}" class="registration-form">
            @csrf
            <div class="mb-3">
                <label for="user_id" class="form-label required">User Name<span class="required-star">*</span></label>
                <select class="form-select" id="user_id" name="user_id" required>
                    <option value="">Select User</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" data-currency="{{ $user->currency }}">{{ $user->firstname }} {{ $user->lastname }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="amount" class="form-label required">Amount<span class="required-star">*</span></label>
                <input type="number" step="0.01" class="form-control" id="amount" name="amount" required>
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label required">Currency<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="currency" name="currency" readonly>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label required">Payment Method<span class="required-star">*</span></label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="">Select Payment Method</option>
                    <option value="cash">Cash</option>
                    <option value="online">Online</option>
                    <option value="cheque">Cheque</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label required">Status<span class="required-star">*</span></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="statusToggle" name="status" value="1" checked>
                    <label class="form-check-label" for="statusToggle" id="statusLabel">Active</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="datetime" class="form-label required">Date & Time<span class="required-star">*</span></label>
                <input type="datetime-local" class="form-control" id="datetime" name="datetime" required>
            </div>
            <button type="button" id="submitButton" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                $.ajax({
                    url: $('#transactionForm').attr('action'),
                    method: 'POST',
                    data: $('#transactionForm').serialize(),
                    success: function(response) {
                        $('#successMessage').text(response.message).show();
                        $('#errorMessage').hide();
                        $('#transactionForm')[0].reset();
                        
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = 'not submiited';

                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '<br>';
                            }
                        }

                        $('#errorMessage').html(errorMessage).show();
                        $('#successMessage').hide();
                    }
                });
            }
        });
    </script>
</body>
</html>
