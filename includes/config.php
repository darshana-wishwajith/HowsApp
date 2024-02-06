<?php
    class Database{
        public static $connection;

        public static function setUpConnection(){
            
            //login credentials
            $hostname = '127.0.0.1'; //localhost
            $username = 'root';
            $password = 'Darshana@1234';
            $database = 'howsapp_db';
            $port = '3306';

            if(!isset(Database::$connection)){
                Database::$connection = new mysqli($hostname, $username, $password, $database, $port);
            }
        }

        //Execute Insert, Update, Delete queries throught database connection
        public static function insert_update_delete($query){
            Database::setUpConnection();
            Database::$connection->query($query);
        }

        //Execute Search queries throught database connection and return a result set from database
        public static function search($query){
            Database::setUpConnection();
            $result_set = Database::$connection->query($query);
            return $result_set;
        }
    }
?>