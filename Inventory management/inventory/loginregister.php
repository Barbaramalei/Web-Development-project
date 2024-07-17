<?php
session_start();
if(!(isset($_SESSION["logged"]) && $_SESSION["logged"] === true))
	
    {
?>

<!DOCTYPE HTML>
<HTML>
<link rel="stylesheet" type="text/css" href="style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
</head>

<body>

<div class = "navbar">

<div class = "brandname">
<a href="index.php"><h1>INVENTORY</h1></a>
</div>
<br>
</div>

<br><br><br><br><br><br>
<div class="loginregisterdiv">
<h2>Log in to your account</h2>
<div class="loginregisterform">

<form action="login.php" method="POST"><br>
<input type="text" name="username" placeholder="Username" required><br>
<input type="password" name="password" placeholder="Password" required><br>
<button name="submit" type="submit" value="submit">Log In</button><br>

<br>
</form>
</div>

</div>
<script>
	const menuToggle = document.querySelector('.menu-toggle');
	const menu = document.querySelector('.menu');

	menuToggle.addEventListener('click', () => {
	menu.classList.toggle('open');
	});
</script>

<script>
	const closeButton = document.querySelector('.close-button');
	const invisibleDiv = document.querySelector('.closebtn');

	closeButton.addEventListener('click', () => {
	//invisibleDiv.style.display = 'none';
	menu.classList.toggle('open');
	});
</script>
</body>
</HTML>
<?php
}else{
	header("location: mainadmin.php");
	exit;
}
?>