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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>

<body>
    <div class="nav">
        <div class="logo">
            <p>Health<span class="sub-logo">Hub</span></p>
        </div>
        <div class="right-links">
            <a href="viewPrescription.php"><button class="btn back-btn">GO BACK</button></a>
            <a href="logout.php"><button class="btn">LOGOUT</button></a>

        </div>
    </div>
    <?php

    include("config.php");
    $prescriptionId = $_POST['prescriptionId'];

    $selectQuery = "SELECT image FROM images WHERE prescriptionId='$prescriptionId'";
    $big_result = $connection->query($selectQuery);
    $small_result = $connection->query($selectQuery);

    ?>


    <div class="container viewContainer">

        <div class="box view-box">

            <div class="image-viewer">
                <?php

                $row = $big_result->fetch_assoc();
                $bigImage = $row['image'];
                $bigImageData = base64_encode($bigImage);

                echo '<img src="data:image/jpeg;base64,' . $bigImageData . '" alt="Thumbnail 1"  id="big-image" >';
                ?>

                <div id="small-image-container">
                    <?php
                    $count = 1;
                    while ($row = $small_result->fetch_assoc()) {

                        $image = $row['image'];
                        $imageData = base64_encode($image);
                        $src = "data:image/jpeg;base64," . $imageData;
                        $borderStyle = '';
                        if ($count == 1) {
                            $borderStyle = 'border: 3px solid #4285f4;';
                        }
                        $imageId = "image" . $count;

                        echo "<img src='$src' alt='Thumbnail' class='small-images' id='$imageId'onclick='showImage(\"$src\",\"$imageId\")' style='$borderStyle'>";

                        $count++;
                    }
                    ?>
                </div>

            </div>
            <form action="sendQuotation.php" method="post" id="invoice-form">
                <div id="invoice-container">
                    <div class="products">
                        <table id="product-table">
                            <thead>
                                <tr>
                                    <th>Drug</th>
                                    <th>Quantity</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody id="product-list">

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="2" class="total">Total</td>
                                    <td id="total" class="total">0.00</td>
                                </tr>
                            </tfoot>
                        </table>


                    </div>

                    <div class="add-products">
                        <div class="field input">
                            <label for="productName">Drug</label>
                            <input type="text" id="productName">
                        </div>
                        <div class="field input">
                            <label for="quantity">Quantity</label>
                            <input type="number" id="quantity">
                        </div>
                        <div class="field input">
                            <label for="price">Amount</label>
                            <input type="number" id="price">
                        </div>
                        <div class="field">
                            <button onclick="addProduct()" class="btn" type="button">ADD PRODUCT</button>
                        </div>

                    </div>
                    <div class="submit-quotation">
                        <div class="field">
                            <button type="button" class="btn send-btn" onclick="sendQuotation()">SEND QUOTATION</button>
                        </div>

                    </div>




                </div>

            </form>


        </div>
    </div>


    <script>
        function showImage(image, imageId) {
            document.getElementById('big-image').src = image;
            var allImages = document.getElementsByClassName('small-images');
            for (image of allImages) {
                image.style.border = 'none';
            }
            document.getElementById(imageId).style.border = '3px solid #4285f4';


        }

        function addProduct() {

            var productName = document.getElementById('productName').value;
            var quantity = document.getElementById('quantity').value;
            var price = document.getElementById('price').value;

            if (productName && quantity && price) {
                var productList = document.getElementById('product-list');
                var totalElement = document.getElementById('total');


                var newRow = productList.insertRow();
                var cell1 = newRow.insertCell(0);
                var cell2 = newRow.insertCell(1);
                var cell3 = newRow.insertCell(2);


                cell1.innerHTML = productName;
                cell2.innerHTML = quantity + " x " + parseFloat(price);
                cell3.innerHTML = quantity * price;


                var currentTotal = parseFloat(totalElement.innerHTML);
                var subtotal = parseFloat(quantity) * parseFloat(price);
                totalElement.innerHTML = (currentTotal + subtotal).toFixed(2);

                document.getElementById('productName').value = '';
                document.getElementById('quantity').value = '';
                document.getElementById('price').value = '';
            } else {
                alert('Please fill in all fields.');
            }
        }

        var sendQuotation = () => {
            console.log("called!");
            var data = [];

           
            $("#product-list tr").each(function() {
                var row = {};
                row.drug = $(this).find("td:eq(0)").text();
                row.quantity = $(this).find("td:eq(1)").text();
                row.amount = $(this).find("td:eq(2)").text();
                data.push(row);
            });

            console.log(data);

            $("#invoice-form").append('<input type="hidden" name="data" value="' + JSON.stringify(data) + '">');

         
            $("#invoice-form").submit();


        };
       
    </script>

</body>

</html>