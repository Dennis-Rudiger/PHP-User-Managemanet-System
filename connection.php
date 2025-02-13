<?php
    class crud{
        public static function connect()
        {
           try {
                $con = new PDO('mysql:host=localhost;dbname=crud_app', 'root', '');
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $con;
           } catch (PDOException $error1) {
                echo 'Something went wrong, unable to connect to the database: ' . $error1->getMessage();
                return false;
           } catch (Exception $error2){
                echo 'A general error occurred: ' . $error2->getMessage();
                return false;
           }
        }
    }
