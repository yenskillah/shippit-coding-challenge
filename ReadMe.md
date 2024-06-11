Shippit - Tech Test Challenge
===================

The Problem :
-------
Our problem is set on the planet of Lengaburu, the distant galaxy of Tara B. Our protagonists are King Arthur, Queen Margaret and their family.
King Arthur is the emperor of Lengaburu and has been ruling the planet for the last 350 years (they have long lives in Lengaburu!).

*Requirements*:
The solution should model out the King Arthur family tree so that:
● You should be able to add a child to any family in the tree through the
mother
● Given a ‘name’ and a ‘relationship’, you should output the people
corresponding to the relationship in the order in which they are added to the family tree
● Input needs to be read from a text file. and output should be printed to the console. Your program should take the location to the test file as a parameter.

The Solution :
-------
I wrote the solution in PHP with version 8.x and tried to adhere to the following steps as recommended:
● Data modeling
● Solution and test for AddChild
● Solution and test for GetRelationship

Additionally, I also put up unit tests as much as I can to cover the functionality. 
Please refer to the test execution results later as you go along with the steps. You can check the generated unit test coverage also under the *coverage* directory.

You can find the test files under the *data* directory.
Note: Upon the script execution, it will always initialize the Family Tree data using the family-tree.json under the *data* directory.

Please follow the instructions below for the execution of the script:
> - Open a shell console and clone the repository 
> **git clone https://github.com/yenskillah/shippit-coding-challenge.git**
> - Once cloned, change directory to the KingArthurFamily folder:
> **cd KingArthurFamily**

> - Install the composer: 
> **composer install**

> - Run the unit test:
> **vendor/bin/phpunit tests --testdox**
*The unit test output should be like this when executed.:*
Constants
 ✔ It should check the attributes constants values
 ✔ It should check the operations constants values
 ✔ It should check the relationship constants values
 ✔ It should check the system constants values
Family
 ✔ It should add a child through a mother
 ✔ It should fetch the relationship for siblings
 ✔ It should return none when there is no siblings
 ✔ It should fetch the relationship for sons
 ✔ It should return none when there is no sons
 ✔ It should fetch the relationship for daughters
 ✔ It should return none when there is no daughters
 ✔ It should fetch the relationship for paternal uncles
 ✔ It should return none when there is no paternal uncles
 ✔ It should fetch the relationship for paternal aunt
 ✔ It should return none when there is no paternal aunt
 ✔ It should fetch the relationship for maternal uncles
 ✔ It should return none when there is no maternal uncles
 ✔ It should fetch the relationship for brother in law
 ✔ It should return none when there is no brother in law
 ✔ It should fetch the relationship for sister in law
 ✔ It should return none when there is no sister in law
 ✔ It should not fetch relatives with a nil target person
 ✔ It should not fetch relatives with a nil relation
 ✔ It should not add a child when required values are null
 ✔ It should not add a child when name is null
 ✔ It should not add a child when gender id null
 ✔ It should not add a child when adding through father
 ✔ It should not add a child when adding to non existing member
Person
 ✔ It should perform a person initialization
 ✔ It should set and get the father
 ✔ It should set and get the mother
 ✔ It should set and get the spouse
 ✔ It should set and get the children
 ✔ It should fetch the children
 ✔ It should fetch the siblings
 ✔ It should fetch the second relatives
Processor
 ✔ It adds a child successfully
 ✔ It fails to add a child when mother is not found
 ✔ It finds relationship successfully
 ✔ It initializes family correctly
 ✔ It processes file with init commands
Time: 00:00.049, Memory: 6.00 MB
OK (41 tests, 77 assertions)

> - To run the script, just execute the following command. Remember to replace the *testfile.txt* with your own test file:
**php main.php testfile.txt**

> - Here are the results of the script execution using different test files:
**php main.php data/example-test.txt**
*CHILD_ADDED
Dominique Minerva
Victorie Dominique Louis*
**php main.php data/sample-1.txt**
*PERSON_NOT_FOUND
PERSON_NOT_FOUND*
**php main.php data/sample-2.txt**
*CHILD_ADDITION_FAILED
NONE*
**php main.php data/sample-3.txt**
*Darcy Alice*