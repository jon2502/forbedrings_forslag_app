<html>
<head>
<title>login</title>
<link rel="stylesheet" href="./styling_and_script/styling.css">
<?php
    require_once("./config_files/sessions.php");
    login_check();
    
    require_once('./display_info/header_simple.php');
    require_once('./config_files/databasefunktioner.php')
?>
</head>
<body>
    <section class="margin">
    <?php 
        // Error reporting
            error_reporting(E_ALL ^ E_NOTICE);
        // Initialize variables
            $self = $_SERVER['PHP_SELF'];
            $username = $_POST['username'] ?? '';
            $userpassword = $_POST['password'] ?? '';
            $submit = $_POST['submit'] ?? '';
        // The HTML form
            $form ="
            <form action=\"$self\" method=\"post\" id=\"sendLogin\">
                <label for=\"username\">username:</label><br>
                <input type=\"username\" name=username value=\"$username\"><br>
                <label for=\"password\">password:</label><br>
                <input type=\"password\" name=\"password\" value=\"$userpassword\" ><br>
                <input type=\"submit\" value='submit' name='submit'>
            </form>
            ";
        // On first opening, display the form
            if (!$submit) {
                $msg = $form; 
            } else {
                    // Redisplay a message and the form if incomplete
                    if (empty($username)|| empty($userpassword)) {
                    $msg = "<b class='main_text'>Please complete all fields</b><br /><br />";
                    $msg .= $form;
                    } else {
                        $username = stripslashes($username);
                        $userpassword = stripslashes($userpassword);
                        $table = "internalusers";
                        $collums = 'username, password';
                        $values = 'username = ?';
                        $index = 'userindex';
                        $bind = "s";
                        $bindvalues = array($username);
                        $query = singleget($table,$collums,$values,$index,$bind,$bindvalues); 
                        var_dump($query);              
                        if($query) {
                                $verifypass = password_verify($userpassword, $query['password'] );
                                if($verifypass){
                                    $_SESSION['username'] = "$username";
                                    header("location:list.php?state=0");
                                }else{
                                    $msg = "<b>somthing whent wrong try again 1</b><br /><br />";
                                    $msg .= $form;
                                }
                            }else{
                                $msg = "<b>somthing whent wrong try again 2</b><br /><br />";
                                $msg .= $form;
                            }
                            }
                        }  
    echo $msg;
    ?>
    <section class="margin">
</body>
</html>