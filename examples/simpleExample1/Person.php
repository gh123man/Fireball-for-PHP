<?php

include_once '../../src/Fireball.php';

class Person {

    private $fireball;
    private $data;
    
    private static $tableDef = array(
        'table'      => 'Person',
        'fields'     => array('ID', 'fname', 'lname', 'time' ),
        'primaryKey' => 'ID',
    );
    
    public function __construct($ID) {
        $this->fireball = new Fireball\ORM($this, $ID, self::$tableDef);
    }
    
    public static function newPerson($val1, $val2) {
        //Validate your data here. 
	$ID = md5($val1 . time());
        if (Fireball\ORM::newRecord(self::$tableDef, array($ID, $val1, $val2, time()))) {
            return new self($ID);
        }
    }
    
    //add your methods here. 
    
}
?>
