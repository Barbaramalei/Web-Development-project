<?php
session_start();
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {

    if (isset($_GET['productID'])) {
        // Retrieve the productID from the URL
        $productID = $_GET['productID'];
        include 'connection.php';

                    // Delete Product
                    $deleteQuery = "DELETE FROM products WHERE productID = $productID";
                    $deleteResult = mysqli_query($connection, $deleteQuery);

                    if ($deleteResult) {
                    echo "<script language='javascript' type='text/javascript'>";
                    echo "alert('Product Deleted Successfully.');";
                    echo "window.location.href='index.php?page=products.php';";
                    echo "</script>";
                } else {
                    echo "<script language='javascript' type='text/javascript'>";
                    echo "alert('Failed! Please Retry');";
                    echo "window.location.href='index.php?page=products.php';";
                    echo "</script>";

            }
        }
    }else{
    // User not logged in, redirect to login page
    header("location: loginregister.php");
    exit;
}
?>