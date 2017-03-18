<?php
require 'connect.php';

$id = $_POST['id'];

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM adminjobs WHERE id = '$id'") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$id = $row['id'];
$type = $row['type'];
$sender = $row['sender'];
$email = $row['email'];
}


if ($type == 'passrecon') {

$EmailFrom = "web-admin@overskolestaevnet.dk";
$EmailTo = Trim(stripslashes($email));
$Subject = "Glemt password til Repræsentant-intra";

// validation
$validationOK=true;
if (!$validationOK) {
  echo "Der skete en fejl!";
  exit;
}

$db->set_charset("utf8");
$result = $db->query("SELECT * FROM Repser WHERE username = '$sender'") or die ($db->error);

while($row = mysqli_fetch_array($result))
            {

$name = $row['name'];
$password = $row['pass'];
}


// prepare email body text
$Body = "Hej ";
$Body .= strtok($name, " ");
$Body .= "\n";
$Body .= "Det ser ud til at du har bedt om at få dit password sendt til denne mail. Din anmodning er nu blevet godkendt. Koden er: ";
$Body .= $password;
$Body .= "\n";
$Body .= "\n";
$Body .= "Har du modtaget denne mail ved en fejl, eller har du ikke bedt om at få genskabt dit password, bedes du kontakte os på denne mail ";
$Body .= $EmailFrom;
$Body .= "\n";
$Body .= "Venlig hilsen";
$Body .= "\n";
$Body .= "Admin";

// send email 
$success = mail($EmailTo, $Subject, $Body, "From: <$EmailFrom>");

// redirect to success page 
if ($success){

}
else{
  echo 'Der skete en fejl!';
  exit;
}
}

$sql = "DELETE FROM adminjobs WHERE id = '$id'";

if ($db->query($sql) === TRUE) {
    $firstName = strtok($name, ' ');
    echo "<div style='background-color: #b7ffbb;' class='jobs' id='<?=$id?>' >
    <p>Opgaven er løst. <b> $firstName </b> har nu modtaget sit password på email <b>$EmailTo</b>.</p>
    <hr/>
</div>";
} else {
    echo "Error deleting record: " . $db->error;
}

$db->close();

?>