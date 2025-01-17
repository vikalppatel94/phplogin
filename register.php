<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'login';
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (mysqli_connect_errno()) {
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}


if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Please complete the registration form!');
}
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Please complete the registration form');
}



if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo 'Username exists, please choose another!';
	} else {
if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email, activation_code) VALUES (?, ?, ?, ?)')) {
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$uniqid = uniqid();
$stmt->bind_param('ssss', $_POST['username'], $password, $_POST['email'], $uniqid);
	$stmt->execute();
	echo 'You have successfully registered, you can now login!';
} else {
	echo 'Could not prepare statement!';
}
	}
	$stmt->close();
} else {
	echo 'Could not prepare statement!';
}
$con->close();
?>