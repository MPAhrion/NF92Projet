<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<h2> Supprimer un thème </h2>
<?php 

$idtheme = $_POST['choixtheme'];

if(empty($idtheme))
{
	echo "Vous devez choisir un thème.";
	echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";
}
else
{
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	$query = "UPDATE `themes` SET `supprime`=UPPER('1') WHERE idthemes='$idtheme'";
	echo "<br>$query<br>";
	$result = mysqli_query($connect, $query);
	if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
	else{echo"Le thème a été virtuellement supprimé.";}
	mysqli_close($connect);
}	
?>
</body>
</html>
