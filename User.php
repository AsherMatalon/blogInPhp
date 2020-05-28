<?php
require 'DbConnect.php';

class  Users extends DbConnect {

    public function create($post){
        $name=$post['name'];
        $email=$post['email'];
        $dsn = 'mysql:host=localhost;dbname=blogs;charset=utf8';
        $db = new PDO($dsn, 'root', '');
        //print_r($db);
        // $db= $this->connect();
        $sql="INSERT INTO users(name,email) VALUES ?, ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$name,$email]);
        $names=$stmt->fetchAll();
        print_r($names);
        $sql= "SELECT id FROM users WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute([$email]);
        $userDetails=$stmt->fetchAll();
        //print_r($userDetails);
        die();
        foreach ($userDetails as $userDetail){
            $user_id= $userDetail['id'];
            print_r($user_id);
            die();
        }
        return $user_id;
    }

    
   public function setUserCurl(){
       $ch = curl_init();
       curl_setopt($ch ,CURLOPT_URL ,'https://jsonplaceholder.typicode.com/users');
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_HEADER, 0);
       $output= curl_exec($ch);
       
       if ($output === FALSE ){
           echo "CURL ERROR". curl_error($ch);
       }
       curl_close($ch);
       file_put_contents("user.json",$output);



      $filename = "user.json";
      $data= file_get_contents($filename);
      $array = json_decode($data);
      
      $db = $this->connect();
      foreach ($array as $user){
      $sql ="INSERT INTO users(name,email) VALUES ( ? , ? )";
      $stmt = $db->prepare($sql);
      $insert = $stmt->execute([$user->name,$user->email]);
      
     }
    
        


   } 

}

// $user= new Users;
// $user->setUserCurl();