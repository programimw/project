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
                    <label for="exampleInputEmail" class="form-label">Email address</label>
                    <input type="email" class="form-control"  id="email" name = "email" aria-describedby="emailHelp" required>
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" class="form-control"  id="password" name = "password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Check me out</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>



<?php
require_once "includes/footer.php";
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>


</body>
</html>