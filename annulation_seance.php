<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<h2> Annuler l'inscription d'un élève </h2>

<div align="center">
<br>
Veuillez séléctionner l'élève que vous voulez désinscrire d'une séance.
<br>
<br>
<?php 
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

$query = "SELECT eleves.ideleve, eleves.nom, eleves.prenom FROM eleves
ORDER by nom";
$result=mysqli_query($connect, $query);

echo "<form action='annuler_seance.php' method='POST'>";
echo "<TABLE class='tableau'>";
echo "<TH>ID</TH><TH>Nom</TH><TH>Prénom</TH><TH>Selection</TH>";
while ($row = mysqli_fetch_array($result, MYSQL_NUM))
{ 
echo "<TR align='center'> <TD><small>$row[0]</small></TD><TD>$row[1]</TD><TD>$row[2]</TD><TD><input type='radio' name='choix' value='$row[0]'></TD></TR>";
}
echo "</TABLE>";
echo "<BR>";
echo "<BR>";
echo "<INPUT type='submit' value='Enregistrer'>";
echo "<INPUT type='reset' value='Effacer'>";
echo"</FORM>";
mysqli_close($connect);
?>
</div>
</body>
</html>