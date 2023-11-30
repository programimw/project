<?php
// Header
require_once "includes/header.php";
// Menu
require_once "includes/top_menu.php";
?>
<br><br>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <img src="img/login.svg" class="img-fluid" alt="sign up">
        </div>
        <div class="col-md-6">
            <form method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                    <div class="form-text">
                        <span id="emailHelp" class="error"></span>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <div class="form-text">
                        <span id="passwordHelp" class="error"></span>
                    </div>
                </div>
                <button type="button" class="btn btn-primary" onclick="login();">Login</button>
            </form>
        </div>
    </div>
</div>

<?php
require_once "includes/footer.php";
?>


<script>

    function login() {
        var error = 0;
        var message = "";
        var email = $("#email").val();
        var password = $("#password").val();

        var passwordRegex = /^[a-zA-Z0-9_-]{4,}$/;

        // Validimi i email nese eshte bosh
        if (isEmpty(email)) {
            error++;
            message = "Email is required";
            $('#emailHelp').text(message);
        } else {
            $('#emailHelp').text("");
        }

        // validimi i passwordit
        if (!passwordRegex.test(password)) {
            error++;
            message = "Incorrect password";
            $('#passwordHelp').text(message);
        } else {
            $('#passwordHelp').text("");
        }
        /////////////////
        var data = new FormData();
        data.append("action", "login")
        data.append("email", email)
        data.append("password", password)

        if (error > 0) {
            Swal.fire('Error', 'Please fill all required fields', 'error')
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "login_api.php",
                // dataType: 'json',
                async: false,
                cache: false,
                processData: false,
                data: data,
                contentType: false,
                success: function (response, status, call) {
                    response = JSON.parse(response);

                    if (call.status == 200) {
                        window.location.href = "profile.php";
                    } else {
                        $("#" + response.tag).text(response.message);
                        Swal.fire('Error', response.message, 'error')
                    }
                }
            });
        }
    }

</script>


</body>
</html>