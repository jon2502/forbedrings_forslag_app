<html>
<head>
<title>Forslag organizer</title>
<link rel="stylesheet" href="./styling_and_script/styling.css">
</head>
<body>
<?php
        error_reporting(E_ALL);
        require_once("./config_files/sessions.php");
        session_checker();
        
        require_once("./display_info/displayfilesnew.php");
        require_once("./display_info/displaylogsnew.php");
        require_once("./display_info/header.php");
        require_once("./display_info/info_content.php");
        require_once("./display_info/displaycommentuploader.php");
        require_once("./display_info/html.php");
        require_once("./config_files/jira.php");
        require_once('./config_files/databasefunktioner.php');
        $id = $_GET['id'] ??get_current_ID();
        $currentuser = $_SESSION['username'];

        $table = 'forslag';
        $collums ='ID, title, name, email, comments, kategori, state, Dateadded, updatedate';
        $values = 'ID = ?';
        $index ='PRIMARY';
        $bind = 's';
        $bindvalues = $id;
        $result = multipleget($table, $collums, $values,$index, $bind, $bindvalues);
            if($result) {
                foreach ($result as $row){
                    echo '<section id="infogrid" class="margin">';
                    echo '<div>';
                        //fremvis generl information
                        displayinfo($row, $id);
                        //fremviser logs
                        getlogs($id);
                        //tilfør form for tilførelse af kommentare 
                        display_comment_uploader($currentuser,$id);
                    echo '</div>';
                        echo '<div id="fileshowcase">';
                        echo '<h2 class="header_text">files</h2>';
                        //fremviser filer linkede til forslag
                        getfiles($id);
                    echo '</div>';
                echo '</section>';
                }
            } else {
            //hvis id ikke kan findes hvis dette istedet for
            echo '<p class="main_text">This release could not be located in our database.</p>';
            }
        
?>
</section>
<script src="./styling_and_script/script.js"></script>
</body>
</html>