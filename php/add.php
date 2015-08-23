<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	//includes hidden info to get access to the database
	include 'dbInfo.php';

	//Used to store database information
	$id = NULL;
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
	$power = NULL;
	$gender = NULL;
	$universe = NULL;
	$bio = NULL;
	$appearance = NULL;

	//Connects to the database and gives an error if it does not connect properly
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if(!$mysqli || $mysqli->connect_errno){
		echo 'Cannot log in to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	//Adds superhero into the database
	if(isset($_POST['addHero'])){
		//Puts the info from the form into variables
		$superhero = $_POST['superhero'];
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$affiliation = $_POST['affiliation'];
		$comic = $_POST['comic'];
		$power = $_POST['power'];
		$gender = $_POST['gender'];
		$universe = $_POST['universe'];
		$bio = $_POST['bio'];
		$appearance = $_POST['appearance'];

		//Checks if any of the post form textboxes are blank and if not, post info to the database
		if($superhero == null){
			echo 'The hero name must be filled in...<br/>';
		} else{
			//Statement to add a new superhero
			if(!($stmt = $mysqli->prepare("INSERT INTO superhero(heroName, firstName, lastName, gender, universe, bio, firstAppearance) 
				VALUES('$superhero', '$fName', '$lName', '$gender', '$universe', '$bio', '$appearance')"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'New superhero has been added to the database...';
			}

			//Gets the superheroID number that was just added
			if(!($stmt = $mysqli->prepare("SELECT id FROM superhero ORDER BY id DESC LIMIT 1"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			}
			if(!$stmt->bind_result($id)){
				echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
			}
			while($stmt->fetch()){			
			}

			//Statement to link the relationship between superhero and affiliation if something is selected
			if($affiliation != 'none'){
				if(!($stmt = $mysqli->prepare("INSERT INTO superheroAffiliation(superheroID, affiliationID) VALUES('$id', '$affiliation')"))){
					echo 'Prepare video failed...';
				}
				if(!$stmt->execute()){
					echo 'Execute video failed...';
				}
			}
			//Statement to link the relationship between superhero and comic if something is selected
			if($comic != 'none'){
				if(!($stmt = $mysqli->prepare("INSERT INTO superheroComic(superheroID, comicID) VALUES('$id', '$comic')"))){
					echo 'Prepare video failed...';
				}
				if(!$stmt->execute()){
					echo 'Execute video failed...';
				}
			}
			//Statement to link the relationship between superhero and power if something is selected
			if($power != 'none'){
				if(!($stmt = $mysqli->prepare("INSERT INTO superheroPower(superheroID, powerID) VALUES('$id', '$power')"))){
					echo 'Prepare video failed...';
				}
				if(!$stmt->execute()){
					echo 'Execute video failed...';
				}
			}
		}
	}

	//Adds affiliation into the database
	if(isset($_POST['addAffiliation'])){
		//Puts the info from the form into variables
		$name = $_POST['affName'];
		$description = $_POST['affDesc'];

		//Checks if any of the post form textboxes are blank and if not, post info to the database
		if($name == null || $description == null){
			echo 'Name and description must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("INSERT INTO affiliation(name, description) VALUES('$name', '$description')"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'New affiliation has been added to the database...';
			}
		}
	}

	//Adds author to the database
 	if(isset($_POST['addAuthor'])){
		//Puts the info from the form into variables
	  $fName = $_POST['authorfName'];
	  $lName = $_POST['authorlName'];

	  //Checks if any of the post form textboxes are blank and if not, post info to the database
	  if($fName == null || $lName == null){
	   	echo 'Both first and last name must be filled in...<br/>';
	  } else{
	   	if(!($stmt = $mysqli->prepare("INSERT INTO author(firstName, lastName) VALUES('$fName', '$lName')"))){
	    echo 'Prepare author failed...';
	  	}
	  	if(!$stmt->execute()){
	    	echo 'Execute author failed...';
	  	} else{
	    	echo 'New author has been added to the database...';
	  	}
	  }
 	}

//Adds publisher to the database
 	if(isset($_POST['addPublisher'])){
		//Puts the info from the form into variables
	  $name = $_POST['pubName'];
	  $dateFounded = $_POST['dateFounded'];
	  $city = $_POST['city'];
	  $state = $_POST['state'];

	  //Checks if any of the post form textboxes are blank and if not, post info to the database
	  if($name == null){
	   echo 'Name must be filled in...<br/>';
	  } else{
		  if(!($stmt = $mysqli->prepare("INSERT INTO publisher(name, founded, corporateLocationCity, corporateLocationState) VALUES('$name', '$dateFounded', '$city', '$state')"))){
		  	echo 'Prepare publisher failed...';
		  }
		  if(!$stmt->execute()){
		    echo 'Execute publisher failed...';
		  } else{
		    echo 'New publisher has been added to the database...';
   		}
  	}
	}

	//Adds comic into the database
	if(isset($_POST['addComic'])){
		//Puts the info from the form into variables
		$name = $_POST['comicName'];
		$publisher = $_POST['publisher'];

		//Checks if any of the post form textboxes are blank and if not, post info to the database
		if($name == null || $publisher == null || $publisher == 'Other'){
			echo 'Name and publisher must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("INSERT INTO comic(name, publisherID) VALUES('$name', '$publisher')"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'New comic has been added to the database...';
			}
		}
	}

	//Adds power into the database
	if(isset($_POST['addPower'])){
		//Puts the info from the form into variables
		$name = $_POST['powerName'];
		$description = $_POST['powerDesc'];

		//Checks if any of the post form textboxes are blank and if not, post info to the database
		if($name == null || $description == null){
			echo 'Name and description must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("INSERT INTO power(name, description) VALUES('$name', '$description')"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'New power has been added to the database...';
			}
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Add</title>
		<link rel="stylesheet" type="text/css" href="style.css">
	</head>
	<body>
		<br><img src="superheroes.jpg" height="150" width="500"></img>
		<div id="topMenu">
		<ul>
			  <li><a href="index.html">Home</a></li>
			  <li><a href="search.php">Search</a></li>
			  <li><a href="add.php">>Add</a></li>
			  <li><a href="update.php">Update</a></li>
			  <li><a href="delete.php">Delete</a></li>
		</ul>
		</div>

		<h3>Add Hero</h3>
		<form action='add.php' method='POST'>
			Superhero Name: <input type='text' name='superhero'><br>
			First Name: <input type='text' name='fName'><br>
			Last Name: <input type='text' name='lName'><br>
			First Appearance Date: <input type='date' name='appearance'><br>
			Gender: <select name="gender">
				<option value='Male'>Male</option>
				<option value='Female'>Female</option>
				<option value='Other'>Other</option>
			</select><br>
			Universe: <input type='text' name='universe'><br>
			Biography: <input type='text' name='bio'><br>
			*Note - In the dropdown information below, if the information is not there, add the respective table first!<br>
			Affiliation: <select name="affiliation">
				<option value='none'>none(if not listed, fill affiliation form first)</option><br>
				<?php
					$affID = NULL;
					$affName = NULL;
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT id, name FROM affiliation;'))){
							echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($affID, $affName)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<option value=' . $affID . '>' . $affName . '</option>';
						}
				?>
			</select><br>	
			Comic Book: <select name="comic">
				<option value='none'>none(if not listed, fill comic form first)</option><br>
				<?php
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
				?>
			</select><br>		
			Power: <select name="power">
				<option value='none'>none(if not listed, fill power form first)</option><br>
				<?php
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
				?>
			</select><br>
			<input type='submit' name='addHero' value='Add'>
		</form>
		
		<h3>Add Affiliation</h3>
		<form action='add.php' method='POST'>
			Affiliation Name: <input type='text' name='affName'><br>
			Affiliation Description: <input type='text' name='affDesc'><br>
			<input type='submit' name='addAffiliation' value='Add'>
		</form>

		<h3>Add Author</h3>
		<form action='add.php' method='POST'>
			First Name: <input type='text' name='authorfName'><br>
			Last Name: <input type='text' name='authorlName'><br>
			<input type='submit' name='addAuthor' value='Add'>
		</form>
		
		<h3>Add Publisher</h3>
		<form action='add.php' method='POST'>
			Name: <input type='text' name='pubName'><br>
			Founded: <input type='date' name='dateFounded'><br>
			City: <input type='text' name='city'><br>
			State: <input type='text' name='state'><br>
			<input type='submit' name='addPublisher' value='Add'>
		</form>
		
		<h3>Add Comic</h3>
		<form action='add.php' method='POST'>
			Name: <input type='text' name='comicName'><br>
			Publisher: <select name="publisher">
				<option value='Other'>Fill in publisher form first if it does not exist.</option>
				<?php
					$publisherID = NULL;
					$publisherName = NULL;
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT id, name FROM publisher;'))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($publisherID, $publisherName)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<option value=' . $publisherID . '>' . $publisherName . '</option>';
						}
				?>
			</select><br>
			<input type='submit' name='addComic' value='Add'>
		</form>
		
		<h3>Add Power</h3>
		<form action='add.php' method='POST'>
			Name: <input type='text' name='powerName'><br>
			Description: <input type='text' name='powerDesc'><br>
			<input type='submit' name='addPower' value='Add'>
		</form>
	</body>
</html>