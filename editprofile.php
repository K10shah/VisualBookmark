<?php
	session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(!isset($_SESSION['name'])){
	header("Location: login.php");
	exit();
	die();
}?>
<html>
<head>
<style> 
#mydiv{
	position:absolute;
    border: 2px solid #fff; 
    resize: both;
    overflow: auto;
	top:10%;
	left:5%;
}
body{
	
background-image: url('background-imager//Elegant_Background-9.jpg');
}	 
</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<link rel="stylesheet" href="jquery-ui-1.11.4.custom/jquery-ui.css">
<script>
$(document).ready(function(){
	var src1 = document.getElementById("prof-image").src;
				document.getElementById("linktext").value = src1 ;
	$("#back-button").click(function(){
				window.location = "newuitest.php";
				
			});
			$("#mydiv").draggable({
  containment: "#prof-image"
  });
	$("#mydiv").css({'width':'100',
    'height': '100'});
	
	setInterval(function(){ 
	var divheight = $("#mydiv").height();
	var divwidth = $("#mydiv").width();
	var divtop = $("#mydiv").offset().top;
	var divleft  = $("#mydiv").offset().left;
	var imgheight = $("#prof-image").height();
	var imgwidth = $("#prof-image").width();
	var imgtop = $("#prof-image").offset().top;
	var imgleft  = $("#prof-image").offset().left;
	document.getElementById("txt1").value = divtop - imgtop;
	document.getElementById("txt2").value = divheight;
	document.getElementById("txt3").value = divleft - imgleft;
	document.getElementById("txt4").value = divwidth;
	var src1 = document.getElementById("prof-image").src;
				document.getElementById("imgstring").value = src1 ;
	if(((divleft+divwidth) > (imgleft+imgwidth)) || ((divheight+divtop)>( imgtop + imgheight)))
	{
		$("#mydiv").css({'width':'100px',
    'height': '100px'});
	}
	}, 500);
});
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#prof-image')
                    .attr('src', e.target.result);
				document.getElementById("linktext").value =  e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
</head>
<body>
<div class="topnavbar"><div class="col-sm-3"><font color="#FFF" size="10" face="Impact">Visual Bookmark</font></div>
<div class="back col-sm-2" style="top:18px;" id="back-button">
<button type="submit" class="btn btn-success" name="reg">Home</button>
</div>

<div class="top-menu-form" style="top:15px;">
			 <div class = "col-sm-1"><font size="6">
     <a class="logout" href="logout.php">Logout</a> </font>
	</div><form name="" action="findusers.php" method="get">
	<div class="col-sm-4">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Username" name="friendname">
    </div>
	<div class = "col-sm-4">
	
	<button type="submit" class="btn btn-success" name="reg">Search a user</button>
	</div>
	</form></div>
</div>
<div class="secondnavbar">
<div class="appearing-name-photo">
<img src="<?php 
$profileid = $_SESSION['uid'];
$sql = "select * from profile where profileid = '$profileid'";

$result=mysqli_query($con,$sql);
if(!$result)
	{
		die(mysqli_error($con));
	}
$count=mysqli_num_rows($result);
if($count == 1)	
{
	$row = mysqli_fetch_array($result);
if(isset($_POST['linktext']))
{
	echo $_POST['linktext'];
}
else
{
	echo $row['profilephoto'];
}
}
else
{
	echo "facebook_blank_face3.jpeg";
}
?>" width="40px" height="40px" class="img-rounded"/> &nbsp <font size="5" color="#000"> <?php echo $_SESSION['uname'];?></font>
</div>
</div>
<div class = "profile-content">
<?php
$profileid = $_SESSION['uid'];
$sql = "select * from profile where profileid = '$profileid'";

$result=mysqli_query($con,$sql);
if(!$result)
	{
		die(mysqli_error($con));
	}
