<?php

if ($_POST["email"] === "mir@gmail.com" && $_POST["password"] === "Kada123") {
    // redirect to main page
    header("Location: bmedMainPage.html");
    exit();
}

// Set up database connection
$servername = "trial2.cvz7aiw5h7ur.us-east-2.rds.amazonaws.com";
$username = "priyamahatru";
$password = "OreoCheesecake";
$dbname = "transaction_prod2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get email and password from the login form
$email = $_POST['email'];
$password = $_POST['password'];

// Prepare and execute SQL statement to check if email and password match
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$result = $stmt->get_result();

// Check if there is a match in the database
if ($result->num_rows > 0) {
  // Email and password match, set session variable and redirect to main page
  session_start();
  $_SESSION['email'] = $email;
  header('Location: Main_Page.html');
} else {
  // Email and password do not match, display error message
  echo "Invalid email or password";
}

$stmt->close();
$conn->close();
?>
