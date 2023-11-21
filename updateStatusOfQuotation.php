<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}

$quotationId = $_POST['quotationId'];
$status = $_POST['status'];
$prescriptionId= $_POST['prescriptionId'];


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
            <a href="viewAllQuotations.php"><button class="btn back-btn">GO BACK</button></a>
            <a href="logout.php"><button class="btn">LOGOUT</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box form-box register-box">
            <?php

            include("config.php");

            $updateQuery = "UPDATE quotations SET status='$status' WHERE quotationId='$quotationId'";


            if (!$connection->query($updateQuery)) {

                echo "
                <div class='ErrorMessageBox'>
                <p>Failed to update!</p>
                <div><br>";
                echo "
                <form method='post' action='viewOneQuotation.php' id='form'>
                <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                <button class='btn' type='submit'>GO BACK</button>
            </form>
                    
                    ";
            } else {
                echo "
                    <div class='SuccessMessageBox'>
                        <p>Quotation successfully accepted!</p>
                        <div><br>";
                echo "
                <form method='post' action='viewOneQuotation.php' id='form'>
                <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                <button class='btn' type='submit'>GO BACK</button>
                </form>
                            
                            ";
            }
            $connection->close();

            ?>
            
        </div>
    </div>
</body>