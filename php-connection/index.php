<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$dbname = "harvest";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error === true) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully <br><br><br><br><br>";


$sql = "SELECT id, name, nic FROM employee";
$result = $conn->query($sql);

if ($result->num_rows > 0 === true) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();
?>