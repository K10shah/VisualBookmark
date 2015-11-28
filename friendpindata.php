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

		$emailstore = $_SESSION['friendname'];
		$emailstore = stripslashes($emailstore);
		$emailstore = mysqli_real_escape_string($con,$emailstore);
		  $sql1 ="SELECT * FROM bookmarks WHERE username='$emailstore' and public='y'";
			$result=mysqli_query($con,$sql1);
			if (!$result)
			{
				die(mysqli_error($con));
			}
			echo "<div id='columns'>";
				echo "<script>
				$(document).ready( function() {
  var container = $('#columns');
  $('#columns').masonry({
    columnWidth: 10,
    itemSelector: '.pin',
	isOriginLeft: true
				});
				$('#del').click(function() {
console.log('clicked');
});
				
				}); </script>";
			$count2=mysqli_num_rows($result);
			if($count2 > 0)
			{
				
				while($row = mysqli_fetch_array($result))
				{	
					if($row['visitcount']==0)
					{
						$disp="";
					}
					else
					{
						$disp = "Times visited:".$row['visitcount']." ";
					}
					$sql4 = "select * from pinlike where likedby='".$_SESSION['friendname']."' and pinid =".$row['bookmarkid'];
					$result4=mysqli_query($con,$sql4);
					if (!$result4)
					{
						die(mysqli_error($con));
					}
					$count3=mysqli_num_rows($result4);
					if($count3>0)
					{
						echo "<div class ='pin'><p>".$row['caption']."</p><a href='pinvisitcounter.php?pinid=".$row['bookmarkid']."'><img src='".$row['image']."'/></a><b><font color='000'>Liked</font></b><br><br><p>".$disp."</p></div>";
					}
					else
					{
						echo "<div class ='pin'><p>".$row['caption']."</p><a href='pinvisitcounter.php?pinid=".$row['bookmarkid']."'><img src='".$row['image']."'/></a><p><form class='delpin'> 
						<input type='hidden' class ='which_clicked' name='which_clicked' value=".$row['bookmarkid']."><input type='hidden' name='friendname' value='".$_SESSION['friendname']."'> <input type='submit' class='btn btn-primary' id='del' class='del' name='like' value='Like'></form>".$disp."</p></div>";
					}
				}
				
			}
			
echo "</div>";

		
  ?>