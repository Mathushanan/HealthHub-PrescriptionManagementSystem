<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:logout.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $receivedData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
        $decodedData = json_decode($receivedData, true);
        $prescriptionId = $_POST['prescriptionData'];

        $total = 0.00;
        foreach ($decodedData as $drugInfo) {
            $total += $drugInfo['amount'];
        }
    }
}




?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p>Health<span class="sub-logo">Hub</span></p>
        </div>

        <?php
        echo "
            <div class='right-links sendQuotation-links'>
            <form method='post' action='prepareQuotation.php'>
                <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                <a href='prepareQuotation.php'><button class='btn back-btn'>GO BACK</button></a>
            </form>
            <a href='logout.php'><button class='btn'>LOGOUT</button></a>
            </div>
            ";
        ?>

    </div>
    <div class="container">
        <div class="box form-box">
            <?php

            include("config.php");



            $insertQuery_Quotation = "INSERT INTO quotations (prescriptionId,seen,total) VALUES (?,?,?)";
            $statement1 = $connection->prepare($insertQuery_Quotation);
            $seen="No";
            $statement1->bind_param("isd", $prescriptionId, $seen, $total);

            if ($statement1->execute()) {
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


            foreach ($decodedData as $drugInfo) {
                $drug = $drugInfo['drug'];
                $quantity = $drugInfo['quantity'];
                $amount = $drugInfo['amount'];
            }





            ?>




        </div>

    </div>


</body>

</html>