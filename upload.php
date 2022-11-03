<?php
require 'db_connection.php';

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["stocks_csv"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {

//    if (file_exists($target_file)) {
//        echo "Sorry, file already exists.";
//        $uploadOk = 0;
//    }
    if ($_FILES["stocks_csv"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        if (!move_uploaded_file($_FILES["stocks_csv"]["tmp_name"], $target_file)) {
            //echo "Error";
            exit();
        }
    }

    $row = $conn->query('select count(*) from stock_rates;');

    if ($row->num_rows > 0) {
        $open = fopen($target_file, "r");
        $sqls = '';
        $i = 0;
        while (($data = fgetcsv($open, 1000, ",")) !== FALSE) {
            if ($i > 0) {
                $sqls .= "INSERT INTO stock_rates (stock_name, stock_price, date) VALUES ('$data[2]', '$data[3]', '" . date('Y-m-d H:i:s', strtotime($data[1])) . "');";
            }
            $i++;
        }

        $result = mysqli_multi_query($conn, $sqls);

        if ($result !== TRUE) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    fclose($open);

    //You need to redirect
    header("Location: http://localhost/stock_trade/"); /* Redirect browser */
    exit();
}




/*Use try catch*/