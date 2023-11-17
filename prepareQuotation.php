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
    
    <div class="container viewContainer">
        <div class="box view-box">
            <div class="image-viewer">
                <img id="big-image" src="img1.jpeg" alt="Big Image">

                <div id="image-container">
                    <img src="img1.jpeg" alt="Thumbnail 1" class="thumbnail" onclick="showImage('img1.jpeg')">
                    <img src="img2.jpeg" alt="Thumbnail 2" class="thumbnail" onclick="showImage('img2.jpeg')">
                    <img src="img3.jpeg" alt="Thumbnail 3" class="thumbnail" onclick="showImage('img3.jpeg')">
                    <img src="img4.jpeg" alt="Thumbnail 4" class="thumbnail" onclick="showImage('img4.jpeg')">
                    <img src="img5.jpeg" alt="Thumbnail 5" class="thumbnail" onclick="showImage('img5.jpeg')">
                </div>

            </div>
            <div id="invoice-container">
                <h2>Invoice</h2>

                <ul id="product-list"></ul>

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
        function showImage(image) {
            document.getElementById('big-image').src = image;
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