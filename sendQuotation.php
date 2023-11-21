<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:logout.php");
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $receivedData = isset($_POST['tableData']) ? $_POST['tableData'] : null;
        $decodedData = json_decode($receivedData, true);
        $prescriptionId = $_SESSION['prescriptionId'];

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

            $checkQuery = "SELECT COUNT(*) FROM quotations WHERE prescriptionId=?";
            $checkStatement = $connection->prepare($checkQuery);
            $checkStatement->bind_param("i", $prescriptionId);

            $checkStatement->execute();
            $checkStatement->bind_result($count);
            $checkStatement->fetch();
            $checkStatement->close();

            if ($count > 0) {
                echo "
                        <div class='ErrorMessageBox'>
                             <p>Quotation Aready submitted!</p>
                        <div><br>";
                echo "
                <form method='post' action='prepareQuotation.php'>
                <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                <button type='submit' class='btn'>GO BACK</button>
                </form>
                    ";
            } else {
                $insertQuery_Quotation = "INSERT INTO quotations (prescriptionId,seen,total) VALUES (?,?,?)";
                $statement1 = $connection->prepare($insertQuery_Quotation);
                $seen = "No";
                $statement1->bind_param("isd", $prescriptionId, $seen, $total);

                $isQuotationSuccess = false;
                $isQuotationDetailsSuccess = true;

                if ($statement1->execute()) {
                    $isQuotationSuccess = true;
                }

                $selectQuery = "SELECT quotationId FROM quotations WHERE prescriptionid=?";
                $selectStatement = $connection->prepare($selectQuery);
                $selectStatement->bind_param("i", $prescriptionId);
                $selectStatement->execute();
                $selectStatement->bind_result($quotationId);
                $selectStatement->fetch();
                $selectStatement->close();

                foreach ($decodedData as $drugInfo) {
                    $drug = $drugInfo['drug'];
                    $quantity = $drugInfo['quantity'];
                    $amount = $drugInfo['amount'];

                    $insertQuery_QuotationDetails = "INSERT INTO quotationdetails (quotationId,drug,quantity,amount) VALUES (?,?,?,?)";
                    $statement2 = $connection->prepare($insertQuery_QuotationDetails);
                    $statement2->bind_param("isid", $quotationId, $drug, $quantity, $amount);

                    if (!$statement2->execute()) {
                        $isQuotationDetailsSuccess = false;
                        break;
                    }
                }

                if ($isQuotationSuccess && $isQuotationDetailsSuccess) {
                    echo "
                            <div class='SuccessMessageBox'>
                                <p>Quotation has been submitted!</p>
                            <div><br>";
                    echo "
                    <form method='post' action='prepareQuotation.php'>
                    <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                    <button type='submit' class='btn'>GO BACK</button>
                    </form>
                        ";
                } else {
                    echo "
                            <div class='ErrorMessageBox'>
                                 <p>Quotation submission failed!</p>
                            <div><br>";
                    echo "
                    <form method='post' action='prepareQuotation.php'>
                    <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                    <button type='submit' class='btn'>GO BACK</button>
                    </form>
                        ";
                }
            }











            ?>




        </div>

    </div>


</body>

</html>