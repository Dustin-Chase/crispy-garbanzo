<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Info</title>
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

	//Removes power information for the superhero
	if(isset($_POST['removePower'])){
		//Puts the info from the form into variables
		$powerID = $_POST['powerID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("DELETE FROM superheroPower WHERE superheroID = '$superheroID' AND powerID = '$powerID'"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
		} else{
			echo 'Power has been removed from the superhero...';
		}
	}

	//Adds power infomation for the superhero
	if(isset($_POST['addPower'])){
		//Puts the info from the form into variables
		$powerID = $_POST['powerID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("INSERT INTO superheroPower(superheroID, powerID) VALUES('$superheroID', '$powerID')"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
			echo 'You cannot add the same superhero power twice...';
		} else{
			echo 'Power has been added to the superhero';
		}
	}

	//Removes affiliation information for the superhero
	if(isset($_POST['removeAffiliation'])){
		//Puts the info from the form into variables
		$affiliationID = $_POST['affiliationID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("DELETE FROM superheroAffiliation WHERE superheroID = '$superheroID' AND affiliationID = '$affiliationID'"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
		} else{
			echo 'Affiliation has been removed for the superhero...';
		}
	}

	//Adds affiliation infomation for the superhero
	if(isset($_POST['addAffiliation'])){
		//Puts the info from the form into variables
		$affiliationID = $_POST['affiliationID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("INSERT INTO superheroAffiliation(superheroID, affiliationID) VALUES('$superheroID', '$affiliationID')"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
			echo 'You cannot add the same affiliation for the superhero twice...';
		} else{
			echo 'Affilation has been added for the superhero';
		}
	}

	//Removes comic information for the superhero
	if(isset($_POST['removeComic'])){
		//Puts the info from the form into variables
		$comicID = $_POST['comicID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("DELETE FROM superheroComic WHERE superheroID = '$superheroID' AND comicID = '$comicID'"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
		} else{
			echo 'Comic has been removed for the superhero...';
		}
	}

	//Adds comic infomation for the superhero
	if(isset($_POST['addComic'])){
		//Puts the info from the form into variables
		$comicID = $_POST['comicID'];
		$superheroID = $_POST['superheroID'];

		if(!($stmt = $mysqli->prepare("INSERT INTO superheroComic(superheroID, comicID) VALUES('$superheroID', '$comicID')"))){
			echo 'Prepare video failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute video failed...';
			echo 'You cannot add the same comic for the superhero twice...';
		} else{
			echo 'Comic has been added for the superhero';
		}
	}

	//Used to load the information depending on what was clicked on the search menu
	if (isset($_GET['id'])) {
		//Stores the id number and looks up the superhero information
		echo "<h1>Superhero</h1>";
		$id = $_GET['id'];
		if(!($stmt = $mysqli->prepare("SELECT id, heroName, firstName, lastName, firstAppearance, gender, bio, universe FROM superhero WHERE id='$id'"))){
					echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($id, $superhero, $fName, $lName, $first, $gender, $bio, $universe)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Hero Name: ". $superhero . "</li>";
				echo '<li>' . "Human Name: " . $fName . " " . $lName . '</li>';
				echo '<li>' . "First Appearance: " .$first . '</li>';
				echo '<li>' . "Gender: " . $gender . '</li>';
				echo '<li>' . "Bio: " . $bio . '</li>'; 
				echo '<li>' . "Universe: " . $universe . '</li>';
			echo '</ul>';
		}

		//Loads up the power information relating to the superhero
		echo "<h3>Power Info</h3>";
		if(!($stmt = $mysqli->prepare("SELECT pwr.id, pwr.name, pwr.description  FROM superheroPower sh_pwr 
			INNER JOIN power pwr ON sh_pwr.powerID = pwr.id
			WHERE sh_pwr.superheroID ='$id'"))){
					echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($powerID, $name, $description)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Power Name: ". $name . "</li>";
				echo '<li>' . "Power Description: " . $description . '</li>';
				//Create a form for the remove button
				echo "<form action = 'info.php?id=" . $id . "' method='POST'>
						<input type='hidden' name='superheroID' value=" . $id . ">						
						<input type='hidden' name='powerID' value=" . $powerID . ">
						<input type='submit' name='removePower' value='Remove'>
					</form>";	
			echo '</ul>';
		}
		//Creates a form for the add button	
		echo "<form action = 'info.php?id=" . $id . "' method='POST'>
			Power: <select name='powerID'>";
		$powerID = NULL;
		$powerName = NULL;
		//Displays the table contents
		if(!($stmt = $mysqli->prepare('SELECT id, name FROM power;'))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($powerID, $powerName)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<option value=' . $powerID . '>' . $powerName . '</option>';
		}
		echo "</select>
			<input type='hidden' name='superheroID' value=" . $id . ">						
			<input type='submit' name='addPower' value='Add Superhero Power'>
			</form>";		
		
		//Loads up the affiliation information relating to the superhero
		echo "<h3>Affiliation Info</h3>";
		if(!($stmt = $mysqli->prepare("SELECT aff.id, aff.name, aff.description  FROM superheroAffiliation sh_aff 
			INNER JOIN affiliation aff ON sh_aff.affiliationID = aff.id
			WHERE sh_aff.superheroID ='$id'"))){
					echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($affiliationID, $name, $description)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Affiliation Name: ". $name . "</li>";
				echo '<li>' . "Affiliation Description: " . $description . '</li>';
				//Create a form for the remove button
				echo "<form action = 'info.php?id=" . $id . "' method='POST'>
						<input type='hidden' name='superheroID' value=" . $id . ">						
						<input type='hidden' name='affiliationID' value=" . $affiliationID . ">
						<input type='submit' name='removeAffiliation' value='Remove'>
					</form>";	
			echo '</ul>';
		}
		//Creates a form for the add button	
		echo "<form action = 'info.php?id=" . $id . "' method='POST'>
			Affiliation: <select name='affiliationID'>";
		$affiliationID = NULL;
		$affiliationName = NULL;
		//Displays the table contents
		if(!($stmt = $mysqli->prepare('SELECT id, name FROM affiliation;'))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($affiliationID, $affiliationName)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<option value=' . $affiliationID . '>' . $affiliationName . '</option>';
		}
		echo "</select>
			<input type='hidden' name='superheroID' value=" . $id . ">						
			<input type='submit' name='addAffiliation' value='Add Superhero to Affiliation'>
			</form>";		

		//Loads up the comic information relating to the superhero
		echo "<h3>Comic Info</h3>";
		if(!($stmt = $mysqli->prepare("SELECT c.id, c.name, pub.name  FROM superheroComic sh_c 
			INNER JOIN comic c ON sh_c.comicID = c.id
			INNER JOIN publisher pub ON c.publisherID = pub.id
			WHERE sh_c.superheroID ='$id'"))){
					echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($comicID, $name, $publisher)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<ul>';
				echo '<li>' . "Comic: ". "<a href='comic.php?id=$comicID'>$name</a></td>" . "</li>";
				echo '<li>' . "Publisher: " . $publisher . '</li>';
				//Create a form for the remove button
				echo "<form action = 'info.php?id=" . $id . "' method='POST'>
						<input type='hidden' name='superheroID' value=" . $id . ">						
						<input type='hidden' name='comicID' value=" . $comicID . ">
						<input type='submit' name='removeComic' value='Remove'>
					</form>";	
			echo '</ul>';
		}
		//Creates a form for the add button	
		echo "<form action = 'info.php?id=" . $id . "' method='POST'>
			Comic: <select name='comicID'>";
		$comicID = NULL;
		$comicName = NULL;
		//Displays the table contents
		if(!($stmt = $mysqli->prepare('SELECT id, name FROM comic;'))){
			echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
		}
		if(!$stmt->execute()){
			echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		if(!$stmt->bind_result($comicID, $comicName)){
			echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
		}
		while($stmt->fetch()){
			echo '<option value=' . $comicID . '>' . $comicName . '</option>';
		}
		echo "</select>
			<input type='hidden' name='superheroID' value=" . $id . ">						
			<input type='submit' name='addComic' value='Add Comic to Superhero'>
			</form>";
	}
?>
