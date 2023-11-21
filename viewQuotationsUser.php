<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HealthHub</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p>Health<span class="sub-logo">Hub</span></p>
        </div>
        <div class="right-links">
            <a href="logout.php"><button class="btn">LOGOUT</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box register-box">
            
        </div>
    </div>
</body>

</html>