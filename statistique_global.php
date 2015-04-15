<html>
<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8">
</head>

<body>
<div align="center">
<h2>Statistiques globales</h2>
<?php
date_default_timezone_set('Europe/Paris');

	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	/*Nombre total d'élèves'*/
	$queryNbEleve="SELECT * FROM inscription ";
	$resultNbEleve=mysqli_query($connect, $queryNbEleve);
	$nbEleve = mysqli_num_rows($resultNbEleve);

	/*Nombre total de thèmes disponibles*/
	$queryNbTheme ="SELECT * FROM themes WHERE supprime ='0'";
	$resultNbTheme=mysqli_query($connect, $queryNbTheme);
	$nbTheme = mysqli_num_rows($resultNbTheme);

	/*Nombre de séances total*/
	$queryNbSeance ="SELECT * FROM seances ";
	$resultNbSeance =mysqli_query($connect, $queryNbSeance);
	$nbSeance = mysqli_num_rows($resultNbSeance);

	/*Moyenne globale*/
	$querymoyenne ="SELECT note FROM inscription WHERE note != '-1'";
	$resultmoyenne=mysqli_query($connect, $querymoyenne);
	$row_cnt = mysqli_num_rows($resultmoyenne);
	if($row_cnt == 0) /*Si pas de séance, la moyenne est de 0 de manière à ne pas diviser par 0 par la suite*/
	{
		$moyenne =0;
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
		$moyenne= round($moyenne, 1);
	}
/*Création du tableau stat des séances*/
		echo "<TABLE font-size='10px' 	class='tableau'>";	
			echo "<TH>Nombre total d'élève</TH><TH>Nombre de thèmes disponibles</TH><TH>Nombre total de séances</TH><TH>Nombre moyen de fautes</TH>";
			echo "<TR align='center'><TD>$nbEleve</TD><TD>$nbTheme</TD><TD>$nbSeance</TD><TD>$moyenne</TD></TR>";
			echo "</TABLE>";
			echo "<BR>";

/*Création du tableau des thèmes*/
		$query="SELECT idthemes, nom FROM themes";
		$resultTheme=mysqli_query($connect, $query);
		echo "<TABLE font-size='10px' 	class='tableau'>";	
		echo "<TH>Thème</TH><TH>Nombre de séances proposées <br>par l'autoécole</TH><TH>Nb minimal de fautes</TH><TH>Nb maximal de fautes</TH><TH>Nb moyen de fautes</TH><TH>Taux de réussite</TH>";
		while ($rowTheme = mysqli_fetch_array($resultTheme, MYSQL_NUM))
			{ 
				$querymoy= "SELECT * FROM inscription, seances WHERE idtheme=$rowTheme[0] AND inscription.idseance=seances.idseance AND inscription.note !='-1'";
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
				/*Nb de séances*/
				$queryséance= "SELECT * FROM inscription, seances WHERE idtheme=$rowTheme[0] GROUP BY seances.idseance ";
				$resultséance=mysqli_query($connect, $queryséance);
				$nbséance = mysqli_num_rows($resultséance);

				/*Nb min et max de fautes*/
				$queryminmax ="SELECT inscription.note  FROM inscription, seances WHERE inscription.note !='-1' AND idtheme=$rowTheme[0] AND seances.idseance = inscription.idseance";
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

					echo "<TR align='center'> <TD>$rowTheme[1]</TD><TD>$nbséance</TD><TD>$min </TD><TD>$max</TD><TD>$moyenne </TD><TD>$pourcentage</TD></TR>";
				
			}
		echo "</TABLE>";
		echo "<BR>";

	echo "<br><input type='button' value='Retour' onClick='history.go(-1)'>";

	mysqli_close($connect);



?>

</body>
</html>