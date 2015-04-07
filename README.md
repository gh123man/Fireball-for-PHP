Fireball For PHP
====

Portable ORM for PHP

Advantages
---
 - No code generation
 - plug-n-play
 - no installation or large setup process
 - light weight

Features and functional notes
---
 - Database flush is automated
 - All values are cached
 - No data is queried until a specific request is made
 - No data is written until a flush is called (automatic on object destrcution)
 - set/get methods are the names of the columns in the table

Usage
---
Your mapped class must inherit the ORM class from the Fireball namespace.
Once this is done, you must simply override the `setUp()` method to make Fireball aware of what table and columns you are mapping to.

You can optionally set up a static `createNew()` static method for adding data to the database.

Once the ORM class is instantiated, it looks at the columns passed in `setUp()` and creates a mapping to the database. From here on out, you can request or update column values by requesting a method of the columns name. For example, if you have a `Person` Table with a `fname` column. You can access it like this: `$person->fname()` or set it like this: `$person->fname('bob')`



The SQL for this could look like:

    create table Person(
        ID int NOT NULL AUTO_INCREMENT,
        fname char(80) NOT NULL,
        lname char(80) NOT NULL,
        time int unsigned NOT NULL,

        PRIMARY KEY (ID)
    );


Keep in mind, this ORM does not write SQL for you. I just makes object mapping and access easier. You still need to write your schema from scratch.

For more information and an implementation of the above code, please look in the examples folder


Comming Soon
===
 - ~~data selection in lists (maps to more complex SQL queries).~~ - DONE
