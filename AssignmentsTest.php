<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] != $checknum) {
    header("Location: index.php");
    ob_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Untitled 1</title>
</head>

<body>
<ul style="list-style-type:none;margin:0px;">
<?php
require 'connect.php';

$id = $_SESSION['login_id'];

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM opgaver ORDER BY time ASC") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$id = $row['id'];
$assignment = $row['assignment'];
$creator = $row['creator'];
$time = $row['time'];
?>

<li style="height:100px;margin:0;border: thin;background: #c6c6c6;background: -webkit-linear-gradient(#c6c6c6, #adadad);background: -o-linear-gradient(#c6c6c6, #adadad);background: -moz-linear-gradient(#c6c6c6, #adadad);background: linear-gradient(#c6c6c6, #adadad)"><h1><?=$assignment?></h1><p><?=$time?></p></li>

<?php
}
?>
</ul>


<p id="demo"></p>

<script>
    function myFunction(hey) {
        alert("Hello! I am "+hey);
    }
</script>

<script>
function functionOne(assign) {
if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById(assign).innerHTML = this.responseText;
    }
  };
xmlhttp.open("POST", "acceptAssign.php", true);
xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlhttp.send("id="+assign);
}
</script>

</body>
</html>