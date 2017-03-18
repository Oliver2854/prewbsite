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
<?php
require 'connect.php';

$id = $_SESSION['login_id'];

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM adminjobs ORDER BY id ASC") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$id = $row['id'];
$type = $row['type'];
$sender = $row['sender'];
$email = $row['email'];
?>
<div class="jobs" id="<?=$id?>" >
<?php if ($type == 'passrecon') { ?>
<p><b><?= strtok($sender, " ") ?></b> anmoder om at modtage sit password på email <b><?=$email?></b>. Vil du godkende dette?</p>
                <input name="Button1" type="button" value="Godkend" onclick="functionOne(this.parentNode.id)" />
                <input name="Button1" type="button" value="Afvis" onclick="myFunction(this.parentNode.id)" />
                <hr/>
</div>

<?php
}
}
?>



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