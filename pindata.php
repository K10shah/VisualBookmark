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

		$emailstore = $_SESSION['uname'];
		$emailstore = stripslashes($emailstore);
		$emailstore = mysqli_real_escape_string($con,$emailstore);
		  $sql1 ="SELECT * FROM bookmarks WHERE username='$emailstore'";
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
				echo "<a href='addnewpin.php'><div class='pin'> <img src='addnew.png'/><p>Add new pin</p></div></a>";
			$count2=mysqli_num_rows($result);
			if($count2 > 0)
			{
				
				while($row = mysqli_fetch_array($result))
				{	
					if($row['visitcount']==0)
					{
						$disp="Times visited: 0 ";
					}
					else
					{
						$disp = "Times visited:".$row['visitcount']." ";
					}
					echo "<div class ='pin'><center><p>".$row['caption']."</p></center><a href='pinvisitcounter.php?pinid=".$row['bookmarkid']."'><img src='".$row['image']."'/></a><p><form class='delpin' style='margin-bottom:10px;'> 
					<input type='hidden' class ='which_clicked' name='which_clicked' value=".$row['bookmarkid']."><button type='submit' class='btn btn-primary' id='del' class='del' name='del'><span class='glyphicon glyphicon-trash'></span></button> &nbsp <button type='submit' class='btn btn-primary' id='edit' class='edit' name='edit' ><span class='glyphicon glyphicon-pencil'></span></button></form>
				
					".$disp."<br><a href='https://twitter.com/share' class='twitter-share-button' data-size='large' data-url='".$row['link']."' data-text='".$row['caption'].":'>Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src='widget.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script></br></p></div>";
				}
				
			}
			
echo "</div>";

		
  ?>