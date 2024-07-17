<?php include 'connection.php'; ?>
<?php

$sql1 = "CREATE TABLE IF NOT EXISTS `users` (
 `userID` INT NOT NULL AUTO_INCREMENT,
 `name` tinytext DEFAULT NULL,
 `country` tinytext DEFAULT NULL,
 `email` varchar(100) DEFAULT NULL,
 `Gender` tinytext DEFAULT NULL,
 `username` varchar(50) NOT NULL,
 `pass` varchar(255) DEFAULT NULL,
 `joined` timestamp NOT NULL DEFAULT current_timestamp(),
 `admin` int(11) DEFAULT 0,
 `made_admin_by` varchar(50) DEFAULT NULL,
 `user_status` tinytext DEFAULT NULL,
 PRIMARY KEY (`userID`),
 UNIQUE KEY `email` (`email`)
)";


if(mysqli_query($connection, $sql1)){
    //echo "Users table created successfully.";
} else{
    echo "ERROR: Could not be able to execute $sql1. " . mysqli_error($connection);
}

   $sql7 = "CREATE TABLE IF NOT EXISTS `sessions` (
    `session_id` VARCHAR(255),
    `user_id` INT NOT NULL,
    `device_info` VARCHAR(255),
    `last_activity` TIMESTAMP,
    PRIMARY KEY (`session_id`)
   )";
       
       if(mysqli_query($connection, $sql7)){
           //echo "Sessions table created successfully.";
   } else{
       echo "ERROR: Could not be able to execute $sql7. " . mysqli_error($connection);
   }

    $sql2 = "CREATE TABLE IF NOT EXISTS `products` (
    `productID` INT NOT NULL AUTO_INCREMENT,
    `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
    `product_name` varchar(100) DEFAULT NULL,
    `product_category` tinytext DEFAULT NULL,
    `product_brand` tinytext DEFAULT NULL,
    `product_weight_kgs` INT NOT NULL,
    `product_quantity` INT NOT NULL,
    `product_price` DECIMAL(10,2),
    `added_by_adminID` INT NOT NULL,
    `expiry_date` DATE,
    PRIMARY KEY (`productID`)
    )";


    if(mysqli_query($connection, $sql2)){
        //echo "Tasks table created successfully.";
    } else{
        echo "ERROR: Could not be able to execute $sql2. " . mysqli_error($connection);
    }


    $checkdefaultadminuser="SELECT email FROM users WHERE email='jackomondi@gmail.com'";
    $result=(mysqli_query($connection,$checkdefaultadminuser));
    if($result->num_rows>0){
        //Main Admin Exists
        //Do Nothing
    }else{
        $defaultpass = "Admin123";
        $hashedpass = (password_hash($defaultpass, PASSWORD_DEFAULT));

        $defaultuseradmin = "INSERT INTO users
        (name, country, email, gender, username, pass, admin, user_status) VALUES
        ('Jack Omondi', 'Kenya', 'jackomondi@gmail.com', 'Male', 'admin', '$hashedpass', '11', 'Active')
        ";
        
        
            if(mysqli_query($connection, $defaultuseradmin)){
                //echo "Tasks table created successfully.";
            } else{
                echo "ERROR: Could not be able to execute $defaultuseradmin. " . mysqli_error($connection);
            }
    }

//mysqli_close($connection);
?>