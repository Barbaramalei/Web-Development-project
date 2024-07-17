<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
?>

<!DOCTYPE HTML>
<HTML>
<link rel = "stylesheet" type = "text/css" href = "admin.css">
<body>
	<h3>Add Products</h3>
	<div class="searchorders">
	<!-- <form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post"> -->
	<form action="" method="post">

      <label for="product_name">Product Name:</label>
      <input type="text" id="product_name" name="product_name" required><br>

      <label for="product_category">Product Category:</label>
      <select id="product_category" type="text" name="product_category" required>
            <option value="" disabled selected>Product Category</option>
            <option value="household">Household</option>
            <option value="electronics">Electronics</option>
            <option value="health_and_fitness">Health and Fitness</option>
            <option value="office">Office</option>
        </select><br>

      <label for="product_brand">Product Brand:</label>
      <input type="text" id="product_brand" name="product_brand" required><br>

      <label for="product_weight_kgs">Product Weight (KGs):</label>
      <input type="number" step="0.01" id="product_weight_kgs" name="product_weight_kgs" required><br>

      <label for="product_quantity">Product Quantity (Number):</label>
	  <input type="number" id="product_quantity" name="product_quantity" required><br>

      <label for="product_price">Product Price (KSh):</label>
      <input type="number" step="0.01" id="product_price" name="product_price" required><br>

      <label for="expiry_date">Product Expiry Date:</label>
	  <input type="date" id="expiry_date" name="expiry_date" required><br>

	  <input type="submit" name="submit" value="Submit">
		
	</form>
    </div>
	<?php
// Assuming you have already established a connection to the MySQL database
include 'connection.php';
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

    // Construct the base query
    $query = "INSERT INTO products
        (product_name, product_category, product_brand, product_weight_kgs, product_quantity, product_price, added_by_adminID, expiry_date) VALUES
        ('$product_name', '$product_category', '$product_brand', '$product_weight_kgs', '$product_quantity', '$product_price', '$currentuserID', '$expiry_date')
        ";

    // Execute the query
    if(mysqli_query($connection, $query)){

        echo "<script language='javascript' type='text/javascript'>";
        echo "alert('Product Added Successfully!');";
        echo "</script>";
        $URL="index.php?page=addproducts.php";
        echo "<script>location.href='$URL'</script>";

    } else{
        echo "ERROR: Could not be able to execute $query. " . mysqli_error($connection);

        /*
        echo "<script language='javascript' type='text/javascript'>";
        echo "alert('Failed! Please Retry');";
        echo "</script>";
        $URL="index.php?page=addproducts.php";
        echo "<script>location.href='$URL'</script>";
        */
    }

}

  
  ?>

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
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}

/* Styling for input fields */
input[type="text"],
input[type="number"],
input[type="date"],
select {
    width: calc(100% - 10px);
    padding: 3px;
    margin-bottom: 10px;
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

/* Styling for select dropdown */
select {
    width: calc(100% - 10px);
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    background-color: white;
    color: black;
}

/* Styling for selected option */
select option:checked {
    color: black;
}

</style>

</body>
</HTML>

<?php
}elseif(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true)){
	header("location: loginregister.php");
	exit;
}

?>