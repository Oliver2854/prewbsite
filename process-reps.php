<?php
session_start();
$checknum = 1123581321;
if ($_SESSION['login_check'] != $checknum) {
header("Location: index.php");
ob_start();
}
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>Updating...</title>
</head>

<body>
<?php
// ImageManipulator.php
class ImageManipulator
{
    /**
     * @var int
     */
    protected $width;

    /**
     * @var int
     */
    protected $height;

    /**
     * @var resource
     */
    protected $image;

    /**
     * Image manipulator constructor
     * 
     * @param string $file OPTIONAL Path to image file or image data as string
     * @return void
     */
    public function __construct($file = null)
    {
        if (null !== $file) {
            if (is_file($file)) {
                $this->setImageFile($file);
            } else {
                $this->setImageString($file);
            }
        }
    }

    /**
     * Set image resource from file
     * 
     * @param string $file Path to image file
     * @return ImageManipulator for a fluent interface
     * @throws InvalidArgumentException
     */
    public function setImageFile($file)
    {
        if (!(is_readable($file) && is_file($file))) {
            throw new InvalidArgumentException("Image file $file is not readable");
        }

        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }

        list ($this->width, $this->height, $type) = getimagesize($file);

        switch ($type) {
            case IMAGETYPE_GIF  :
                $this->image = imagecreatefromgif($file);
                break;
            case IMAGETYPE_JPEG :
                $this->image = imagecreatefromjpeg($file);
                break;
            case IMAGETYPE_PNG  :
                $this->image = imagecreatefrompng($file);
                break;
            default             :
                throw new InvalidArgumentException("Image type $type not supported");
        }

