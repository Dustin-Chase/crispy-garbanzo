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

	//Connects to the database and gives an error if it does not connect properly
	$mysqli = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
	if(!$mysqli || $mysqli->connect_errno){
		echo 'Cannot log in to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
	}

	//Updates information in the superhero database
	if(isset($_POST['updateHero'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$superhero = $_POST['superhero'];
		$fName = $_POST['fName'];
		$lName = $_POST['lName'];
		$appearance = $_POST['appearance'];
		$gender = $_POST['gender'];
		$bio = $_POST['bio'];
		$universe = $_POST['universe'];

		//Posts the information into the database
		if($superhero == null){
			echo 'The hero name must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE superhero SET heroName = '$superhero', firstName = '$fName', lastName = '$lName',
				firstAppearance = '$appearance', gender = '$gender', bio = '$bio', universe = '$universe'
				WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table superhero has been updated in the database...';
			}
		}
	}

	//Updates information in the affiliation database
	if(isset($_POST['updateAff'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$name = $_POST['affName'];
		$description = $_POST['affDesc'];

		//Posts the information into the database
		if($name == null || $description == null){
			echo 'Name and description must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE affiliation SET name = '$name', description = '$description' WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table affiliation has been updated in the database...';
			}
		}
	}

	//Updates information in the author database
	if(isset($_POST['updateAuthor'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$fName = $_POST['authorfName'];
		$lName = $_POST['authorlName'];

		//Posts the information into the database
		if($fName == null || $lName == null){
			echo 'First and last name must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE author SET firstName = '$fName', lastName = '$lName' WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table author has been updated in the database...';
			}
		}
	}	

	//Updates information in the publisher database
	if(isset($_POST['updatePublisher'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$name = $_POST['pubName'];
		$dateFounded = $_POST['dateFounded'];
		$city = $_POST['city'];
		$state = $_POST['state'];

		//Posts the information into the database
		if($name == null){
			echo 'Name must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE publisher SET name = '$name', founded = '$dateFounded',
				corporateLocationCity = '$city', corporateLocationState = '$state' WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table publisher has been updated in the database...';
			}
		}
	}

	//Updates information in the comic database
	if(isset($_POST['updateComic'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$name = $_POST['comicName'];
		$publisherID = $_POST['publisher'];

		//Posts the information into the database
		if($name == null){
			echo 'Comic name must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE comic SET name = '$name', publisherID = '$publisherID' WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table comic has been updated in the database...';
			}
		}
	}	

	//Updates information in the power database
	if(isset($_POST['updatePower'])){
		//Puts the info from the form into variables
		$id = $_POST['id'];
		$name = $_POST['powerName'];
		$description = $_POST['powerDesc'];

		//Posts the information into the database
		if($name == null || $description == null){
			echo 'Name and description must be filled in...<br/>';
		} else{
			if(!($stmt = $mysqli->prepare("UPDATE power SET name = '$name', description = '$description' WHERE id = '$id'"))){
				echo 'Prepare video failed...';
			}
			if(!$stmt->execute()){
				echo 'Execute video failed...';
			} else{
				echo 'An entry in table power has been updated in the database...';
			}
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Update</title>
		<link rel="stylesheet" href="style.css">
	</head>
	<body>
		<br><img src="superheroes.jpg" height="150" width="500"></img>
		<div id="topMenu">
		<ul>
			  <li><a href="index.html">Home</a></li>
			  <li><a href="search.php">Search</a></li>
			  <li><a href="add.php">Add</a></li>
			  <li><a href="update.php">>Update</a></li>
			  <li><a href="delete.php">Delete</a></li>
		</ul>
		</div>
		<h3>Update Hero</h3>
		<form action='update.php' method='POST'>
			Hero Name: <select name="hero">
				<?php
					$heroID = NULL;
					$heroName = NULL;
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT id, heroName FROM superhero;'))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($heroID, $heroName)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<option value=' . $heroID . '>' . $heroName . '</option>';
						}
				?>
			</select><br>
			<input type='submit' name='loadHero' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadHero'])){
					$id = $_POST['hero'];
					$superhero = NULL;
					$fName = NULL;
					$lName = NULL;
					$appearance = NULL;
					$gender = NULL;
					$bio = NULL;
					$universe = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, heroName, firstName, lastName, firstAppearance, gender, bio, universe 
						FROM superhero WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $superhero, $fName, $lName, $appearance, $gender, $bio, $universe)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							Superhero Name: <input type='text' name='superhero' value='" . $superhero . "'><br>
							First Name: <input type='text' name='fName' value='" . $fName . "'><br>
							Last Name: <input type='text' name='lName' value ='" . $lName . "'><br>
							First Appearance Date: <input type='date' name='appearance' value = '" . $appearance . "'><br>
							Gender: <select name='gender'>";
					if($gender == 'male' || $gender == 'Male'){
						echo "<option value='Male' selected>Male</option>
							<option value='Female'>Female</option>
							<option value='Other'>Other</option>";

					} elseif($gender == 'female' || $gender == 'Female'){
						echo "<option value='Male'>Male</option>
							<option value='Female' selected>Female</option>
							<option value='Other'>Other</option>";
					} else{
						echo "<option value='Male'>Male</option>
							<option value='Female'>Female</option>
							<option value='Other' selected>Other</option>";
					}
					echo "	</select><br>
							Universe: <input type='text' name='universe' value ='" . $universe . "'><br>
							Biography: <input type='text' name='bio' value ='" . $bio . "'><br>
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updateHero' value='Update'>
						</form>";
						
			}

		?>

		<h3>Update Affiliation</h3>
		<form action='update.php' method='POST'>
			Affiliation Name: <select name="affiliation">
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
			<input type='submit' name='loadAff' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadAff'])){
					$id = $_POST['affiliation'];
					$name = NULL;
					$description = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, name, description	FROM affiliation WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $name, $description)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							Affiliation Name: <input type='text' name='affName' value='" . $name . "'><br>
							Affiliation Description: <input type='text' name='affDesc' value='" . $description . "'><br>
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updateAff' value='Update'>
						</form>";		
			}
		?>

		<h3>Updates Author</h3>
		<form action='update.php' method='POST'>
			Author Name: <select name="author">
				<?php
					$authID = NULL;
					$firstName = NULL;
					$lastName = NULL; 
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT id, firstName, lastName FROM author;'))){
								echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
						}
						if(!$stmt->execute()){
							echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						if(!$stmt->bind_result($authID, $firstName, $lastName)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<option value=' . $authID . '>' . $firstName . " " . $lastName . '</option>';
						}
				?>
			</select><br>
			<input type='submit' name='loadAuthor' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadAuthor'])){
					$id = $_POST['author'];
					$fName = NULL;
					$lName = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, firstName, lastName FROM author WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $fName, $lName)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							First Name: <input type='text' name='authorfName' value='" . $fName . "'><br>
							Last Name: <input type='text' name='authorlName' value='" . $lName . "'><br>
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updateAuthor' value='Update'>
						</form>";		
			}
		?>

		<h3>Update Publisher</h3>
		<form action='update.php' method='POST'>
			Publisher: <select name="publisher">
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
			<input type='submit' name='loadPublisher' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadPublisher'])){
					$id = $_POST['publisher'];
					$name = NULL;
					$dateFounded = NULL;
					$city = NULL;
					$state = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, name, founded, corporateLocationCity, corporateLocationState	FROM publisher WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $name, $dateFounded, $city, $state)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							Name: <input type='text' name='pubName' value='" . $name . "'><br>
							Founded: <input type='date' name='dateFounded' value='" . $dateFounded . "'><br>
							City: <input type='text' name='city' value='" . $city . "'><br>
							State: <input type='text' name='state' value='" . $state . "'><br>
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updatePublisher' value='Update'>
						</form>";		
			}
		?>

		<h3>Update Comic</h3>
		<form action='update.php' method='POST'>
			Comic: <select name="comic">
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
			<input type='submit' name='loadComic' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadComic'])){
					$id = $_POST['comic'];
					$name = NULL;
					$pubID = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, name, publisherID	FROM comic WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $name, $pubID)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							Name: <input type='text' name='comicName' value='" . $name . "'><br>
							Publisher: <select name='publisher' value='" . $publisherID . "'>
								<option value='Other'>Fill in publisher form first if it does not exist.</option>";

					$publisherID = NULL;
					$publisherName = NULL;
						
					//Displays the table contents in a dropdown menu
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
						if($pubID == $publisherID){
							echo '<option value=' . $publisherID . ' selected>' . $publisherName . '</option>';
						} else{
							echo '<option value=' . $publisherID . '>' . $publisherName . '</option>';
						}

					}
					echo"</select><br>
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updateComic' value='Update'>
							</form>";		
			}
		?>
		
		<h3>Update Power</h3>
		<form action='update.php' method='POST'>
			Comic: <select name="power">
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
			<input type='submit' name='loadPower' value='Next'>
		</form>
		<?php
			//Creates an update form if the user clicks on Next
			if(isset($_POST['loadPower'])){
					$id = $_POST['power'];
					$name = NULL;
					$description = NULL;

					//Displays the form information for that id
					if(!($stmt = $mysqli->prepare("SELECT id, name, description	FROM power WHERE id = '$id';"))){
						echo 'Prepare failed: (' . $mysqli->errno . ') ' . $mysqli->error;
					}
					if(!$stmt->execute()){
						echo 'Execute failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					if(!$stmt->bind_result($id, $name, $description)){
						echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
					}
					while($stmt->fetch()){
					}

					//Create a form and displays it
					echo "<form action = 'update.php' method='POST'>
							Name: <input type='text' name='powerName' value='" . $name . "'><br>
							Description: <input type='text' name='powerDesc' value='" . $description . "'><br>							
							<input type='hidden' name='id' value=" . $id . ">
							<input type='submit' name='updatePower' value='Update'>
						</form>";		
			}
		?>
	</body>
</html>