<?php

session_start();
if(!isset($_SESSION['email'])){
    header("Location:logout.php");
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
    <div class="container viewContainer">
        <div class="box view-box">
            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Note</th>
                        <th>Delivery Address</th>
                        <th>Delivery Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    include("config.php");
                    $result=mysqli_query($connection,"SELECT * FROM prescriptions");

                    while($row=$result->fetch_assoc()){

                        echo "

                        <tr>
                          <td>$row[name]</td>
                          <td>$row[note]</td>
                          <td>$row[deliveryAddress]</td>
                          <td>$row[deliveryTime]</td>
                          <td>
                          <form method='post' action='prepareQuotation.php'>
                          <input type='hidden' name='prescriptionId' value='$row[prescriptionId]' />
                          <button type='submit' class='btn quotation-btn'>Quote</button>
                          </form>
                          </td>
                        </tr>
                        
                        ";

                    }


                    ?>
                    
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>