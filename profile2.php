<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] != $checknum) {
header("Location: repsintra.php");
ob_start();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<link href="Stylesheets/intra.css" rel="stylesheet" />

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Repræsentant intra</title>
</head>

<body>
<h1>Repræsentant intra</h1>

<a href="logout.php" id="exit">Log af</a>


<?php
require 'connect.php';

$id = $_SESSION['login_id'];

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM Repser WHERE id = '$id' ORDER BY name ASC") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

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
}
?>

<div id="form">
<p>Kære med-repser<br>Dette er muligvis den grimmeste side jeg nogensinde har lavet.<br>
Det skal blive til vores interne side en dag, og jeg lover at den bliver pænere til den tid.
<br>Lige for nu har den kun ét formål, og det er at samle data, så hvis du gidder at udfylde nedestående felter bliver jeg meget glad.
<br>Har du flere svar sepereres de med komma</p>
<form name="web_form" id="web_form" method="post" action="process-reps.php" enctype="multipart/form-data">
        <p><label>Fulde navn: </label><br/><input <?php if (strlen($name) < 1) { ?> required="required" <?php } ?> type="text" name="name" id="name" /></p>
        <p><label>Arbejdstitel: </label><br><input type="text" name="title" id="title" /></p>
        <p><label>Email (@overskolestaevnet.dk): </label><br><input <?php if (strlen($email) < 1) { ?> required="required" <?php } ?> type="text" name="email" id="email" /></p>
        <p><label>Tlf.: </label><br><input <?php if (strlen($phone) < 1) { ?> required="required" <?php } ?> type="text" name="phone" id="phone" /></p>
        <label>Skjul mit nummer på hjemmesiden </label><input <?php if ($hidephone > 0) { ?> checked <?php } ?> name="hidephone" type="checkbox" />
        <p><label>Skole: </label><br><select <?php if (strlen($school) < 1) { ?> required="required" <?php } ?> name="school" id="school" >
           <option disabled selected value> -- Vælg skole -- </option>
           <option>Vidar Skolen</option>
           <option>Sydskolen</option>
           <option>Kristofferskolen</option>
           <option>Michaelskolen</option>
           <option>Vordingborg</option>
           <option>Odense</option>
           <option>Københavnerskolen</option>
           <option>Aalborg</option>
           <option>Vejle</option>
           <option>Skanderborg</option>
        </select></p>
        <p><label>Klasse: </label><br><select <?php if (strlen($grade) < 1) { ?> required="required" <?php } ?> name="grade" id="grade">
           <option disabled selected value> -- Vælg klassetrin -- </option>
           <option>8. Klasse</option>
           <option>9. Klasse</option>
           <option>1. VG</option>
           <option>2. VG</option>
           <option>3. VG</option>
        </select></p>
        <p><label>Profilbillede: </label><br><input <?php if (strlen($profile) < 1) { ?> required="required" <?php } ?> type="file" name="fileToUpload" id="fileToUpload"/></p>
        <p><label>Lidt om dig selv: </label><br><textarea <?php if (strlen($description) < 1) { ?> required="required" <?php } ?> name="story" rows="5" cols="64"><?=$description?></textarea></p>
        <input type="submit" name="Submit" value="Submit"/>
</form>
</div>

</body>

</html>
