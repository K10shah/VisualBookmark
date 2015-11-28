<html>
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
	die();}
?>
<head>
<style>
body{
	
background-image: url('background-imager//1282860.jpg');
}
</style>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
	$("#back-button").click(function(){
				window.location = "newuitest.php";
				
			});
	var $input = $('input:text'),
    $register = $('#upload');    
$register.attr('disabled', true);

$input.keyup(function() {
    var trigger = false;
    $input.each(function() {
        if (!$(this).val()) {
            trigger = true;
        }
    });
    trigger ? $register.attr('disabled', true) : $register.removeAttr('disabled');
});
});
function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#displayimage')
                    .attr('src', e.target.result)
                    .width("50%");
				document.getElementById("linktext").value =  e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
</head>
<body>
<div class="topnavbar">
<font color="#B517A5" size="25" face="Wolf in the City">Visual</font>
<font color="#F1B80A" size="25" face="Wolf in the City">Bookmarker: </font>
<font color="#FFF" size="25" face="Wolf in the City">Create,    Share   and   Organize   your   Ideas..</font>
<div class="back col-sm-4" style="top:18px;" id="back-button">
<button type="submit" class="btn btn-success" name="reg">Home</button>
</div>
</div>
<center>
<div class="addcontent">
<br><center><div class="addpinform image-rounded"><font size="5"><b>Create a pin :</b> </font><br>
<img id="displayimage"><br><br>
<form id="Upload" action="addnewpin.php" enctype="multipart/form-data" method="post" name="uploadpin">

 <input type="file" id="pinimage" name="pinimage" class="btn btn-success" accept="image/gif, image/jpeg, image/png"  onchange="readURL(this);" /> 

 <br>
 <br>
 <b>Caption : </b><input type="text" class="form-control" id="captionpin" class="pincaption" name="pincaption">
 <br>
 
 <b>Link : </b><input type="text" class="form-control" id="pinlink" class="pinlink" name="pinlink">
 <br>
	
 <br><input type="submit" class ="btn btn-success" id="upload" value="Upload" name="Upload"/>
 <input type="hidden" id="linktext" value="" name="linktext">
</form>
</div></center>
</div>
</center>
<?php
$emailstore = $_SESSION['uname'];
		$emailstore = stripslashes($emailstore);
		$emailstore = mysqli_real_escape_string($con,$emailstore);
if(isset($_POST['Upload']))
{
	$photo = $_POST['linktext'];
	$caption = $_POST['pincaption'];
	$link = $_POST['pinlink'];
	echo $photo,$caption,$link;
	$sql = "insert into bookmarks(username,link,image,caption) values('$emailstore','$link','$photo','$caption')";
	$result=mysqli_query($con,$sql);
if (!$result)
	{
		die(mysqli_error($con));
	}
	echo "<script> alert('Successfully added a pin'); </script>"; 	
}		
?>
</body>
</html>