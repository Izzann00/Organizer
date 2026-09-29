@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<script>
    setTimeout(function () {
        const alerts = document.querySelectorAll('.alert');

        alerts.forEach(function (alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';

            setTimeout(function () {
                alert.remove();
            }, 500);
        });
    }, 3000);
</script>