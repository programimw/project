<?php
if (isset($_GET['errorMessage'])){
    echo "<h1>".$_GET['errorMessage']."</h1>";
}
?>
<html>
<head></head>
<body>
<form method="post" action="backend.php">
    <label for="emri"> Emri: </label>
    <input type="text" name="emri" placeholder="Vendosni emrin">
    <br><br>
    <label for="mbiemri"> Mbiemri: </label>
    <input type="text" name="mbiemri" placeholder="Vendosni mbiemrin">
    <br><br>
    <label for="email"> Email: </label>
    <input type="text" name="email" placeholder="Vendosni e-mail">
    <br><br>
    <input type="submit" name = 'button' value="Save">
</form>
</body>

</html>