        return $this;
    }
    
    /**
     * Set image resource from string data
     * 
     * @param string $data
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function setImageString($data)
    {
        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }

        if (!$this->image = imagecreatefromstring($data)) {
            throw new RuntimeException('Cannot create image from data string');
        }
        $this->width = imagesx($this->image);
        $this->height = imagesy($this->image);
        return $this;
    }

    /**
     * Resamples the current image
     *
     * @param int  $width                New width
     * @param int  $height               New height
     * @param bool $constrainProportions Constrain current image proportions when resizing
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function resample($width, $height, $constrainProportions = true)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        if ($constrainProportions) {
            if ($this->height >= $this->width) {
                $width  = round($height / $this->height * $this->width);
            } else {
                $height = round($width / $this->width * $this->height);
            }
        }
        $temp = imagecreatetruecolor($width, $height);
        imagecopyresampled($temp, $this->image, 0, 0, 0, 0, $width, $height, $this->width, $this->height);
        return $this->_replace($temp);
    }
    
    /**
     * Enlarge canvas
     * 
     * @param int   $width  Canvas width
     * @param int   $height Canvas height
     * @param array $rgb    RGB colour values
     * @param int   $xpos   X-Position of image in new canvas, null for centre
     * @param int   $ypos   Y-Position of image in new canvas, null for centre
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function enlargeCanvas($width, $height, array $rgb = array(), $xpos = null, $ypos = null)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        
        $width = max($width, $this->width);
        $height = max($height, $this->height);
        
        $temp = imagecreatetruecolor($width, $height);
        if (count($rgb) == 3) {
            $bg = imagecolorallocate($temp, $rgb[0], $rgb[1], $rgb[2]);
            imagefill($temp, 0, 0, $bg);
        }
        
        if (null === $xpos) {
            $xpos = round(($width - $this->width) / 2);
        }
        if (null === $ypos) {
            $ypos = round(($height - $this->height) / 2);
        }
        
        imagecopy($temp, $this->image, (int) $xpos, (int) $ypos, 0, 0, $this->width, $this->height);
        return $this->_replace($temp);
    }
    
    /**
     * Crop image
     * 
     * @param int|array $x1 Top left x-coordinate of crop box or array of coordinates
     * @param int       $y1 Top left y-coordinate of crop box
     * @param int       $x2 Bottom right x-coordinate of crop box
     * @param int       $y2 Bottom right y-coordinate of crop box
     * @return ImageManipulator for a fluent interface
     * @throws RuntimeException
     */
    public function crop($x1, $y1 = 0, $x2 = 0, $y2 = 0)
    {
        if (!is_resource($this->image)) {
            throw new RuntimeException('No image set');
        }
        if (is_array($x1) && 4 == count($x1)) {
            list($x1, $y1, $x2, $y2) = $x1;
        }
        
        $x1 = max($x1, 0);
        $y1 = max($y1, 0);
        
        $x2 = min($x2, $this->width);
        $y2 = min($y2, $this->height);
        
        $width = $x2 - $x1;
        $height = $y2 - $y1;
        
        $temp = imagecreatetruecolor($width, $height);
        imagecopy($temp, $this->image, 0, 0, $x1, $y1, $width, $height);
        
        return $this->_replace($temp);
    }
    
    /**
     * Replace current image resource with a new one
     * 
     * @param resource $res New image resource
     * @return ImageManipulator for a fluent interface
     * @throws UnexpectedValueException
     */
    protected function _replace($res)
    {
        if (!is_resource($res)) {
            throw new UnexpectedValueException('Invalid resource');
        }
        if (is_resource($this->image)) {
            imagedestroy($this->image);
        }
        $this->image = $res;
        $this->width = imagesx($res);
        $this->height = imagesy($res);
        return $this;
    }
    
    /**
     * Save current image to file
     * 
     * @param string $fileName
     * @return void
     * @throws RuntimeException
     */
    public function save($fileName, $type = IMAGETYPE_JPEG)
    {
        $dir = dirname($fileName);
        if (!is_dir($dir)) {
            if (!mkdir($dir, 0755, true)) {
                throw new RuntimeException('Error creating directory ' . $dir);
            }
        }
        
        try {
            switch ($type) {
                case IMAGETYPE_GIF  :
                    if (!imagegif($this->image, $fileName)) {
                        throw new RuntimeException;
                    }
                    break;
                case IMAGETYPE_PNG  :
                    if (!imagepng($this->image, $fileName)) {
                        throw new RuntimeException;
                    }
                    break;
                case IMAGETYPE_JPEG :
                default             :
                    if (!imagejpeg($this->image, $fileName, 95)) {
                        throw new RuntimeException;
                    }
            }
        } catch (Exception $ex) {
            throw new RuntimeException('Error saving image file to ' . $fileName);
        }
    }

    /**
     * Returns the GD image resource
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->image;
    }

    /**
     * Get current image resource width
     *
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Get current image height
     *
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }
}
// ImageManipulator.php over
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
$name = mysqli_real_escape_string($link, $_POST['name']);
$title = mysqli_real_escape_string($link, $_POST['title']);
$email = mysqli_real_escape_string($link, $_POST['email']);
$phone = mysqli_real_escape_string($link, $_POST['phone']);
$hidephone = mysqli_real_escape_string($link, $_POST['hidephone']);
$school = mysqli_real_escape_string($link, $_POST['school']);
$grade = mysqli_real_escape_string($link, $_POST['grade']);
$story = mysqli_real_escape_string($link, $_POST['story']);
$image = mysqli_real_escape_string($link, $_FILES['fileToUpload']['name']);

if (strlen($image) < 1) { 
//$_SESSION['img_empt'] = yes;  Disabled because of required="required" in profile.php
$URL="http://intra.overskolestaevnet.dk/profile.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
} 

/*
$opt1 = mysqli_real_escape_string($link, $_FILES['fileToUpload']['name']);
$opt2 = mysqli_real_escape_string($link, $_POST['hiddenPicture']);

if (strlen($opt1) < 1 && strlen($opt2) > 1) {
$image = $opt2;
} else if (strlen($opt1) > 1 && strlen($opt2) < 1) {
   $image = $opt1;
}
*/

