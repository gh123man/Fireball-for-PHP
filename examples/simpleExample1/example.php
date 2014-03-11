<?php

include_once 'Person.php';
include_once '../../src/Fireball.php';

Fireball\ORM::connect('fbSimpleExample', 'localhost', 'DB_USER', 'DB_PASSWORD');

$person = Person::newPerson('John', 'Doe');

echo $person->data->ID(); //print id
echo "\n";

echo $person->data->fname(); //print first name
echo "\n";

$person->data->fname('Bob'); //set first name to bob

echo $person->data->fname(); //print first name
echo "\n";

echo $person->data->lname(); //print last name
echo "\n";

echo $person->data->time(); //print timestamp
echo "\n";






?>
