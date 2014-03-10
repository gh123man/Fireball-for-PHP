Fireball For PHP
====

Portable ORM for PHP

Advantages
---
 - No code generation
 - plug-n-play
 - no installation or large setup process
 - does not impact the actual structure of a project. 
 - light weight

How it works
---
The Fireball namespace includes two key components. 
One is the ORM class, which will be a private member variable within the parent class (representing the table). This class provides database access information and should not be directly exposed. (The reason the ORM is not directly inherited is to allow support for class level inheritance, which is a key focus in designing this)

Once the ORM class is instantiated in the construction of the parent class, it registers a the FireballDataAccessInterface object “data” as a member variable with the parent class. This is a public member that provides controlled access to the underlying table and communicates directly with the ORM class.

The FireballDataAccessInterface (the second key component of Fireball) intercepts function calls named after the columns in the database. Lets assume we have a Person class, it allows you to do something like this:
    
    $person->data->name(); //fetches the value of the name column
    
    $person->data->name(“bob”) //sets the value of the name column. 

The columns are defined in a private array within the table class. Below is an example that would represent a person class:
    
    private static $tableDef = array(
        'table'      => 'Person',
        'fields'     => array('ID', 'fname', 'lname', 'time' ),
        'primaryKey' => 'ID',
    );

The SQL for this would look like:
    
    create table Person(
        ID char(32) NOT NULL,
        fname char(80) NOT NULL,
        lname char(80) NOT NULL,
        time int unsigned NOT NULL,
        
        PRIMARY KEY (ID)
    );

Keep in mind, the tabledef will not create the table. you have to have the database modeled out beforehand. The tabledef should mapp 1:1 with the table in the database. 

For more information and an implementation of the above code, please look in the examples folder


Comming Soon
===
 - proper polymorphism support
 - data selection in lists (maps to more complex SQL queries). 

