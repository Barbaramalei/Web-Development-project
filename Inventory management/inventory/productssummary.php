<?php
if (isset($_SESSION["logged"]) && $_SESSION["logged"] === true) {
?>

<!DOCTYPE HTML>
<HTML>
<link rel="stylesheet" type="text/css" href="admin.css">
<body>

<?php
// Assuming you have already established a connection to the MySQL database
include 'connection.php';
// Check if the form is submitted
if (isset($_GET['tile'])) {
    // Retrieve the productID from the URL
    $tile = $_GET['tile'];

    // Construct the base query
    $query = "SELECT * FROM products WHERE 1";
    $heading = "Total Products";

    // Add conditions based on the selected tile
    if ($tile == "2") {
        $query .= " AND product_quantity <= 50";
        $heading = "Total Products Out of Stock";
    } elseif ($tile == "3") {
        // Calculate the date 10 days from now
        $expiryDateThreshold = date('Y-m-d', strtotime('+10 days'));

        // Update the query to select products expiring soon (in 10 days or less)
        $query .= " AND expiry_date <= '$expiryDateThreshold'";
        $heading = "Products Expiring Soon (in 10 days or less)";
    }

    echo '<h1>' . $heading . '</h1>';
    // Execute the query
    $result = mysqli_query($connection, $query);
    echo '<br>' . '<br>';
    echo '<div class="results">';
    if (mysqli_num_rows($result) > 0) {
        $index = 1;

        // Create an HTML table to display the results
        echo '<table style="border: 2px double black;">
            <tr>
                <th style="border: 2px double black;">#</th>
                <th style="border: 2px double black;">Product ID</th>
                <th style="border: 2px double black;">Product Name</th>
                <th style="border: 2px double black;">Category</th>
                <th style="border: 2px double black;">Brand</th>
                <th style="border: 2px double black;">Weight</th>
                <th style="border: 2px double black;">Quantity</th>
                <th style="border: 2px double black;">Price</th>
                <th style="border: 2px double black;">Expiry Date</th>
            </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                <td style="border: solid 1px black;"><b>' . $index . '</b></td>
                <td style="border: solid 1px black;">' . $row['productID'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_name'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_category'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_brand'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_weight_kgs'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_quantity'] . '</td>
                <td style="border: solid 1px black;">' . $row['product_price'] . '</td>
                <td style="border: solid 1px black;">' . $row['expiry_date'] . '</td>
            </tr>';
            $index = $index + 1;
        }

        echo '</table>';
    } else {
        echo "No results found.";
    }

    echo '</div>';
}
?>

<style>
    .results {
        display: flex;
        justify-content: center;
        align-items: center;
    }
</style>

</body>
</HTML>

<?php
} elseif (!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)) {
    header("location: loginregister.php");
    exit;
}
?>
