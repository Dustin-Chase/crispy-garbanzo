-- Solomon Huynh
-- Dustin Chase
/*
Table Alias Names:


superhero                 sh
power                         pwr
superheroPower         sh_pwr
publisher                 pub
comic                         c
superheroComic         sh_c
affiliation                aff
superheroAffiliation          sh_aff
author                        a
comicAuthor                c_a
*/


DROP TABLE IF EXISTS superheroPower;
DROP TABLE IF EXISTS superheroAffiliation;
DROP TABLE IF EXISTS superheroComic;
DROP TABLE IF EXISTS comicAuthor; 
DROP TABLE IF EXISTS author; 
DROP TABLE IF EXISTS superhero;
DROP TABLE IF EXISTS power;
DROP TABLE IF EXISTS affiliation;
DROP TABLE IF EXISTS comic;
DROP TABLE IF EXISTS publisher;


-- Creating tables
CREATE TABLE superhero(
id INT NOT NULL AUTO_INCREMENT,
heroName VARCHAR(255) NOT NULL,
firstName VARCHAR(255) default NULL,
lastName VARCHAR(255) default NULL,
firstAppearance DATE default NULL,
gender VARCHAR(255),
bio TEXT,
universe VARCHAR(255) default NULL,
PRIMARY KEY(id)
)ENGINE=InnoDB;


CREATE TABLE power(
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL,
description TEXT NOT NULL,
PRIMARY KEY(id)
)ENGINE=InnoDB;


CREATE TABLE superheroPower(
superheroID INT,
powerID INT,
PRIMARY KEY(superheroID, powerID),
FOREIGN KEY(superheroID) 
REFERENCES superhero(id)
ON DELETE CASCADE
ON UPDATE CASCADE,
FOREIGN KEY(powerID) 
REFERENCES power(id)
ON DELETE CASCADE
ON UPDATE CASCADE
)ENGINE=InnoDB;


CREATE TABLE publisher (
id INT NOT NULL AUTO_INCREMENT, 
name VARCHAR(255) NOT NULL, 
founded DATE, 
corporateLocationCity VARCHAR(255), 
corporateLocationState VARCHAR(255),
PRIMARY KEY(id)
)ENGINE=InnoDB; 


CREATE TABLE comic (
id INT NOT NULL AUTO_INCREMENT,
name VARCHAR(255) NOT NULL, 
publisherID INT,
PRIMARY KEY(id),  
FOREIGN KEY(publisherID) 
REFERENCES publisher(id)
ON DELETE NO ACTION
ON UPDATE CASCADE
)ENGINE=InnoDB;


CREATE TABLE author(
id INT NOT NULL AUTO_INCREMENT, 
firstName VARCHAR(255) NOT NULL, 
lastName VARCHAR(255) NOT NULL, 
PRIMARY KEY(id)
)ENGINE=InnoDB;


