<?php
        
        require_once("./sessions.php");
            session_checker();
        require_once("./databasefunktioner.php");
        require_once('../mails.php');
        require_once("./jira.php");
        $id = $_GET['id'];
        $state = $_GET['state'];
        $table = "forslag";
        $collums = "state=?, updatedate=NOW()";
        $values = "ID = $id";
        $bind = "s";
        $bindvalues = $state;
        $result = edit($table,$collums,$values,$bind,$bindvalues);
        $username = $_SESSION["username"];
        if($result){
            $table2 = 'logging';
            $collums2 = 'username, forslagid, status, timestamp';
            $values2 = "?, ?, ?, NOW()";
            $bind2="sss";
            $bindvalues2 = array($username, $id, $state);
            insert($table2,$collums2,$values2,$bind2,$bindvalues2);
            $table3 = "forslag";
            $collums3 = 'name, email';
            $values3 = 'ID=?';
            $index3 ='PRIMARY';
            $bind3 ='s';
            $bindvalues3 = $id;
            $result = multipleget($table3, $collums3, $values3, $index3, $bind3, $bindvalues3);
            if($result){
                $name = $result[0][0];
                $email = $result[0][1];
                automail($state,$name,$email);
                if($state == 2){
                    $table4 = "forslag";
                    $collums4 = 'title, name, email, kategori,comments';
                    $values4 = 'ID=?';
                    $index4 ='PRIMARY';
                    $bind4 ='s';
                    $bindvalues4 = array($id);
                    $result1 = singleget($table4, $collums4, $values4, $index4, $bind4, $bindvalues4);
                    send_to_jira($result1,$id);
                }
                header("location:../info.php?id=$id");
            }else{
                echo "Error updating record: " . mysqli_stmt_error($result);
            }
        }
