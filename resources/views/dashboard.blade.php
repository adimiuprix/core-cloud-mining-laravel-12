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
    //Counter
    $(document).ready(function() {
        var speed = (parseFloat( {{ $user_earning_rate }} )/60).toFixed(8);
        setInterval(function() {
            var oldvalue =  parseFloat($('#balance').html()).toFixed(8);
            var result = parseFloat(parseFloat(oldvalue) + parseFloat(speed)).toFixed(8);
            $("#balance").html(result);
        }, 1000);
    });
    </script>
</body>
</html>
