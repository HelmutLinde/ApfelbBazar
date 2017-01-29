<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

define('__ROOT__', dirname(__FILE__));
require_once(__ROOT__ . '/credentials.php');

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

if (isset($_POST['id'])) {

    $query = 'SELECT * FROM `artikel` WHERE `barcode_id` = ' . $_POST['id'];
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)==0) {
        return "None";
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['artikelbezeichnung'] . '#' . $row['groesse'] . '#' . number_format($row['preis'], 2)  . '#' . $row['farbe'];
    }
    mysqli_free_result($result);
}


mysqli_close($conn);
?>
