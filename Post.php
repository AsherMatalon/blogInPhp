<?php

require 'User.php';


class Posts extends Users{
    
    public function __construct($post){

                $name = $post['name'];
                $email = $post['email'];
                $title = $post['title'];
                $body = $post['body'];
                
             if (!empty($name)&& !empty($email) && !empty($title) && !empty($body)){
                if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                    $sql= "SELECT email From users where email = ?";
                    $db = $this->connect();
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$email]);
                    $ExistEmail=$stmt->fetchAll();
                    if ($ExistEmail){
                        header("Location:./index.html?error=emailAllReadyExist");
                        exit();
                    }
                }
            } elseif(empty($name)|| empty($email) || empty($title) ||empty($body)){
                header("Location:./index.html?error=somefiledempty");
                exit();
            }
            $this->create($post);
            
            print_r($user_id);
            return $user_id;
        }
        

    
        
        
       
 

    public function create($post){
       
        $user_id = parent::create($post);
        $sql="INSERT INTO 'posts'(user_id, title, body) VALUES (?, ?, ?)";
        $dsn = 'mysql:host=localhost;dbname=blogs;charset=utf8';
        $db = new PDO($dsn, 'root', '');
        $stmt = $db->prepare($sql);
        $stmt->execute([$post[user_id],$post[$title],$post[$body]]);
        echo "Detailed inserted successfully";
    }

    public function searchById($post_id){

        $db= $this->connect();
        $sql ="SELECT * FROM posts WHERE id = ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$post_id]);
        $posts= $stmt->fetchAll();
        //print_r($posts);
        if ($posts){
            foreach ($posts as $post){
                $post= json_encode($post);
                echo "<pre>";
                print_r($post);
            }
        }else{
            echo "There is no id like that";
        }
        
    }
    public function searchByUserId($user_id){
        $db = $this->connect();
        $sql = "SELECT * FROM posts WHERE user_id = ? ";
        $stmt = $db->prepare($sql);
        $stmt->execute([$user_id]);
        $postsByUser= $stmt->fetchAll();
        if($postsByUser){
            foreach($postsByUser as $postByUser){
                $postByUser= json_encode($postByUser);
                echo "<pre>";
                print_r($postByUser);
            }
        }else{
            echo "There is no posts for user Id No.".$user_id;
        }
        
    }
        
    public function searchByContent($string){
        $db = $this->connect();
        $sql = "  SELECT * FROM posts WHERE body LIKE '%$string%'  OR title LIKE '%$string%'";
        $stmt = $db->prepare($sql);
        $stmt->execute([$string]);
        $contents= $stmt->fetchAll();
        if($contents){
            foreach($contents as $contnet){
                $contnet= json_encode($contnet);
                echo "<pre>";
                print_r($contnet);
            }
        }else{
            echo "There is no posts for user Id No.".$string;
        }
    }

    public function setPostCurl(){
        $ch = curl_init();
        curl_setopt($ch ,CURLOPT_URL ,'https://jsonplaceholder.typicode.com/posts');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output= curl_exec($ch);
        
        if ($output === FALSE ){
            echo "CURL ERROR". curl_error($ch);
        }
        curl_close($ch);
        file_put_contents("posts.php",$output);
 
 
 
       $filename = "posts.php";
       $data= file_get_contents($filename);
       $array = json_decode($data);
       
       $db = $this->connect();
       foreach ($array as $post){
        $sql ="INSERT INTO posts(user_id, title, body) VALUES (?,?,?)";
        $stmt= $db->prepare($sql);
       $insert = $stmt->execute( [$post->userId ,$post->title, $post->body]);
       
      }
     
         
 
 
    } 
    

}

if (isset($_POST['updateByPost'])){
    $post= new Posts($_POST);
}



// if (!isset($post['updateSubmit'])){
//     // require 'DbConnect.php';
    
//      $name = $post['name'];
//      $email = $post['email'];
//      $title = $post['title'];
//      $body = $post['body'];
//      print_r($this->$body);
//      if (!empty($name)&& !empty($email) && !empty($title) && !empty($body)){
//         if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
//             $sql= "SELECT email From users where email = ?";
//             $db = parent::connect();
//             $stmt = $db->prepare($sql);
//             $stmt->execute([$this->email]);
//             $ExistEmail=$stmt->fetchAll();
//             if ($ExistEmail){
//                 header("Location:./index.html?error=emailAllReadyExist");
//                 exit();
//             }
//         }
//     }
//     $user_id = parent::createUser($post);
//     print_r($user_id);
//     return $user_id;
// }
// }
    // $post= new Post;
    // $post->setPostCurl();
// $post= new Post;
// $post->searchById(1);

// $post= new Post;
// $post->searchByUserId(3);

// $post= new Post;
// $post->searchByContent('ss');