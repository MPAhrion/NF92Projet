<html>

<head>
	<LINK rel="stylesheet" HREF="miseenforme2.css" type="text/css">
	<meta charset="UTF-8"> 
</head>

<body>
<h2> Ajout d'une séance de code </h2>

	Formulaire d'ajout d'une séance de code</br></br>
	Choisissez le thème sur lequel portera la séance, puis la date de la séance (celle ci ne peut pas être antérieure à la date du jour). </br>
	L'effectif est compris entre 1 et 50 élèves. Par défaut, il est fixé à 25. </br>
	Il ne peut y avoir deux séances ayant le même thème le même jour. </br>
<div align="center">
<BR>
<BR>
<?php 
	$dbhost = 'tuxa.sme.utc';
	$dbuser = 'nf92a032';
	$dbpass = 'VxC3CvUn';
	$dbname = 'nf92a032';
	$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');

	$query = "SELECT * FROM themes WHERE supprime=0";
	$result=mysqli_query($connect, $query);

	echo "<form action='ajouter_seance.php' method='POST'>";
	echo "<TABLE>";
	echo "<TR>";
	echo "<TD>Choix du thème :</TD><TD><select name='choixtheme'>";
	while ($row = mysqli_fetch_array($result, MYSQL_NUM))
	{
		echo "<option value=$row[0]> $row[1] </option>";
	}
	echo "</select></TD>";
	echo "</TR>";
	echo "<TR>";
		echo "<TD> Date : </TD> <TD> <select name='jourseance' id='jourseance'>"; 
						echo "<option value=''>Jour</option>";
						echo"<option value='1'>1</option>";
						echo"<option value='2'>2</option>";
						echo"<option value='3'>3</option>";
						echo"<option value='4'>4</option>";
						echo"<option value='5'>5</option>";
						echo"<option value='6'>6</option>";
						echo"<option value='7'>7</option>";
						echo"<option value='8'>8</option>";
						echo"<option value='9'>9</option>";
						echo"<option value='10'>10</option>";
						echo"<option value='11'>11</option>" ; 
						echo"<option value='12'>12</option>";
						echo"<option value='13'>13</option>" ; 
						echo"<option value='14'>14</option>";
						echo"<option value='15'>15</option>" ;
						echo"<option value='16'>16</option>";
						echo"<option value='17'>17</option>" ; 
						echo"<option value='18'>18</option>";
						echo"<option value='19' >19</option>";
						echo"<option value='20'>20</option>" ; 
						echo"<option value='21'>21</option>";
						echo"<option value='22'>22</option>" ;
						echo"<option value='23'>23</option>";
						echo"<option value='24'>24</option>";
						echo"<option value='25'>25</option>";
						echo"<option value='26'>26</option>";
						echo"<option value='27'>27</option>";
						echo"<option value='28'>28</option>";
						echo"<option value='29'>29</option>"; 
						echo"<option value='30'>30</option>";   
						echo"<option value='31'>31</option>"; 
		echo"</select>";

		echo"<select name='moisseance' id='moisseance' >  <option value='' >Mois</option>";
						echo"<option value='1'>Janvier</option>";
						echo "<option value='2'>Février</option>";
						echo "<option value='3'>Mars</option>";
						echo "<option value='4'>Avril</option>";
						echo "<option value='5'>Mai</option>";
						echo "<option value='6'>Juin</option>";
						echo "<option value='7' >Juillet</option>";
						echo" <option value='8'>Août</option>";
						echo "<option value='9'>Septembre</option>";
						echo "<option value='10'>Octobre</option>";  
						echo "<option value='11'>Novembre</option>"; 
						echo "<option value='12'>Décembre</option>";
		echo "</select>";
		echo "<select  name='anneeseance' id='anneeseance'>  <option value=''>Année</option>";
					echo"<option value='2014'>2014</option>";
					echo"<option value='2015'>2015</option>";
					echo"<option value='2016'>2016</option>";
					echo"<option value='2017'>2017</option>";
					echo"<option value='2018'>2018</option>";
					echo"<option value='2019'>2019</option>";
					echo"<option value='2020'>2020</option>";
					echo"<option value='2021'>2021</option>";
					echo"<option value='2022'>2022</option>";
					echo"<option value='2023'>2023</option>";
					echo"<option value='2024'>2024</option>";
					echo"<option value='2025'>2025</option>";
					echo"<option value='2026'>2026</option>";
					echo"<option value='2027'>2027</option>";
					echo"<option value='2028'>2028</option>";
					echo"<option value='2029'>2029</option>";
					echo"<option value='2030'>2030</option>";
					echo"<option value='2031'>2031</option>";
					echo"<option value='2032'>2032</option>";
					echo"<option value='2033'>2033</option>";
					echo"<option value='2034'>2034</option>";
					echo"<option value='2035'>2035</option>";
					echo"<option value='2036'>2036</option>";
					echo"<option value='2037'>2037</option>";
					echo"<option value='2038'>2038</option>";
					echo"<option value='2039'>2039</option>";
					echo"<option value='2040'>2040</option>";

	echo "</TR>";
	echo "<TR>";
		echo "<TD>Effectif maximal :</td> <td><input type='number' min='1' max='50' value='25' name='effectif'> </td>";
	echo "</TR>";
	echo "</TABLE>";
	echo "<INPUT type='submit' value='Enregistrer'>";
	echo "<INPUT type='reset' value='Effacer'>";
	echo"</FORM>";
	mysqli_close($connect);
?>
</div>
</body>
</html>
