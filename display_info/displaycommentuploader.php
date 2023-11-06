<?php
    function display_comment_uploader($currentuser,$id){
        if(isset($_POST['add-comment'])){
            $comment = $_POST['comments'];
            $table = 'internalcomments';
            $collums ='user, content, forslagID, Timestamp';
            $values = "'$currentuser', ?, '$id', NOW()";
            $bind = 's';
            $bindvalues = array($comment);
            var_dump("info.php?id=".$id."");
            var_dump($comment);
            insert($table, $collums, $values, $bind, $bindvalues);
            header("location:info.php?id=".$id."");
        }else{
            //fremhvis kommentare 
            $table = 'internalcomments';
            $collums ='ID, user, content, forslagID, timestamp';
            $values = 'forslagID = ?';
            $index = 'forslag_index';
            $bind = 's';
            $bindvalues = $id;
            $result = multipleget($table, $collums, $values,$index, $bind, $bindvalues);
            commentuploader($id);
            if(sizeof($result) > 0){
                comment_header();
                foreach ($result as $row){
                    comments($row);
                    if($row[1]==$currentuser){
                        commentsoptions($row, $id);
                    }
                    if(isset($_POST['delete-comment']) ){
                        $table2 = 'internalcomments';
                        $values2 = 'ID = ?';
                        $bind2 = 's';
                        $bindvalues2 = $id;
                        delete($table2, $values2, $bind2, $bindvalues2);
                        header("location:info.php?id=".$id."");
                    }
                    echo "</div>";
                }
                echo "</section>";
            } else{
                echo '<p class="main_text">no comments found</p>';
            }
        }
    }

