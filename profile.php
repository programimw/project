<?php
session_start();
// Header
require_once "includes/login/header.php";
// Menu
require_once "includes/login/top_menu.php";

include "includes/connect.php";

$query_user_data = "SELECT * 
                    FROM users 
                    WHERE id = '".mysqli_real_escape_string($conn, $_SESSION['id'])."' ";

$result_user_data = mysqli_query($conn, $query_user_data);

if (!$result_user_data){
    echo "Error";
    exit;
}

$data = mysqli_fetch_assoc($result_user_data);
//echo "<pre>";
//print_r($data);
//exit;

?>
<style>
    .photo-src {
        height: 300px;
        width: 300px;
    }
</style>

    <div class="container px-4 mt-4">

        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        <img class="img-account-profile rounded-circle mb-2 photo-src" src="<?=$data['photo']?>" alt="">
                        <!-- Profile picture help block-->
                        <input type="file" class="upload-file" id = 'profile_photo' style="display: none" >
                        <br>
                        <span id = 'photoHelp' class = 'error'></span>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4">
                    <div class="card-header">Profile Details</div>
                    <div class="card-body">
                        <form>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (first name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="name">First name</label>
                                    <input class="form-control" id="name" name = 'name' type="text" placeholder="Enter your first name" value="<?= $data['name'] ?>">
                                    <span id = 'nameHelp' class = 'error'></span>
                                </div>
                                <!-- Form Group (last name)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Last name</label>
                                    <input class="form-control" id="surname" name = 'surname'  type="text" placeholder="Enter your last name" value="<?= $data['surname'] ?>">
                                    <span id = 'surnameHelp' class = 'error'></span>
                                </div>
                            </div>

                            <!-- Form Group (email address)-->
                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                <input class="form-control" id="email" name = 'email' type="email" placeholder="Enter your email address" value="<?= $data['email'] ?>">
                                <span id = 'emailHelp' class = 'error'></span>
                            </div>
                            <!-- Form Row-->
                            <div class="row gx-3 mb-3">
                                <!-- Form Group (phone number)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Password</label>
                                    <input class="form-control" id="password" type="password" placeholder="Enter your phone number" value="">
                                </div>
                                <!-- Form Group (birthday)-->
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBirthday">Confirm Password</label>
                                    <input class="form-control" id="confirmPassword" type="password" name="birthday" placeholder="Enter your birthday" value="">
                                </div>
                            </div>
                            <!-- Save changes button-->
                            <button class="btn btn-primary" type="button" onclick="updateProfile()">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
require_once "includes/login/footer.php";
?>


<script>

    $(document).ready(function() {

        var readURL = function(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('.photo-src').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".upload-file").on('change', function(){
            readURL(this);
        });

        $(".photo-src").on('click', function() {
            $(".upload-file").click();
        });
    });


    function updateProfile() {
        var error = 0;
        var message = "";
        var name = $("#name").val();
        var surname = $("#surname").val();
        var email = $("#email").val();
        var photo = $("#profile_photo").prop('files')[0];

        // var password = $("#password").val();
        // var confirmPassword = $("#confirmPassword").val();

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
        // if (!passwordRegex.test(password)) {
        //     error++;
        //     message = "Incorrect password";
        //     $('#passwordHelp').text(message);
        // } else {
        //     $('#passwordHelp').text("");
        // }
        //
        // if (password != confirmPassword) {
        //     error++;
        //     message = "Confirm password does not match with password";
        //     $('#confirmPasswordHelp').text(message);
        // } else {
        //     $('#confirmPasswordHelp').text("");
        // }

        /////////////////
        var data = new FormData();
        data.append("action", "updateProfile")
        data.append("name", name)
        data.append("surname", surname)
        data.append("email", email)
        data.append("photo", photo)
        // data.append("password", password)
        // data.append("confirmPassword", confirmPassword)

        if (error > 0) {
            Swal.fire('Error', 'Please fill all required fields', 'error')
            return false;
        } else {
            $.ajax({
                type: "POST",
                url: "ajax.php",
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
                        setTimeout(function () {
                            window.location.href = "login.php";
                        }, 2000)
                    } else {
                        $("#" + response.tag).text(response.message);
                        Swal.fire('Error', response.message, 'error')
                    }
                }
            });
        }
    }



</script>
