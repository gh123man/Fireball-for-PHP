<?php

include_once '../../src/Fireball.php';

class Person extends Fireball\ORM {

    const TABLE_NAME  = 'Person';
    const PRIMARY_KEY = 'ID';
    const FNAME       = 'fname';
    const LNAME       = 'lname';
    const TIME        = 'time';

    private static $fields = array (
        self::PRIMARY_KEY,
        self::FNAME,
        self::LNAME,
        self::TIME,
    );

    //Override
    protected function setUp(Fireball\TableDef $def) {
        $def->setName(self::TABLE_NAME);
        $def->setKey(self::PRIMARY_KEY);
        $def->setCols(self::$fields);
    }


    public static function newPerson($fname, $lname) {
        //Validate input data here
        $ID = Fireball\ORM::createUniquePrimaryKey(self::TABLE_NAME, self::PRIMARY_KEY, time());
        if (Fireball\ORM::newRecord(self::TABLE_NAME, self::$fields, array($ID, $fname, $lname, time()))) {
            return new self($ID);
        }
    }

    // EXAMPLES BELOW

    /**
     * This is an example of a method you could write that will return an array of mapped person objects for every person in the database.
     */
    public static function getAllPeople() {
        $result = self::mapQuery(self::rawQuery('select * from ' . self::TABLE_NAME, null, true));
        return $result;
    }


}
?>
