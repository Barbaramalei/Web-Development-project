<?php
if(isset($_SESSION["logged"]) && $_SESSION["logged"] === true){
?>

<!DOCTYPE HTML>
<HTML>
<link rel = "stylesheet" type = "text/css" href = "admin.css">
<body>
	<h1>Search Products</h1>
	<div class="searchorders"><br>
	<!-- <form action="<?php //echo $_SERVER['PHP_SELF']; ?>" method="post"> -->
	<form action="" method="post">
  <div class="topmostdiv">
      <div class = "topmostlabel">
      <label for="product_id">Product ID:</label><br>
      </div>

      <div class = "topmostinput">
      <input type="text" id="product_id" name="product_id"><br>
      </div>
    </div><br>

		<div class="topdiv">
			<div class="toplabels">
				<label for="product_brand">Product Brand:</label><br>
				<label for="product_price">Product Price:</label><br>
			</div>

			<div class="topinputs">
				<input type="text" id="product_brand" name="product_brand"><br>
				<input type="number" step="0.01" id="product_price" name="product_price"><br>
			</div>
		</div>

		<div class="bottomdiv">
			<div class="bottomlabels">
				<label for="product_name">Product Name:</label><br>
				<label for="product_category">Product Category:</label><br>
			</div>
		
			<div class="bottominputs">
				<input type="text" id="product_name" name="product_name"><br>
				<input type="text" id="product_category" name="product_category"><br>
			</div>
		</div>
		</div>
		<input type="submit" name="submit" value="Search">
		
	</form>

	<?php
// Assuming you have already established a connection to the MySQL database
include 'connection.php';
// Check if the form is submitted
if (isset($_POST['submit'])) {

    // Retrieve form data
    $product_id = $connection -> real_escape_string(($_POST['product_id']));
    $product_brand = $connection -> real_escape_string(($_POST['product_brand']));
    $product_price = $connection -> real_escape_string(($_POST['product_price']));
    $product_name = $connection -> real_escape_string(($_POST['product_name']));
    $product_category = $connection -> real_escape_string(($_POST['product_category']));

    // Construct the base query
    $query = "SELECT * FROM products WHERE 1";

    // Add conditions based on the filled fields
    if (!empty($product_id)) {
      $query .= " AND productID LIKE '%$product_id%'";
    }
    
    if (!empty($product_brand)) {
        $query .= " AND product_brand LIKE '%$product_brand%'";
    }

    if (!empty($product_price)) {
        $query .= " AND product_price LIKE '%$product_price%'";
    }

    if (!empty($product_name)) {
        $query .= " AND product_name LIKE '%$product_name%'";
    }

    if (!empty($product_category)) {
        $query .= " AND product_category LIKE '%$product_category%'";
    }

    // Execute the query
    $result = mysqli_query($connection, $query);
	echo '<br>'.'<br>';
	echo '<div class = "results">';
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
                <th style="border: 2px double black;">Action</th>
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
                <td style="border: solid 1px black;">' . $row['expiry_date'] . '</td>';

                $modifyproduct = "?page=modifyproduct.php&productID=".$row['productID'];
                $deleteproduct = "?page=deleteproduct.php&productID=".$row['productID'];


                echo '<td style="border: solid 1px black;">
                <select name="forma" onchange="selectOption(this.value, \''.$modifyproduct.'\', \''.$deleteproduct.'\')">
                        <option value="#">Select</option>
                        <option value="modify">Modify</option>
                        <option value="delete" style="color: red;">Delete</option>
                    </select>
                    </td>
        </tr>';
      
     $index = $index + 1;
    }

    echo '</table>';

    // Free the result set
    mysqli_free_result($result);
		}else{
			echo "No results found.";
		}
echo '</div>';
}

  
  ?>





<script>
function selectOption(value, modifyproductURL,deleteproductUrl) {
    var confirmationMessage;

    if (value === "modify") {
            confirmationMessage = "Modify this product details?";

        var confirmed = confirm(confirmationMessage);

        if (confirmed) {
            window.location.href = modifyproductURL;
        }
    } else if (value === "delete") {
            confirmationMessage = "Delete this product? Please note that this cannot be undone.";

        var confirmed = confirm(confirmationMessage);

        if (confirmed) {
            window.location.href = deleteproductUrl;
        }
    } else if (value !== "#") {
        window.location.href = value;
    }
}
</script>






	<style>	
  .searchorders {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 80%;
	margin: auto;
	padding-right: 100px;
}


.topmostdiv {
  display: inline-flex;
  margin: auto;
}

.topmostlabel {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.topmostinput {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.topdiv, .bottomdiv {
  display: inline-flex;
  flex-direction: row;
  margin-left: 12px;
}

.toplabels, .bottomlabels {
  display: flex;
  flex-direction: column;
  align-items: flex-end;
}

.topinputs, .bottominputs {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

label {
  margin-bottom: 5px;
}

input[type="submit"] {
  margin-top: 10px;
}

input[type="text"] {
  margin-left: 4px;
}

input[type="email"] {
  margin-left: 4px;
}

.results{
	display: flex;
	justify-content: center;
	align-items: center;
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