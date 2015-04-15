<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<div align=center>
<?php 

$choix = $_POST["choixseance"];


if (empty($choix)) 
{
	echo "Veuillez bien rentrer les infos.<br>";
	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
else
{
	$choix = explode(" ",$choix);
	$ideleve = $choix[0];
	$idseance = $choix[1];

	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	$query = "DELETE FROM inscription WHERE ideleve='$ideleve' AND idseance='$idseance'";
	echo "<br>$query<br>";
	$result = mysqli_query($connect, $query);
	if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
	else{echo"L'élève a été désinscrit de cette séance ! ";}
	mysqli_close($connect);
} 
?>
</div>
</body>

</html>