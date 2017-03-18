<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<style>
footer {width:100%;}
</style>

<!-- Facebook like-button start -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/da_DK/sdk.js#xfbml=1&version=v2.5&appId=309970117706";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<!-- Facebook like-button end -->

<!-- mobile detect -->

<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<link href="Stylesheets/main.css" rel="stylesheet" type="text/css" />
<title>Overskolestævnet</title>

</head>

<body>


<div id="topholder">
<div id="mainTitle" class="topboxes">
<h1>OVERSKOLESTÆVNET</h1>
</div>

<!-- top start -->
<div id="navbarholder" class="topboxes">
<ul id="navbar">
   <li><a href="index.html">Home</a></li>
   <li><a href="Aaretsstaevne.html">Årets stævne</a></li>
   <li><a href="Repser.php">Repræsentanterne</a></li>
   <li><a href="Kontakt.html">Kontakt</a></li>
   <li><a href="Tak.html">Tak til</a></li>
</ul>
</div>
<hr></hr>
</div>
<!-- top end -->

<div id="compensation"></div>
<div id="maincontent">
<div id="spacing1"></div>

<h1>Årets repræsentanter</h1>
<div id="repslist">
<hr></hr>

<?php
require 'connect.php';

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM Repser ORDER BY name ASC") or die ($db->error);

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
?>

<a class="boxes" href="#openModal<?=$id?>" 
<?php
if (strlen($profile) < 1) {
?>
style="display:none"
<?php
}
?>
>
<div id="<?=$id?>" class="repser">
<img class="circular" src="Images/profile/<?=$profile?>" width="125" height="125">
<h><?=$name?></h>
<p><?=$title?></p>
</div>
</a>

<div id="openModal<?=$id?>" class="modalDialog">
    <div>	<a href="#close" title="Close" class="close">X</a>
            
            <img class="circular" src="Images/profile/<?=$profile?>" width="125" height="125">

        	<h2><?=$name?></h2>

        <p class="title"><b><?=$title?></b></p>
        <p class="information"><b>Skole: </b><?=$school?></p>
        <p class="information"><b>Klassetrin: </b><?=$grade?></p>
        <p class="information"><b>Email: </b><?=$email?></p>
<?php
if ($hidephone < 1) {
?>
        <p class="information"><b>Tlf.: </b><?=$phone?></p>
<?php
} else {
?>
        <br/>
<?php
}
?>
        <br/>
        <p class="story"><i><?=$description?></i></p>
    </div>
</div>

<?php } ?>

</div>
</div>
<div id="Clear"></div>
</body>
<footer>
<hr id="bottomLine">
<div id="columns">
<div id="column1" class="columns">
<h class="footerH"><b>mere</b></h><p>Galleri<br>Sponsorer<br>Support<br>Billet<br>Nyhedsbrev</p></div>
<div id="column2" class="columns">
<h class="footerH"><b>Kolonne2</b></h><p>List1<br>List2<br>List3<br>List4<br>List</p></div>
<div id="column3" class="columns">
<h class="footerH"><b>Følg os</b></h>
<br>
<div id="ig"> 
<style>.ig-b- { display: inline-block; }
.ig-b- img { visibility: hidden; }
.ig-b-:hover { background-position: 0 -60px; } .ig-b-:active { background-position: 0 -120px; }
.ig-b-32 { width: 32px; height: 32px; background: url(//badges.instagram.com/static/images/ig-badge-sprite-32.png) no-repeat 0 0; }
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
.ig-b-32 { background-image: url(//badges.instagram.com/static/images/ig-badge-sprite-32@2x.png); background-size: 60px 178px; } }</style>
<a href="https://www.instagram.com/oss_2016/?ref=badge" class="ig-b- ig-b-32"><img src="//badges.instagram.com/static/images/ig-badge-32.png" alt="Instagram" /></a><br>
</div>

<div id="fb">
<style>.fb-b- { display: inline-block; margin-top:3px;}
.fb-b- img { visibility: hidden; }
.fb-b-:hover { background:url(Images/png/Light.png) no-repeat; } .fb-b-:active { background:url(Images/png/Dark.png) no-repeat; }
.fb-b-32 { width: 32px; height: 32px; background: url(Images/png/FB-f-Logo__blue_29.png) no-repeat 0 0; }
@media only screen and (-webkit-min-device-pixel-ratio: 2), only screen and (min--moz-device-pixel-ratio: 2), only screen and (-o-min-device-pixel-ratio: 2 / 1), only screen and (min-device-pixel-ratio: 2), only screen and (min-resolution: 192dpi), only screen and (min-resolution: 2dppx) {
.fb-b-32 { background-image: url(Images/png/Facebook.png); background-size: 60px 178px; } }</style>
<a href="https://www.facebook.com/overskolestaevnet/" class="fb-b- fb-b-32"><img src="Images/png/FB-f-Logo__blue_29.png" alt="Facebook" /></a>
</div>
</div>
</div>

<p id="adress">Overskolestævnet<br>Lindvedvej 64<br>Odense 5260</p>

<div class="fb-like"
data-href="https://www.facebook.com/overskolestaevnet"
data-layout="standard"
data-action="like"
data-show-faces="true"
data-share="true"
data-colorscheme="dark""></div>

<a id="mail" href="mailto:info@overskolestaevnet.dk">info@overskolestaevnet.dk</a>
<p id="copyright">Copyright © 2016 Oliver Milan M. Nielsen.</p>
</footer>

</html>
