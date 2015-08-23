<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//includes hidden info to get access to the database
	include 'dbInfo.php';

	//Used to store database information
	$id = NULL;
	$comicID = NULL;
	$superhero = NULL;
	$fName = NULL;
	$lName = NULL;
	$affiliation = NULL;
	$comic = NULL;
	$name = NULL;
	$description = NULL;
	$publisher = NULL;
	$dateFounded = NULL;
	$city = NULL;
	$state = NULL;



	//Connects to the database and gives an error if it does not connect properly
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if(!$mysqli || $mysqli->connect_errno){
		echo 'Cannot log in to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Search</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<img src="superheroes.jpg" height="150" width="500"></img>
		<div id="topMenu">
		<ul>
			  <li><a href="index.html">Home</a></li>
			  <li><a href="search.php">>Search</a></li>
			  <li><a href="add.php">Add</a></li>
			  <li><a href="update.php">Update</a></li>
			  <li><a href="delete.php">Delete</a></li>
		</ul>
		</div>

		<h3>Search Query</h3>
		<form action='search.php' method='POST'>
			Superhero Name: <input type='text' name='superhero'><br>
			First Name: <input type='text' name='fName'><br>
			Last Name: <input type='text' name='lName'><br>
			Affiliation: <input type='text' name='affiliation'><br>
			Comic Book: <input type='text' name='comic'><br>
			<input type='submit' name='search' value='Search'>
			<input type='submit' name='reset' value='Reset'>
		</form>
		<table>
			<caption>Search Results</caption>
			<thead>
				<tr>
	  			<th>ID</th>
	  			<th>Superhero</th>
	  			<th>First Name</th>
	  			<th>Last Name</th>
	  			<th>Affiliation</th>
	  			<th>Comic Book</th> 			
				<tr>
			</thead>
			<tbody>
				<?php
					if(isset($_POST['search'])){
						//Defaults the whereClause variable to just "WHERE "
						$whereClause = "WHERE ";
						$count = 0; //Used as a counter

						//Sets the variables based on the form
						$superhero = $_POST['superhero'];
						$fName = $_POST['fName'];
						$lName = $_POST['lName'];
						$affiliation = $_POST['affiliation'];
						$comic = $_POST['comic'];

						//Adds the input to whereClause if it contains something
						if($superhero){
							$whereClause = $whereClause . "sh.heroName = '". $superhero . "'";
							$count++;
						}
						if($fName){
							if($count > 0)
								$whereClause = $whereClause . " AND " . "sh.firstName = '". $fName . "'";
							else
								$whereClause = $whereClause . "sh.firstName = '". $fName . "'";
							$count++;
						}
						if($lName){
							if($count > 0)
								$whereClause = $whereClause . " AND " . "sh.lastName = '". $lName . "'";
							else
								$whereClause = $whereClause . "sh.lastName = '". $lName . "'";
							$count++;
						}
						if($affiliation){
							if($count > 0)
								$whereClause = $whereClause . " AND " . "aff.name = '". $affiliation . "'";
							else
								$whereClause = $whereClause . "aff.name = '". $affiliation . "'";
							$count++;
						}												
						if($comic){
							if($count > 0)
								$whereClause = $whereClause . " AND " . "c.name = '". $comic . "'";
							else
								$whereClause = $whereClause . "c.name = '". $comic . "'";
							$count++;
						}
						if($count == 0)
							$whereClause = "";

						//Displays the table contents with the WHERE condition
						if(!($stmt = $mysqli->prepare("SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name, c.id FROM superhero sh
							LEFT JOIN superheroPower sh_pwr ON sh.id = sh_pwr.superheroID
							LEFT JOIN power pwr ON sh_pwr.powerID = pwr.id
							LEFT JOIN superheroAffiliation sh_aff ON sh.id = sh_aff.superheroID 
							LEFT JOIN affiliation aff ON sh_aff.affiliationID = aff.id
							LEFT JOIN superheroComic sh_c ON sh.id = sh_c.superheroID
							LEFT JOIN comic c ON sh_c.comicID = c.id
							LEFT JOIN publisher pub ON c.publisherID = pub.id
							LEFT JOIN comicAuthor c_a ON c.id = c_a.comicID
							LEFT JOIN author a ON c_a.authorID = a.id
							$whereClause;"))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic, $comicID)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . "<a href='info.php?id=$id'>$superhero</a></td>";
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . "<a href='comic.php?id=$comicID'>$comic</a></td>";
							echo '</tr>';
						}
					} 
					elseif(isset($_POST['reset'])){
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name, c.id FROM superhero sh
							LEFT JOIN superheroPower sh_pwr ON sh.id = sh_pwr.superheroID
							LEFT JOIN power pwr ON sh_pwr.powerID = pwr.id
							LEFT JOIN superheroAffiliation sh_aff ON sh.id = sh_aff.superheroID 
							LEFT JOIN affiliation aff ON sh_aff.affiliationID = aff.id
							LEFT JOIN superheroComic sh_c ON sh.id = sh_c.superheroID
							LEFT JOIN comic c ON sh_c.comicID = c.id
							LEFT JOIN publisher pub ON c.publisherID = pub.id
							LEFT JOIN comicAuthor c_a ON c.id = c_a.comicID
							LEFT JOIN author a ON c_a.authorID = a.id;'))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic, $comicID)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . "<a href='info.php?id=$id'>$superhero</a></td>";
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . "<a href='comic.php?id=$comicID'>$comic</a></td>";
							echo '</tr>';
						}
					} 
					else{
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name, c.id FROM superhero sh
							LEFT JOIN superheroPower sh_pwr ON sh.id = sh_pwr.superheroID
							LEFT JOIN power pwr ON sh_pwr.powerID = pwr.id
							LEFT JOIN superheroAffiliation sh_aff ON sh.id = sh_aff.superheroID 
							LEFT JOIN affiliation aff ON sh_aff.affiliationID = aff.id
							LEFT JOIN superheroComic sh_c ON sh.id = sh_c.superheroID
							LEFT JOIN comic c ON sh_c.comicID = c.id
							LEFT JOIN publisher pub ON c.publisherID = pub.id
							LEFT JOIN comicAuthor c_a ON c.id = c_a.comicID
							LEFT JOIN author a ON c_a.authorID = a.id;'))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic, $comicID)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . "<a href='info.php?id=$id'>$superhero</a></td>";
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . "<a href='comic.php?id=$comicID'>$comic</a></td>";
							echo '</tr>';
						}
					}
				?>
			</tbody>
		</table>
	</body>
</html>