<?php
	session_start();
		$con = mysqli_connect("localhost","root","");
		if (!$con)
		{
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"visbookmark");
	if(!isset($_SESSION['name'])){
	header("Location: popuplogin.php");
	exit();
	die();
}?>
<html>
<head>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="mycss.css" rel="stylesheet">
<script src="jquery-1.11.2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</head>
<body id="boddyy">
<b>CVisual Bookmarker : </b>
	<br>
		<?php 
		$text = $_POST["text"];
		$image = $_POST["image"];?>
	<br>
	<br>
<img width=70% src="<?php echo $image;?>" style="border-bottom: 1px solid #ccc;"/>
<br>
<br>

<form action="success.php" method="post" name="imagestore">
<div class="col-sm-6">
<input type ="text" name="captiontext" class="form-control" placeholder="Enter your caption here"><br>
<input type ="text" name="categorytext" class="form-control" placeholder="Enter a new category if you wish to create"><br>
</div><br><br>
<?php
$sportskeywords = array("sports","cricket","football","fifa","hockey","scores","game","basketball","nba","espn","starsports","fixtures","racing","ferrari");
$codekeywords=array("code","javascript","scripting","stackoverflow","programming","php","java","c++","python","coding","function","method","msdn","Java","filereader","filewriter","string","codesport","w3schools","css","css3","object-oriented","json","PHP");
$shoppingkeywords = array("shopping","online","jabong","myntra","snapdeal","amazon","ebay","clothing","shoes","buy","sell","sale","buying","store","shop","brands","discount");
$foodkeywords = array("cookery","cook","food","recipe","cooking","dishes","delicacy","cuisine","multi-cuisine","menu","ingredient","ingredients","lunch","dinner","chef","recipes","foodie","restaurant","cocktail","ice-cream");

$link = $text;

$keywords ="";
$description = "";
$ch = curl_init();  // Initialising cURL
curl_setopt($ch, CURLOPT_URL, $link);    // Setting cURL's URL option with the $url variable passed into the function
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
$data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
curl_close($ch); 

$doc = new DOMDocument();
@$doc->loadHTML($data);
$nodes = $doc->getElementsByTagName('title');

if($nodes->item(0)<>null)
{
//get and display what you need:
$title = $nodes->item(0)->nodeValue;
}
else
	$title="";


$metas = $doc->getElementsByTagName('meta');

$nodeList = $doc->getElementsByTagName('script');
for ($nodeIdx = $nodeList->length; --$nodeIdx >= 0; ) {
$node = $nodeList->item($nodeIdx);
$node->parentNode->removeChild($node);
}
$data = $doc->saveHtml();


for ($i = 0; $i < $metas->length; $i++)
{
$meta = $metas->item($i);
if($meta->getAttribute('name') == 'description')
    $description = $meta->getAttribute('content');
if($meta->getAttribute('name') == 'keywords')
    $keywords = $meta->getAttribute('content');

}
$keywords = strtolower($keywords);
$title = strtolower($title);
$description = strtolower($description);
$data = strtolower($data);

//calculating sports score
$sportlength = count($sportskeywords);
$i=0;
$sportscore=0;
while ($i<$sportlength)
{
	$temp = substr_count($title,$sportskeywords[$i]);
	$sportscore = $sportscore + $temp*8;
	$temp=0;
	$temp = substr_count($keywords,$sportskeywords[$i]);
	$sportscore = $sportscore + $temp*4;
	$temp=0;
	$temp = substr_count($description,$sportskeywords[$i]);
	$sportscore = $sportscore + $temp*2;
	$temp=0;
	$temp = substr_count($data,$sportskeywords[$i]);
	$sportscore = $sportscore + $temp*1;
	$i = $i + 1;
}

//calculating food score
$foodlength = count($foodkeywords);
$i=0;
$foodscore=0;
while ($i<$foodlength)
{
	$temp = substr_count($title,$foodkeywords[$i]);
	$foodscore = $foodscore + $temp*8;
	$temp=0;
	$temp = substr_count($keywords,$foodkeywords[$i]);
	$foodscore = $foodscore + $temp*4;
	$temp=0;
	$temp = substr_count($description,$foodkeywords[$i]);
	$foodscore = $foodscore + $temp*2;
	$temp=0;
	$temp = substr_count($data,$foodkeywords[$i]);
	$foodscore = $foodscore + $temp*1;
	$i = $i + 1;
}



//calculating code score
$codelength = count($codekeywords);
$i=0;
$codescore=0;
while ($i<$codelength)
{
	$temp = substr_count($title,$codekeywords[$i]);
	$codescore = $codescore + $temp*8;
	$temp=0;
	$temp = substr_count($keywords,$codekeywords[$i]);
	$codescore = $codescore + $temp*4;
	$temp=0;
	$temp = substr_count($description,$codekeywords[$i]);
	$codescore = $codescore + $temp*2;
	$temp=0;
	$temp = substr_count($data,$codekeywords[$i]);
	$codescore = $codescore + $temp*1;
	$i = $i + 1;
}



//calculating shopping score
$shoppinglength = count($shoppingkeywords);
$i=0;
$shoppingscore=0;
while ($i<$shoppinglength)
{
	$temp = substr_count($title,$shoppingkeywords[$i]);
	$shoppingscore = $shoppingscore + $temp*8;
	$temp=0;
	$temp = substr_count($keywords,$shoppingkeywords[$i]);
	$shoppingscore = $shoppingscore + $temp*4;
	$temp=0;
	$temp = substr_count($description,$shoppingkeywords[$i]);
	$shoppingscore = $shoppingscore + $temp*2;
	$temp=0;
	$temp = substr_count($data,$shoppingkeywords[$i]);
	$shoppingscore = $shoppingscore + $temp*1;
	$i = $i + 1;
}