CREATE TABLE comicAuthor(
comicID INT, 
authorID INT, 
PRIMARY KEY(comicID, authorID),
FOREIGN KEY(comicID)
        REFERENCES comic(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE, 
FOREIGN KEY(authorID)
        REFERENCES author(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE


)ENGINE=InnoDB;
  
CREATE TABLE superheroComic (
superheroID INT, 
comicID INT, 
PRIMARY KEY(superheroID, comicID),
FOREIGN KEY(superheroID) 
REFERENCES superhero(id)
ON DELETE CASCADE
ON UPDATE CASCADE, 
FOREIGN KEY(comicID) 
REFERENCES comic(id)
ON DELETE CASCADE
ON UPDATE CASCADE
) ENGINE=InnoDB;


CREATE TABLE superheroAffiliation (
superheroID INT, 
affiliationID INT,
PRIMARY KEY(superHeroID, affiliationID),
FOREIGN KEY(superHeroID) 
REFERENCES superhero(id)
ON DELETE CASCADE
ON UPDATE CASCADE
)ENGINE=InnoDB; 


CREATE TABLE affiliation (
id INT NOT NULL AUTO_INCREMENT, 
name varchar(255) NOT NULL, 
description TEXT,
PRIMARY KEY(id) 
)ENGINE=InnoDB;
 
-- Insert Sample Data
--
--


-- Insert data into table powers


INSERT INTO power (name, description) VALUES 
('Flight', 'The ability to levitate into the air'),
('Shieldsmanship', 'Using a shield as a weapon'),
('Acrobat', 'High agility'),
('Healing', 'Ability to restore wounds'),
('Retractable Claws', 'Ability to pull in and out claws from the knuckles'),
('Extended Lifespan', 'Live longer than an average human lifespan'),
('Enhanced Strength', 'Strength drastically greater than a human'),
('Spider Sense', 'Ability that has the senses of a spider'),
('Weather Manipulation', 'Ability to change the weather at will'),
('Super Jump', 'Ability to jump extremely high'),
('Optic Blast', 'The ability to emit solar energy from the eyes'),
('Telepathy', 'Ability to use read minds and communicate by using one\'s mind'),
('Shapeshifting', 'Ability to change forms into any human or creature'),
('Thief', 'Highly skillful at stealing'),
('Marksman', 'High shooting accuracy');


-- Insert data into table superhero


INSERT INTO superhero (heroName, firstName, lastName, firstAppearance, gender, bio, universe) VALUES 
('Captain America', 'Steve', 'Rogers', '1941-03-01', 'Male', 'Scrawny teen is given a super-soldier serum and transformed into a patriotic hero.', 'Marvel'),
('Wolverine', 'James', 'Howlett', '1974-11-01', 'Male', 'Wolverine was born, James Howlett, inCold Lake, Alberta, Canada, during the late 1880s, to rich farm owners John and Elizabeth Howlett. Bone claws emerge from the back of his hands, as his mutation manifests.', 'Marvel'), 
('Spider-Man', 'Peter', 'Parker', '1962-08-01', 'Male', 'In Forest Hills, Queens, New York, high school student Peter Parker is a science-whiz orphan living with his Uncle Ben and Aunt May. He is bitten by a radioactive spider at a science exhibit and acquires the agility and proportionate strength of an arachnid.', 'Marvel'), 
('Thor', 'Donald', 'Blake', '1962-08-01', 'Male', 'Thor\'s father Odin decides his son needed to be taught humility and consequently places Thor (without memories of godhood) into the body and memories of an existing, partially disabled human medical student, Donald Blake.', 'Marvel'), 
('Hulk', 'Bruce', 'Banner', '1962-05-01', 'Male', 'During the experimental detonation of a gamma bomb, Banner is hit with the blast, absorbing massive amounts of gamma radiation. He awakens later in an infirmary, seeming relatively unscathed, but that night transforms into a lumbering grey form.', 'Marvel'), 
('Superman', 'Clark', 'Kent', '1938-06-01', 'Male', 'Superman is the sole survivor of the planet Krypton. His father, Jor-El, discovered that a nuclear chain reaction was building inside Krypton that would soon shatter the entire world. Jor-El therefore had his unborn son Kal-El removed from the Kryptonian Gestation Chambers and affixed the life matrix containing Kal-El to an experimental vessel for travel through hyperspace. Jor-El launched the starcraft toward Earth just before Krypton exploded.', 'DC'), 
('Wonder Woman', 'Diane', 'Prince', '1942-06-01', 'Female', 'Warrior princess of the Amazons (based on the Amazons of Greek mythology) and is known in her homeland as Princess Diana of Themyscira.', 'DC'), 
('Martian Manhunter', 'J\'onn', 'J\'onzz', '1955-11-01', 'Other', 'The character is a green-skinned extraterrestrial humanoid from the planet Mars, who is pulled to earth by an experimental teleportation beam (originally presented as an attempted communication device) constructed by Dr. Saul Erdel.', 'DC'), 
('Storm', 'Ororo', 'Munroe', '1975-05-01', 'Female', 'Ororo\'s mother, N\'Dare, was the princess of a tribe in Kenya and descended from a long line of African witch-priestesses with white hair, blue eyes, and a natural gift for sorcery. N\'Dare falls in love with and marries American photojournalist David Munroe.', 'Marvel'), 
('Savage Dragon', 'Emperor', 'Kurr', '1982-06-01', 'Male', 'The Dragon used to be an evil tyrant named Emperor Kurr, who led a nomadic race of space aliens who spent thousands of years traveling through space, searching for a suitable new homeworld. After Kurr had chosen Earth, he decided to go against his people\'s peaceful ways and slaughter all humans. Two scientists named Rech and Weiko conspired against him, giving him brain damage that erased his memory, and implanted within his memories five days\' worth of satellite television broadcasts from Earth. Kurr was then sent to live on Earth, while his race moved on to search for a new planet elsewhere.', 'Image'), 
('Invincible', 'Mark', 'Grayson', '2002-11-01', 'Male', 'Markus Sebastian Grayson is the son of Nolan Grayson, who is the superhero Omni-Man as well as a successful novelist, and Deborah Grayson. When Mark was seven years old, Nolan reveals that he is a member of a race of peaceful alien explorers called Viltrumites, that he had come to Earth to help mankind and that one day Mark would develop super powers. Mark\'s powers manifest at the age of 17 while he is working at his part-time job.', 'Image'); 


-- Insert data into publisher table


INSERT INTO publisher (name, founded, corporateLocationCity, corporateLocationState) VALUES 
('DC', '1934-05-01','New York','New York'),
('Marvel','1939-12-01','New York', 'New York'),
('Image','1992-02-01','Berkeley','California');


-- Insert data into table comic


INSERT INTO comic (name, publisherID) VALUES 
('Captain America', 2),
('X-Men',2),
('Spider-Man', 2),
('Thor',2),
('The Incredible Hulk',2),
('Superman', 1),
('Wonder Woman', 1),
('Martian Manhunter',1),
('Savage Dragon', 3),
('Invincible', 3);


-- insert data into affiliation


INSERT INTO affiliation (name, description) VALUES
('X-Men','Heroic team of mutants'),
('Avengers','Earth\'s mightiest heroes'),
('Defenders','Team of individualistic outsiders'),
('Justice League of America','Heroic team with rotating roster'),
('BrotherHood of Mutants','Supervillian team devoted to mutant superiority over normal humans'),
('Justice Society of America','First team of superheroes'),
('Newsboy Legion','A kid gang'),
('West Coast Avengers','Founded by Avenger Hawkeye to expand Avengers influence'),
('Alpha Flight','Canadian superhero team'),
('Sinister Six','Supervillian team drawn from Spider-Man comics'),
('Brigade ','Heroic team originally led by Battlestone'),
('Youngblood','High-profile team sanctioned by U.S. government');


-- Insert data into table superheroPower


INSERT INTO superheroPower (superheroID, powerID) VALUES
(1, 2),
(1, 3),
(1, 15),
(2, 4),
(2, 5),
(2, 6),
(3, 7),
(3, 8),
(3, 3),
(4, 9),
(4, 6),
(5, 7),
(5, 10),
(5, 4),
(6, 1),
(6, 11),
(6, 7),
(7, 1),
(7, 7),
(7, 4),
(7, 12),
(8, 13),
(8, 7),
(8, 11),
(9, 9),
(9, 14),
(10, 7),
(10, 4),
(11, 7),
(11, 1);


-- Insert data into table superheroComic


INSERT INTO superheroComic (superheroID, comicID) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 2),
(10, 9),
(11, 10);


-- Insert data into table superheroAffiliation


INSERT INTO superheroAffiliation (superheroID, affiliationID) VALUES
(1, 2),
(2, 1),
(3, NULL),
(4, 2),
(5, 3),
(6, NULL),
(7, 6),
(8, 6),
(9, 1),
(10, NULL),
(11, NULL);


INSERT INTO author (firstName, lastName) VALUES 
('Jack','Kirby'),
('Stan','Lee'),
('Larry','Lieber'),
('Joe','Simon'),
('Jerry','Siegel'),
('Joe ','Shuster'),
('John','Byrne'),
('William','Marston'),
('H.G.','Peter'),
('Joseph','Samachson'),
('Joe','Certa'),
('Erik','Larsen'),
('Robert','Kirkman'),
('Cory','Walker'),
('Steve','Ditko');


INSERT INTO comicAuthor (comicID, authorID) VALUES 
(1, 1), 
(1, 4), 
(2, 2), 
(2, 1), 
(3, 2), 
(3, 15),
(4, 3),
(4, 1),
(4, 2),
(5, 1),
(5, 2), 
(6, 5), 
(6, 6),
(6, 7),
(7, 8), 
(7, 9), 
(8, 10), 
(8, 11),
(9, 12),
(10, 13), 
(10, 14);