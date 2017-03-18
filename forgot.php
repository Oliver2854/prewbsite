<?php
session_start();
ob_start();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="Stylesheets/intra.css" rel="stylesheet" />

<title>Repræsentant intra - Glemt password</title>
</head>

<body>
<h1 id="intratitle">Repræsentant intra</h1>
<a id="help" href="http://overskolestaevnet.dk">Hjælp, jeg er ikke repræsentant!</a><!-- igen svigter directory navigation -->

<div id="loginbox">
<img id="loginpic" src="Repslogin.png"/> <!-- Det er pisse irriterende lige nu, men billedet skal flyttes til ../Images/Repslogin.png på et tidspunkt. -->
<form action="passrecon.php" method="post">
<label id="Labelusrn">Username:</label><br/><input id="username" name="username" type="username" />
<?php
if ($_SESSION['no_user'] == yes) {
?>
<br/><label id="PassErr">Ingen bruger med dette navn</label>
<?php
unset($_SESSION['no_user']);
}
?>
<br/><label id="Labelpass">Email du ønsker passwordet sendt til:</label><br/><input id="email" name="email" type="email" />

<br/><input type="submit" id="loginbtn" name="loginbtn" value="Anmod"/>
</form>

</div>

</body>

</html>