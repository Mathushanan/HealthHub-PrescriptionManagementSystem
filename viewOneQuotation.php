<?php

session_start();
if (!isset($_SESSION['email'])) {
    header("Location:index.php");
}
$prescriptionId = $_POST['prescriptionId'];
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
            <table>
                <thead>
                    <tr>
                        <th>Drug</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>

                    <?php

                    include("config.php");

                    $selectQuery = "SELECT quotationId,total FROM quotations WHERE prescriptionId='$prescriptionId'";
                    $result1 = $connection->query($selectQuery);
                    if ($result1) {

                        $row = $result1->fetch_assoc();
                        $quotationId = $row['quotationId'];
                        $total = $row['total'];

                        $result1->close();
                    }



                    $result2 = mysqli_query($connection, "SELECT drug,amount,quantity FROM quotationdetails WHERE quotationId='$quotationId'");

                    if (mysqli_num_rows($result2) > 0) {
                        while ($Row = $result2->fetch_assoc()) {

                            echo "
                                        <tr>
                                            <td>$Row[drug]</td>
                                            <td>$Row[quantity]</td>
                                            <td>$Row[amount]</td>
                                        </tr>
                            
                                    ";
                        }
                    }





                    ?>
                </tbody>
            </table>
            <div class="total">
                Total Amount: <?php echo $total ?>
            </div>
            <div class="accept-reject">
                <form method='post' action='updateStatusOfQuotation.php'>
                    <input type='hidden' name='quotationId' value='<?php echo $quotationId ?>' />
                    <input type='hidden' name='status' id='status' value='' />

                    <button type='submit' class='btn accept-btn' onclick='updateStatus("accept")'>ACCEPT</button>
                    <button type='submit' class='btn reject-btn' onclick='updateStatus("reject")'>REJECT</button>
                </form>
                <div>







                </div>
            </div>

            <script>

                var updateStatus=(status)=>{
                    document.getElementById('status').value=status;
                }


            </script>
</body>

</html>