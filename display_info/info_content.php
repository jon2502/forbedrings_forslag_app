<?php
    function displayinfo($row, $id){
        infomain($row);
            //lav knapper til odatering af forslags status
            if($row[6] == 0){
                echo "<a href='./config_files/updatestate.php?state=2&id=$id' class='button_link main_text'>accept</a>";
                echo "<a href='./config_files/updatestate.php?state=1&id=$id' class='button_link main_text'>reject</a>";
            } elseif($row[6] == 1 || $row[6] == 2){
                echo "<a href='./config_files/updatestate.php?state=0&id=$id' class='button_link main_text'>pending</a>";
            }
    }
?>