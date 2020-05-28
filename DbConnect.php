<?php
class DbConnect{
    public function connect(){
        try{
            $dsn = 'mysql:host=localhost;dbname=blogs;charset=utf8';
            $db = new PDO($dsn, 'root', '');
            $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, TRUE);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
            }catch(PDOExeption $e){
                echo 'Faild:'.$e->getmessage();
        
            }

    }
}


