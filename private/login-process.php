<?php

if(isset($_POST['login'])){
    $username= trim($_POST['username']);
    $password= trim($_POST['password']);

    if( $username && $password){
        $statement = $connection->prepare("SELECT * FROM catalogue_admin WHERE username = ?");
        $statement->bind_param("s", $username);
        $statement->execute();
        $result = $statement -> get_result();

        if($result->num_rows === 1){
            $row= $result -> fetch_assoc();
            if(password_verify($password, $row['hashed_password'])){
                session_start();
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['last_login'] =time();
                $_SESSION['login_expires'] = strtotime("+3 minute");

                header("Location: index.php");
                exit();
            }else{
                $message= "<p> Invalid username or password </p>";
            }
        }else{
            $message= "<p> Invalid username or password </p>";
        }
    }else{
        $message= "<p> Both fields are required </p>";
    }

}

?>