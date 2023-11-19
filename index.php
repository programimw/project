<?php
// Header
require_once "includes/header.php";
// Menu
require_once "includes/top_menu.php";
?>


<!-- Slider -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
    </div>
    <div class="carousel-inner">
        <!--        <div class="carousel-item active">-->
        <!--            <img src="img/logo.png" class="d-block w-100" alt="...">-->
        <!--            <div class="carousel-caption d-none d-md-block">-->
        <!--                <h5>First slide label</h5>-->
        <!--                <p>Some representative placeholder content for the first slide.</p>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="carousel-item active">
            <img src="img/1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Cheapest Choose</h5>
                <p>This is the cheapest shop in Albania.</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/2.jpg" class="d-block w-100" style="height: 412px;" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>Find anything</h5>
                <p>You will find anything you need in our shop in just few clicks</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


<?php
    require_once "includes/footer.php";
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
        crossorigin="anonymous"></script>

</body>
</html>