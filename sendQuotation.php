<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    
</body>
</html>
<?php
session_start();
if(!isset($_SESSION['email'])){
    header("Location:index.php");
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    if (isset($_POST["data"])) {
      
        $data = json_decode($_POST["data"], true);

        var_dump($data);
       
    } else {
       
        echo "No data received.";
    }
} else {
  
    echo "Invalid request method.";
}
?>



