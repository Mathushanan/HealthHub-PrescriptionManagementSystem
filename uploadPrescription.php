<?php

session_start();
include("config.php");


if (!isset($_SESSION['email'])) {
    header("Location: logout.php");
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
            <a href="viewAllQuotations.php"><button class="btn back-btn">RECEIVED QUOTATIONS</button></a>
            <a href="logout.php"><button class="btn">LOGOUT</button></a>

        </div>
    </div>
    <div class="container">
        <div class="box form-box register-box">
            <?php

            if (isset($_POST["submit"])) {

                $isStatement1Success = false;
                $isStatement2Success = false;

                $note = mysqli_real_escape_string($connection, $_POST['note']);
                $deliveryAddress = mysqli_real_escape_string($connection, $_POST['deliveryAddress']);
                $deliveryTime = mysqli_real_escape_string($connection, $_POST['deliveryTime']);
                $email = $_SESSION['email'];
                $name=$_SESSION['name'];

                $insertQuery = "INSERT INTO prescriptions (name,email,deliveryAddress,note,deliveryTime) VALUES (?,?,?,?,?)";
                $statement1 = $connection->prepare($insertQuery);
                $statement1->bind_param("sssss", $name,$email, $deliveryAddress, $note, $deliveryTime);
              
                
               if ($statement1->execute()) {
                    $isStatement1Success = true;

                    $selectQuery = "SELECT prescriptionId FROM prescriptions WHERE email=? ORDER BY prescriptionId DESC LIMIT 1";
                    $selectStatement = $connection->prepare($selectQuery);
                    $selectStatement->bind_param("s", $email);

                    $selectStatement->execute();
                    $selectStatement->bind_result($prescriptionId);
                    $selectStatement->fetch();
                    $selectStatement->close();

                    $file = $_FILES['images'];

                    foreach ($file['tmp_name'] as $key => $tmp_name) {

                        $fileError = $file['error'][$key];
                        $fileTmpName = $tmp_name;

                        if ($fileError == 0) {

                            $imageData = file_get_contents($fileTmpName);

                            $insertImageQuery = "INSERT INTO images (prescriptionId,image) VALUES (?,?)";
                            $statement2 = $connection->prepare($insertImageQuery);
                            $statement2->bind_param("is", $prescriptionId, $imageData);

                            if ($statement2->execute()) {
                                $isStatement2Success = true;
                            }
                        }
                    }
               }


                if ($isStatement1Success && $isStatement1Success) {
                    echo "
                        <div class='SuccessMessageBox'>
                            <p>Prescription uploaded successfully!</p>
                        <div><br>";
                    echo "
                        <a href='uploadPrescription.php'><button class='btn'>GO BACK</button></a>
                    ";
                } else {
                    echo "
                        <div class='ErrorMessageBox'>
                             <p>Failed to upload the prescription!</p>
                        <div><br>";
                    echo "
                        <a href='uploadPrescriptions.php'><button class='btn'>GO BACK</button></a>
                    ";
                }
            } else {




            ?>
                <header>Upload Prescription</header>
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="field input">
                        <label for="fileUpload">Prescription Images</label>
                        <input type="file" class="fileUpload" id="fileUpload" name="images[]" accept="image/*" multiple required>
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