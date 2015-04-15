<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="iso-8859-1">
</head>

<body>
<h2> Supprimer une séance de code </h2>

<div align="center">
<br>
<small>ATTENTION : Supprimer une séance entrainera la désinscription de tous les élèves de celle ci.</small>
<br>
<br>
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

$query = "SELECT s.idseance, t.nom, s.date, s.effectif FROM seances s, themes t
WHERE s.idtheme = t.idthemes
AND $date < s.date
ORDER by date";
$result=mysqli_query($connect, $query);
$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 0)/*Si pas de séances futures on ne peut rien supprimer*/
	{
	 echo"Il n'y a pas de séances à venir, vous ne pouvez donc rien supprimer.";
	}
	else /*S'il y a des séances à venir, alors proposer de les supprimer*/
	{
		echo "<form action='supprimer_seance.php' method='POST'>";
		echo "<TABLE class='tableau'>";
		echo "<TH>Thème</TH><TH>Date</TH><TH>Effectif</TH><TH>Supprimer ?</TH>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
		{ 
			$timestamp = strtotime($row[2]); 
			$dateSeance = date('d/m/Y', $timestamp);
			echo "<TR align='center'> <TD>$row[1]</TD><TD>$dateSeance</TD><TD>$row[3]</TD><TD><input type='radio' name='choix' value='$row[0]'></TD></TR>";
		}
		echo "</TABLE>";
		echo "<BR>";
		echo "<BR>";
		echo "<INPUT type='submit' value='Supprimer la séance' >";
		echo "<INPUT type='reset' value='Annuler'>";
		echo"</FORM>";
	}
mysqli_close($connect);
?>
</div>
</body>
</html>