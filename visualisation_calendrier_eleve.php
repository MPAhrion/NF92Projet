<html>
<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<h2>Calendrier des élèves</h2>
<br>
<div align="center">
Sélectionner un élève pour lequel vous voulez voir les séances à venir : <br><br>
<?php
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

$query = "SELECT * FROM eleves ORDER BY nom";
$result=mysqli_query($connect, $query);

echo "<form action='visualiser_calendrier_eleve.php' method='POST'>";
	echo "<TABLE class='tableau'>";
		echo "<TH>ID</TH><TH>Nom</TH><TH>Prénom</TH><TH>Selection</TH>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
			{ 
			echo "<TR align='center'> <TD><font size='2px'>$row[0]</font></TD><TD>$row[1]</TD><TD>$row[2]</TD><TD><input type='radio' name='choix' value ='$row[0]'></TD></TR>";
			}
	echo "</TABLE>";
	echo "<BR>";
	echo "<BR>";

		echo "<INPUT type='submit' class='submit' value='Voir les séances à venir'>";

echo"</FORM>";
mysqli_close($connect);

?>
</div>
</body>

</html>
