<html>
<head>
<title>Form page</title>
<link rel="stylesheet" href="./styling_and_script/styling.css">
</head>
<body>
    <?php 
        require_once("./config_files/sessions.php");
        session_checker();
        
        require_once('./mails.php');
        require_once('./fileuploaders/newfileuploader.php');
        require_once('./config_files/databasefunktioner.php');
        require_once("./display_info/header.php");
        require_once("./display_info/html.php");
        // Error reporting
            error_reporting(E_ALL ^ E_NOTICE);
            
        // Initialize variables
            $self = $_SERVER['PHP_SELF'];
            $title = $_POST['title'] ?? '';
            $name = $_POST["name"] ?? '';
            $email = $_POST['email'] ?? '';
            $kategori = $_POST['kategori'] ?? '';
            $comments = $_POST['comments'] ?? '';
            $submit = $_POST['submit'] ?? '';
            // The HTML form
            $form = form($self);

        // On first opening, display the form
            if (!$submit) {
                $msg = $form; 
                } else {
                    // Redisplay a message and the form if incomplete
                    if (empty($title)|| empty($name) || empty($email) || empty($comments)) {
                    $msg = "<div><b class='main_text'>Please complete all necesary fields</b><br /><br />";
                    $msg .= "$form </div>";
                    } else {
                        //check if email has a vilid structuer with FILTER_VALIDATE_EMAIL 
                        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $msg = "Invalid email format";
                        $msg .= $form;
                        } else {
                        $title = stripslashes($title);
                        $name = stripslashes($name);
                        $comments = stripslashes($comments);
                        // Connect to MySQL
                        
                        $table = "forslag";
                        $collums = 'title, name, email, kategori, comments, Dateadded, updatedate';
                        $values = '?, ?, ?, ?, ?, NOW(),NOW()';
                        $bind = "sssss";
                        $bindvalues = array($title, $name, $email, $kategori, $comments);
                        insert($table, $collums, $values, $bind, $bindvalues);
                        
                        //runs if there is content in files otherwise skip
                        if(!empty($_FILES['files']['name'][0])){
                            echo '<pre>';
                            var_dump($_FILES);
                            echo '</pre>';
                            die;
                            //create array and count files
                            $files = array_filter($_FILES['files']['name']);
                            $count_files = count($_FILES['files']['name']);
                            //loop trough files
                            for ($i=0; $i<$count_files; $i ++){
                                //get filename
                                $filename = addslashes($_FILES['files']['name'][$i]);
                                //get filetype
                                $filetype = addslashes($_FILES['files']['type'][$i]);
                                //get file extension
                                $fileextension = strtolower(pathinfo($_FILES["files"]["name"][$i],PATHINFO_EXTENSION));
                                //get file data
                                $filedata = $_FILES["files"]["tmp_name"][$i];
                                uploadfiles($filename,$filetype,$fileextension,$filedata,$title,$name,$email,$kategori,$comments);
                            }
                        }

                        //sends mail with php mailer
    
                        automail(3,$name,$email);
                       //redirects to list page for pending for viewing med state sat til pending
                       header("location:list.php?state=0");
                }
            }
        }
        ?>
        <section class="form_setup">
        <?php
        echo $msg;
    ?>  
        </section>
</body>
</html>