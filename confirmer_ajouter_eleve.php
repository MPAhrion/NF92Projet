<html>

<head>
<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
<meta http-equiv="Content-Type" content="text/html" charset="UTF-8" /> 
</head>

<body>
<?php 

	$nom = $_POST['recupnom'];
	$prenom= $_POST["recupprenom"]; 
	$ddnjour= $_POST["recupddnjour"];
	$ddnmois= $_POST["recupddnmois"];
	$ddnannee= $_POST["recupddnannee"];

	date_default_timezone_set('Europe/Paris');
	$date = date("Y-m-d");

	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

	$dateNaiss=$ddnannee."-".$ddnmois."-".$ddnjour;

	echo "Vous êtes $nom "."$prenom et vous êtes né(e) le $dateNaiss";

	$query = "insert into eleves values (NULL, '$nom', '$prenom', '$dateNaiss', "."'$date'".")";
	echo "<br>$query<br>";
	$result = mysqli_query($connect, $query);
	if (!$result) { echo "<br> pas bon ".mysqli_error($connect);}
	else{echo "L'élève a été ajouté !";}
	mysqli_close($connect);

?>


</body>

</html>
