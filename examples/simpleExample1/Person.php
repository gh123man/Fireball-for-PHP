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
        
        
        $ID = self::newRecord(self::TABLE_NAME, array (
            self::FNAME => $fname,
            self::LNAME => $lname,
            self::TIME => time(),
        ));
    
        if (is_numeric($ID)) {
            return new self($ID);
        } else {
            throw new Exception("Node creation failed");
        }
    }

    // EXAMPLES BELOW

    /**
     * This is an example of a method you could write that will return an array of mapped person objects for every person in the database.
     */
    public static function getAllPeople() {
        $result = self::mapQuery(self::rawQuery('select * from Person'));
        return $result;
    }


}
?>
