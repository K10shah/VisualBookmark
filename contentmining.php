<html>
<head>
</head>
<body>
<form action="contentmining.php" method = "post">
<input type ="text" name="link"/>
<input type="submit" name="sub" value="check"/>
</form>
<?php
$sportskeywords = array("sports","cricket","football","fifa","hockey","scores","game","basketball","nba","espn","starsports","fixtures","racing","ferrari");
$codekeywords=array("code","javascript","scripting","stackoverflow","programming","php","java","c++","python","coding","function","method","msdn","Java","filereader","filewriter","string","codesport","w3schools","css","css3");
$shoppingkeywords = array("shopping","online","jabong","myntra","snapdeal","amazon","ebay","clothing","shoes","buy","sell","sale","buying","store","shop","brands","discount");
$foodkeywords = array("cookery","cook","food","recipe","cooking","dishes","delicacy","cuisine","multi-cuisine","menu","ingredients","lunch","dinner","chef");

if(isset($_POST['sub']))
{

$link = $_POST['link'];
$keywords ="";
$description = "";
$ch = curl_init();  // Initialising cURL
curl_setopt($ch, CURLOPT_URL, $link);    // Setting cURL's URL option with the $url variable passed into the function
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Setting cURL's option to return the webpage data
$data = curl_exec($ch); // Executing the cURL request and assigning the returned data to the $data variable
curl_close($ch); 
echo $data;
$doc = new DOMDocument();
@$doc->loadHTML($data);
$nodes = $doc->getElementsByTagName('title');
$body = $doc->getElementsByTagName('body');
//get and display what you need:
$title = $nodes->item(0)->nodeValue;

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
echo $sportscore;
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
echo "<br>";
echo $foodscore;

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
echo "<br>";
echo $codescore;

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
echo "<br>";
echo $shoppingscore;
}
?>
</body>
</html>
