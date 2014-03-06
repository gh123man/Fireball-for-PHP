<?php

namespace Fireball {

    use \PDO;
    use \Exception;
    use \UnexpectedValueException;
    
    class ORM {

        private $tableName;
        private $primaryKey;
        private $colCache;
        private $colChangedCache;
        private $ID;
        private static $connection;
        
        private $parentTableDef;
        
        private static $objectCache;
        
        public function __construct($parent, $ID, $tableDef) {
        
            self::validateTableDef($tableDef);
        
            $this->tableName = $tableDef['table']; //assumes table is named after class
            $this->primaryKey = $tableDef['primaryKey'];
            
            if (!isset($ID) || !self::rowExistsFrom($this->tableName, $this->primaryKey, $ID)) {
                throw new UnexpectedValueException("ID: " . $ID . " does not exist in " . $this->tableName);
            }
            
            
            $this->ID = $ID;
            
            $tableID = md5(serialize($tableDef));
            
            if (isset(self::$objectCache[$tableID])) {
            
                $dataAccess = self::$objectCache[$tableID];
                
            } else {
            
                $dataAccess = $this->setupDataAccess($tableDef);
                self::$objectCache[$tableID] = $dataAccess;
                
            }
            
            $parentMemberName = 'data';
            
            $parent->$parentMemberName = $dataAccess;
            
        }
        
        private static function validateTableDef($tableDef) {
            if (!isset($tableDef['primaryKey'])) {
                throw new UnexpectedValueException('primaryKey must be set');
            }
            
            if (!isset($tableDef['fields'])) {
                throw new UnexpectedValueException('database fields must be set');
            }
            
            if (!isset($tableDef['table'])) {
                throw new UnexpectedValueException('table name must be set');
            }
        }
        
        private function setupDataAccess($table) {
            
            $dataAccess = new FireballDataAccessInterface($this, $table['fields']);
            
            return $dataAccess;
            
        }
        
        public static function connect($db, $host, $uname, $pword) {
        
            $connection = new PDO('mysql:dbname=' . $db . ';host=' . $host . ';charset=utf8', $uname, $pword);
            $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            self::$connection = $connection;
        }
        
        public static function getConnection() {
            if (!isset(self::$connection)) {
                throw new UnexpectedValueException("Database conneciton not set");
            }
            return self::$connection;
        }
        
        public function getID() {
            return $this->ID;
        }
        
        public static function newRecord() {
            //herefd
        }

        /**
         * selects one item from the database
         */
        public static function dbSelect($what, $table, $where, $is) {
            $query = self::getConnection()->prepare('SELECT ' . $what . ' FROM ' . $table . ' WHERE ' . $where . ' = :IS');
            $query->execute(array(':IS' => $is));
            $query->setFetchMode(PDO::FETCH_ASSOC); 
            $results = $query->fetch();
            return $results[$what];
        }
        
        /**
         * updates a given column in the database
         */
        public function update($col, $val, $where, $is) {
            $query = self::getConnection()->prepare('UPDATE ' . $this->tableName . ' SET ' . $col . ' = :data WHERE ' . $where . ' = :IS');
            return ($query->execute(array(':data' => $val, ':IS' => $is)));
        }
        
        /**
         * method to insert a key => value array into the database
         */
        public static function insert($tableName, $data) {
            $keys = array();
            $qArr = array();
            foreach($data as $key => $value) {
                $keys[] = ":" . $key;
                $qArr[$key] = $value;
            }

            $query = self::getConnection()->prepare('INSERT INTO ' . $tableName . ' VALUES (' . implode(", ", $keys) . ')');
            return ($query->execute($qArr));
        }
        
        /**
         * returns true if the row exists by the given ID
         */
        public function rowExists($ID) {
            if (!isset($ID)) {
                return false;
            }
            $ID1 = self::dbSelect($this->primaryKey, $this->tableName, $this->primaryKey, $ID);
            return $ID1 == $ID;
        }
        
        /**
         * returns true if the row exists by the given ID, col, and table name
         */
        public static function rowExistsFrom($table, $col, $ID) {
            if (!isset($table) || !isset($col) || !isset($ID)) {
                return false;
            }
            $ID1 = self::dbSelect($col, $table, $col, $ID);
            return $ID1 == $ID;
        }
        
        /**
         * interchange bridging access to the database with a runtime cache 
         */
        public function getCol($col) {
            if (!isset($this->colCache) || !isset($this->colCache[$col])) {
                $this->colCache[$col] = self::dbSelect($col, $this->tableName, $this->primaryKey, $this->getID());
                $this->colChangedCache[$col] = false;
            }
            return $this->colCache[$col];
        }
        
        /**
         * updates object cache and ticks change value to true
         */
        public function setCol($col, $val) {
            $this->colCache[$col] = $val;
            $this->colChangedCache[$col] = true;
            return true;
        }
        
        /**
         * dumps all changed values into the database
         */
        public function flush() { //TODO: update this to assemble one query
            if (isset($this->colCache) && isset($this->colChangedCache)) {
                foreach($this->colCache as $col => $val) {
                    if ($this->colChangedCache[$col]) {
                        $this->update($col, $val, $this->primaryKey, $this->getID());
                    }
                }
            }
        }
        
        /**
         * called on object distruction
         */
        public function __destruct() {
            $this->flush();
        }
        
    }

    class FireballDataAccessInterface {
    
        private $cols;
        private $orm;
        
        public function __construct($orm, $cols) {
            $this->cols = $cols;
            $this->orm  = $orm;
        }
        
        public function __call($col, $value = null) {
            
            
            if (isset($this->cols[$col])) {
            
                if (isset($value)) {
                    $this->orm->setCol($col, $value);
                    
                } else {
                    return $this->orm->getCol($col);
                }
            }
        }
        
        
    }
}
    
?>
