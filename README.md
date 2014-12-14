Fireball For PHP
====

Portable ORM for PHP

Advantages
---
 - No code generation
 - plug-n-play
 - no installation or large setup process
 - light weight

How it works
---
Your mapped class must inherit the ORM class from the Fireball namespace.
Once this is done, you must simply override the `setUp()` method to make Fireball aware of what table and columns you are mapping to.

You can optionally set up a static `createNew()` static method for adding data to the database. The example.php covers this.

Once the ORM class is instantiated, it looks at the columns passed in `setUp()` and creates a mapping to the database. From here on out, you can request or update column values by requesting a method of the columns name. For example, if you have a `Person` Table with a `fname` column. You can access it like this: `$person->fname()` or set it like this: `$person->fname('bob')`



The SQL for this would look like:

    create table Person(
        ID char(32) NOT NULL,
        fname char(80) NOT NULL,
        lname char(80) NOT NULL,
        time int unsigned NOT NULL,

        PRIMARY KEY (ID)
    );

Keep in mind, this ORM does not write SQL for you. I just makes object mapping and access easier. You still need to write your schema from scratch.

For more information and an implementation of the above code, please look in the examples folder


Comming Soon
===
 - polymorphism support
 - ~~data selection in lists (maps to more complex SQL queries).~~ - DONE
