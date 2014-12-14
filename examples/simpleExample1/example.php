<?php

include_once 'Person.php';
include_once '../../src/Fireball.php';

Fireball\ORM::connect('DB', 'HOST', 'USERNAME', 'PASSWORD');

$person = Person::newPerson('John', 'Doe');

echo $person->ID(); //print id
echo "\n";

echo $person->fname(); //print first name
echo "\n";

$person->fname('Bob'); //set first name to bob

echo $person->fname(); //print first name
echo "\n";

echo $person->lname(); //print last name
echo "\n";

echo $person->time(); //print timestamp
echo "\n\n";


echo "All People\n";
$allPeople = $person->getAllPeople();

foreach ($allPeople as $person) {
    echo $person->fname();
    echo "\n";
}





?>
