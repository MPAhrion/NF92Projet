<html>
<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<h2> Valider une séance</h2>
<br>
	Ici, vous pouvez valider une séance de code d'un élève en renseignant son nombre de fautes.</br>
	Les règles à respecter sont les suivantes :
	<ul>
		<li>Séléctionner l'élève pour lequel vous voulez valider la séance (un élève à la fois).</li>
		<li> <b>En temps normal, on ne peut valider que les séances qui ont eu lieu, mais pour tester le site, on se permet cet écart</b></li>
		<li> Le nombre de fautes est compris entre 0 et 40</li>
	</ul>
	<div align="center">
<?php
date_default_timezone_set('Europe/Paris');
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

/* Date du jour */
	date_default_timezone_set('Europe/Paris');
	$date = date("Ymd");

$query = "SELECT s.idtheme, s.date, i.ideleve, i.idseance, i.note, t.nom, e.nom, e.prenom
FROM seances s, inscription i, themes t, eleves e
WHERE i.idseance = s.idseance
AND i.note =  '-1'
AND s.idtheme = t.idthemes
AND i.ideleve =e.ideleve
/* AND s.date <= $date */
ORDER BY DATE";
$result=mysqli_query($connect, $query);
$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 0)
	{
	 echo"Il n'y a pas de séances à valider, revenez un autre jour.<br>";
	}
	else
	{
		echo "<form action='valider_seance.php' method='POST'>";
			echo "<TABLE class='tableau'>";
				echo "<TH>Thème</TH><TH>Date</TH><TH>Eleve</TH><TH>Quel étudiant ?</TH>";
				while ($row = mysqli_fetch_array($result, MYSQL_NUM))
					{ 
					$timestamp = strtotime($row[1]); 
					$dateSeance = date('d/m/Y', $timestamp);
					echo "<TR align='center'> <TD>$row[5]</TD><TD>$dateSeance</TD><TD>$row[7] $row[6]</TD><TD><input type='radio' name='choix' value ='$row[2] $row[3]'></TD></TR>";
					}
			echo "</TABLE>";
			echo "<BR>";
			echo " Nombre de fautes : <input type='number' min='0' max='40' value='0' name='note'>";
			echo "<BR>";
			echo "<BR>";

				echo "<INPUT type='submit' value='Valider la séance'>";

		echo"</FORM>";
	}
mysqli_close($connect);

?>
</div>
</body>

</html>
