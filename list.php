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
        require_once("./display_info/header.php");
        require_once("./display_info/html.php");
        require_once("./config_files/databasefunktioner.php");
        deleterejects();
        deleteaccepts();
        deleteremaningfiles();
        
        ?>
            <section class="margin">
        <?php
        $state = $_GET['state'];        
            if($state == 0){
                ?>
                <h2 class="header_text">pending</h2>
                <?php
            } elseif($state == 1){
                ?>
                <h2 class="header_text">rejected</h2>
                <?php
            } elseif($state == 2){
                ?>
                <h2 class="header_text">accepted</h2>
                <?php
            }
        ?>
        <?php
                $table = 'forslag';
                $collums ='ID, title, name, email, kategori, Dateadded';
                $values = 'state = ?';
                $index ='state_index';
                $bind = 's';
                $bindvalues = $state;
                $result = multipleget($table, $collums, $values, $index, $bind, $bindvalues);
                if (sizeof($result) > 0) {
                    
                // If records present, iterate through resultset and display title with links to edit and delete scripts
                    listheader();
                    echo '<section class="listgrid">';
                //foreach in result in result array genereate html element
                foreach ($result as $row) {
                    listinfo($row);
                }
                echo "</section>";
                $success = true;
                }else{
                    //if no content is found in db with selected state show this
                    $msg = '<p class="main_text">no content found</p>';
                    $success = false;
                }
    
        
        // Output the result
            if (!$success) {
                echo $msg;
            }
    
    ?>
    </section>
    <script src="./styling_and_script/script.js"></script>
</body>
</html>