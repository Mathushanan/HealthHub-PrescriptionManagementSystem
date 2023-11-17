<?php

session_start();

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

        </div>
    </div>
    <div class="container">
        <div class="box form-box">
            <?php

            include("config.php");
            if (isset($_POST["submit"])) {

                $email = mysqli_real_escape_string($connection, $_POST['email']);
                $password = mysqli_real_escape_string($connection, $_POST['password']);
                $result = mysqli_query($connection, "SELECT * FROM users WHERE email='$email' AND password='$password'");


                if ($result && mysqli_num_rows($result) > 0) {

                    $row = mysqli_fetch_assoc($result);
                    $_SESSION['email'] = $row['email'];
                    $_SESSION['name'] = $row['name'];
                    $_SESSION['password'] = $row['password'];
                    $_SESSION['dob'] = $row['dob'];
                    $_SESSION['mobile'] = $row['mobile'];
                    $_SESSION['address'] = $row['address'];
                    $_SESSION['type'] = $row['type'];

                    if ($_SESSION['type'] == "Parmacy User") {
                        header("Location:viewPrescription.php");
                        exit();
                    } else {
                        header("Location:uploadPrescription.php");
                        exit();
                    }
                } else {
                    echo "
                         <div class='ErrorMessageBox'>
                            <p>Wrong Email or Password!</p>
                         <div><br>";
                    echo "
                        <a href='index.php'><button class='btn'>GO BACK</button></a>
                    ";
                }
            } else {


            ?>
                <header>Login</header>
                <form action="" method="post">
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="LOGIN">
                    </div>
                    <div class="link">
                        Don't have Account? <a href="register.php">SIGNUP</a>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>


</body>

</html>