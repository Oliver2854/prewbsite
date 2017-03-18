<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] == $checknum) {
header("Location: test.php");
ob_start();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="StylesheetMobile/intra.css" rel="stylesheet" />
<title>Repræsentant intra - Login</title>
</head>

<body>
<!-- <h1 id="intratitle">Repræsentant intra</h1>
<a id="help" href="http://overskolestaevnet.dk">Hjælp, jeg er ikke repræsentant!</a>--><!-- igen svigter directory navigation -->

<div id="loginbox">
<img id="loginpic" src="RepsloginBig.png"/> <!-- Det er pisse irriterende lige nu, men billedet skal flyttes til ../Images/Repslogin.png på et tidspunkt. -->
<form action="loginscript.php" method="post">
<label id="Labelusrn">Username:</label><br/><input id="username" name="username" type="username" />
<?php
if ($_SESSION['wrong_usrn'] == yes) {
?>
<br/><label id="PassErr">Ingen bruger med dette navn</label>
<?php
unset($_SESSION['wrong_usrn']);

}
?>
<br/><label id="Labelpass">Password:</label><br/><input id="password" name="password" type="password" />
<?php
if ($_SESSION['wrong_pass'] == yes) {
?>
<br/><label id="PassErr">Koden var forkert!</label>
<?php
unset($_SESSION['wrong_pass']);
}
?>
<br/><input type="submit" id="loginbtn" name="loginbtn" value="Login"/>
</form>
</div>

</body>

</html>