<html>
<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<div align="center">

<?php 
date_default_timezone_set('Europe/Paris');

$ideleve = $_POST["choix"];

if (empty($ideleve)) 
{
	echo"<h2>Consultation du profil d'un élève</h2>";
	echo "<br>Veuillez bien rentrer les infos.<br>";
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
	$query ="SELECT nom, prenom from eleves where ideleve ='$ideleve' ";
	$result=mysqli_query($connect, $query);
	$data = mysqli_fetch_array($result, MYSQL_NUM);
	echo "<h2>Profil de $data[0] $data[1]</h2>";

	$query = "SELECT ideleve, nom, prenom, dateNaiss, dateInscription from eleves WHERE ideleve='$ideleve'";
	echo "<TABLE align=center>";
	$result=mysqli_query($connect, $query);
	while ($row = mysqli_fetch_array($result, MYSQL_NUM))
		{ 
			$timestamp = strtotime($row[3]); 
			$dateNaissance = date('d/m/Y', $timestamp);
			$timestamp = strtotime($row[4]); 
			$dateInscription = date('d/m/Y', $timestamp);

			echo "<TR><TD>ID :</TD><TD>$row[0]</TD></TR>
			<TR><TD>Nom :</TD><TD>$row[1]</TD></TR> 
			<TR><TD>Prénom :</TD><TD>$row[2]</TD></TR> 
			<TR><TD>Né(e) le :</TD><TD>$dateNaissance</TD></TR> 
			<TR><TD>Inscription le :</TD><TD>$dateInscription</TD></TR>"; 
		}
	echo "</TABLE>";
	echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";
	mysqli_close($connect);
}

?>

</body>
</html>