<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Repræsentant intra værktøj</title>
</head>

<body>
<h1>Følgende kontoer er inaktive:</h1>
<?php
require 'connect.php';

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM Repser ORDER BY username ASC") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$name = $row['name'];
$usrname = $row['username'];
$school = $row['school'];
$email = $row['email'];
$grade = $row['grade'];
$phone = $row['phone'];
$title = $row['title'];
$hidephone = $row['hidephone'];
$description = $row['description'];
$profile = $row['pb'];
$id = $row['id'];

if (strlen($profile) < 3) {
if (strlen($name) > 1 ) {
?>
        <p class="missing" style="color:#f90202;"><?=$name?>
<?php
if (strlen($school) > 1 || strlen($grade) > 1 || strlen($phone) > 1 || strlen($title) > 1 || strlen($description) > 1) {
?>
        <b>(profilen er delvist udfyldt)</b></p><br/>
<?php
}
 } else {
?>
        <p class="missing" style="color:#f90202;"><?=$usrname?></p><br/>
<?php
 }
 }
}
?>

</body>

</html>
