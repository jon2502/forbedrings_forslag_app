<?php
function session_checker(){
    //tjekker om session username eksistere ellers bliver man redirectede tilbage til index
    session_start();
    if(!isset($_SESSION['username'])){
        header("location:index.php");
    }
}
function login_check(){
    session_start();
    if(isset($_SESSION['username'])){
        header("location:list.php?state=0");
    }
}