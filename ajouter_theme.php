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
	$pattern = '/[][(){}<>\/+�"\'*%&=?`^\!$_:;,]/';

echo "<h2>Ajout d'un th�me</h2>";
echo "<div align=center>";
 /*On v�rifie que le nom ne contient pas de caract�res sp�ciaux*/
if (preg_match($pattern, $verifnom, $matches))
{
	echo "Le nom de la s�ance contient des caract�res sp�ciaux <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
elseif (preg_match('/[0-9]/', $verifnom, $matches))
{
  	echo "Le nom contient des chiffres <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}

 /*On v�rifie que le nom et le pr�nom ne sont pas seulement un ou des espaces*/
elseif ((trim($nom, ' ')) == '')
{
	echo "Vous n'avez rentr� que des espaces pour le nom <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>"; 
}  
else
{
 	/*On v�rifie si le th�me existe d�j�.*/
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

   		echo "Ce th�me existe d�j� !";
   	}
	else
	{ /*On regarde si le th�me n'�tait pas virtuellement effac�*/
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
			else{echo "Le th�me a �t� virtuellement effac�, il vient d'�tre rajout� � la liste des th�mes disponibles !";}
			mysqli_close($connect);

	   	}  	
		/*Si pas inscrit, alors on enregistre l'ajout du th�me*/
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
			else{echo"Le th�me a bien �t� cr��";}
			mysqli_close($connect);
		}
	}
}
echo "</div>";
?>


</body>

</html>
