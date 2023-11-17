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
        <div class="box form-box register-box">

            <?php
            include("config.php");
            if (isset($_POST['submit'])) {

                $name = $_POST['name'];
                $email = $_POST['email'];
                $mobile = $_POST['mobile'];
                $address = $_POST['address'];
                $dob = $_POST['dob'];
                $password = $_POST['password'];
                $type=$_POST['type'];

                $verifyQuery = mysqli_query($connection, "SELECT * FROM users WHERE email='$email'");

                if (mysqli_num_rows($verifyQuery) != 0) {

                    echo "
                <div class='ErrorMessageBox'>
                    <p>Email is already registered!</p>
                <div><br>";
                    echo "
                <a href='register.php'><button class='btn'>GO BACK</button></a>
                ";
                } else {
                    mysqli_query($connection, "INSERT INTO users (name,email,address,mobile,dob,password,type) VALUES ('$name','$email','$address','$mobile','$dob','$password','$type')");
                    echo "
                <div class='SuccessMessageBox'>
                    <p>Registration successfull!</p>
                <div><br>";
                    echo "
                <a href='index.php'><button class='btn'>LOGIN</button></a>
                ";
                }
            } else {

            ?>
                <header>Register</header>
                <form action="" method="post">
                    <div class="field input">
                       
                        <select id="type" name="type">
                            <option value="Parmacy User">Parmacy User</option>
                            <option value="Normal User">Normal User</option>
                        </select>
                    </div>
                    <div class="field input">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" required>
                    </div>
                    <div class="field input">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" required>
                    </div>
                    <div class="field input">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" required>
                    </div>
                    <div class="field input">
                        <label for="address">Address</label>
                        <input type="text" name="address" id="address" required>
                    </div>
                    <div class="field input">
                        <label for="dob">Date of Birth</label>
                        <input type="date" name="dob" id="dob" required>
                    </div>
                    <div class="field input">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>
                    <div class="field input">
                        <label for="cpassword">Confirm Password</label>
                        <input type="password" name="cpassword" id="cpassword" required>
                    </div>
                    <div class="field">
                        <input type="submit" class="btn" name="submit" value="SIGNUP">
                    </div>
                    <div class="link">
                        Already have an Account? <a href="index.php">LOGIN</a>
                    </div>
                </form>
        </div>
    <?php } ?>
    </div>


</body>

</html>