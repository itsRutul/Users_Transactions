document.addEventListener('DOMContentLoaded', function() {
    // JavaScript code here
    // JavaScript code here
    const statusToggle = document.getElementById('statusToggle');
    const statusLabel = document.getElementById('statusLabel');

    statusToggle.addEventListener('change', function() {
        if (statusToggle.checked) {
            statusLabel.textContent = 'Active';
        } else {
            statusLabel.textContent = 'Inactive';
        }
    });

    document.querySelectorAll('.registration-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                alert('Please fill all required fields.');
            }
        });
    });
});

