<?php

session_start();
include("config.php");


if(!isset($_SESSION['email'])){
    header("Location: index.php");
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
            <?php

            if(isset($_POST["submit"])){

                $note=mysqli_real_escape_string($connection,$_POST['note']);
                $deliveryAddress=mysqli_real_escape_string($connection,$_POST['deliveryAddress']);
                $deliveryTime=mysqli_real_escape_string($connection,$_POST['deliveryTime']);
                $email=$_SESSION['email'];
                
                $insertQuery="INSERT INTO prescriptions (email,deliveryAddress,note,deliveryTime) VALUES (?,?,?,?)";
                $statement=$connection->prepare($insertQuery);
                $statement->bind_param("ssss",$email,$deliveryAddress,$note,$deliveryTime);

                if($statement->execute()){
                    echo "
                        <div class='SuccessMessageBox'>
                            <p>Prescription uploaded successfully!</p>
                        <div><br>";
                    echo "
                        <a href='uploadPrescription.php'><button class='btn'>GO BACK</button></a>
                    ";
                }else{
                    echo "
                        <div class='ErrorMessageBox'>
                             <p>Failed to upload the prescription!</p>
                        <div><br>";
                    echo "
                        <a href='uploadPrescriptions.php'><button class='btn'>GO BACK</button></a>
                    ";
                }
            }else{

            


            ?>
            <header>Upload Prescription</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="fileUpload">Prescription Images</label>
                    <input type="file" class="fileUpload" id="fileUpload" name="image" accept=".jpg, .jpeg, .png" multiple>
                </div>
                <div class="field input">
                    <label for="note">Note</label>
                    <textarea id="note" name="note" rows="4" cols="50"></textarea>
                </div>
                <div class="field input">
                    <label for="deliveryAddress">Delivery Address</label>
                    <input type="text" name="deliveryAddress" id="deliveryAddress" required>
                </div>
                <div class="field input">
                    <label for="deliveryTime">Delivery Time</label>
                    <select id="deliveryTime" name="deliveryTime">
                        <option value="8-10AM">8:00 AM - 10:00 AM</option>
                        <option value="10-12PM">10:00 AM - 12:00 PM</option>
                        <option value="12-2PM">12:00 PM - 2:00 PM</option>
                        <option value="2-4PM">2:00 PM - 4:00 PM</option>
                        <option value="4-6PM">4:00 PM - 6:00 PM</option>
                        <option value="6-8PM">6:00 AM - 8:00 PM</option>
                        <option value="8-10PM">8:00 AM - 10:00 PM</option>
                        <option value="10-12PM">10:00 PM - 12:00 PM</option>
                    </select>
                </div>
              
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="UPLOAD">
                </div>
            </form>
        </div>
        <?php } ?>
    </div>
    
    
</body>
</html>