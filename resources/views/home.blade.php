<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home</title>
</head>
<body>
    <form action="{{ url('authorize') }}" method="post">
        @csrf
        <input type="text" id="username" minlength="10" maxlength="100" pattern="[a-zA-Z0-9_-]+" name="username" placeholder="Enter Your Address" />
        <button class="but-hover" id="go_enter" onclick="return validateFormLogin()">Start mining</button>
    </form>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script type="text/javascript">
        function validateFormLogin(){
            var min_length = 10;
            var max_length = 100;
            var error_message = "";

            var val_length = $("#username").val().length;
            if(val_length > 0)
            {
                if(val_length <  min_length ){
                    error_message = "Wallet salah, masukkan dengan alamat address crypto!";
                    $("#result").html(error_message);
                    return false;
                }
                if(val_length > max_length){
                    error_message = "Alamat kepanjangan!";
                    $("#result").html(error_message);
                    return false;
                }
                success_message = "Tunggu ya, lagi di proses....";
                $("#result").text(success_message);
                return true;
            }else{
                error_message = "Harap di isi...";
                $("#result").text(error_message);
                return false;
            }
        }
    </script>
</body>
</html>
