
<?php
//include './User.php';
// var_dump($_POST['updateSubmit']);
if (!isset($_POST['updateSubmit'])){
   // require 'DbConnect.php';
    $dsn = 'mysql:host=localhost;dbname=blogs;charset=utf8';
    $db = new PDO($dsn, 'root', '');
    $name = $_POST['name'];
    $email = $_POST['email'];
    $title = $_POST['title'];
    $body = $_POST['body'];
    
   // echo "$body";


    if (!empty($name)&& !empty($email) && !empty($title) && !empty($body)){
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $sql= "SELECT email From users where email = ?";                
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);
            $ExistEmail=$stmt->fetchAll();
            if ($ExistEmail){
                header("Location:./index.html?error=emailAllReadyExist");
                exit();
            }
            $user= new User;
            $user->setUser($name,$email);
            $sql="INSERT INTO users( name, email) VALUES (?, ?) ";
            $stmt = $db->prepare($sql);
            $stmt->execute([$name,$email]);

            $sql= "SELECT id From users where email = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute([$email]);
            $userDetails=$stmt->fetchAll();
            foreach ($userDetails as $userDetail){
                $userId= $userDetail['id'];
                $sql= "INSERT INTO posts( user_id,title, body) VALUES (?, ?, ?) ";
                $stmt = $db->prepare($sql);
                $stmt->execute([$userId,$title,$body]);
                echo "Detailed inserted successfully";
            }
           

           
        }
    }   
    elseif(empty($name)|| empty($email) || empty($title) ||empty($body)){
        header("Location:./index.html?error=somefiledempty");
        exit();
    }

}
