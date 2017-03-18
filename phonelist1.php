<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="Stylesheets/intra.css" rel="stylesheet" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Telefonliste</title>
</head>

<body>
<div id="contactlistBox">
<h1>Telefon- og email-liste</h1>
<?php
require 'connect.php';

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM Repser ORDER BY name ASC") or die ($db->error);

while($row = mysqli_fetch_array($result)) {

$name = $row['name'];
$school = $row['school'];
$email = $row['email'];
$grade = $row['grade'];
$phone = $row['phone'];
$title = $row['title'];
$hidephone = $row['hidephone'];
$description = $row['description'];
$profile = $row['pb'];
$id = $row['id'];
?>
<div id="<?=$name?>" class="contactlist"
<?php
if (strlen($name) < 1) {
?>
style="display:none"
<?php
}
?>
>
<h1><?=$name?></h1>
<p>Tlf.: <a href="tel:<?=$phone?>"><?=$phone?></a></p>
<br/><p>Email: <a href="mailto:<?=$email?>"><?=$email?></a></p>
</div>
<?php
}
?>
</div>

</body>

</html>
