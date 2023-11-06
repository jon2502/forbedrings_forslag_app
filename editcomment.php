<html>
<head>
<title>Forslag organizer</title>
<link rel="stylesheet" href="./styling_and_script/styling.css">
</head>
<body>
<?php
    require_once("./config_files/sessions.php");
    session_checker();
    
    require_once('./display_info/header.php');
    require_once("./config_files/databasefunktioner.php");
    require_once("./display_info/html.php");
    $id = $_GET['id'];
    $forslag = $_GET['forslagid'];
    $comment = $_POST['comments']?? '';
    $table = "internalcomments";
    $collums = 'content';
    $values = 'ID = ?';
    $index = 'PRIMARY';
    $bind = "s";
    $bindvalues = array($id);
    $query = singleget($table,$collums,$values,$index,$bind,$bindvalues); 
    if($query){
        editcomment($query, $id, $forslag );
        if(isset($_POST['save'])){
            $table = "internalcomments";
            $collums = "content=?";
            $values = "ID = $id";
            $bind = "s";
            $bindvalues = $comment;
            $result = edit($table,$collums,$values,$bind,$bindvalues);
            if ($result) {
                header("location:info.php?id=$forslag");
              } else {
                echo "Error updating record";
              }
        }
    } else {
                echo '<p>That press release could not be located in our database.</p>';
            }
    
?>
<script src="./styling_and_script/script.js"></script>
</body>
</html>