<html>
<head>
<title>register</title>
<link rel="stylesheet" href="./styling_and_script/styling.css">
</head>
<body>
<?php
    require_once("./config_files/sessions.php");
    login_check();

    require_once('./display_info/header_simple.php');
    require_once('./config_files/databasefunktioner.php');
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

        if (!$submit) {
            $msg = $form; 
            } else {
                // Redisplay a message and the form if incomplete
                if (empty($username)|| empty($userpassword)) {
                $msg = "<b class='main_text'>Please complete all fields</b><br /><br />";
                $msg .= $form;
                } else {
                    $option = [
                        'cost' => 12,
                    ];
                    $hash = password_hash($_POST['password'], PASSWORD_BCRYPT,$option);
                    $table = "internalusers";
                    $collums = 'username,password';
                    $values = '?, ?';
                    $bind = "ss";
                    $bindvalues = array($username,$hash);
                    insert($table, $collums, $values, $bind, $bindvalues);
                    $running = true;
                    if($running){
                        $msg = '<p> user created </p>';
                    }else{
                        $msg = '<p>an error ocured try agin</p>';
                        $msg .= $form;
                    }
                    }
                }   
     // On first opening, display the form
    echo $msg;
?>
</body>
</html>