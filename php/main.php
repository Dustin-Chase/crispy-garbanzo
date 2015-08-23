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
		//checks if publisher already in database
		$checkPub = "SELECT id, name FROM publisher WHERE name=?";
		//Checks if any of the post form textboxes are blank and if not, post info to the database
		if($name == null){
			echo 'Name must be filled in...<br/>';
		} 
		if ($publisher != null) {
			//check if publisher already in database
			$checkExist = $mysqli->prepare($checkPub); 
			if(!$checkExist){
				echo "Error: " . $mysqli->error; 
			}
			if(!($checkExist->bind_param("s", $publisher))){
				echo "Error: " . $checkExist->error; 
			}
				
			$checkExist->execute();
			$checkExist->bind_result($id, $pub_name);
			$checkExist->store_result(); 
			$row_count = $checkExist->num_rows(); 

			if ($row_count > 0) {
				//the publisher already exists in the publisher data table
				$checkExist->fetch(); 
				if(!($stmt = $mysqli->prepare("INSERT INTO comic(name,  publisherID) VALUES('$name', $id)"))){
					echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error; 
					}
					if(!$stmt->execute()){
						echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
					} else{
						echo 'New comic has been added to the database...';
					}
			}
		}
		
		else{
			echo "Please enter a publisher name.<br>"; 
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
		<title>CS340 Final Project - Superhero DB</title>
	</head>
	<body>
		<h3>Add Hero</h3>
		<form action='main.php' method='POST'>
			Superhero Name: <input type='text' name='superhero'><br>
			First Name: <input type='text' name='fName'><br>
			Last Name: <input type='text' name='lName'><br>
			Affiliation: <input type='text' name='name'><br>
			Comic Book: <input type='text' name='comic'><br>
			Creator First Name: <input type='text' name='authorfName'><br>
			Creator Last Name: <input type='text' name='authorlName'><br>			
			Power 1<input type='text' name='power1'><br>
			Power 2<input type='text' name='power2'><br>
			Power 3<input type='text' name='power3'><br>
			Publisher<input type='text' name='publisher'><br>
			<input type='submit' name='addHero' value='Add'>
		</form>
		
		<h3>Add Affiliation</h3>
		<form action='main.php' method='POST'>
			Affiliation Name: <input type='text' name='affName'><br>
			Affiliation Description: <input type='text' name='affDesc'><br>
			<input type='submit' name='addAffiliation' value='Add'>
		</form>
		
		<h3>Add Author</h3>
		<form action='main.php' method='POST'>
			First Name: <input type='text' name='authorfName'><br>
			Last Name: <input type='text' name='authorlName'><br>
			<input type='submit' name='addAuthor' value='Add'>
		</form>
		
		<h3>Add Publisher</h3>
		<form action='main.php' method='POST'>
			Name: <input type='text' name='pubName'><br>
			Founded: <input type='date' name='dateFounded'><br>
			City: <input type='text' name='city'><br>
			State: <input type='text' name='state'><br>
			<input type='submit' name='addPublisher' value='Add'>
		</form>
		
		<h3>Add Comic</h3>
		<form action='main.php' method='POST'>
			Name: <input type='text' name='comicName'><br>
			Publisher: <input type='text' name='publisher'><br>
			<input type='submit' name='addComic' value='Add'>
		</form>
		
		<h3>Add Power</h3>
		<form action='main.php' method='POST'>
			Name: <input type='text' name='powerName'><br>
			Description: <input type='text' name='powerDesc'><br>
			<input type='submit' name='addPower' value='Add'>
		</form>






		<h3>Search Query</h3>
		<form action='main.php' method='POST'>
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

						echo $whereClause;

						//Displays the table contents with the WHERE condition
						if(!($stmt = $mysqli->prepare("SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name FROM superhero sh
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
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . $superhero . '</td>';
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . $comic . '</td>';
							echo '</tr>';
						}
					} 
					elseif(isset($_POST['reset'])){
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name FROM superhero sh
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
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . $superhero . '</td>';
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . $comic . '</td>';
							echo '</tr>';
						}
					} 
					else{
						//Displays the table contents
						if(!($stmt = $mysqli->prepare('SELECT DISTINCT sh.id, sh.heroName, sh.firstName, sh.lastName, aff.name, c.name FROM superhero sh
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
						if(!$stmt->bind_result($id, $superhero, $fName, $lName, $affiliation, $comic)){
							echo 'Binding parameters failed: (' . $stmt->errno . ') ' . $stmt->error;
						}
						while($stmt->fetch()){
							echo '<tr>';
							echo '<td>' . $id . '</td>';
							echo '<td>' . $superhero . '</td>';
							echo '<td>' . $fName . '</td>';
							echo '<td>' . $lName . '</td>';
							echo '<td>' . $affiliation . '</td>';
							echo '<td>' . $comic . '</td>';
							echo '</tr>';
					}
				}
			?>
		</tbody>
		</table>
	</body>
</html>