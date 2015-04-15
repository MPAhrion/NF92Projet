<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<?php 

$ideleve = $_POST['choixeleve'];
$idseance= $_POST["choixseance"];

/*On vérifie si l'élève n'est pas déjà inscrit*/
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
	mysql');

	$query ="SELECT * FROM eleves, seances, inscription 
	WHERE eleves.ideleve=inscription.ideleve
	AND seances.idseance=inscription.idseance
	AND seances.idseance='$idseance'
	AND eleves.ideleve='$ideleve'";

	$result =mysqli_query($connect, $query);
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 1) /*Si inscrit, on refuse*/
	{
		echo "<h2> Inscrire un élève à une séance </h2>";
		echo "<div align=center>";
		echo "<br>";
	   	echo 'Cet élève est déjà inscrit à cette séance de code !';
		echo "<br>";
		echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
		echo "</div>";
	}
	/*Si pas inscrit, alors on enregistre l'inscription*/
	else
	{
		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92a032';
		$dbpass = 'VxC3CvUn';
		$dbname = 'nf92a032';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
		mysql');

		$query = "insert into inscription(ideleve, idseance) values ('$ideleve','$idseance')";
		echo "<h2> Inscrire un élève à une séance </h2>";
		echo "<br>$query<br>";
		$result = mysqli_query($connect, $query);
		if (!$result) 
		{
			echo "<br> pas bon ".mysqli_error($connect);
		}	
		else{echo"<br>L'élève a bien été inscrit à la séance<br>";}
		mysqli_close($connect);
	}

?>
</body>

</html>
