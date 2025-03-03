<?php

function logout(){
    unset($_SESSION);
    session_destroy();
    header('Location: index.php');
}

function last_login_is_recent(){
    $max_time= 60 * 3 ; 
    if(!isset($_SESSION['last_login'])){
        return false;
    }
    return($_SESSION['last_login'] + $max_time) >= time(); 
}

function login_is_still_valid(){
    if (!isset($_SESSION['login_expires'])){
        echo 'login expired';
        return false;
    }
    echo 'login valid';
    return($_SESSION['login_expires'] >= time());
}

function login_expiry(){
    if(!isset($_SESSION['user_id']) || login_is_still_valid() == false){
        logout();
    }
}



?>