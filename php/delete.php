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
	
	//Deletes hero from the database
	if(isset($_POST['deleteHero'])){
		//Puts the info from the form into variables
		$id = $_POST['hero'];

		if(!($stmt = $mysqli->prepare("DELETE FROM superhero WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute delete failed...';
		} else{
			echo 'Superhero deleted from the database...';
		}
	
	}
	
	//Deletes affiliation from the database
	if(isset($_POST['deleteAff'])){
		//Puts the info from the form into variables
		$id = $_POST['affiliation'];

		if(!($stmt = $mysqli->prepare("DELETE FROM affiliation WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute delete failed...';
		} else{
			echo 'Affiliation deleted from the database...';
		}
	
	}
	
	//Deletes author from the database
	if(isset($_POST['deleteAuth'])){
		//Puts the info from the form into variables
		$id = $_POST['author'];

		if(!($stmt = $mysqli->prepare("DELETE FROM author WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute delete failed...';
		} else{
			echo 'Author deleted from the database...';
		}
	
	}
	
	//Deletes publisher from the database
	if(isset($_POST['deletePublisher'])){
		//Puts the info from the form into variables
		$id = $_POST['publisher'];

		if(!($stmt = $mysqli->prepare("DELETE FROM publisher WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Cannot delete a publisher which has existing comics!';
		} else{
			echo 'Publisher deleted from the database...';
		}
	
	}
	
	//Deletes comic from the database
	if(isset($_POST['deleteComic'])){
		//Puts the info from the form into variables
		$id = $_POST['comic'];

		if(!($stmt = $mysqli->prepare("DELETE FROM comic WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute failed...';
		} else{
			echo 'Comic deleted from the database...';
		}
	}
	
	//Deletes power from the database
	if(isset($_POST['deletePower'])){
		//Puts the info from the form into variables
		$id = $_POST['power'];

		if(!($stmt = $mysqli->prepare("DELETE FROM power WHERE id=$id"))){
			echo 'Prepare delete failed...';
		}
		if(!$stmt->execute()){
			echo 'Execute failed...';
		} else{
			echo 'Power deleted from the database...';
		}
	}
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Super Hero Database - Delete</title>
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
			  <li><a href="delete.php">>Delete</a></li>
		</ul>
		</div>
		<h3>Delete Hero</h3>
		<form action='delete.php' method='POST'>
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
			<input type='submit' name='deleteHero' value='Delete'>
		</form>
		
		<h3>Delete Affiliation</h3>
		<form action='delete.php' method='POST'>
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
			<input type='submit' name='deleteAff' value='Delete'>
		</form>
		
		<h3>Delete Author</h3>
		<form action='delete.php' method='POST'>
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
			<input type='submit' name='deleteAuth' value='Delete'>
		</form>
		
		<h3>Delete Publisher</h3>
		<form action='delete.php' method='POST'>
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
			<input type='submit' name='deletePublisher' value='Delete'>
		</form>
		
		<h3>Delete Comic</h3>
		<form action='delete.php' method='POST'>
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
			<input type='submit' name='deleteComic' value='Delete'>
		</form>
		
		<h3>Delete Power</h3>
		<form action='delete.php' method='POST'>
			Power: <select name="power">
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
			<input type='submit' name='deletePower' value='Delete'>
		</form>
	</body>
</html>