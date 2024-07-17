<?php

if((isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){

    if (isset($_GET['productID'])) {
        // Retrieve the productID from the URL
        $productID = $_GET['productID'];
    }

	$deviceInfo = $_SESSION['deviceInfo'];
        $sessionID = $_SESSION['session_id'];

        $getCurrentSessionQuery = "SELECT session_id FROM sessions WHERE user_id = $currentuserID AND device_info = '$deviceInfo'";
        $currentSessionResult = mysqli_query($connection, $getCurrentSessionQuery);
        if ($currentSessionResult && mysqli_num_rows($currentSessionResult) > 0) {
?>
    
    <!DOCTYPE HTML>
	<HTML>
    <link rel = "stylesheet" type = "text/css" href = "admin.css">
    <body>

<div class="editproductdetails">
<h3>Edit Product details</h3>

<?php
include 'connection.php';

//Fetch Product Details from the Database
$query = "SELECT * FROM products WHERE productID = $productID";
$result = mysqli_query($connection, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $userData = mysqli_fetch_assoc($result);
} else {
    // Handle the case when the user is not found
    die("User not found.");
}

?>

<form action="" method="POST" enctype="multipart/form-data"><br>

<label>Product Name: </label><input style="color: grey;" type="text" name="product_name" placeholder="Product Name" value="<?php echo $userData['product_name']; ?>" ><br>

<label>Product Category: </label><select style="color: grey;" type="text" name="product_category">
	<option value="<?php echo $userData['product_category']; ?>" selected> <?php echo $userData['product_category']; ?> </option>
    <option value="household">Household</option>
    <option value="electronics">Electronics</option>
    <option value="health_and_fitness">Health and Fitness</option>
    <option value="office">Office</option>
</select><br>			

<label>Product Brand: </label><input style="color: grey;" type="text" name="product_brand" placeholder="Product Brand" value="<?php echo $userData['product_brand']; ?>"><br>
<label>Product Weight (KGs): </label><input style="color: grey;" type="text" name="product_weight_kgs" placeholder="Product Weight (KGs)" value="<?php echo $userData['product_weight_kgs']; ?>"><br>
<label>Product Quantity (Number): </label><input style="color: grey;" type="text" name="product_quantity" placeholder="Product Quantity (Number)" value="<?php echo $userData['product_quantity']; ?>"><br>
<label>Product Price (KSh): </label><input style="color: grey;" type="text" name="product_price" placeholder="Product Price (KSh)" value="<?php echo $userData['product_price']; ?>"><br>
<label>Product Expiry Date: </label><input style="color: grey;" type="date" name="expiry_date" placeholder="Product Expiry Date" value="<?php echo $userData['expiry_date']; ?>"><br>

<input type="submit" name="submit" value="Submit">

</form>

</div>

</body>

<style>
    form {
    margin: auto;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f9f9f9;
    width: 400px;
}

/* Styling for labels */
label {
    font-weight: bold;
}

/* Styling for input fields */
input[type="text"],
input[type="date"],
select {
    width: 100%;
    padding: 4px;
    margin: 5px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

/* Styling for submit button */
input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 4px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

/* Change the color of selected dropdown option */
select option:checked {
    color: grey;
}
</style>

</HTML>

<?php

// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Retrieve form data
    $product_name = $connection -> real_escape_string(($_POST['product_name']));
    $product_category = $connection -> real_escape_string(($_POST['product_category']));
    $product_brand = $connection -> real_escape_string(($_POST['product_brand']));
    $product_weight_kgs = $connection -> real_escape_string(($_POST['product_weight_kgs']));
    $product_quantity = $connection -> real_escape_string(($_POST['product_quantity']));
    $product_price = $connection -> real_escape_string(($_POST['product_price']));
    $expiry_date = $connection -> real_escape_string(($_POST['expiry_date']));

    // Construct the query
    $query = "INSERT INTO products
        (product_name, product_category, product_brand, product_weight_kgs, product_quantity, product_price, added_by_adminID, expiry_date) VALUES
        ('$product_name', '$product_category', '$product_brand', '$product_weight_kgs', '$product_quantity', '$product_price', '$currentuserID', '$expiry_date')
        ";

        $query = "UPDATE products SET 
                product_name = '$product_name', 
                product_category = '$product_category', 
                product_brand = '$product_brand', 
                product_weight_kgs = '$product_weight_kgs', 
                product_quantity = '$product_quantity', 
                product_price = '$product_price',
                expiry_date = '$expiry_date'  
                WHERE 
                productID = '$productID'";


    // Execute the query
    if(mysqli_query($connection, $query)){

        echo "<script language='javascript' type='text/javascript'>";
        echo "alert('Product Details Updated Successfully!');";
        echo "</script>";
        $URL="index.php?page=products.php";
        echo "<script>location.href='$URL'</script>";

    } else{
        echo "ERROR: Could not be able to execute $query. " . mysqli_error($connection);

        /*
        echo "<script language='javascript' type='text/javascript'>";
        echo "alert('Failed! Please Retry');";
        echo "</script>";
        $URL="index.php?page=products.php";
        echo "<script>location.href='$URL'</script>";
        */
    }

}


// Update the last activity time
$_SESSION['last_activity'] = time();

// Update last activity on every user interaction (e.g., on each page load)
$updateLastActivityQuery = "UPDATE sessions SET last_activity = NOW() WHERE session_id = '$sessionID'";
$connection->query($updateLastActivityQuery);

}else{
header("location: logout.php");
    exit;
}
}elseif(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){
	header("location: loginregister.php");
	exit;
}

?>