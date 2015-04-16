<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<div align="center">
<?php 
date_default_timezone_set('Europe/Paris');

	$ideleve=$_POST['choix'];

	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

	$query ="SELECT nom, prenom from eleves where ideleve ='$ideleve' ";
	$result=mysqli_query($connect, $query);
	$data = mysqli_fetch_array($result, MYSQL_NUM);
	echo "<h2>Annuler une séance pour $data[0] $data[1]</h2>";

	/* Date du jour */
		date_default_timezone_set('Europe/Paris');
		$date = date("Ymd");

	$query ="SELECT inscription.ideleve, seances.idseance, inscription.idseance, seances.date, themes.nom from inscription, seances, themes 
	where inscription.ideleve='$ideleve' 
	and $date < seances.date
	and seances.idseance = inscription.idseance
	and themes.idthemes= seances.idtheme
	ORDER BY date";
	$result =mysqli_query($connect, $query);
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 0)
	{
	 echo"L'élève n'a pas de séances prévues !<br>";
	 echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	}
	else
	{	
		echo "<FORM action='annuler_seance2.php' method='POST'>";
		echo "Sélectionner la séance pour laquelle vous voulez désinscrire l'élève :<br>";
		echo "Note : On ne peut évidemment pas annuler une séance dans le passé...<br><br>";

		echo "<TABLE class='tableau'>";
		echo "<TR><TH>ID Séance</TH><TH>Thème</TH><TH>Date</TH><TH>Selection</TH>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
		{
			$timestamp = strtotime($row[3]); 
			$dateSeance = date('d/m/Y', $timestamp);

			echo "<TR align='center'><TD>$row[1]</TD><TD>$row[4]</TD><TD>$dateSeance</TD><TD><input type='radio' name='choixseance' value='$row[0] $row[1]'>";
		}
		echo "</TABLE><br>";
		echo "<INPUT type='submit' value='Enregistrer'> ";
	 	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	 	echo "</FORM>";
	}

mysqli_close($connect);
?>
</div>
</body>
</html>
