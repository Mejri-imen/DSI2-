<?php
// Establish a connection to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fullstack";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check if the connection is successful
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Get the form data and sanitize it
  $username = mysqli_real_escape_string($conn, $_POST["username"]);
  $password = mysqli_real_escape_string($conn, $_POST["password"]);
  $confirm_password = mysqli_real_escape_string($conn, $_POST["confirm_password"]);

  // Check if the passwords match
  if ($password != $confirm_password) {
    echo "Passwords do not match.";
    exit();
  }

  // Check if the username already exists in the database
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);
  $count = mysqli_num_rows($result);
  if ($count > 0) {
    echo "Username already exists.";
    exit();
  }

  // Insert the user data into the database
  $hashed_password = password_hash($password, PASSWORD_DEFAULT);
  $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
  if (mysqli_query($conn, $sql)) {
    echo "Registration successful.";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  // Close the database connection
  mysqli_close($conn);
}
?>
