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
<link href="Stylesheets/intra.css" rel="stylesheet" />

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Repræsentant intra</title>
</head>

<body>
<?php
if ($_SESSION['img_empt'] == yes) {
$message = "Hvis ikke du vælger et billede vil din profil ikke eksistere!";
echo "<script type='text/javascript'>alert('$message');</script>";
}
?>
<h1>Repræsentant intra</h1>

<a href="logout.php" id="exit">Log af</a>

<div id="intraholder">
<div id="navbarholder">
<ul id="navbar">
   <li class="selected"><a href="profile.php">Mig</a></li>
   <li><a href="embed.htm">Kalender</a></li>
   <li><a href="password.php">Skift kode</a></li>
   <li><a href="Cloud.html">Dokumenter</a></li>
   <li><a href="phonelist.php">Kontaktliste</a></li>
</ul>
</div>
<br/>
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
<p>Kære repræsentanter
<br/>Dette er repræsentanternes interne intranet.
<br/>Her vil langsomt dukke flere og flere funktioner op, og i må derfor meget gerne holde øje med siden her. 
<br/>Lige nu er der kun en side her, og det er din personlige profil. Har du ikke udfyldt denne endnu, eksisterer du ikke i vores system, og du vil ikke være til at finde på hjemmesiden. Du bedes derfor udfylde den hurtigst muligt. 
<br/>Mange af felterne er påkrævet, herunder telefonnummer. Bemærk dog at der er mulighed for at skjule dit nummer på hjemmesiden, ved at klikke på checkboksen under "Skjul mit nummer".</p>
<form name="web_form" id="web_form" method="post" action="process-reps.php" enctype="multipart/form-data">
        <p><label>Fulde navn: </label><br/><input <?php if (strlen($name) < 1) { ?> required="required" <?php } ?> type="text" name="name" id="name" style="text-transform: capitalize;" value="<?=$name?>" /></p>
        <p><label>Arbejdstitel (Denne behøves ikke at være udfyldt. Du kan også skrive "Repræsentant"): </label><br><input type="text" name="title" id="title" value="<?=$title?>" /></p>
        <p><label>Email (@overskolestaevnet.dk): </label><br><input <?php if (strlen($email) < 1) { ?> required="required" <?php } ?> type="text" name="email" id="email" value="<?=$email?>" /></p>
        <p><label>Tlf.: </label><br><input <?php if (strlen($phone) < 1) { ?> required="required" <?php } ?> type="text" name="phone" id="phone" value="<?=$phone?>" /></p>
        <label>Skjul mit nummer på hjemmesiden </label><input <?php if ($hidephone > 0) { ?> checked <?php } ?> name="hidephone" type="checkbox" value="1" />
        <p><label>Skole: </label><br><select <?php if (strlen($school) < 1) { ?> required="required" <?php } ?> name="school" id="school" >
           <option disabled selected value> -- Vælg skole -- </option>
           <option <?php if ($school == 'Vidar Skolen') { ?>selected<?php } ?> value="Vidar Skolen">Vidar Skolen</option>
           <option <?php if ($school == 'Sydskolen') { ?>selected<?php } ?> value="Sydskolen">Sydskolen</option>
           <option <?php if ($school == 'Kristofferskolen') { ?>selected<?php } ?> value="Kristofferskolen">Kristofferskolen</option>
           <option <?php if ($school == 'Michaelskolen') { ?>selected<?php } ?> value="Michaelskolen">Michaelskolen</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Kvistgård') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Kvistgård">Kvistgård</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Vordingborg') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Vordingborg">Vordingborg</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Odense') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Odense">Odense</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i København') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i København">Københavnerskolen</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Aalborg') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Aalborg">Aalborg</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Vejle') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Vejle">Vejle</option>
           <option <?php if ($school == 'Rudolf Steiner Skolen i Skanderborg') { ?>selected<?php } ?> value="Rudolf Steiner Skolen i Skanderborg">Skanderborg</option>
        </select></p>
        <p><label>Klasse: </label><br><select <?php if (strlen($grade) < 1) { ?> required="required" <?php } ?> name="grade" id="grade">
           <option disabled selected value> -- Vælg klassetrin -- </option>
           <option <?php if ($grade == '8. Klasse') { ?>selected<?php } ?> value="8. Klasse">8. Klasse</option>
           <option <?php if ($grade == '9. Klasse') { ?>selected<?php } ?> value="9. Klasse">9. Klasse</option>
           <option <?php if ($grade == '1. VG') { ?>selected<?php } ?> value="1. VG">1. VG</option>
           <option <?php if ($grade == '2. VG') { ?>selected<?php } ?> value="2. VG">2. VG</option>
           <option <?php if ($grade == '3. VG') { ?>selected<?php } ?> value="3. VG">3. VG</option>
        </select></p>
        <p><label>Profilbillede: <br/>(Bemærk: hjemmesiden tilpasser automatisk billedet, så det passer til siden.
        Hvis du ønsker dit billede placeret anderledes, kan du selv beskære det kvadratisk, og uploade det.)</label><br><input required="required" type="file" name="fileToUpload" id="fileToUpload"/></p> <!-- put instead of required="required": <?php if (strlen($profile) < 1) { ?> required="required" <?php } ?> -->
        <!-- <?php if (strlen($profile) < 1) { ?><input name="hiddenPicture" type="hidden" value="<?=$profile?>" /><?php } ?> -->
        <p><label>Lidt om dig selv: </label><br><textarea <?php if (strlen($description) < 1) { ?> required="required" <?php } ?> name="story" rows="5" cols="64"><?=$description?></textarea></p>
        <input type="submit" name="Submit" <?php if (strlen($profile) > 0) { ?> value="Opdater" <?php } else { ?> value="Opret" <?php } ?>
value="Submit"/>
</form>
</div>
</div>

</body>

</html>
