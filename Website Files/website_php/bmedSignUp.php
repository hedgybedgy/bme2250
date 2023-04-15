<?php
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

// Get email and password from the signup form
$email = $_POST['email'];
$password = $_POST['password'];

// Check if the email already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  // Email already exists, display error message
  echo "Email already exists";
} else {
  // Email does not exist, insert the new user into the database
  $stmt = $conn->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
  $stmt->bind_param("ss", $email, $password);
  $stmt->execute();

  if ($stmt->affected_rows > 0) {
    // Account created successfully, display success message
    echo "Account created successfully";
  } else {
    // Error occurred while creating the account, display error message
    echo "An error occurred";
  }
}

$stmt->close();
$conn->close();
?>