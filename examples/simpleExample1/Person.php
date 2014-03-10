<?php

include_once '../../src/Fireball.php';

class Person {

    private $fireball;
    public $data;
    
    private static $tableDef = array(
        'table'      => 'Person',
        'fields'     => array('ID', 'fname', 'lname', 'time' ),
        'primaryKey' => 'ID',
    );
    
    public function __construct($ID) {
        $this->fireball = new Fireball\ORM($this, $ID, self::$tableDef);
    }
    
    public static function newPerson($fname, $lname) {
        //Validate input data here
        $ID = md5($fname . time());
        if (Fireball\ORM::newRecord(self::$tableDef, array($ID, $fname, $lname, time()))) {
            return new self($ID);
        }
    }
    
    //add your methods here. 
    
}
?>
