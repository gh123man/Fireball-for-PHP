<?php

include_once 'Fireball.php';

class Person {

    private $fireball;
    
    private static $tableDef = array(
        'table'      => 'Person',
        'fields'     => array('ID', 'fname', 'lname', 'time' ),
        'primaryKey' => 'ID',
    );
    
    public function __construct($ID) {
        $this->fireball = new Fireball\ORM($this, $ID, self::$tableDef);
    }
    
    public static function newPerson($val2, $val2) {
        return Fireball\ORM::newRecord(self::$tableDef, array($val1, $val2));
    }
    
    //add your methods here. 
    
    
}



?>
