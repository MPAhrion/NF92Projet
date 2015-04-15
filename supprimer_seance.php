<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<div align=center>
<?php 

$idseance = $_POST["choix"];


if (empty($idseance)) 
{
	echo "Veuillez bien rentrer les infos.<br>";
	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
else
{

	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	$query = "DELETE FROM inscription WHERE idseance='$idseance' AND note ='-1'";
	$result = mysqli_query($connect, $query);
	$query2 = "DELETE FROM seances WHERE idseance='$idseance'";
	$result2 = mysqli_query($connect, $query2);
	if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
	echo "Tous les élèves ont été désinscrit et la séance a été supprimée.";
	mysqli_close($connect);
} 
?>
</div>
</body>

</html>