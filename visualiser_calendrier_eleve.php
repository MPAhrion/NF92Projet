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
	echo "<h2>Calendrier des élèves</h2>";
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
	echo "<h2>Calendrier de $data[0] $data[1]</h2>";

	/* Date du jour */
		date_default_timezone_set('Europe/Paris');
		$date = date("Ymd");

	$query ="SELECT inscription.ideleve, seances.idseance, inscription.idseance, seances.date from inscription, seances 
	where inscription.ideleve='$ideleve' 
	and $date < seances.date
	and seances.idseance = inscription.idseance";
	$result =mysqli_query($connect, $query);
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 0) /*Si pas de séances de prévues*/
	{
	 echo"L'élève n'a pas de séances prévues !<br>";
	 echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	}
	else /*Si séances à venir, on les affiche*/
	{
		$query = "SELECT t.nom, s.date, s.effectif, i.ideleve, i.idseance, i.note, s.idtheme, t.descriptif from eleves e, seances s, themes t, inscription i 
		WHERE i.note= '-1'
		AND i.ideleve ='$ideleve'
		AND s.idtheme = t.idthemes
		AND e.ideleve = i.ideleve
		AND i.idseance = s.idseance
		ORDER BY DATE";
		$result=mysqli_query($connect, $query);
		$query2 ="SELECT nom, prenom from eleves where ideleve ='$ideleve' ";
		$result2=mysqli_query($connect, $query2);
		$data = mysqli_fetch_array($result2, MYSQL_NUM);

		echo "<br> Voici les séances à venir : <br><br>";
		echo "<TABLE class='tableau'>";	
		echo "<TH>Thème</TH><TH>Date séance</TH><TH>Effectif</TH>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
			{ 
				$timestamp = strtotime($row[1]); 
			$dateSeance = date('d/m/Y', $timestamp);
				echo "<TR align='center'> <TD>$row[0]<br><small>$row[7]</small></TD><TD>$dateSeance</TD><TD>$row[2]</TD></TR>";
			}
		echo "</TABLE>";
		echo "<BR>";
		echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";
		$result = mysqli_query($connect, $query);
		if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
		mysqli_close($connect);
	}
}

?>

</body>
</html>