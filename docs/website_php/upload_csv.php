<?php
header("Content-Type: application/json");

// Set up database connection
$servername = "bmed-2250-database.cvz7aiw5h7ur.us-east-2.rds.amazonaws.com";
$username = "priyamahatru";
$password = "OreoCheesecake";
$dbname = "transaction_prod2";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the CSV data from the POST request
$csv_data = json_decode(file_get_contents("php://input"), true);

// Insert the CSV data into the MySQL table
foreach ($csv_data as $row) {
    $x = $row["x"];
    $y = $row["y"];

    $stmt = $conn->prepare("INSERT INTO $table_name (x, y) VALUES (?, ?)");
    $stmt->bind_param("ss", $x, $y);
    $stmt->execute();
}

// Close the database connection
$conn->close();

// Return a JSON response indicating success
http_response_code(200);
echo json_encode(["success" => true]);
?>