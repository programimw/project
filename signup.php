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
            <img src="img/register.svg" class="img-fluid" alt="sign up">
        </div>
        <div class="col-md-6">
            <form method="post">
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" aria-describedby="nameHelp" required>
                    <div class="form-text"
                    <span id="nameHelp" class="error"></span>
                </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputSurname" class="form-label">Surname</label>
            <input type="text" class="form-control" id="surname" name="surname" aria-describedby="surnameHelp" required>
            <div class="form-text">
                <span id="surnameHelp" class="error"></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
            <div class="form-text">
                <span id="emailHelp" class="error"></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="form-text">
                <span id="passwordHelp" class="error"></span>
            </div>
        </div>
        <div class="mb-3">
            <label for="exampleInputConfirmPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            <div class="form-text">
                <span id="confirmPasswordHelp" class="error"></span>
            </div>
        </div>
        <button type="button" class="btn btn-primary" onclick="signup()">Save</button>
        </form>
    </div>
</div>
</div>


<?php
require_once "includes/footer.php";
?>


<script>
    function signup() {
        var error = 0;
        var message = "";
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();
        var password = $("#password").val();
        var confirmPassword = $("#confirmPassword").val();

        var alphanumericRegex = /^[a-zA-Z0-9]{3,}$/;
        var passwordRegex = /^[a-zA-Z0-9_-]{4,}$/;

        // Validimi i emrit
        if (!alphanumericRegex.test(name)) {
            error++;
            message = "Name must be alphanumeric and minimum 1 letter";
            $('#nameHelp').text(message);
        } else {
            $('#nameHelp').text("");
        }

        // Validimi i mbiemrit
        if (!alphanumericRegex.test(surname)) {
            error++;
            message = "Surname must be alphanumeric and minimum 1 letter";
            $('#surnameHelp').text(message);
        } else {
            $('#surnameHelp').text("");
        }

        // Validimi i mbiemrit
        if (isEmpty(email)) {
            error++;
            message = "Email can not be empty";
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

        if (password != confirmPassword) {
            error++;
            message = "Confirm password does not match with password";
            $('#confirmPasswordHelp').text(message);
        } else {
            $('#confirmPasswordHelp').text("");
        }

        /////////////////
        var data = new FormData();
        data.append("action", "signup")
        data.append("name", name)
        data.append("surname", surname)
        data.append("email", email)
        data.append("password", password)
        data.append("confirmPassword", confirmPassword)

        if (error > 0) {
            Swal.fire('Error', 'Please fill all required fields', 'error')
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "signup_api.php",
                // dataType: 'json',
                async: false,
                cache: false,
                processData: false,
                data: data,
                contentType: false,
                success: function (response, status, call) {
                    response = JSON.parse(response);

                    if (call.status == 201) {
                        Swal.fire('Success', response.message, 'success');
                        $('#nameHelp').text("");
                        // setTimeout(function () {
                        //     window.location.href = "login.php";
                        // }, 2000)
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