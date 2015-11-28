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
echo "<div id='columns'>";
				echo "<script>
				$(document).ready( function() {
  var container = $('#columns');
  $('#columns').masonry({
    columnWidth: 10,
    itemSelector: '.board',
	isOriginLeft: true
				});
				$('#del').click(function() {
console.log('clicked');
});
				
				}); </script>";
		$emailstore = $_SESSION['friendname'];
		$emailstore = stripslashes($emailstore);
		$emailstore = mysqli_real_escape_string($con,$emailstore);
		  $sql1 ="SELECT * FROM boards where owner='sys' or owner='$emailstore'";
			$result=mysqli_query($con,$sql1);
			if (!$result)
			{
    die(mysqli_error($con));
			}
			$count2=mysqli_num_rows($result);
			if($count2 > 0)
			{
				
				while($row = mysqli_fetch_array($result))
				{	
					if($row['owner']=="sys")
					{
						echo "<div class ='board'><a href='boardpinview.php?selboard=".$row['boardid']."'><img src='".$row['boardpicture']."' id='firstboard'/></a><p>".$row['boardcaption']."</p></div>";
					}
					else
					{
						echo "<div class ='board'><a href='boardpinview.php?selboard=".$row['boardid']."'><img src='".$row['boardpicture']."' id='firstboard'/></a><p>".$row['boardcaption']."</p></div>";
					}
				}
				
			}


		echo "</div>";
  ?>