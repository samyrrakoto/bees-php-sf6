## How to run
+ /!\ Requires PHP 8.1 as it uses some of the latest features, like the attributes and the read-only properties.
+ First `git clone`the repository.
+ Then execute a `composer install`.
+ Launch the PHP Symfony web server : `symfony serve`.
+ Open the default localhost + port on your favorite browser once the server is successfully lauched : [http://127.0.0.1:8000](http://127.0.0.1:8000).
+ Have all the fun you want killing random bees.
+ The game restarts automatically when the Queen dies.
+ You can also start a fresh new game anytime by clicking `RESET`.
+ When you're done hitting those poor bees, should you want to run unit tests, be my guest : just execute `./bin/phpunit`.


## What is this ?
This is a technical test I had to pass to get in a company once that i had to do in PHP.
Below are the test specifications

## Goal
This test aims at creating a PHP application that performs the following:
	- produce a web page with an interface to play the game (UI design is not expected or necessary)
	- a button should appear in order to "hit" a random bee 
	- the game must follow the rules described below 

N.B: The solution should run locally (please provide a README.md). You don’t need to setup any web server or host your code online


## Specifications

There are 3 different types of bees:

- The Queen
	- has 100 hit points
	- when the Queen is hit, then 15 hit points should be deduced from her lifespan
	- when the Queen is running out of hit points, all the other bees should automatically be out of hit points
	- there is only 1 Queen in the game

- The Worker
	- each has 50 hit points
	- when a worker is hit, he loses 20 hit points
	- there are 5 Workers at start 

- The Scout
	- each has 30 hit points
	- when a scout is hit, he loses 15 hit points
	- there are 8 Scouts at start


## Gameplay 

Should be visible on the UI:
	-- the list of bees associated with their role (Queen, Worker, Scout) and remaining hit points
	-- a clickable "hit" button

When the button is clicked:
	-- a random bee should be selected 
	-- the correct damages should be deduced from its lifespan

Please note that:
	-- if a bee is running out of hit points, then it cannot be randomly selected again
	-- when all bees are running out of hit points, then the game must be able to reset itself for another round
