<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <div>
        <h4>Your balance</h4>
        <input type="hidden" id="getBalance" value="{{ $balance }}" />
        <span id="balance">{{ $balance }}</span>
    </div>

    <div>
        <button type="button" onclick="location.href='logout'">Logout</button>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        // Preserve original business logic values
        const initialBalance = parseFloat($('#getBalance').val()) || 0;
        const earningRatePerMinute = parseFloat({{ $user_earning_rate }}) || 0;

        // Critical optimization: Calculate precise real-time value instead of incremental steps
        const ratePerMs = earningRatePerMinute / (60 * 1000); // True rate per millisecond
        const startTime = Date.now();

        // Immediately normalize display format to match update precision (prevents first-frame jump)
        $('#balance').text(initialBalance.toFixed(8));

        // Smooth animation loop using browser's refresh rate
        function animateBalance() {
            const elapsedMs = Date.now() - startTime;
            const currentBalance = initialBalance + (elapsedMs * ratePerMs);
            const formatted = currentBalance.toFixed(8);

            // Only update DOM when visible value changes (reduces layout thrashing)
            if ($('#balance').text() !== formatted) {
                $('#balance').text(formatted);
            }

            requestAnimationFrame(animateBalance);
        }

        // Start smooth animation loop
        requestAnimationFrame(animateBalance);
    });
    </script>
</body>
</html>
