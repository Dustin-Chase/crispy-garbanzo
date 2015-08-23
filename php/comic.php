<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Comic Info</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<br><img src="superheroes.jpg" height="150" width="500"></img>
		<div id="topMenu">
		<ul>
			  <li><a href="index.html">Home</a></li>
			  <li><a href="search.php">Search</a></li>
			  <li><a href="add.php">Add</a></li>
			  <li><a href="update.php">Update</a></li>
			  <li><a href="delete.php">Delete</a></li>
		</ul>
		</div>
	</body>
</html>
<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//includes hidden info to get access to the database
	include 'dbInfo.php';

	//Used to store database information
	$id = NULL;
	$powerID = NULL;
	$superheroID = NULL;
	$affiliationID = NULL;
	$publisherID = NULL;
	$comicID = NULL;
	$authorID = NULL;
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

	//Removes author information from the comic
	if(isset($_POST['removeAuthor'])){
		//Puts the info from the form into variables
		$authorID = $_POST['authorID'];
		$comicID = $_POST['comicID'];

		if(!($stmt = $mysqli->prepare("DELETE FROM comicAuthor WHERE comicID = '$comicID' AND authorID = '$authorID'"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
		} else{
			echo 'Creator has been removed from the comic book...';
		}
	}

	//Adds author infomation for the comic
	if(isset($_POST['addAuthor'])){
		//Puts the info from the form into variables
		$authorID = $_POST['authorID'];
		$comicID = $_POST['comicID'];

		if(!($stmt = $mysqli->prepare("INSERT INTO comicAuthor(comicID, authorID) VALUES('$comicID', '$authorID')"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
			echo 'You cannot add the same creator twice to the comic...';
		} else{
			echo 'Creator has been added to the comic';
		}
	}

	//Used to load the information depending on what was clicked on the search menu
	if (isset($_GET['id'])) {
		//Stores the id number and looks up the comic information
		echo "<h1>Comic Information</h1>";
		$id = $_GET['id'];
		if(!($stmt = $mysqli->prepare("SELECT id, name FROM comic WHERE id='$id'"))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($id, $name)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Comic Series: ". $name . "</li>";
			echo '</ul>';
		}

		//Loads up the publisher information
		echo "<h3>Publisher</h3>";
		if(!($stmt = $mysqli->prepare("SELECT pub.id, pub.name, pub.founded, pub.corporateLocationCity, pub.corporateLocationState  FROM comic c
			INNER JOIN publisher pub ON c.publisherID = pub.id
			WHERE c.id ='$id'"))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($publisherID, $publisher, $dateFounded, $city, $state)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Name: ". $publisher ."</li>";
				echo '<li>' . "Date Founded: ". $dateFounded ."</li>";
				echo '<li>' . "City: ". $city ."</li>";
				echo '<li>' . "State: ". $state ."</li>";
			echo '</ul>';
		}

		//Loads up the author information relating to the superhero
		echo "<h3>Creator(s)</h3>";
		if(!($stmt = $mysqli->prepare("SELECT a.id, a.firstName, a.lastName  FROM comicAuthor c_a
			INNER JOIN author a ON c_a.authorID = a.id
			WHERE c_a.comicID ='$id'"))){
					echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($authorID, $fName, $lName)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Name: ". $fName . ' ' . $lName ."</li>";
				//Create a form for the remove button
				echo "<form action = 'comic.php?id=" . $id . "' method='POST'>
						<input type='hidden' name='comicID' value=" . $id . ">						
						<input type='hidden' name='authorID' value=" . $authorID . ">
						<input type='submit' name='removeAuthor' value='Remove'>
					</form>";	
			echo '</ul>';
		}
		//Creates a form for the add button	
		echo "<form action = 'comic.php?id=" . $id . "' method='POST'>
			Author: <select name='authorID'>";
		$powerID = NULL;
		$powerName = NULL;
		//Displays the table contents
		if(!($stmt = $mysqli->prepare('SELECT id, firstName, lastName FROM author;'))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($authorID, $fName, $lName)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<option value=' . $authorID . '>' . $fName . ' ' . $lName . '</option>';
		}
		echo "</select>
			<input type='hidden' name='comicID' value=" . $id . ">						
			<input type='submit' name='addAuthor' value='Add Creator'>
			</form>";	
		}
?>