$count=mysqli_num_rows($result);
if($count == 1)	
{
	$row = mysqli_fetch_array($result);
	echo "<div class='profile-image'>";
if ($row['profilephoto'] == NULL)
{
	echo "<img id='prof-image' src='facebook_blank_face3.jpeg'>";
}
else if(isset($_POST['linktext']))
{
	echo "<img id='prof-image' src='".$_POST['linktext']."'>";
}
else
{
	echo "<img id='prof-image' src='".$row['profilephoto']."'>";
}
echo"<div id='mydiv' ></img></div></div>";
}
echo "<div class = 'edit-profile-submit'><form id='edit-prof-submit' action='editprofile.php' enctype='multipart/form-data' method='post' name='edit-prof-submit'>
<input type='file' id='profileimagebutton' name='profileimagebutton'class='btn btn-success' accept='image/gif, image/jpeg, image/png'  onchange='readURL(this);' /> 
<br><br>
";
if($row['interests']<>NULL)
{
	$interestsval = $row['description'];
}
else
	$interestsval="";
if($row['description']<>NULL)
{
	$descriptionval = $row['description'];
}
else
	$descriptionval="";


echo " <b><font color='#fff'>Description : </b><input type='text' value= '$descriptionval' class='form-control col-md-6' id='descr' class='descr' name='descr'>
 <br>
 
 <b>Interests: </font></b><input type='text' value= '$interestsval' class='form-control col-md-6' id='inters' class='inters' name='inters'>
 <br>
	
 <br><br><br>
<input type = 'hidden' name='t t1' id='txt1'>
<input type = 'hidden' name='txt2' id='txt2'>
<input type = 'hidden' name='txt3' id='txt3'>
<input type = 'hidden' name='txt4' id='txt4'>
<input type='hidden' name='imgstring' id='imgstring' value=''>
<input type='submit'  class ='btn btn-success' value='Crop' name='ourbtn'>
<input type='submit' class ='btn btn-success' id='upload' value='Save' name='Upload'/>
<input type='hidden' id='linktext' value='' name='linktext'></form> </div>";
 
 
if(isset($_POST['Upload']))
{
 $desc = $_POST['descr'];
 $intr = $_POST['inters'];
 $primg = $_POST['linktext'];
 
 $sql = "update profile SET profilephoto='$primg',description='$desc',interests='$intr'  where profileid='$profileid'";
 $result=mysqli_query($con,$sql);
if(!$result)
	{
		die(mysqli_error($con));
	}
echo "<script> alert('Successfully updated new content ');</script?";	
}
else if(isset($_POST['ourbtn']))
{
$imgstring = $_POST['imgstring'];
$x1 = $_POST['txt3'];
$x2 = $_POST['txt4'];
$y1 = $_POST['txt1'];
$y2 = $_POST['txt2'];

if(($pos = strpos($imgstring, ',')) !== false)
{
   $newimgstring = substr($imgstring, $pos + 1);
   //echo $imgstring;
}
$data = base64_decode($newimgstring);

$im = imagecreatefromstring($data);
$actualwidth = imagesx($im);
$actualheight = imagesy($im);
$x1 = $actualwidth/553 * $x1;
$x2 = $actualwidth/553 * $x2;
$y1 = $actualheight/553 * $y1;
$y2 = $actualheight/553 * $y2;
if ($im !== false) {
    // ob_start();
    // imagepng($im);
	// $contents =  ob_get_contents();
// ob_end_clean();
$to_crop_array = array('x' =>$x1 , 'y' => $y1, 'width' => $x2, 'height'=> $y2);

$thumb_im = imagecrop($im, $to_crop_array);
ob_start();
imagejpeg($thumb_im);
$contents =  ob_get_contents();
ob_end_clean();
$sql = "update profile SET profilephoto='data:image/jpeg;base64,".base64_encode($contents)."' where profileid='$profileid'";
	 $result=mysqli_query($con,$sql);
	 echo "<script>
document.getElementById('prof-image').src = 'data:image/jpeg;base64,".base64_encode($contents)."';

	 </script>";
	if(!$result)
		{
			die(mysqli_error($con));
		}
}
}
 
?>
</div>
</body>
</html>