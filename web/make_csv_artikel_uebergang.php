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
header("Content-Disposition: attachment; filename=apfelbazar_artikel.csv");

$query = 'SELECT * FROM artikel JOIN verkaeufer ON artikel.verkaeufer_id = verkaeufer.id';
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {

    print "16" . sprintf('%05d', intval($row['barcode_id'])) . "|" . urldecode($row['artikelbezeichnung']) . "|" . urldecode($row['farbe']) . "|" . $row['groesse'] . "|" . str_replace(".", ",", $row['preis']) . "|" . urldecode($row['name']) . "|" . urldecode($row['tel1']) . "|" . urldecode($row['mail']) . "\n";
}
mysqli_free_result($result);

mysqli_close($conn);
?>