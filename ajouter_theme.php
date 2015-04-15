<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="iso-8859-1"> 
</head>

<body>
<?php 

	$nom = $_POST['nom'];
	$descriptif= $_POST["descriptif"]; 

	$verifnom = $_POST['nom'];
	$pattern = '/[][(){}<>\/+²"\'*%&=?`^\!$_:;,]/';

echo "<h2>Ajout d'un thème</h2>";
echo "<div align=center>";
 /*On vérifie que le nom ne contient pas de caractères spéciaux*/
if (preg_match($pattern, $verifnom, $matches))
{
	echo "Le nom de la séance contient des caractères spéciaux <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
elseif (preg_match('/[0-9]/', $verifnom, $matches))
{
  	echo "Le nom contient des chiffres <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}

 /*On vérifie que le nom et le prénom ne sont pas seulement un ou des espaces*/
elseif ((trim($nom, ' ')) == '')
{
	echo "Vous n'avez rentré que des espaces pour le nom <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>"; 
}  
else
{
 	/*On vérifie si le thème existe déjà.*/
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	$query ="SELECT themes.idthemes, themes.nom, themes.supprime FROM themes
	WHERE themes.nom='$nom'
	AND themes.supprime=0 ";

	$result =mysqli_query($connect, $query);
	$row_cnt = mysqli_num_rows($result);

	if($row_cnt == 1)
	{

   		echo "Ce thème existe déjà !";
   	}
	else
	{ /*On regarde si le thème n'était pas virtuellement effacé*/
		$query ="SELECT themes.idthemes, themes.nom, themes.supprime FROM themes
		WHERE themes.nom='$nom'
		AND themes.supprime=1 ";
	
		$result =mysqli_query($connect, $query);
		$row_cnt = mysqli_num_rows($result);
		if($row_cnt == 1)
		{
			$query = "UPDATE `themes` SET `supprime`=UPPER('0') WHERE nom='$nom'";
			echo "<br>$query<br>";
			$result = mysqli_query($connect, $query);
			if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
			else{echo "Le thème a été virtuellement effacé, il vient d'être rajouté à la liste des thèmes disponibles !";}
			mysqli_close($connect);

	   	}  	
		/*Si pas inscrit, alors on enregistre l'ajout du thème*/
		else
		{
			$dbhost = 'tuxa.sme.utc';
			$dbuser = 'nf92a032';
			$dbpass = 'VxC3CvUn';
			$dbname = 'nf92a032';
			$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
			mysql');

			$query = "insert into themes values (NULL, '$nom', 0, '$descriptif')";
			echo "<br>$query<br>";
			$result = mysqli_query($connect, $query);
			if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
			else{echo"Le thème a bien été créé";}
			mysqli_close($connect);
		}
	}
}
echo "</div>";
?>


</body>

</html>
