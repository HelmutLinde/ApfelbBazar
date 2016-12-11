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

if (isset($_POST['user'])) {

    $query = 'SELECT * FROM `verkaeufer` WHERE `user` LIKE "' . $_POST['user'] . '"';
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)==0) {
        echo "Dieser Benutzername existiert nicht! Bitte wenden Sie sich an das Bazar-Team vom Apfelbäumchen.";
    }

    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['id'] . '#' .
             $row['name'] . '#' .
             $row['vorname'] . '#' .
             $row['mail'] .'#' .
             $row['start_barcode'] . '#' .
             $row['end_barcode'] . '#' .
             $row['strasse'] . '#' .
             $row['ort'] . '#' .
             $row['plz'] . '#' .
             $row['tel1'] . '#' .
             $row['user'];
    }
    mysqli_free_result($result);
}


mysqli_close($conn);
?>