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

$values = array();
$personal = array("name", "vorname", "mail", "strasse", "ort", "plz", "tel1");
$personal_values = array();

foreach ($_POST as $key => $value) {

    if ( substr($key,0,2) == "id" ) {
        $userid = $value;

    } elseif ( in_array($key, $personal) ) {
        $personal_values[$key] = $value;

    } else {
        $typenr = explode("-", $key);
        $type = $typenr[0];
        $nr = $typenr[1];

        if(! array_key_exists($nr, $values)) {
            $values[$nr] = array();
        }
        $values[$nr][$type] = $value;
    }
}

$fail=0;
$sucess=0;

$query = "UPDATE verkaeufer SET name='" . $personal_values['name'] . "', mail='" . $personal_values['mail'] . "', vorname='" . $personal_values['vorname'] . "', strasse='" . $personal_values['strasse'] . "',plz='" . $personal_values['plz'] . "', ort='" . $personal_values['ort'] . "', tel1='" . $personal_values['tel1'] . "' WHERE id=$userid";
//echo "<script>alert($query)</script>";
$result = mysqli_query($conn, $query);


foreach ($values as $key => $value) {
    $barcode = $value['barcode'];
    $groesse = $value['groesse'];
    $article = $value['article'];
    $preis   = $value['preis'];
    $farbe   = $value['farbe'];

    $query = 'SELECT barcode_id FROM artikel WHERE barcode_id = ' . $barcode;
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result)==0) {
        $query = 'INSERT INTO artikel (barcode_id, artikelbezeichnung, groesse, preis, verkaeufer_id, farbe) VALUES ("' . $barcode . '", "' . $article . '", "' . $groesse . '", "' . $preis . '", "' . $userid . '", "' . $farbe . '")';
        if (mysqli_query($conn, $query)) { $sucess++; } else { $fail++; }

    } else {
        $query = 'UPDATE artikel SET artikelbezeichnung="' . $article . '", groesse="' . $groesse . '", preis="' . $preis . '", farbe="' . $farbe . '" WHERE barcode_id=' . $barcode;
        if (mysqli_query($conn, $query)) { $sucess++; } else { $fail++; }
    }
    mysqli_free_result($result);


}

echo "Daten aktualisiert" . (($fail==0) ? "" : "$fail Fehler.");



mysqli_close($conn);
?>