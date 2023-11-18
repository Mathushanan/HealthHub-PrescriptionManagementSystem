<?php

session_start();

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
                        $borderStyle='';
                        if($count==1){
                            $borderStyle='border: 3px solid #4285f4;';
                        }
                        $imageId = "image" . $count;

                        echo "<img src='$src' alt='Thumbnail' class='small-images' id='$imageId'onclick='showImage(\"$src\",\"$imageId\")' style='$borderStyle'>";

                        $count++;
                    }
                    ?>




                </div>

            </div>
            <div id="invoice-container">
                <h2>Invoice</h2>

                <ul id="product-list">

                </ul>

                <div class="field input">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName">
                </div>
                <div class="field input">
                    <label for="quantity">Quantity:</label>
                    <input type="number" id="quantity">
                </div>
                <div class="field input">
                    <label for="price">Price:</label>
                    <input type="number" id="price">
                </div>
                <div class="field">
                    <button onclick="addProduct()" class="btn">Add Product</button>
                </div>

            </div>

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

                var listItem = document.createElement('li');
                listItem.className = 'product-item';
                listItem.innerHTML = `<strong>${productName}</strong> - Quantity: ${quantity}, Price: ${price}`;

                productList.appendChild(listItem);

                // Clear input fields after adding the product
                document.getElementById('productName').value = '';
                document.getElementById('quantity').value = '';
                document.getElementById('price').value = '';
            } else {
                alert('Please fill in all fields.');
            }
        }
    </script>

</body>

</html>