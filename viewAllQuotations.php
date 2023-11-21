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
            <a href="uploadPrescription.php"><button class="btn back-btn">GO BACK</button></a>
            <a href="logout.php"><button class="btn">LOGOUT</button></a>
        </div>
    </div>
    <div class="container">
        <div class="box view-box">
            <table>
                <thead>
                    <tr>
                        <th>Note</th>
                        <th>Delivery Address</th>
                        <th>Delivery Time</th>
                        <th>Status</th>

                    </tr>
                </thead>
                <tbody>
                    <?php

                    include("config.php");
                    $result = mysqli_query($connection, "SELECT * FROM prescriptions WHERE email='$_SESSION[email]'");

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = $result->fetch_assoc()) {


                            $result1 = mysqli_query($connection, "SELECT status FROM quotations WHERE prescriptionId='$row[prescriptionId]'");

                            if ($result1) {
                                if (mysqli_num_rows($result1) > 0) {
                                    $Row = mysqli_fetch_assoc($result1);
                                    $status = $Row['status'];

                                    if ($status == "Accepted") {
                                        echo "
                                        <tr>
                                            <td>$row[note]</td>
                                            <td>$row[deliveryAddress]</td>
                                            <td>$row[deliveryTime]</td>
                                            <td><span class='accepted'>$Row[status]</span></td>
                                            <td>
                                            <form method='post' action='viewOneQuotation.php' id='form'>
                                            <input type='hidden' name='prescriptionId' value='$row[prescriptionId]'  />
                                            <button type='submit' class='btn view-btn' >VIEW</button>
                                           
                                             </form>
                                        
                                                
                                            </td>
                                            
                                        </tr>
                            
                                    ";
                                    } else if ($status == "Rejected") {
                                        echo "
                                        <tr>
                                            <td>$row[note]</td>
                                            <td>$row[deliveryAddress]</td>
                                            <td>$row[deliveryTime]</td>
                                            <td><span class='rejected'>$Row[status]</span></td>
                                            <td>
                                            <form method='post' action='viewOneQuotation.php' id='form'>
                                            <input type='hidden' name='prescriptionId' value='$row[prescriptionId]'  />
                                            <button type='submit' class='btn view-btn' >VIEW</button>
                                           
                                             </form>

                              
                                            </td>
                                            
                                        </tr>
                            
                                    ";
                                    } else if ($status == "Pending") {

                                        echo "
                                        <tr>

                                            <td>$row[note]</td>
                                            <td>$row[deliveryAddress]</td>
                                            <td>$row[deliveryTime]</td>
                                            <td><span class='pending'>$Row[status]</span></td>
                                            <td>
                                            <form method='post' action='viewOneQuotation.php' id='form'>
                                            <input type='hidden' name='prescriptionId' value='$row[prescriptionId]'  />
                                            <button type='submit' class='btn view-btn' >VIEW</button>
                                           
                                             </form>
                                            </td>
                                            
                                        </tr>
                            
                                    ";
                                    }
                                }
                            }
                        }
                    }
                    mysqli_free_result($result);



                    ?>

                </tbody>
            </table>

        </div>
    </div>
    <script>

    </script>
</body>

</html>