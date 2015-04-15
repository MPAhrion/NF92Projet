<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8"> 
</head>

<body>
<h2> Supprimer un thème </h2>

Il vous suffit de sélectionner le thème que vous voulez virtuellement supprimer, c'est-à-dire que vous ne voulez plus proposer de séances dessus pour le moment, mais que vous pouvez réactiver à tout moment via <a href="ajout_theme.html">Ajouter un thème</a>
<br>

<div align="center">
<BR>
<BR>
	<?php 
		$dbhost = 'tuxa.sme.utc';
		$dbuser = 'nf92a032';
		$dbpass = 'VxC3CvUn';
		$dbname = 'nf92a032';
		$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

	$query = "SELECT * FROM themes WHERE supprime=0 ORDER BY nom";
	$result=mysqli_query($connect, $query);

	echo "<form action='supprimer_theme.php' method='POST'>";
	echo "<TABLE class='tableau'>";
	echo "<TR><TH>ID Thème</TH><TH>Thème</TH><TH>Supprimer ce thème ?</TH></TR>";
	
	while ($row = mysqli_fetch_array($result, MYSQL_NUM))
	{
		echo "<TR><TD align='center'><small>$row[0]</small></TD><TD>$row[1]<br><small>$row[3]</small></TD><TD align='center'><input type='radio' name='choixtheme' value='$row[0]'></TD></TR>";
	}
	echo "</TABLE>";
	echo "<br>";
	echo "<INPUT type='submit' value='Enregistrer'>";
	echo "<INPUT type='reset' value='Effacer'>";
	echo"</FORM>";
	mysqli_close($connect);
	?>
</div>
</body>
</html>
