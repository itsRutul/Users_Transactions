<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>User Registration</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
</head>
<body>
    <div class="container mt-5">
        <h2>Add User</h2>
        <div id="successMessage" class="alert alert-success" style="display:none;"></div>
        <div id="errorMessage" class="alert alert-danger" style="display:none;"></div>
        
        <form id="registrationForm" method="POST" action="{{ route('register.store') }}">
            @csrf
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name<span class="required-star">*</span></label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
            </div>
            <div class="mb-3">
                <label for="introduction" class="form-label">Introduction<span class="required-star">*</span></label>
                <textarea class="form-control" id="introduction" name="introduction" required></textarea>
            </div>
            <div class="mb-3">
                <label for="deposit" class="form-label">Deposit</label>
                <input type="number" step="0.01" class="form-control" id="deposit" name="deposit">
            </div>
            <div class="mb-3">
                <label for="total_confirmed_amount" class="form-label">Deal Amount</label>
                <input type="number" step="0.01" class="form-control" id="total_confirmed_amount" name="total_confirmed_amount">
            </div>
            <div class="mb-3">
                <label for="currency" class="form-label">Currency<span class="required-star">*</span></label>
                <select class="form-select" id="currency" name="currency" required>
                    <option value="">Select Currency</option>
                    <option value="INR">INR</option>
                    <option value="USD">USD</option>
                    <option value="AUD">AUD</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Status<span class="required-star">*</span></label>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="statusToggle" name="status" value="1" checked>
                    <label class="form-check-label" for="statusToggle" id="statusLabel">Active</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date<span class="required-star">*</span></label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <button type="button" id="submitButton" class="btn btn-primary">Register</button>
        </form>
    </div>
    
    <script>
        $(document).ready(function() {
            $('#submitButton').on('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                $.ajax({
                    url: $('#registrationForm').attr('action'),
                    method: 'POST',
                    data: $('#registrationForm').serialize(),
                    success: function(response) {
                        $('#successMessage').text(response.message).show();
                        $('#errorMessage').hide();
                        $('#registrationForm')[0].reset(); // Reset the form on success
                    },
                    error: function(xhr) {
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';

                        for (var key in errors) {
                            if (errors.hasOwnProperty(key)) {
                                errorMessage += errors[key][0] + '<br>';
                            }
                        }

                        $('#errorMessage').html(errorMessage).show();
                        $('#successMessage').hide();
                    }
                });
            });
        });
    </script>
</body>
</html>
