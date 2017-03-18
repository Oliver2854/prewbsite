<?php
require 'connect.php';
session_start(); // Starting Session
$username = $_POST['username'];
$email = $_POST['email'];

$result = $db->query("SELECT * FROM Repser WHERE username='$username'") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$usrn = $row['username'];
}

if (strlen($usrn)>1) {
    $sql = "INSERT INTO adminjobs (sender, type, email)
    VALUES ('$usrn', 'passrecon', '$email')";

    if ($db->query($sql) === TRUE) {
        echo "Når din anmodning bliver godkendt af en admin, vil du modtage dit password på den email du har indtastet";
    } else {
        echo "Error creating record: " . $db->error;
    }

    $db->close();
}else if ($username != $usrn) {
    $_SESSION['no_user'] = yes;
header("Location: forgot.php");
}

?>