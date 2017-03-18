<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] != $checknum) {
header("Location: index.php");
ob_start();
}
$id = $_SESSION['login_id'];


require 'connect.php';

$db->set_charset("utf8");
$result = $db->query("SELECT pass FROM Repser WHERE id = '$id'") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {
$_SESSION['pass'] = $row['pass'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link href="Stylesheets/intra.css" rel="stylesheet" />
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Repræsentant intra</title>
</head>

<body>
<p></p><p></p><form method="post" action="changepass.php">
<label id="Label1">Nuværende kode:</label>
<br/><input name="oldpass" type="password" />
<?php
if ($_SESSION['wrong_pass'] == yes) {
?>
<br/><label id="PassErr">Koden var forkert!</label>
<?php
unset($_SESSION['wrong_pass']);
}
?>
<br/><label id="Label1">Ny kode:</label>
<br/><input name="newpass" type="password" />
<br/><label id="Label1">Gentag ny kode:</label>
<br/><input name="repeatpass" type="password" />
<?php
if ($_SESSION['wrong_pass'] == yes) {
?>
<br/><label id="PassErr">Koderne stemmer ikke.</label>
<?php
unset($_SESSION['wrong_pass']);
}
?>

<br/><input name="Submit" type="submit" value="Skift password" />
</form>
</body>

</html>
