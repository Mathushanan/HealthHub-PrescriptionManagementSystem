<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $receivedData = isset($_POST['tableData']) ? $_POST['tableData'] : null;

    $decodedData = json_decode($receivedData, true);



    foreach ($decodedData as $drugInfo) {
        $drug = $drugInfo['drug'];
        $quantity = $drugInfo['quantity'];
        $amount = $drugInfo['amount'];
    }
    $prescriptionId=$_POST['prescriptionData'];
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
        <div class="right-links">
            <?php
            echo "
            <form method='post' action='prepareQuotation.php'>
                <input type='hidden' name='prescriptionId' value='$prescriptionId' />
                <a href='prepareQuotation.php'><button class='btn back-btn'>GO BACK</button></a>
                <a href='logout.php'><button class='btn'>LOGOUT</button></a>
            </form>
            ";
            ?>
            

        </div>
    </div>
    <?php





    ?>
</body>

</html>