<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>

<?php 

	$nom = $_POST['nom'];
	$prenom= $_POST["prenom"]; 
	$ddnjour= $_POST["ddnjour"];
	$ddnmois= $_POST["ddnmois"];
	$ddnannee= $_POST["ddnannee"];

	$verifnom = $_POST['nom'];
	$verifprenom = $_POST['nom'];
	$pattern = '/[][(){}<>\/+²"*%&=?`"\'^\!$_:;,]/';


echo "<h2>Ajout d'un élève</h2>";
echo "<div align=center>";
	/* On vérifie que la date de naissance est valide*/
if (!checkdate($ddnmois, $ddnjour, $ddnannee))
 {
  	echo "Veuillez rentrer une date de naissance valide <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
 }
elseif (empty($ddnjour) or empty($ddnmois) or empty($ddnannee)) 
{
	echo "Vous avez oublié de mettre la date ! <br>";	
	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}	
 	/*On vérifie que le nom et le prénom ne contiennent pas de caractères spéciaux*/
elseif (preg_match($pattern, $verifnom, $matches))
{
  	echo "Le nom contient des caractères spéciaux <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
elseif (preg_match('/[0-9]/', $verifnom, $matches))
{
  	echo "Le nom contient des chiffres <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
elseif (preg_match($pattern, $verifprenom, $matches))
{
  	echo "Le prénom contient des caractères spéciaux <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
elseif (preg_match('/[0-9]/', $verifprenom, $matches))
{
  	echo "Le prénom contient des chiffres <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>";
}
	/*On vérifie que le nom et le prénom ne sont pas seulement un ou des espaces*/
elseif ((trim($nom, ' ')) == '')
{

 	 echo "Vous n'avez rentré que des espaces pour le nom <br>";
	 echo "<input type='button' value='Retour' onClick='history.go(-1)'>"; 
}

elseif ((trim($prenom, ' ')) == '')
{

  	echo "Vous n'avez rentré que des espaces pour le prénom <br>";
  	echo "<input type='button' value='Retour' onClick='history.go(-1)'>"; 
}

	/*Si aucune erreur, alors on peut enregistrer dans la BDD*/
else
 {
		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92a032';
		$dbpass = 'VxC3CvUn';
		$dbname = 'nf92a032';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
		mysql');

	$query ="SELECT * from eleves where nom='$nom' and prenom='$prenom'";
	$result =mysqli_query($connect, $query);
	$row_cnt = mysqli_num_rows($result);
	if($row_cnt == 1)
	{
	 echo"<form method='POST' action='confirmer_ajouter_eleve.php'>";
	
	 echo "<input type='hidden' name='recupnom' value='$nom'>";
	 echo "<input type='hidden' name='recupprenom' value='$prenom'>";
	 echo "<input type='hidden' name='recupddnjour' value='$ddnjour'>";
	 echo "<input type='hidden' name='recupddnmois' value='$ddnmois'>";
	 echo "<input type='hidden' name='recupddnannee' value='$ddnannee'>";

	 echo "<div align=center>";
	 echo "<br>";
	 echo "Un élève du nom de <font color='red'> $nom $prenom </font> existe déjà, voulez vous tout de même inscrire l'élève homonyme ?";
	 echo "<br>";
	 echo "<input type='submit' value='Oui'>";
	 echo "<input type='button' value='Non' onClick='history.go(-1)'>";
	 echo "</div>";
	 echo "</form>";
	
	}
	else
	{	
		date_default_timezone_set('Europe/Paris');
		$date = date("Y-m-d");

		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92a032';
		$dbpass = 'VxC3CvUn';
		$dbname = 'nf92a032';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to
		mysql');

		$dateNaiss=$ddnannee."-".$ddnmois."-".$ddnjour;

		echo "Vous êtes $nom "."$prenom et vous êtes né(e) le $dateNaiss";

		$query = "insert into eleves values (NULL, '$nom', '$prenom', '$dateNaiss', "."'$date'".")";
		echo "<br>$query<br>";
		$result = mysqli_query($connect, $query);
		if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
		else{echo"l'élève a bien été ajouté !";}
		mysqli_close($connect);
	}
 }
echo "</div>";
?>


</body>

</html>
