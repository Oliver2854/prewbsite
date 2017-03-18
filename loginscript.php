<?php
require 'connect.php';
session_start(); // Starting Session
$username = $_POST['username'];
$password = $_POST['password'];
$checknum = 1123581321;

if (strlen($username)<1 || strlen($password)<1) {
    header("Location: index.php");
}

$result = $db->query("SELECT * FROM Repser WHERE username='$username'") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$usrn = $row['username'];
$correct_pass = $row['pass'];
$id = $row['id'];
$perm = $row['permissions'];
}

if ($password == $correct_pass) {
$_SESSION['login_check']=$checknum;
$_SESSION['login_id']=$id; // Initializing Session
$_SESSION['auth']=$perm;
header("Location: profile.php");
}else if ($username == $usrn) {
$_SESSION['wrong_pass'] = yes;
header("Location: index.php");
}else {
$_SESSION['no_user'] = yes;
header("Location: index.php");
}

?>
