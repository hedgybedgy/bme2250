<?php
$servername = "trial2.cvz7aiw5h7ur.us-east-2.rds.amazonaws.com";
$username = "priyamahatru";
$password = "OreoCheesecake";
$dbname = "transaction_prod2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connection success\n";
}

// Get user input data
// $name = $_POST["name"];
// $age = $_POST["age"];

// Insert user data into database
$sql = "INSERT INTO transactions (transaction_id, amount, transaction_type) VALUES (1, 50, 1)";
$sql = "INSERT INTO transactions (transaction_id, amount, transaction_type) VALUES (2, 100, 2)";
$sql = "INSERT INTO transactions (transaction_id, amount, transaction_type) VALUES (3, 150, 3)";


$query  = "SELECT * FROM transactions";
$last_update = '';

$stmt->bind_param('s', $last_update);

if ($stmt = $con->prepare($query)) {

    $stmt->execute();
    $stmt->bind_result($transaction_id, $amount, $transaction_type);

    while ($stmt->fetch()) {
        printf("%s, %s, %s, %s\n",
               $actor_id, $first_name, $last_name, $last_update);
    }

    $stmt->close();
}’

// $sql = "SELECT * FROM transactions";

// echo "Code passed to end\n";

/*
if( $conn->connect_error )
{
  returnWithError( $conn->connect_error );
} else {
  $stmt = $conn->prepare("INSERT INTO transactions (transaction_id, amount, transaction_type) VALUES (1, 50, 1)");
  $stmt->execute();

  $stmt->close();
  $conn->close();
  $checkstmt->close();
  returnWithError("N/A");
} */

/*
if ($conn->query($sql) === TRUE) {
  echo "User data inserted successfully";
} else {
  echo "Error inserting user data: " . $conn->error;
}

$conn->close(); */
?>