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
$mode = $_POST["mode"];
if (empty($ideleve)) 
{
	echo "<h2>Statistiques des élèves</h2>";
	echo "<br>Veuillez bien choisir un élève.<br>";
	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
else
{
	if ($mode=='seance')
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
		echo "<h2>Statistiques de $data[0] $data[1]</h2>";
		echo "Affichage des statistiques par séances";

		$query = "SELECT t.nom, t.descriptif, s.date, i.ideleve, i.note, s.idtheme from eleves e, seances s, themes t, inscription i 
		WHERE i.ideleve ='$ideleve'
		AND s.idtheme = t.idthemes
		AND e.ideleve = i.ideleve
		AND i.idseance = s.idseance
		ORDER BY DATE";
		/*Création du tableau séance par séance*/
		$result=mysqli_query($connect, $query);
		echo "<TABLE font-size='10px' 	class='tableau'>";	
		echo "<TH>Thème</TH><TH>Date séance</TH><TH>Nb de fautes</TH>";
		while ($row = mysqli_fetch_array($result, MYSQL_NUM))
			{ 
				$timestamp = strtotime($row[2]); 
				$dateSeance = date('d/m/Y', $timestamp);

				if($row[4]==-1)
				{
					$row[4]='-';
				}
				else{}
				echo "<TR align='center'> <TD>$row[0]<br><small>$row[1]	</small></TD><TD>$dateSeance</TD><TD>$row[4]</TD></TR>";
			}
		echo "</TABLE>";
		echo "<BR>";

		/*Nombre total de séances*/
		$queryseancetotal ="SELECT ideleve FROM inscription WHERE ideleve ='$ideleve'";
		$resultnbseancetotal=mysqli_query($connect, $queryseancetotal);
		$nbseancetotal = mysqli_num_rows($resultnbseancetotal);

		/*Nombre de séances effectuées*/
		$queryseancevalide ="SELECT ideleve FROM inscription WHERE ideleve ='$ideleve' AND note !='-1'";
		$resultnbseancevalide=mysqli_query($connect, $queryseancevalide);
		$nbseancevalide = mysqli_num_rows($resultnbseancevalide);

		/*Moyenne de l'élève*/
		$querymoyenne ="SELECT note FROM inscription WHERE ideleve ='$ideleve' AND note != '-1'";
		$resultmoyenne=mysqli_query($connect, $querymoyenne);
		$row_cnt = mysqli_num_rows($resultmoyenne);
		if($row_cnt == 0) /*Si pas de séance, la moyenne est - de manière à ne pas diviser par 0 par la suite*/
		{
			$moyenne ='-';
		}
		else
		{
			$moyenne = 0;
			$iteration =0;
			while ($row = mysqli_fetch_array($resultmoyenne, MYSQL_NUM))
				{ 
					$moyenne = $moyenne + $row[0];
					$iteration = $iteration + 1;
				}
			$moyenne = $moyenne/$iteration ;
			$moyenne= round($moyenne, 2);
		}

		/*Nombre min et max de fautes*/
		$queryminmax ="SELECT note FROM inscription WHERE ideleve='$ideleve' AND note !='-1'";
		$resultminmax=mysqli_query($connect, $queryminmax);
		$min = 99 ;
		$max =0;
		while ($row = mysqli_fetch_array($resultminmax, MYSQL_NUM))
			{ 
				if ($row[0] < $min)
				{
					$min = $row[0];
				}
				if ($row[0] > $max)
				{
					$max = $row[0];
				}
			}
		if ($min == 99)
		{
			$min= '-';
		}
		if (($max == 0) and ($min == 0) and ($moyenne == 0)) /*On considère que l'élève parfait n'existe pas...*/
		{
			$max= '-';
		}

			/*Création du tableau stat des séances*/
			echo "<TABLE font-size='10px' 	class='tableau'>";	
				echo "<TH>Nombre de <br>séances total</TH><TH>Nombre de <br>séances effectuées</TH><TH>Nombre moyen<br>de fautes</TH><TH>Nombre minimal<br>de fautes</TH><TH>Nombre maximal<br>de fautes</TH>";
				echo "<TR align='center'><TD>$nbseancetotal</TD><TD>$nbseancevalide</TD><TD>$moyenne</TD><TD>$min</TD><TD>$max</TD></TR>";
				echo "</TABLE>";
				echo "<BR>";

		echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";
		mysqli_close($connect);
	}
	elseif($mode=='theme')
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
		echo "<h2>Statistiques de $data[0] $data[1]</h2>";
		echo "Affichage des statistiques par thèmes";

		$query="SELECT idthemes, nom FROM themes";
		$resultTheme=mysqli_query($connect, $query);

	    /*Création du tableau par thème*/
		echo "<TABLE font-size='10px' 	class='tableau'>";	
		echo "<TH>Thème</TH><TH>Nombre de séances</TH><TH>Nb moyen de fautes</TH><TH>Taux de réussite</TH>";
		while ($rowTheme = mysqli_fetch_array($resultTheme, MYSQL_NUM))
			{ 
				$querymoy= "SELECT * FROM inscription, seances WHERE ideleve='$ideleve' AND idtheme=$rowTheme[0] AND inscription.idseance=seances.idseance AND inscription.note !='-1'";
				$resultmoy=mysqli_query($connect, $querymoy);
				$row_cntmoy = mysqli_num_rows($resultmoy);
				if($row_cntmoy == 0) /*Si pas de séance, la moyenne et le pourcentage sont - de manière à ne pas diviser par 0 par la suite*/
				{
					$moyenne ='-';
					$iteration =0;
					$pourcentage ='-';
				}
				else
				{
					$moyenne = 0;
					$iteration =0;
					$moins5 =0 ;
					while ($rowmoy = mysqli_fetch_array($resultmoy, MYSQL_NUM))
						{ 
							$moyenne = $moyenne + $rowmoy[2];
							$iteration = $iteration + 1;
							if($rowmoy[2]<6)
								{$moins5 = $moins5+1;}
						}
					$moyenne = $moyenne/$iteration ;
					$moyenne= round($moyenne, 2);
					$pourcentage= round(($moins5/$iteration)*100, 0).'%';
				}

					echo "<TR align='center'> <TD>$rowTheme[1]</TD><TD>$iteration</TD><TD>$moyenne </TD><TD>$pourcentage</TD></TR>";
				
			}
		echo "</TABLE>";
		echo "<BR>";

		echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";
		mysqli_close($connect);
	}

}


?>

</body>
</html>