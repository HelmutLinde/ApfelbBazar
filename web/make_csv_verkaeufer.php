<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include("credentials.php");
$servername = SERVERNAME;
$username = USERNAME;
$password = PASSWORD;
$db = DB;

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($conn, $db);

header("Content-type: text/plain; charset=utf-8");
header("Content-Disposition: attachment; filename=apfelbazar_verkaeufer.csv");

$query = 'SELECT * FROM verkaeufer';
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {

    print $row['id'] . "|" . urldecode($row['vorname']) . "|" . urldecode($row['name']) . "|" . urldecode($row['mail']) . "|" . urldecode($row['start_barcode']) . "|" . urldecode($row['end_barcode']) . "|" . urldecode($row['user']) . "|" . urldecode($row['strasse']) . "|" . urldecode($row['plz']) . "|" . urldecode($row['ort']) . "|" .$row['tel1']) . "\n";
}
mysqli_free_result($result);

mysqli_close($conn);
?>