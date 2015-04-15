<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<h2> Ajout d'une séance de code </h2>
<div align=center>
<?php 

	$idtheme = $_POST['choixtheme'];
	$jourseance= $_POST["jourseance"];
	$moisseance= $_POST["moisseance"];
	$anneeseance= $_POST["anneeseance"];
	$effectif= $_POST["effectif"];

	if (empty($jourseance) or empty($moisseance) or empty($anneeseance)) 
	{
		echo "Vous avez oublié de mettre la date ! <br>";	
		echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	}
	elseif (empty($effectif)) 
	{
		echo "Vous avez oublié de mettre l'effectif ! <br>";	
		echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	}
	else
	{	
		$dateseance=$anneeseance."-".$moisseance."-".$jourseance;

		/* Date du jour */
			date_default_timezone_set('Europe/Paris');
			$date = date("Ymd");

		// on formate les dates selon le format Ymd
		$date = new DateTime( $date );
		$date = $date->format("Ymd");
		$dateseance = new DateTime( $dateseance );
		$dateseance = $dateseance->format("Ymd");
	
		/* On vérifie que la date de la séance est valide*/
		if (!checkdate($moisseance, $jourseance, $anneeseance))
 		{
  			echo "Veuillez rentrer une date valide <br>";
  			echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
 		}
		elseif( $date > $dateseance ) 
		{
			echo "La séance est dans le passé...<br>";
		  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
		}
		//elseif(is_int($effectif))
		//{
	  	//	echo "L'effectif doit être un nombre <br>";
	  	//	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
		//}
		else
		{
			$dbhost = 'tuxa.sme.utc';
			$dbuser = 'nf92a032';
			$dbpass = 'VxC3CvUn';
			$dbname = 'nf92a032';
			$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

			$query ="SELECT * from seances where idtheme='$idtheme' and date='$dateseance'";
			$result =mysqli_query($connect, $query);
			$row_cnt = mysqli_num_rows($result);
			if($row_cnt == 1)
			{
	 			echo "Il y a déjà une séance sur ce thème à cette date !";
	 			echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
	 		}	
			/*Si aucune erreur, alors on peut enregistrer dans la BDD*/  
			else
			 {
				$query = "insert into seances values (NULL, '$dateseance', '$effectif', '$idtheme')";
				echo "<br>$query<br>";
				$result = mysqli_query($connect, $query);
				if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
				else{echo "La séance a bien été ajoutée";}
				mysqli_close($connect);
			 }
		}	 
	}	 
?>
</div>

</body>

</html>
