<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] != $checknum) {
header("Location: index.php");
ob_start();
}
$dbpass = $_SESSION['pass'];

$link = mysqli_connect("overskolestaevnet.dk.mysql", "overskolestaevnet_dk", "tdvpQFUv", "overskolestaevnet_dk");
 
// Check connection
if(!$link){

   echo "ERROR: Could not connect. ";
} else {
   echo "Success. ";
}
echo "end";

mysqli_set_charset($link, "utf8");

$id=$_SESSION['login_id'];
$old = mysqli_real_escape_string($link, $_POST['oldpass']);
$new = mysqli_real_escape_string($link, $_POST['newpass']);
$repeat = mysqli_real_escape_string($link, $_POST['repeatpass']);


if ($dbpass == $old && $new == $repeat) {
$sql = "UPDATE Repser SET pass = '$new' WHERE id = '$id'";
if(mysqli_query($link, $sql)){
     echo "Updating...";

} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    echo "Der er sket en fejl. Kontakt Oliver og copy/paste det ovenstående.";
}
} else if ($dbpass != $old) {
$_SESSION['wrong_pass'] = yes;
$URL="http://intra.overskolestaevnet.dk";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
} else if ($new != $repeat) {
$_SESSION['unequal'] = yes;
$URL="http://intra.overskolestaevnet.dk/profile.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
}


// close connection
mysqli_close($link);

$URL="http://intra.overskolestaevnet.dk/profile.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";