// attempt insert query execution
if (strlen($image) < 1) {
$sql = "UPDATE Repser SET name = '$name', title = '$title', email = '$email', phone = '$phone', hidephone = '$hidephone', school = '$school', grade = '$grade', description = '$story' WHERE id = '$id'";
} else  {
$sql = "UPDATE Repser SET name = '$name', title = '$title', email = '$email', phone = '$phone', hidephone = '$hidephone', school = '$school', grade = '$grade', description = '$story', pb = '$image' WHERE id = '$id'";
}
if(mysqli_query($link, $sql)){
     echo "Updating...";
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
    echo "Der er sket en fejl. Kontakt Oliver og copy/paste det ovenstående.";
}

// close connection
mysqli_close($link);

if ($_FILES['fileToUpload']['error'] > 0) {
	echo "Error: " . $_FILES['fileToUpload']['error'] . "<br />";
} else {
	// array of valid extensions
	$validExtensions = array('.jpg', '.jpeg', '.gif', '.png');
	// get extension of the uploaded file
	$fileExtension = strrchr($_FILES['fileToUpload']['name'], ".");
	// check if file Extension is on the list of allowed ones
	if (in_array($fileExtension, $validExtensions)) {
		$manipulator = new ImageManipulator($_FILES['fileToUpload']['tmp_name']);
		$width 	= $manipulator->getWidth();
		$height = $manipulator->getHeight();
		if ($width == $height) {
		$manipulator->save('/customers/1/7/e/overskolestaevnet.dk/httpd.www/Images/profile/' . $_FILES['fileToUpload']['name']);
		}else if ($width > $height) {
		$centreX = round($width / 2);
		$centreY = round($height / 2);
		
		$x1 = $centreX - $centreY;
		$y1 = $centreY - $centreY;

		$x2 = $centreX + $centreY;
		$y2 = $centreY + $centreY;

		$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
		// saving file to uploads folder
		$manipulator->save('/customers/1/7/e/overskolestaevnet.dk/httpd.www/Images/profile/' . $_FILES['fileToUpload']['name']);
		// echo 'Done ...';
		}else if ($width < $height) {
		$centreX = round($width / 2);
		$centreY = round($height / 2);
		
		$x1 = $centreX - $centreX;
		$y1 = $centreY - $centreX;

		$x2 = $centreX + $centreX;
		$y2 = $centreY + $centreX;

		$newImage = $manipulator->crop($x1, $y1, $x2, $y2);
		// saving file to uploads folder
		$manipulator->save('/customers/1/7/e/overskolestaevnet.dk/httpd.www/Images/profile/' . $_FILES['fileToUpload']['name']);
		echo 'Done ...';
		}
	} else {
		echo 'You must upload an image...';
	}
}

$URL="http://intra.overskolestaevnet.dk/profile.php";
echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";

/*
   if(isset($_FILES['image'])){
      $errors= array();
      $file_name = $_FILES['image']['name'];
      $file_size =$_FILES['image']['size'];
      $file_tmp =$_FILES['image']['tmp_name'];
      $file_type=$_FILES['image']['type'];
      $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
      
      $expensions= array("jpeg","jpg","png");
      
      if(in_array($file_ext,$expensions)=== false){
         $errors[]="extension not allowed, please choose a JPEG or PNG file.";
      }
      
      if($file_size > 2097152){
         $errors[]='File size must be excately 2 MB';
      }
      
      if(empty($errors)==true){
         move_uploaded_file($file_tmp,"/customers/1/7/e/overskolestaevnet.dk/httpd.www/Images/profile/".$file_name);
         echo "Success";
      }else{
         print_r($errors);
      }
   }

*/


/* photo upload

$target_dir = "/uploads/";
$target_file = $target_dir . basename($_FILES["photo"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["photo"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["photo"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["photo"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
*/
?>
</body>
</html>