$defaultcategory = "";
if($shoppingscore ==0 && $foodscore==0 && $codescore==0 && $sportscore==0)
{
	$defaultcategory = "none";
}
else if($sportscore > $foodscore && $sportscore > $codescore && $sportscore > $shoppingscore)
{
	$defaultcategory = "Sports";
}
else if ($foodscore > $codescore && $foodscore > $shoppingscore && $foodscore > $sportscore)
{
	$defaultcategory = "Food";
}
else if( $codescore> $foodscore && $codescore>$shoppingscore && $codescore>$sportscore)
{
	$defaultcategory = "Code";
}
else if( $shoppingscore >$foodscore &&  $shoppingscore > $codescore && $shoppingscore > $sportscore)
{
	$defaultcategory = "Shopping";
}

echo "<br><b><div class='col-sm-12'>
 Default category : ".$defaultcategory."</b></br></br></div>";
 
 
echo "<div class='form-group col-sm-6'>
  <label for='sel1'>Select from categories you have created :</label>
  <select class='form-control' id='sel1' name='selcategory'>
    <option>none</option>";
$emailstore = $_SESSION['uname'];
$emailstore = stripslashes($emailstore);
$emailstore = mysqli_real_escape_string($con,$emailstore);
$sql5 = "select * from boards where owner = '$emailstore'";
$result5 = mysqli_query($con,$sql5);
	if (!$result5)
	{
		die(mysqli_error($con));
	}
$count5 = mysqli_num_rows($result5);
	if($count5>0)
	{
		while($row = mysqli_fetch_array($result5))
		{
			echo "<option>".$row['boardcaption']."</option>";
		}
		echo"</select></div><br><br>";
	}
if(isset($_POST['store']))
{
	if(isset($_POST['pub1']) && $_POST['pub1'] =="yes")
		$pub='y';
	else
		$pub = 'n';
	$caption = $_POST['captiontext'];
	$sql2="insert into bookmarks(username,link,image,caption,public) values('$emailstore','$text','$image','$caption','$pub')";
	$result2=mysqli_query($con,$sql2);
	if (!$result2)
	{
		die(mysqli_error($con));
	}
	echo "<div class=' col-sm-12 alert alert-success' id='validdata' role='alert'><font color='green'> You have successfully bookmarked this link </font></div> ";
		
	$sql3 = "select * from bookmarks where username='$emailstore' and link='$text'";
	$result3=mysqli_query($con,$sql3);
	if (!$result3)
	{
		die(mysqli_error($con));
	}
	$count3 = mysqli_num_rows($result3);
	if($count3>0)
	{
		while($row = mysqli_fetch_array($result3))
		{
			$pinid = $row['bookmarkid'];
		}
	}

if($defaultcategory <> "none")
{
	if($defaultcategory == "Sports")
	{
		$selectboardid = 2;
	}
	else if($defaultcategory == "Food")
	{
		$selectboardid = 1;
	}
	else if($defaultcategory == "Code")
	{
		$selectboardid = 3;
	}
	else if($defaultcategory == "Shopping")
	{
		$selectboardid = 4;
	}
	$sql4 = "insert into pinreference(bid,pinid) values('$selectboardid','$pinid')";
	$result4 = mysqli_query($con,$sql4);
	if (!$result4)
	{
		die(mysqli_error($con));
	}
}
$selcategory = $_POST['selcategory'];

$sql6  = "select * from boards where boardcaption='$selcategory'";
$result6  = mysqli_query($con,$sql6);
	if (!$result6)
	{
		die(mysqli_error($con));
	}
	
$count6 = mysqli_num_rows($result6);
	if($count6>0)
	{
		while($row = mysqli_fetch_array($result6))
		{
			$selid = $row['boardid'];
		}
	}
if($selcategory <>"none")
{
	$sql7 = "insert into pinreference(bid,pinid) values('$selid','$pinid')";
	$result7 = mysqli_query($con,$sql7);
	if (!$result7)
	{
		die(mysqli_error($con));
	}
	
}
if($_POST['categorytext'] <> "")
{
	$sql = "insert into boards(boardpicture,boardcaption,owner) values('$image','".$_POST['categorytext']."','$emailstore')";
	$result=mysqli_query($con,$sql);
if (!$result)
	{
		die(mysqli_error($con));
	}
	$sql1 = "select * from boards where boardpicture = '$image' and boardcaption= '".$_POST['categorytext']."' and owner='$emailstore'";
	$result=mysqli_query($con,$sql1);
if (!$result)
	{
		die(mysqli_error($con));
	}
	$row = mysqli_fetch_array($result);
	$sql2 = "insert into pinreference(bid,pinid) values(".$row['boardid'].",'$pinid')";
	$result7 = mysqli_query($con,$sql2);
	if (!$result7)
	{
		die(mysqli_error($con));
	}
	
}
		
}

?><br><br>

	<br><br>
<div style="margin-top:15px;"class="col-sm-6"><br>
<label class="checkbox-inline"><input type="checkbox" style="margin-top:10px;" name="pub1" value="yes"> Visible to everyone</label><br>
<input type="submit" class="btn btn-primary" style="margin-top:10px;" name="store" value="Bookmark it">
</div>
<br>
<input type="hidden" name="text" value="<?php echo $_POST["text"]; ?>">

<input type ="hidden" name="image" value="<?php echo $_POST["image"]; ?>">

</form>

</body>
</html>