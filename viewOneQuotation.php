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


            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>Drug Name</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Replace the following rows with data from your database -->
                    <tr>
                        <td>Drug A</td>
                        <td>10</td>
                        <td>$5.00</td>
                        <td>$50.00</td>
                    </tr>
                    <tr>
                        <td>Drug B</td>
                        <td>5</td>
                        <td>$8.00</td>
                        <td>$40.00</td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>

            <div class="total">
                Total Amount: $90.00 <!-- Replace with the actual total from your database -->
            </div>


        </div>
    </div>
</body>

</html>