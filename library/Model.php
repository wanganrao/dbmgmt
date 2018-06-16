<?php

/*
 * Here is where we are setting up a simple wrapper class around mysql
 * functions just to make it a little more convenient.  Our models will
 * simple extend our database class and simplify making queries just a bit.
 */
require_once 'config.php';
class Model {

    protected $connection;

    // Every time you instantiate this class you are going to create
    // a new connection to the database.
    public function __construct() {
        // First we setup up a nice little connection to the database,
        // make sure you use your connection information.  If the
        // connection fails we just die with the error.
//changed to use PDO ; tutorial followed: http://wiki.hashphp.org/PDO_Tutorial_for_MySQL_Developers

        try {
            $mysqlstr = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
            $this->connection = new PDO($mysqlstr, DB_USER, DB_PASSWORD);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            //handle me.
            echo "DB error occured: " . ($ex->getMessage());
        }
    }

    // Here we will query the database with the passed query string,
    // build up an array of objects and return them, simple enough.
    public function query($query) {
        // Here we make our query and set the result to a $result variable
        $stmt = $this->connection->prepare($query);
        $stmt->execute();

        // Create a container array variable to hold all of our result objects.
        $resultObjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Now we just return our array that has all our result objects in it
        return $resultObjects;
    }

    // Here we add a simpler method for handling INSERTs and UPDATEs since
    // they do not return a result set.
    //prepare method escapes strings and protects from SQL injection
    public function execute($qry, $param = Array()) {
        $stmt = $this->connection->prepare($qry);
//        var_dump($stmt);
//        var_dump($param);
        $affected_rows = $stmt->execute($param);
        return $affected_rows;
    }

}
