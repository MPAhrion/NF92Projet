<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<h2> Inscrire un élève à une séance </h2>
	Formulaire d'inscription d'un élève à une séance de Code.</br></br>
	Il suffit de sélectionner l'élève à inscrire, puis la séance correspondante. </br>
	Si l'élève est déjà inscrit à la séance, vous ne pouvez évidemment pas l'inscrire une seconde fois et un message d'erreur apparaitra.</br>
	On ne peut pas inscrire un élève à une séance de code déjà passée.</br>
	</br>

<div align="center">
<?php 
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

$query = "SELECT * FROM eleves ORDER by nom";
$result=mysqli_query($connect, $query);

echo "<form action='inscrire_eleve.php' method='POST'>";
echo "<TABLE>";
	echo "<TR>";
		echo "<TD> (ID)Elève : </TD>";
		echo "<TD><select name='choixeleve'>";
			while ($row = mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value=$row[0]>($row[0]) $row[1] $row[2] </option>";
			}
		echo "</select></TD>";
	echo "</TR>";

		/* Date du jour */
		date_default_timezone_set('Europe/Paris');
		$date = date("Ymd");

		$query2 = "SELECT seances.idseance, seances.date, seances.idtheme, themes.nom FROM seances, themes WHERE seances.idtheme=themes.idthemes AND $date < seances.date ORDER by date";
		$result=mysqli_query($connect, $query2);
	
	echo "<TR>";
		echo "<TD> Séance : </TD>";
		echo "<TD><select name='choixseance'>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
		{
			date_default_timezone_set('Europe/Paris');
			$timestamp = strtotime($row[1]); 
			$dateSeance = date('d/m/Y', $timestamp);
			echo "<option value=$row[0]>$row[3] (le $dateSeance) </option>";
		}
		echo "</select></TD>";

	echo "</TR>";

echo "</TABLE>";
echo "<BR>";
echo "<INPUT type='submit' value='Enregistrer'>";
echo "<INPUT type='reset' value='Effacer'>";
echo"</FORM>";
mysqli_close($connect);
?>
</div>
</body>
</html>
