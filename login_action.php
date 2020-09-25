<?php
$database="mysql:host=localhost;dbname=login_system";
$user='root';
$password='admin1234';


try{
    $pdo= new PDO($database,$user,$password);
}catch(PDOException $e)
{
    print('Error: '. $e->getMessage());
    die(); //The process will stop when there's is an error
}

$loginStatus=false;

$username= stripslashes($_POST['username']); //To prevent sql injection
$password= stripcslashes($_POST['password']);


$query='select * from users where (username = :user)';

$data= [':user'=>$username];

try{
    $response=$pdo->prepare($query);
    $response->execute($data);
}catch (PDOException $e){
    echo 'Query failed';
    die();
}

$row= $response->fetch(PDO::FETCH_ASSOC);
if(is_array($row)){
    if(password_verify($password,$row['password'])){
        $loginStatus=true; //valid
        echo 'User has been authenticated';
    }else{
        $loginStatus=false; //invalid
        echo 'Invalid user credentails. Please try again!';

    }
}else{
    echo 'User not found!';
    //Shows when user is not in the database
}




